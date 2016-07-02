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
?>
<!-- Easybook Reloaded - Joomla! 2.5 Component by Kubik-Rubik.de - Viktor Vogel -->
<div id="easybook">
    <?php if($this->params->get('show_page_title', 1)) : ?>
        <h2 class="componentheading"><?php echo $this->heading ?></h2>
    <?php endif; ?>
    <div class="easy_entrylink">
        <?php
        if(_EASYBOOK_CANADD AND !$this->params->get('offline'))
        {
            echo "<a class=\"sign\" href='".JRoute::_('index.php?option=com_easybookreloaded&controller=entry&task=add')."' style=\"text-decoration: none !important;\">";
            echo "<strong>".JText::_('COM_EASYBOOKRELOADED_SIGN_GUESTBOOK');
            echo JHTML::_('image', 'components/com_easybookreloaded/images/new.png', JText::_('COM_EASYBOOKRELOADED_SIGN_GUESTBOOK').":", 'height="16" border="0" width="16" class="png" style="vertical-align: middle; padding-left: 3px;"')."</strong></a>";
        }

        if($this->params->get('show_introtext') == 1)
        {
            ?>
            <div class='easy_intro'>
                <br /><?php echo nl2br($this->params->get('introtext')); ?>
            </div>
        <?php
        }
        elseif($this->params->get('show_introtext') == 2)
        {
            ?>
            <div class='easy_intro'>
                <br /><?php echo JTEXT::_('COM_EASYBOOKRELOADED_INTROTEXT'); ?>
            </div>
<?php } ?>
        <br />
        <br />