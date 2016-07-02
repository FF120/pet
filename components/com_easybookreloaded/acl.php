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

$user = JFactory::getUser();
$params = JComponentHelper::getParams('com_easybookreloaded');
$canAdd = false;
$canEdit = false;

$add_acl_array = $params->get('add_acl', array(1));
$admin_acl_array = $params->get('admin_acl', array(8));

$usergroup = JAccess::getGroupsByUser($user->id);

foreach($usergroup as $value)
{
    foreach($add_acl_array as $add_acl_value)
    {
        if($value == $add_acl_value)
        {
            $canAdd = true;
        }
        if($value == 8)
        {
            $canAdd = true;
        }
    }
    foreach($admin_acl_array as $admin_acl_value)
    {
        if($value == $admin_acl_value)
        {
            $canEdit = true;
        }
        if($value == 8)
        {
            $canEdit = true;
        }
    }
}

define('_EASYBOOK_CANADD', $canAdd);
define('_EASYBOOK_CANEDIT', $canEdit);
?>