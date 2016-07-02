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

    function __construct()
    {
        parent::__construct();

        $array = JRequest::getVar('cid', 0, '', 'array');
        $this->setId((int) $array[0]);
    }

    function setId($id)
    {
        $this->_id = $id;
        $this->_data = null;
    }

    function getData()
    {
        $mainframe = JFactory::getApplication();

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
        }

        return $this->_data;
    }

    function store()
    {
        $mainframe = JFactory::getApplication();
        $row = &$this->getTable();
        $data = JRequest::get('post');
        $data['gbtext'] = htmlspecialchars(JRequest::getVar('gbtext', NULL, 'post', 'none', JREQUEST_ALLOWRAW), ENT_QUOTES);

        $date = &JFactory::getDate($data['gbdate'], $mainframe->getCfg('offset'));
        $data['gbdate'] = $date->toMySQL();

        if(!$row->bind($data))
        {
            $this->setError($this->_db->getErrorMsg());

            return false;
        }

        if(!$row->check())
        {
            $this->setError($this->_db->getErrorMsg());

            return false;
        }

        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());

            return false;
        }

        return true;
    }

    function delete()
    {
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable();

        foreach($cids as $cid)
        {
            if(!$row->delete($cid))
            {
                $this->setError($row->_db->getErrorMsg());
                return false;
            }
        }

        return true;
    }

    function publish($state)
    {
        $cids = JRequest::getVar('cid', array(0), 'post', 'array');
        $row = $this->getTable();

        if(!$row->publish($cids, $state))
        {
            $this->setError($row->getError());

            return false;
        }

        return true;
    }
}
?>