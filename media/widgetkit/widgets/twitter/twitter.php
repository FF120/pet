<?php
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

/*
	Class: TwitterWidgetkitHelper
		Twitter helper class
*/
class TwitterWidgetkitHelper extends WidgetkitHelper {

	/* type */
	public $type;

	/* options */
	public $options;

	/*
		Function: Constructor
			Class Constructor.
	*/
	public function __construct($widgetkit) {
		parent::__construct($widgetkit);

		if(!class_exists('OAuthException')) { 
			require_once($this["path"]->path("classes:OAuth.php")); 
		}

		// init vars
		$this->type    = strtolower(str_replace('WidgetkitHelper', '', get_class($this)));
		$this->options = $this['system']->options;

		// create cache
		$cache = $this['path']->path('cache:');
		if ($cache && !file_exists($cache.'/twitter')) {
			mkdir($cache.'/twitter', 0777, true);
		}

		// register path
        $this['path']->register(dirname(__FILE__), $this->type);
 	}
	
	/*
		Function: site
			Site init actions

		Returns:
			Void
	*/
	public function site() {

    		// add translations
    		foreach (array('LESS_THAN_A_MINUTE_AGO', 'ABOUT_A_MINUTE_AGO', 'X_MINUTES_AGO', 'ABOUT_AN_HOUR_AGO', 'X_HOURS_AGO', 'ONE_DAY_AGO', 'X_DAYS_AGO') as $key) {
    			$translations[$key] = $this['system']->__($key);
    		}

        // add stylesheets/javascripts
        $this['asset']->addFile('css', 'twitter:styles/style.css');
        $this['asset']->addFile('js', 'twitter:twitter.js');
    		$this['asset']->addString('js', sprintf('$widgetkit.trans.addDic(%s);', json_encode($translations)));
            
    		// rtl
    		if ($this['system']->options->get('direction') == 'rtl') {
    	        $this['asset']->addFile('css', 'twitter:styles/rtl.css');
    		}

	}
    
	/*
		Function: render
			Render widget on site

		Returns:
			String
	*/
	public function render($options) {

    if(!function_exists('curl_init')) {
      return "Please enable the PHP curl extension to use the Twitter widget";
    }

		if ($tweets = $this->_getTweets($options)) {

			// get options
			extract($options);

			return $this['template']->render("twitter:styles/$style/template", compact('tweets', 'show_image', 'show_author', 'show_date', 'image_size'));
		}

		return 'No tweets found.';
	}

	/*
		Function: _queryTwitter
			Query Twitter API

		Returns:
			String
	*/
	protected function _queryTwitter($options) {
		
    $params = array();

		// get options
		extract($options);

		// clean options
		foreach (array('from_user', 'to_user', 'ref_user', 'word', 'nots', 'hashtag') as $var) {
			$$var = preg_replace('/[@#]/', '', preg_replace('/\s+/', ' ', trim($$var)));
		}
		
		// build query
		$query = array();
		
		if ($from_user) {
			$query[] = 'from:'.str_replace(' ', ' OR from:', $from_user);
		}

		if ($to_user) {
			$query[] = 'to:'.str_replace(' ', ' OR to:', $to_user);
		}

		if ($ref_user) {
			$query[] = '@'.str_replace(' ', ' @', $ref_user);
		}

		if ($word) {
			$query[] = $word;
		}

		if ($nots) {
			$query[] = '-'.str_replace(' ', ' -', $nots);
		}

		if ($hashtag) {
			$query[] = '#'.str_replace(' ', ' #', $hashtag);
		}

		$limit = min($limit ? intval($limit) : 5, 100);

    if ($limit > 15) {
      $params["count"] = $limit;
    }

		// build timeline url
		if ($from_user && !strpos($from_user, ' ') && count($query) == 1) {

			$url                   = 'statuses/user_timeline';
      $params["screen_name"] = trim($from_user,'@');

    // search url
		} elseif (count($query)) {

      $url         = 'search/tweets';
      $params["q"] = urlencode(implode(' ', $query));

		}

    $response = '';

    if ($path = $this['path']->path('cache:twitter')) {
        $file = rtrim($path, '/').sprintf('/twitter-%s.php', md5($url.serialize($params)));

        // is cached ?
        if (file_exists($file)) {
          $response = file_get_contents($file);
        }

        // refresh cache ?
        if (!file_exists($file) || (time() - filemtime($file)) > 300) {

          $connection = new WidgetkitTwitterOAuth(@$consumer_key, @$consumer_secret, @$access_token, @$access_token_secret);
          $request    = $connection->get($url, $params);

          //var_dump($request);return;
          if (!isset($request['errors'])) {
            $response = json_encode($request);
          }

          file_put_contents($file, $response);
        }
      }


		return $response;	
	}

