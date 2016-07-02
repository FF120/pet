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
defined('_JEXEC') or die;

class EasybookReloadedHelper
{
    public static function addSubmenu($vName)
    {
        JSubMenuHelper::addEntry(JText::_('COM_EASYBOOKRELOADED_SUBMENU_ENTRIES'), 'index.php?option=com_easybookreloaded', $vName == 'easybookreloaded');

        JSubMenuHelper::addEntry(JText::_('COM_EASYBOOKRELOADED_SUBMENU_CONFIG'), 'index.php?option=com_easybookreloaded&amp;task=config', $vName == 'config');

        JSubMenuHelper::addEntry(JText::_('COM_EASYBOOKRELOADED_SUBMENU_BADWORDFILTER'), 'index.php?option=com_easybookreloaded&amp;controller=badwords', $vName == 'badwords');

        JSubMenuHelper::addEntry(JText::_('COM_EASYBOOKRELOADED_SUBMENU_ABOUT'), 'index.php?option=com_easybookreloaded&amp;task=about', $vName == 'about');
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @param	int		The category ID.
     * @param	int		The contact ID.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions($categoryId = 0, $contactId = 0)
    {
        $user = JFactory::getUser();
        $result = new JObject;

        if(empty($contactId) && empty($categoryId))
        {
            $assetName = 'com_contact';
        }
        elseif(empty($contactId))
        {
            $assetName = 'com_contact.category.'.(int) $categoryId;
        }
        else
        {
            $assetName = 'com_contact.contact.'.(int) $contactId;
        }

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach($actions as $action)
        {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

}
