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

class EasybookReloadedControllerEntry extends JController
{
    var $_access = null;

    function __construct()
    {
        parent::__construct();

        $this->registerTask('add', 'edit');
    }

    function edit()
    {
        JRequest::setVar('view', 'entry');
        JRequest::setVar('layout', 'form');
        JRequest::setVar('hidemainmenu', 1);
        parent::display();
    }

    function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('entry');

        if($model->store())
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_SAVED');
            $type = 'message';
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_SAVING_ENTRY');
            $type = 'error';
        }

        $this->setRedirect('index.php?option=com_easybookreloaded', $msg, $type);
    }

    function remove()
    {
        JRequest::checkToken() or jexit('Invalid Token');
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

    function cancel()
    {
        $msg = JText::_('COM_EASYBOOKRELOADED_OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_easybookreloaded', $msg, 'notice');
    }

    function publish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('entry');

        if($model->publish(1))
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_PUBLISHED');
            $type = 'message';
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_CHANGE_PUBLISH_STATUS')." - ".$model->getError();
            $type = 'error';
        }

        $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
    }

    function unpublish()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('entry');

        if($model->publish(0))
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ENTRY_UNPUBLISHED');
            $type = 'message';
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_ERROR_COULD_NOT_CHANGE_PUBLISH_STATUS')." - ".$model->getError();
            $type = 'error';
        }

        $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded', false), $msg, $type);
    }
}
?>