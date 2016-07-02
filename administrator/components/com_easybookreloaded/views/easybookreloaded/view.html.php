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

class EasybookReloadedViewEasybookReloaded extends JView
{
    function display($tpl = null)
    {
        $mainframe = JFactory::getApplication();

        JToolBarHelper::title(JText::_('COM_EASYBOOKRELOADED_EASYBOOKRELOADED')." - ".JText::_('COM_EASYBOOKRELOADED_SUBMENU_ENTRIES'), 'easybookreloaded');
        JToolBarHelper::publishList();
        JToolBarHelper::unpublishList();
        JToolBarHelper::deleteList();
        JToolBarHelper::editListX();
        JToolBarHelper::addNewX();
        JToolBarHelper::preferences('com_easybookreloaded', '500');
        JHTML::_('stylesheet', 'easybookreloaded.css', 'administrator/components/com_easybookreloaded/css/');

        $items = $this->get('Data');
        $pagination = $this->get('Pagination');

        $this->assign('version', "<span style='border-bottom: dotted 1px #b9b9b9; padding-right: 5px; padding-left: 5px;'><strong><a href='http://joomla-extensions.kubik-rubik.de/ebr-easybook-reloaded' target='_blank' title='Easybook Reloaded'>Easybook Reloaded "._EASYBOOK_VERSION."</a></strong></span>");

        $lang = JFactory::getLanguage();

        if($lang->getTag() == "de-DE")
        {
            $donate_image = 'components/com_easybookreloaded/images/spenden.png';
        }
        else
        {
            $donate_image = 'components/com_easybookreloaded/images/donate.png';
        }

        $this->assignRef('pagination', $pagination);
        $this->assignRef('items', $items);
        $this->assignRef('donate_image', $donate_image);

        parent::display($tpl);
    }
}
?>