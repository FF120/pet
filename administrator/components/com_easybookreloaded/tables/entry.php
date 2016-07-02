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

class TableEntry extends JTable
{
    var $id = null;
    var $gbip = null;
    var $gbname = null;
    var $gbmail = null;
    var $gbmailshow = null;
    var $gbloca = null;
    var $gbpage = null;
    var $gbvote = null;
    var $gbtext = null;
    var $gbdate = null;
    var $gbtitle = null;
    var $gbcomment = null;
    var $published = null;
    var $gbicq = null;
    var $gbaim = null;
    var $gbmsn = null;
    var $gbyah = null;
    var $gbskype = null;

    function TableEntry(&$db)
    {
        parent::__construct('#__easybook', 'id', $db);
    }
}
?>