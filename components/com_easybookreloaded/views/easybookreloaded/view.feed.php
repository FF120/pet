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
        $document = JFactory::getDocument();
        $document->link = JRoute::_('index.php?option=com_easybookreloaded&view=easybookreloaded');
        JRequest::setVar('limit', $mainframe->getCfg('feed_limit'));

        // Get some data from the model
        $items = $this->get('Data');

        foreach($items as $item)
        {
            // strip html from feed item title
            $title = $this->escape($item->gbname);
            $title = html_entity_decode($title);

            // url link to article
            $link = JRoute::_('index.php?option=com_easybookreloaded&view=easybookreloaded#gbentry_'.$item->id);

            // strip html from feed item description text
            $description = $item->gbtext;
            $date = ($item->gbdate ? date('r', strtotime($item->gbdate)) : '');

            // load individual item creator class
            $feeditem = new JFeedItem();
            $feeditem->title = $title;
            $feeditem->link = $link;
            $feeditem->description = $description;
            $feeditem->date = $date;
            $feeditem->category = 'Guestbook';

            // loads item info into rss array
            $document->addItem($feeditem);
        }
    }
}
?>