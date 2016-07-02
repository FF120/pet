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
jimport('joomla.application.component.controller');

class EasybookReloadedController extends JController
{

    function display()
    {
        parent::display();
    }

    function publish_mail()
    {
        $hashrequest = JRequest::getVar('hash', '', 'default', 'base64');
        $error = $this->performMail($hashrequest);

        if($error == false)
        {
            $model = $this->getModel('entry');

            switch($model->publish())
            {
                case -1:
                    $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_CHANGE_PUBLISH_STATUS');
                    $type = 'error';
                    break;
                case 0:
                    $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_UNPUBLISHED');
                    $type = 'message';
                    break;
                case 1:
                    $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_PUBLISHED');
                    $type = 'message';
                    break;
            }

            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_CHANGE_PUBLISH_STATUS');
            $type = 'error';
            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
    }

    function remove_mail()
    {
        $hashrequest = JRequest::getVar('hash', '', 'default', 'base64');
        $error = $this->performMail($hashrequest);

        if($error == false)
        {
            $model = $this->getModel('entry');

            if(!$model->delete())
            {
                $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_ENTRY_COULD_NOT_BE_DELETED');
                $type = 'error';
            }
            else
            {
                $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_DELETED');
                $type = 'message';
            }

            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_ENTRY_COULD_NOT_BE_DELETED');
            $type = 'error';
            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
    }

    function comment_mail()
    {
        $hashrequest = JRequest::getVar('hash', '', 'default', 'base64');
        $error = $this->performMail($hashrequest);

        if($error == false)
        {
            JRequest::setVar('view', 'entry');
            JRequest::setVar('layout', 'commentform_mail');
            JRequest::setVar('hidemainmenu', 1);
            parent::display();
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_SAVE_COMMENT');
            $type = 'error';
            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
    }

    function savecomment_mail()
    {
        $hashrequest = JRequest::getVar('hash', '', 'default', 'base64');
        $error = $this->performMail($hashrequest);

        if($error == false)
        {
            $model = $this->getModel('entry');

            if(!$row = $model->savecomment())
            {
                $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_SAVE_COMMENT');
                $type = 'error';
            }
            else
            {
                if(isset($row['inform']) AND $row['inform'] == 1)
                {
                    $data = $model->getRow($row['id']);
                    $uri = JFactory::getURI();
                    $mail = JFactory::getMailer();
                    $params = JComponentHelper::getParams('com_easybookreloaded');
                    require_once(JPATH_SITE.DS.'components'.DS.'com_easybookreloaded'.DS.'helpers'.DS.'route.php');

                    $href = $uri->base().EasybookReloadedHelperRoute::getEasybookReloadedRoute($data->get('id'));
                    $mail->setsubject(JTEXT::_('COM_EASYBOOKRELOADED_ADMIN_COMMENT_SUBJECT'));

                    if($params->get('send_mail_html'))
                    {
                        $mail->IsHTML(true);
                        $mail->setbody(JTEXT::sprintf('COM_EASYBOOKRELOADED_ADMIN_COMMENT_BODY_HTML', $data->get('gbname'), $uri->base(), $href));
                    }
                    else
                    {
                        $mail->setbody(JTEXT::sprintf('COM_EASYBOOKRELOADED_ADMIN_COMMENT_BODY', $data->get('gbname'), $uri->base(), $href));
                    }

                    $mail->addrecipient($data->get('gbmail'));
                    $mail->send();

                    $msg = JText::_('COM_EASYBOOKRELOADED_COMMENT_SAVED_INFORM');
                }
                else
                {
                    $msg = JText::_('COM_EASYBOOKRELOADED_COMMENT_SAVED');
                }

                $type = 'message';
            }

            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_SAVE_COMMENT');
            $type = 'error';
            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
    }

    function edit_mail()
    {
        $hashrequest = JRequest::getVar('hash', '', 'default', 'base64');
        $error = $this->performMail($hashrequest);

        if($error == false)
        {
            JRequest::setVar('view', 'entry');
            JRequest::setVar('layout', 'form_mail');
            parent::display();
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_PLEASE_VALIDATE_YOUR_INPUTS');
            $type = 'error';
            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
    }

    function save_mail()
    {
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $hashrequest = JRequest::getVar('hash', '', 'default', 'base64');
        $error = $this->performMail($hashrequest);

        if($error == false)
        {
            $session = JFactory::getSession();
            $time = $session->get('time', null, 'easybookreloaded');
            $session->set('time', $time - $params->get('type_time_sec'), 'easybookreloaded');

            $model = $this->getModel('entry');
            if($model->store())
            {
                if($params->get('default_published', true))
                {
                    $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_SAVED');
                    $type = 'message';
                }
                else
                {
                    $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_SAVED_BUT_HAS_TO_BE_APPROVED');
                    $type = 'notice';
                }
                $link = JRoute::_('index.php?option=com_easybookreloaded&view=easybookreloaded', false);
            }
            else
            {
                $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_SAVE_COMMENT');
                $link = JRoute::_('index.php?option=com_easybookreloaded&view=easybookreloaded', false);
                $type = 'notice';
            }
            $this->setRedirect($link, $msg, $type);
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_SAVE_COMMENT');
            $type = 'error';
            $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
        }
    }

    function performMail($hashrequest)
    {
        $model = $this->getModel('entry');

        $params = JComponentHelper::getParams('com_easybookreloaded');
        $secretword = $params->get('secret_word');
        $error = false;

        jimport('joomla.utilities.simplecrypt');
        $crypt = new JSimpleCrypt();

        if($hashrequest == '')
        {
            $error = true;
            return $error;
        }

        $hash = base64_decode($hashrequest);
        $hash = $crypt->decrypt($hash);
        $hash = unserialize($hash);

        if(isset($hash['id']))
        {
            $gbrow = $model->getRow($hash['id']);
        }
        else
        {
            $error = true;
            return $error;
        }

        $app = JFactory::getApplication();
        $offset = $app->getCfg('offset');

        $date_entry = JFactory::getDate($gbrow->get('gbdate'));
        $date_entry->setOffset($offset);

        $date_now = JFactory::getDate();
        $date_now->setOffset($offset);

        $valid_time_emailnot = $params->get('valid_time_emailnot') * 60 * 60 * 24;

        if($date_entry->toUnix() + $valid_time_emailnot <= $date_now->toUnix())
        {
            $error = true;
            return $error;
        }

        if(md5($gbrow->get('gbmail')) != $hash['gbmail'])
        {
            $error = true;
            return $error;
        }

        if($gbrow->get('gbname') != $hash['username'])
        {
            $error = true;
            return $error;
        }

        if($hash['custom_secret'] != $secretword)
        {
            $error = true;
            return $error;
        }

        $hash = array();
        $hash['id'] = (int) $gbrow->get('id');
        $hash['gbmail'] = md5($gbrow->get('gbmail'));
        $hash['custom_secret'] = $secretword;
        $hash['username'] = $gbrow->get('gbname');
        $hash = serialize($hash);
        $hash = $crypt->encrypt($hash);
        $hash = base64_encode($hash);

        if($hash != $hashrequest)
        {
            $error = true;
            return $error;
        }

        return $error;
    }
}
?>