	/*
		Function: _getTweets
			Get Tweet Object Array

		Returns:
			Array
	*/
	protected function _getTweets($options) {

		// init vars
		$tweets = array();
		
		// query twitter
		$response = $this->_queryTwitter($options);

		// create tweets
		if (strlen($response)) {

			$response = json_decode($response, true);
			
			if (is_array($response)) {
				
				if (isset($response['statuses'])) {
					foreach ($response['statuses'] as $res) {

						$tweet = new WidgetkitTweet();
						$tweet->id   = $res['id_str'];
						$tweet->user = $res['user']['screen_name'];
						$tweet->name = $res['user']['name'];
						$tweet->image = $res['user']['profile_image_url'];
						$tweet->text = $res['text'];
						$tweet->created_at = $res['created_at'];
						
						$tweets[] = $tweet;
					}
				} else {
					foreach ($response as $res) {

						$tweet = new WidgetkitTweet();
						$tweet->id   = $res['id_str'];
						$tweet->user = $res['user']['screen_name'];
						$tweet->name = $res['user']['name'];
						$tweet->image = $res['user']['profile_image_url'];
						$tweet->text = $res['text'];
						$tweet->created_at = $res['created_at'];

						$tweets[] = $tweet;
					}
				}
				
			}
		}
		
		return array_slice($tweets, 0, isset($options['limit']) ? intval($options['limit']) : 5);
	}

}

/*
	Class: WidgetkitTweet
		Widgetkit Twitter Tweet.
*/
class WidgetkitTweet {

	public $id;
	public $user;
	public $name;
	public $image;
	public $text;
	public $created_at;

	public function getLink() {
		return 'http://twitter.com/'.$this->user;			
	}

	public function getStatusLink() {
		return 'http://twitter.com/'.$this->user.'/statuses/'.$this->id;			
	}

	public function getText() {

		// format text
		$text = preg_replace('@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@', '<a href="$1">$1</a>', $this->text);
		$text = preg_replace('/@(\w+)/', '<a href="http://twitter.com/$1">@$1</a>', $text);
		$text = preg_replace('/\s+#(\w+)/', ' <a href="http://search.twitter.com/search?q=%23$1">#$1</a>', $text);

		return $text;			
	}

}

// bind events
$widgetkit = Widgetkit::getInstance();
$widgetkit['event']->bind('site', array($widgetkit['twitter'], 'site'));



/* 
 * Based on TwitterOAuth
 * Abraham Williams (abraham@abrah.am) http://abrah.am
 */

/**
 * Twitter OAuth class
 */
class WidgetkitTwitterOAuth {
  /* Contains the last HTTP status code returned. */
  public $http_code;
  /* Contains the last API call. */
  public $url;
  /* Set up the API root URL. */
  public $host = "https://api.twitter.com/1.1/";
  /* Set timeout default. */
  public $timeout = 30;
  /* Set connect timeout. */
  public $connecttimeout = 30; 
  /* Verify SSL Cert. */
  public $ssl_verifypeer = FALSE;
  /* Respons format. */
  public $format = 'json';
  /* Decode returned json data. */
  public $decode_json = TRUE;
  /* Contains the last HTTP headers returned. */
  public $http_info;
  /* Set the useragnet. */
  public $useragent = 'WidgetkitTwitterOAuth v1.0';
  /* Immediately retry the API call if the response was not successful. */
  //public $retry = TRUE;


  /**
   * Set API URLS
   */
  public function accessTokenURL()  { return 'https://api.twitter.com/oauth/access_token'; }
  public function authenticateURL() { return 'https://api.twitter.com/oauth/authenticate'; }
  public function authorizeURL()    { return 'https://api.twitter.com/oauth/authorize'; }
  public function requestTokenURL() { return 'https://api.twitter.com/oauth/request_token'; }

  /**
   * Debug helpers
   */
  public function lastStatusCode() { return $this->http_status; }
  public function lastAPICall() { return $this->last_api_call; }

