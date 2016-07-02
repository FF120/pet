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

/**
 * Easybook View
 *
 * @package    Easybook
 */
class EasybookReloadedViewEasybookReloaded extends JView
{
    /**
     * Easybook view display method
     * @return void
     * */
    function display($tpl = null)
    {
        $mainframe = JFactory::getApplication();
        $document = JFactory::getDocument();
        $menus = JSite::getMenu();
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $task = JRequest::getVar('task');

        // Set CSS File
        if($params->get('template') == 0)
        {
            JHTML::_('stylesheet', 'easybookreloaded.css', 'components/com_easybookreloaded/css/');
        }
        elseif($params->get('template') == 1)
        {
            JHTML::_('stylesheet', 'easybookreloadeddark.css', 'components/com_easybookreloaded/css/');
        }
        elseif($params->get('template') == 2)
        {
            JHTML::_('stylesheet', 'easybookreloadedtransparent.css', 'components/com_easybookreloaded/css/');
        }

        $document->addCustomTag('
		<!--[if IE 6]>
    		<style type="text/css">
                    .easy_align_middle { behavior: url('.JURI::base().'components/com_easybookreloaded/scripts/pngbehavior.htc); }
                    .png { behavior: url('.JURI::base().'components/com_easybookreloaded/scripts/pngbehavior.htc); }
    		</style>
  		<![endif]-->');

        // Get some Data
        $entries = $this->get('Data');
        $count = $this->get('Total');
        $pagination = $this->get('Pagination');

        // Show RSS Feed
        $link = '&format=feed&limitstart=';
        $attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
        $document->addHeadLink(JRoute::_($link.'&type=rss'), 'alternate', 'rel', $attribs);
        $attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
        $document->addHeadLink(JRoute::_($link.'&type=atom'), 'alternate', 'rel', $attribs);

        // Document page title
        $menu = $menus->getActive();
        switch($task)
        {
            case 'add':
                $document->setTitle($heading = $menu->name." - ".JTEXT::_('COM_EASYBOOKRELOADED_SIGN_GUESTBOOK'));
                break;
            case 'edit':
                $document->setTitle($heading = $menu->name." - ".JTEXT::_('COM_EASYBOOKRELOADED_EDIT_ENTRY'));
                break;
            case 'comment':
                $document->setTitle($heading = $menu->name." - ".JTEXT::_('COM_EASYBOOKRELOADED_EDIT_COMMENT'));
                break;
        }

        $heading = $document->getTitle();

        // Assign Data to template
        $this->assignRef('heading', $heading);
        $this->assignRef('entries', $entries);
        $this->assignRef('count', $count);
        $this->assignRef('pagination', $pagination);
        $this->assignRef('params', $params);

        // Add HTML Head Link
        if(method_exists($document, "addHeadLink"))
        {
            $paginationdata = $pagination->getData();

            if($paginationdata->start->link)
            {
                $document->addHeadLink($paginationdata->start->link, "first");
            }

            if($paginationdata->previous->link)
            {
                $document->addHeadLink($paginationdata->previous->link, "prev");
            }

            if($paginationdata->next->link)
            {
                $document->addHeadLink($paginationdata->next->link, "next");
            }

            if($paginationdata->end->link)
            {
                $document->addHeadLink($paginationdata->end->link, "last");
            }
        }
        // Display template
        parent::display($tpl);
    }
}