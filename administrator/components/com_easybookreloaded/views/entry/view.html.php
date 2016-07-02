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
jimport('joomla.application.component.view');

class EasybookReloadedViewEntry extends JView
{
    function display($tpl = null)
    {
        jimport('joomla.html.pane');
        $mainframe = JFactory::getApplication();

        JHTML::_('stylesheet', 'easybookreloaded.css', 'administrator/components/com_easybookreloaded/css/');

        $entry = $this->get('Data');
        $isNew = ($entry->id < 1);

        $text = $isNew ? JText::_('COM_EASYBOOKRELOADED_NEWENTRY') : JText::_('COM_EASYBOOKRELOADED_EDITENTRY');
        JToolBarHelper::title(JText::_('COM_EASYBOOKRELOADED_ENTRY').': <small><small>['.$text.']</small></small>', 'easybookreloaded');
        JToolBarHelper::save();

        if($isNew)
        {
            JToolBarHelper::cancel();
        }
        else
        {
            JToolBarHelper::cancel('cancel', 'Close');
        }

        JHTML::_('behavior.calendar');

        $config = JFactory::getConfig();
        $offset = $config->getValue('config.offset');

        $date = JFactory::getDate($entry->gbdate);
        $date->setOffset($offset);
        $entry->gbdate = $date->toFormat();

        $this->assignRef('entry', $entry);
        parent::display($tpl);
    }
}
?>