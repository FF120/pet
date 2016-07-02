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

class EasybookReloadedModelEasybookReloaded extends JModel
{
    var $_data;
    var $_total;
    var $_pagination;

    function _buildQuery()
    {
        $ebconfig = JComponentHelper::getParams('com_easybookreloaded');
        $start = JRequest::getVar('limitstart', 0, '', 'int');
        $order = $this->_db->getEscaped($ebconfig->get('entries_order', "DESC"));
        $limit = intval($ebconfig->get('entries_perpage', 5));

        if(_EASYBOOK_CANEDIT)
        {
            $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook')." ORDER BY ".$this->_db->nameQuote('gbdate')." ".$order." LIMIT ".$start.", ".$limit;
        }
        else
        {
            $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook')." WHERE ".$this->_db->nameQuote('published')." = 1 ORDER BY ".$this->_db->nameQuote('gbdate')." ".$order." LIMIT ".$start.", ".$limit;
        }

        return $query;
    }

    function _buildCountQuery()
    {
        if(_EASYBOOK_CANEDIT)
        {
            $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook');
        }
        else
        {
            $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook')." WHERE ".$this->_db->nameQuote('published')." = 1";
        }

        return $query;
    }

    function getData()
    {
        if(empty($this->_data))
        {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query);
        }

        return $this->_data;
    }

    function getPagination()
    {
        $mainframe = JFactory::getApplication();
        $ebconfig = JComponentHelper::getParams('com_easybookreloaded');

        if(empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), JRequest::getVar('limitstart', 0), $ebconfig->get('entries_perpage', 5));
        }

        return $this->_pagination;
    }

    function getTotal()
    {
        if(empty($this->_total))
        {
            $query = $this->_buildCountQuery();
            $this->_total = $this->_getListCount($query);
        }

        return $this->_total;
    }

}
?>