  /**
   * construct TwitterOAuth object
   */
  public function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL) {
    $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
    $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
    if (!empty($oauth_token) && !empty($oauth_token_secret)) {
      $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
    } else {
      $this->token = NULL;
    }
  }


  /**
   * Get a request_token from Twitter
   *
   * @returns a key/value array containing oauth_token and oauth_token_secret
   */
  public function getRequestToken($oauth_callback = NULL) {
    $parameters = array();
    if (!empty($oauth_callback)) {
      $parameters['oauth_callback'] = $oauth_callback;
    } 
    $request = $this->oAuthRequest($this->requestTokenURL(), 'GET', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }

  /**
   * Get the authorize URL
   *
   * @returns a string
   */
  public function getAuthorizeURL($token, $sign_in_with_twitter = TRUE) {
    if (is_array($token)) {
      $token = $token['oauth_token'];
    }
    if (empty($sign_in_with_twitter)) {
      return $this->authorizeURL() . "?oauth_token={$token}";
    } else {
       return $this->authenticateURL() . "?oauth_token={$token}";
    }
  }

  /**
   * Exchange request token and secret for an access token and
   * secret, to sign API calls.
   *
   * @returns array("oauth_token" => "the-access-token",
   *                "oauth_token_secret" => "the-access-secret",
   *                "user_id" => "9436992",
   *                "screen_name" => "abraham")
   */
  public function getAccessToken($oauth_verifier = FALSE) {
    $parameters = array();
    if (!empty($oauth_verifier)) {
      $parameters['oauth_verifier'] = $oauth_verifier;
    }
    $request = $this->oAuthRequest($this->accessTokenURL(), 'GET', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }

  /**
   * One time exchange of username and password for access token and secret.
   *
   * @returns array("oauth_token" => "the-access-token",
   *                "oauth_token_secret" => "the-access-secret",
   *                "user_id" => "9436992",
   *                "screen_name" => "abraham",
   *                "x_auth_expires" => "0")
   */  
  public function getXAuthToken($username, $password) {
    $parameters = array();
    $parameters['x_auth_username'] = $username;
    $parameters['x_auth_password'] = $password;
    $parameters['x_auth_mode'] = 'client_auth';
    $request = $this->oAuthRequest($this->accessTokenURL(), 'POST', $parameters);
    $token = OAuthUtil::parse_parameters($request);
    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
    return $token;
  }

  /**
   * GET wrapper for oAuthRequest.
   */
  public function get($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'GET', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response, true);
    }
    return $response;
  }
  
  /**
   * POST wrapper for oAuthRequest.
   */
  public function post($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'POST', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response, true);
    }
    return $response;
  }

  /**
   * DELETE wrapper for oAuthReqeust.
   */
  public function delete($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'DELETE', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response, true);
    }
    return $response;
  }

  /**
   * Format and sign an OAuth / API request
   */
  public function oAuthRequest($url, $method, $parameters) {
    if (strrpos($url, 'https://') !== 0 && strrpos($url, 'http://') !== 0) {
      $url = "{$this->host}{$url}.{$this->format}";
    }
    $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $parameters);
    $request->sign_request($this->sha1_method, $this->consumer, $this->token);
    switch ($method) {
    case 'GET':
      return $this->http($request->to_url(), 'GET');
    default:
      return $this->http($request->get_normalized_http_url(), $method, $request->to_postdata());
    }
  }

  /**
   * Make an HTTP request
   *
   * @return API results
   */
  protected function http($url, $method, $postfields = NULL) {
    $this->http_info = array();
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
    curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
    curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
    curl_setopt($ci, CURLOPT_HEADER, FALSE);

    switch ($method) {
      case 'POST':
        curl_setopt($ci, CURLOPT_POST, TRUE);
        if (!empty($postfields)) {
          curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }
        break;
      case 'DELETE':
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
        if (!empty($postfields)) {
          $url = "{$url}?{$postfields}";
        }
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    $response = curl_exec($ci);
    $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
    $this->url = $url;
    curl_close ($ci);
    return $response;
  }

  /**
   * Get the header info to store.
   */
  public function getHeader($ch, $header) {
    $i = strpos($header, ':');
    if (!empty($i)) {
      $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
      $value = trim(substr($header, $i + 2));
      $this->http_header[$key] = $value;
    }
    return strlen($header);
  }
}
