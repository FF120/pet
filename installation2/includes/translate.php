<?php
/**
 * @package akeebainstaller
 * @copyright Copyright (C) 2009-2013 Nicholas K. Dionysopoulos. All rights reserved.
 * @author Nicholas K. Dionysopoulos - http://www.dionysopoulos.me
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL v3 or later
 *
 * Akeeba Backup Installer Translation Class
 */

defined('_ABI') or die('Direct access is not allowed');

/**
 * Akeeba Translation Class
 */
class ABIText
{
	/**
	 * An associative array of translation strings
	 * @var array
	 */
	var $_lang;

	/**
	 * Singleton implementation
	 * @return ABIText
	 */
	static function &getInstance()
	{
		static $instance;

		if(!is_object($instance))
		{
			$instance = new ABIText();
		}

		return $instance;
	}

	/**
	 * Class constructor. Loads the translation files for the installer,
	 * honouring user's browser settings
	 * @return ABIText
	 */
	function ABIText()
	{
		// Load default language (English)
		$this->_lang = $this->parse_lang_file(JPATH_INSTALLATION.'/lang/en-GB.ini');

		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$languages = strtolower( $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
			// $languages = ' fr-ch;q=0.3, da, en-us;q=0.8, en;q=0.5, fr;q=0.3';
			// need to remove spaces from strings to avoid error
			$languages = str_replace( ' ', '', $languages );
			$languages = explode( ",", $languages );

			foreach ( $languages as $language_list )
			{
				// pull out the language, place languages into array of full and primary
				// string structure:
				$temp_array = array();
				// slice out the part before ; on first step, the part before - on second, place into array
				$temp_array[0] = substr( $language_list, 0, strcspn( $language_list, ';' ) );//full language
				$temp_array[1] = substr( $language_list, 0, 2 );// cut out primary language
				if( (strlen($temp_array[0]) == 5) && ( (substr($temp_array[0],2,1) == '-') || (substr($temp_array[0],2,1) == '_') ) )
				{
					$langLocation = strtoupper(substr($temp_array[0],3,2));
					$temp_array[0] = $temp_array[1].'-'.$langLocation;
				}
				//place this array into main $user_languages language array
				$user_languages[] = $temp_array;
			}
			
			$baseName = JPATH_INSTALLATION.'/lang/';
			foreach($user_languages as $languageStruct) {
				// Search for exact language
				$langFilename = $baseName.$languageStruct[0].'.ini';
				if(!file_exists($langFilename)) {
					$langFilename = '';
					if(function_exists('glob')) {
						$allFiles = glob($baseName.$languageStruct[1].'-*.ini');
						if(count($allFiles)) {
							$langFilename = array_shift($allFiles);
						}
					}
				}
				
				if(!empty($langFilename)) {
					$langLocal = $this->parse_lang_file($langFilename);
					$this->_lang = array_merge($this->_lang, $langLocal);
					unset( $langLocal );
					unset( $langEnglish );
					return; // So that we don't end up overwritting the language with a less important language!
				}
			}
		}
	}
	
	function parse_lang_file($filename)
	{
		$ret = array();
		if(!file_exists($filename)) return array();
		$lines = file($filename);
		foreach($lines as $line)
		{
			$line = ltrim($line);
			if( (substr($line,0,1) == '#') || (substr($line,0,2) == '//') ) continue;
			$entries = explode('=',$line,2);
			if(isset($entries[1])) {
				$string = trim($entries[1]);
				if(substr($string, 0, 1) == '"') $string = trim($string, '"');
				$ret[$entries[0]] = rtrim($string,"\n\r");
			}
		}
		return $ret;
	}

	/**
	 * Performs the real translation of the static _() function
	 * @param $key string Translation key
	 * @return string Translation text
	 */
	function _realTranslate($key)
	{
		if(array_key_exists($key, $this->_lang))
		{
			return $this->_lang[$key];
		}
		else
		{
			return $key;
		}
	}

	/**
	 * Returns the translation text of a given key
	 * @param $key string Translation key
	 * @return string Translation text
	 * @static
	 */
	public static function _($key)
	{
		static $instance;

		if(!is_object($instance))
		{
			$instance = ABIText::getInstance();
		}

		return $instance->_realTranslate($key);
	}

}