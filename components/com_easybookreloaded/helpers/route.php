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
jimport('joomla.application.component.helper');

class EasybookReloadedHelperRoute
{
    function getEasybookReloadedRoute($id, $Itemid)
    {
        $limit = EasybookReloadedHelperRoute::_limitstart($id);
        $link = 'index.php?option=com_easybookreloaded&view=easybookreloaded';
        $link .= '&Itemid='.$Itemid;

        if($limit != 0)
        {
            $link .= '&limitstart='.$limit;
        }

        $link .= '#gbentry_'.$id;

        return $link;
    }

    function getEasybookReloadedRouteHashPublish($id, $Itemid)
    {
        $link = 'index.php?option=com_easybookreloaded&task=publish_mail';
        $link .= '&Itemid='.$Itemid;
        $link .= '&hash=';

        return $link;
    }

    function getEasybookReloadedRouteHashDelete($id, $Itemid)
    {
        $link = 'index.php?option=com_easybookreloaded&task=remove_mail';
        $link .= '&Itemid='.$Itemid;
        $link .= '&hash=';

        return $link;
    }

    function getEasybookReloadedRouteHashComment($id, $Itemid)
    {
        $link = 'index.php?option=com_easybookreloaded&task=comment_mail';
        $link .= '&Itemid='.$Itemid;
        $link .= '&hash=';

        return $link;
    }

    function getEasybookReloadedRouteHashEdit($id, $Itemid)
    {
        $link = 'index.php?option=com_easybookreloaded&task=edit_mail';
        $link .= '&Itemid='.$Itemid;
        $link .= '&hash=';

        return $link;
    }

    function _limitstart($id)
    {
        $bookParams = JComponentHelper::getParams('com_easybookreloaded');
        $bookEntrieperPage = $bookParams->get('entries_perpage', 5);

        $db = JFactory::getDBO();
        $query = "SELECT * FROM ".$db->nameQuote('#__easybook')." WHERE ".$db->nameQuote('published')." = 1 ORDER BY ".$db->nameQuote('id')." DESC";
        $db->setQuery($query);
        $db->query();
        $result = $db->loadResultArray();

        $key = array_search($id, $result);
        $limit = $bookEntrieperPage * intval($key / $bookEntrieperPage);

        return $limit;
    }
}
?>