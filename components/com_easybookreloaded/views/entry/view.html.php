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
        $mainframe = JFactory::getApplication();
        $document = JFactory::getDocument();
        $menus = JSite::getMenu();
        $params = JComponentHelper::getParams('com_easybookreloaded');
        $task = JRequest::getVar('task');
        $session = JFactory::getSession();
        $user = JFactory::getUser();

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

        if($params->get('show_rating'))
        {
            if($params->get('show_rating_type') == 0)
            {
                $document->addCustomTag('
                <script type="text/javascript">
                        //<![CDATA[
                        window.addEvent("load", function() {
                                MooStarRatingImages.defaultImageFolder = "'.JURI::base().'components/com_easybookreloaded/images";
                                var Rating = new MooStarRating({ form: "gbookForm", radios: "gbvote", imageEmpty: "sun_empty.png", imageFull:  "sun_full.png", imageHover: "sun_hover.png", tip: "<em>[VALUE] / [COUNT]</em>", tipTarget: $("easybookvotetip"), tipTargetType: "html"  });
                        });
                        //]]>
                </script>');
            }
            elseif($params->get('show_rating_type') == 1)
            {
                $document->addCustomTag('
                <script type="text/javascript">
                        //<![CDATA[
                        window.addEvent("load", function() {
                                MooStarRatingImages.defaultImageFolder = "'.JURI::base().'components/com_easybookreloaded/images";
                                var Rating = new MooStarRating({ form: "gbookForm", radios: "gbvote", imageEmpty: "star_empty.png", imageFull:  "star_full.png", imageHover: "star_hover.png", tip: "<em>[VALUE] / [COUNT]</em>", tipTarget: $("easybookvotetip"), tipTargetType: "html"  });
                        });
                        //]]>
                </script>');
            }
            elseif($params->get('show_rating_type') == 2)
            {
                $document->addCustomTag('
                <script type="text/javascript">
                        //<![CDATA[
                        window.addEvent("load", function() {
                                MooStarRatingImages.defaultImageFolder = "'.JURI::base().'components/com_easybookreloaded/images";
                                var Rating = new MooStarRating({ form: "gbookForm", radios: "gbvote", imageEmpty: "star_boxed_empty.png", imageFull:  "star_boxed_full.png", imageHover: "star_boxed_hover.png", width: 17, tip: "<em>[VALUE] / [COUNT]</em>", tipTarget: $("easybookvotetip"), tipTargetType: "html" });
                        });
                        //]]>
                </script>');
            }
        }

        $entry = $this->get('Data');
        $easycalccheck = $this->get('EasyCalcCheck');
        $entry->ip = getenv('REMOTE_ADDR');

        switch($task)
        {
            case 'add':
                $heading = $document->getTitle()." - ".JTEXT::_('COM_EASYBOOKRELOADED_SIGN_GUESTBOOK');
                break;
            case 'edit' OR 'edit_mail':
                $heading = $document->getTitle()." - ".JTEXT::_('COM_EASYBOOKRELOADED_EDIT_ENTRY');
                break;
            case 'comment' OR 'comment_mail':
                $heading = $document->getTitle()." - ".JTEXT::_('COM_EASYBOOKRELOADED_EDIT_COMMENT');
                break;
        }

        $this->assignRef('heading', $heading);
        $this->assignRef('entry', $entry);
        $this->assignRef('params', $params);
        $this->assignRef('session', $session);
        $this->assignRef('user', $user);

        parent::display($tpl);
    }
}
?>