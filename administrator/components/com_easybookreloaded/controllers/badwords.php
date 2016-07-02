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

class EasybookReloadedControllerBadwords extends JController
{
    function __construct()
    {
        parent::__construct();
        $this->registerTask('add', 'edit');
    }

    function edit()
    {
        JRequest::setVar('view', 'badword');
        JRequest::setVar('layout', 'form');
        JRequest::setVar('hidemainmenu', 1);
        parent::display();
    }

    function save()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('badword');

        if($model->store())
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_BADWORDSAVEDSUCCESS');
            $type = 'message';
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_BADWORDSAVEDFAIL');
            $type = 'error';
        }

        $this->setRedirect('index.php?option=com_easybookreloaded&controller=badwords', $msg, $type);
    }

    function remove()
    {
        JRequest::checkToken() or jexit('Invalid Token');
        $model = $this->getModel('badword');

        if(!$model->delete())
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_BADWORDDELETEFAIL');
            $type = 'error';
        }
        else
        {
            $msg = JText::_('COM_EASYBOOKRELOADED_BADWORDDELETESUCCESS');
            $type = 'message';
        }

        $this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded&controller=badwords', false), $msg, $type);
    }

    function cancel()
    {
        $msg = JText::_('COM_EASYBOOKRELOADED_OPERATION_CANCELLED');
        $this->setRedirect('index.php?option=com_easybookreloaded&controller=badwords', $msg, 'notice');
    }

    function display()
    {
        JRequest::setVar('view', 'badwords');

        require_once JPATH_COMPONENT.'/helpers/easybookreloaded.php';

        EasybookReloadedHelper::addSubmenu(JRequest::getCmd('view', 'easybookreloaded'));

        parent::display();
    }
}
?>