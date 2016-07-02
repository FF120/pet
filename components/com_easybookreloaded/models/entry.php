<?php
/**
 * EBR - Easybook Reloaded for Joomla! 2.5
 * License: GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * Author: Viktor Vogel
 * Projectsite: http://joomla-extensions.kubik-rubik.de/ebr-easybook-reloaded
 *
 * @license GNU/GPL
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class EasybookReloadedModelEntry extends JModel
{
    var $_data = null;
    var $_id = null;
    var $_badwords = null;

    function __construct()
    {
        parent::__construct();

        if($hashrequest = JRequest::getVar('hash', '', 'default', 'base64'))
        {
            jimport('joomla.utilities.simplecrypt');
            $crypt = new JSimpleCrypt();
            $hash = base64_decode($hashrequest);
            $hash = $crypt->decrypt($hash);
            $hash = unserialize($hash);
            $id = $hash['id'];
        }
        else
        {
            $id = JRequest::getVar('cid', 0, '', 'int');
        }

        $this->setId($id);
    }

    function setId($id)
    {
        $this->_id = $id;
        $this->_data = null;
    }

    function getData()
    {
        $mainframe = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $user = JFactory::getUser();

        if(JRequest::getVar('retry') == 'true')
        {
            $this->_data = $this->getTable();
            $this->_data->bind($mainframe->getUserState('eb_validation_data'));
        }

        if(empty($this->_data))
        {
            $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook')." WHERE ".$this->_db->nameQuote('id')." = ".$this->_db->quote($this->_id);
            $this->_db->setQuery($query);
            $this->_data = $this->_db->loadObject();
        }

        if(!$this->_data)
        {
            $this->_data = $this->getTable();
            $this->_data->id = 0;

            if($user->get('id'))
            {
                if($params->get('registered_username'))
                {
                    $this->_data->gbname = $user->get('name');
                }
                else
                {
                    $this->_data->gbname = $user->get('username');
                }
                $this->_data->gbmail = $user->get('email');
            }
        }

        return $this->_data;
    }

    function store()
    {
        $mainframe = JFactory::getApplication();
        jimport('joomla.utilities.date');

        $row = $this->getTable();
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $user = JFactory::getUser();
        $data = JRequest::get('post');
        $data['gbtext'] = htmlspecialchars(JRequest::getVar('gbtext', NULL, 'post', 'none', JREQUEST_ALLOWRAW), ENT_QUOTES);
        $session = JFactory::getSession();
        $date = JFactory::getDate();

        if($user->guest == 0 AND !_EASYBOOK_CANEDIT)
        {
            if($params->get('registered_username'))
            {
                $data['gbname'] = $user->get('name');
            }
            else
            {
                $data['gbname'] = $user->get('username');
            }

            $data['gbmail'] = $user->get('email');
        }

        if(!isset($data['id']))
        {
            $data['gbdate'] = $date->toMysql();
            $data['published'] = $params->get('default_published', 1);

            if($params->get('enable_log', true))
            {
                $data['gbip'] = getenv('REMOTE_ADDR');
            }
            else
            {
                $data['gbip'] = "0.0.0.0";
            }

            $data['gbcomment'] = null;
        }

        if(!$this->validate($data))
        {
            return false;
        }

        if(!$row->bind($data))
        {
            $this->setError($this->_db->getErrorMsg());

            return false;
        }

        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());

            return false;
        }

        $session->clear('spamcheck1', 'easybookreloaded');
        $session->clear('spamcheck2', 'easybookreloaded');
        $session->clear('spamcheckresult', 'easybookreloaded');
        $session->clear('time', 'easybookreloaded');

        return $row;
    }

    function delete()
    {
        $row = $this->getTable();

        if(!$row->delete($this->_id))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        return true;
    }

    function publish()
    {
        $data = $this->getData();
        $status = $data->published;

        $query = "UPDATE ".$this->_db->nameQuote('#__easybook')." SET ".$this->_db->nameQuote('published')." = ".$this->_db->quote(!$status)." WHERE ".$this->_db->nameQuote('id')." = ".$this->_db->quote($this->_id)." LIMIT 1;";
        $this->_db->SetQuery($query);

        if(!$this->_db->query())
        {
            $this->setError($this->_db->getErrorMsg());
            return -1;
        }

        return (int) !$status;
    }

    function getEasyCalcCheck()
    {
        $mainframe = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $session = JFactory::getSession();
        $user = JFactory::getUser();

        if($params->get('enable_spam', true) AND ($params->get('enable_spam_reg') OR $user->guest))
        {
            $spamcheck1 = mt_rand(1, $params->get('max_value', 20));
            $spamcheck2 = mt_rand(1, $params->get('max_value', 20));

            if($params->get('operator') == 0)
            {
                $operator = 0;
            }
            elseif($params->get('operator') == 1)
            {
                $operator = 1;
            }
            elseif($params->get('operator') == 2)
            {
                $operator = mt_rand(0, 1);
            }

            if($operator == 0)
            {
                $spamcheckresult = $spamcheck1 + $spamcheck2;
                $operator = '+';
            }
            elseif($operator == 1)
            {
                $spamcheckresult = $spamcheck1 - $spamcheck2;
                $operator = '-';
            }

            $session->set('spamcheck1', $spamcheck1, 'easybookreloaded');
            $session->set('spamcheck2', $spamcheck2, 'easybookreloaded');
            $session->set('spamcheckresult', $spamcheckresult, 'easybookreloaded');
            $session->set('operator', $operator, 'easybookreloaded');
            $session->set('time', time(), 'easybookreloaded');
        }
    }

    function validate(&$data)
    {
        $mainframe = JFactory::getApplication();
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $session = JFactory::getSession();
        $user = JFactory::getUser();
        jimport('joomla.mail.helper');
        jimport('joomla.filter.filterinput');
        $filter = & JFilterInput::getInstance();
        $errors = array();
        $error = false;

        $spamcheck1 = $session->get('spamcheck1', null, 'easybookreloaded');
        $spamcheck2 = $session->get('spamcheck2', null, 'easybookreloaded');
        $spamcheckresult = $session->get('spamcheckresult', null, 'easybookreloaded');
        $time = $session->get('time', null, 'easybookreloaded');

        if(empty($data['gbname']))
        {
            $error = true;
            $errors['name'] = true;
        }

        if(empty($data['gbtext']))
        {
            $error = true;
            $errors['text'] = true;
        }

        if(($params->get('enable_spam', true) AND ($params->get('enable_spam_reg') OR $user->guest)) AND (($spamcheck1 == '') OR ($spamcheck2 == '') OR ($spamcheckresult == '') OR ($time == '')))
        {
            $error = true;
            $errors['sessionvariable'] = true;
        }

        if(!empty($data['gbtext']))
        {
            if(preg_match_all('@\[img\].+\[/img\]@isU', $data['gbtext'], $treffer))
            {
                $text = $data['gbtext'];

                foreach($treffer[0] as $wert)
                {
                    $img = str_replace(array('\'', "\""), '', $wert);

                    if(strpos($img, ' ') == true)
                    {
                        $img_neu = substr($img, 0, strpos($img, ' ')).'[/img]';
                        $text = str_replace($wert, $img_neu, $text);
                    }
                }
                $data['gbtext'] = $text;
            }

            if(preg_match_all('@https?://(www\.)?([a-zA-Z0-9-]+\.)?([a-zA-Z0-9-]{3,65})(\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))@is', $data['gbtext'], $matches))
            {
                if(count($matches[0]) > $params->get('maxnumberlinks'))
                {
                    $error = true;
                    $errors['toomanylinks'] = true;
                }
            }

            if(preg_match('@\[link.*\].*\[/link\]@isU', $data['gbtext']))
            {
                $error = true;
                $errors['easycalccheck'] = true;
            }
        }

        if(($params->get('enable_spam', true) AND ($params->get('enable_spam_reg') OR $user->guest)) AND (($data['easycalccheck'] != $spamcheckresult) OR ((time() - $params->get('type_time_sec')) <= $time)))
        {
            $error = true;
            $errors['easycalccheck'] = true;
        }

        if($params->get('block_ip'))
        {
            $gbip = getenv('REMOTE_ADDR');
            $ips = explode(",", $params->get('block_ip'));

            foreach($ips as $ip)
            {
                $ip = trim($ip);
                $pattern = "@$ip@";
                if(preg_match($pattern, $gbip))
                {
                    $error = true;
                    $errors['easycalccheck'] = true;
                }
            }
        }

        if($params->get('timelock_ip') AND $params->get('enable_log'))
        {
            $gbip = getenv('REMOTE_ADDR');
            $date_last_entry = $this->lastEntryDate($gbip);
            date_default_timezone_set('UTC');
            $date_back = strftime("%Y-%m-%d %H:%M:%S", time() - $params->get('timelock_ip'));

            if($date_last_entry > $date_back)
            {
                $error = true;
                $errors['iptimelock'] = true;
            }
        }

        if(!empty($data['gbaim']))
        {
            $allowed = '@^[A-Za-z0-9_\.]+$@';

            if(!preg_match($allowed, $data['gbaim']))
            {
                $error = true;
                $errors['aim'] = true;
            }
        }

        if(!empty($data['gbicq']))
        {
            $allowed = '@^[0-9]+$@';

            if(!preg_match($allowed, $data['gbicq']))
            {
                $error = true;
                $errors['icq'] = true;
            }
        }

        if(!empty($data['gbyah']))
        {
            $allowed = '@^[A-Za-z0-9_\.]+$@';

            if(!preg_match($allowed, $data['gbyah']))
            {
                $error = true;
                $errors['yah'] = true;
            }
        }

        if(!empty($data['gbskype']))
        {
            $allowed = '@^[A-Za-z0-9_\.-]+$@';

            if(!preg_match($allowed, $data['gbskype']))
            {
                $error = true;
                $errors['skype'] = true;
            }
        }

        if(!empty($data['gbpage']))
        {
            $data['gbpage'] = str_replace(array('\'', "\""), '', $data['gbpage']);

            if(strpos($data['gbpage'], ' ') == true)
            {
                $data['gbpage'] = substr($data['gbpage'], 0, strpos($data['gbpage'], ' '));
            }

            $data['gbpage'] = htmlspecialchars($data['gbpage'], ENT_QUOTES);
        }

        if((!empty($data['gbmail']) OR $params->get('require_mail', true)) AND !JMailHelper::isEmailAddress($data['gbmail']))
        {
            $error = true;
            $errors['mail'] = true;
        }

        if(($params->get('show_title', true)) AND (empty($data['gbtitle']) AND $params->get('require_title', true)))
        {
            $error = true;
            $errors['title'] = true;
        }
        elseif(!empty($data['gbtitle']))
        {
            $data['gbtitle'] = htmlspecialchars($data['gbtitle'], ENT_QUOTES);
        }

        if(!empty($data['gbmsn']) AND !JMailHelper::isEmailAddress($data['gbmsn']))
        {
            $error = true;
            $errors['msn'] = true;
        }

        if($params->get('badwordfilter', true))
        {
            $badwords = $this->_getBadwordList();
            foreach($badwords as $badword)
            {
                $data['gbtext'] = preg_replace("@".$badword->word."@iu", "***", $data['gbtext']);

                if(!empty($data['gbtitle']))
                {
                    $data['gbtitle'] = preg_replace("@".$badword->word."@iu", "***", $data['gbtitle']);
                }
            }
        }

        if($error)
        {
            $session->set('errors', $errors, 'easybookreloaded');
            $mainframe->setUserState('eb_validation_errors', $errors);
            $mainframe->setUserState('eb_validation_data', $data);

            return false;
        }
        else
        {
            return true;
        }
    }

    function savecomment()
    {
        $row = $this->getTable();
        $data = JRequest::get('post');
        $data['gbcomment'] = htmlspecialchars(JRequest::getVar('gbcomment', NULL, 'post', 'none', JREQUEST_ALLOWRAW), ENT_QUOTES);

        if(!$row->bind($data))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return $data;
    }

    function _getBadwordList()
    {
        if(empty($this->_badwords))
        {
            $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook_badwords')." ORDER BY length(word) DESC";
            $this->_db->setQuery($query);
            $this->_badwords = $this->_db->loadObjectList();
        }

        return $this->_badwords;
    }

    function lastEntryDate($ip)
    {
        $query = "SELECT ".$this->_db->nameQuote('gbdate')." FROM ".$this->_db->nameQuote('#__easybook')." WHERE ".$this->_db->nameQuote('gbip')." = ".$this->_db->quote($ip)." ORDER BY gbdate DESC";
        $this->_db->setQuery($query);
        $date_last_entry = $this->_db->loadResult();

        return $date_last_entry;
    }

    function getRow($id)
    {
        $id = (int) $id;
        $table = $this->getTable('entry');
        $table->load($id);

        return $table;
    }
}
?>