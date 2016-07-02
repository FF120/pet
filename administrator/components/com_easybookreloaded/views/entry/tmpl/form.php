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
$pane = JPane::getInstance('sliders');
?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div class="col100">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_EASYBOOKRELOADED_DETAILS'); ?></legend>
            <?php
            echo $pane->startPane("menu-pane");
            echo $pane->startPanel(JText ::_('COM_EASYBOOKRELOADED_BASIC_DATA'), "param-page");
            ?>
            <table class="admintable">
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbname">
                            <?php echo JText::_('COM_EASYBOOKRELOADED_AUTHOR'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbname" id="gbname" size="32" value="<?php echo $this->entry->gbname; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbdate">
                            <?php echo JText::_('COM_EASYBOOKRELOADED_DATE'); ?>:
                        </label>
                    </td>
                    <td>
                        <?php echo JHTML::_('calendar', $this->entry->gbdate, 'gbdate', 'gbdate', '%Y-%m-%d %H:%M:%S', array('class' => 'text_area', 'size' => '32', 'maxlength' => '19')); ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbmail">
                            <?php echo JText::_('COM_EASYBOOKRELOADED_EMAIL'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbmail" id="gbmail" size="32" value="<?php echo $this->entry->gbmail; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbmailshow">
                            <?php echo JText::_('COM_EASYBOOKRELOADED_SHOW_EMAIL'); ?>:
                        </label>
                    </td>
                    <td>
                        <input style="float: none !important" class="text_area" type="radio" name="gbmailshow" id="gbmailshow" value="1" <?php if($this->entry->gbmailshow)
                            {
                                echo "checked='checked'";
                            } ?> /><?php echo JText::_('JYES'); ?>
                        <input style="float: none !important" class="text_area" type="radio" name="gbmailshow" id="gbmailshow" value="0" <?php if(!$this->entry->gbmailshow)
                            {
                                echo "checked='checked'";
                            } ?> /><?php echo JText::_('JNO'); ?>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbtitle">
<?php echo JText::_('COM_EASYBOOKRELOADED_TITLE'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbtitle" id="gbtitle" size="32" value="<?php echo $this->entry->gbtitle; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbtext">
<?php echo JText::_('COM_EASYBOOKRELOADED_ENTRY'); ?>:
                        </label>
                    </td>
                    <td>
                        <textarea class="text_area" rows="10" cols="60" id="gbtext" name="gbtext"><?php echo $this->entry->gbtext; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbcomment">
<?php echo JText::_('COM_EASYBOOKRELOADED_COMMENT'); ?>:
                        </label>
                    </td>
                    <td>
                        <textarea class="text_area" rows="6" cols="60" id="gbcomment" name="gbcomment"><?php echo $this->entry->gbcomment; ?></textarea>
                    </td>
                </tr>
            </table>
            <?php
            echo $pane->endPanel();
            echo $pane->startPanel(JText :: _('COM_EASYBOOKRELOADED_CONTACT_DETAILS'), "param-page");
            ?>
            <table class="admintable">
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbpage">
<?php echo JText::_('COM_EASYBOOKRELOADED_HOMEPAGE'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbpage" id="gbpage" size="32" value="<?php echo $this->entry->gbpage; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbloca">
<?php echo JText::_('COM_EASYBOOKRELOADED_LOCATION'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbloca" id="gbloca" size="32" value="<?php echo $this->entry->gbloca; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbicq">
<?php echo JText::_('COM_EASYBOOKRELOADED_ICQ'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbicq" id="gbicq" size="32" value="<?php echo $this->entry->gbicq; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbaim">
<?php echo JText::_('COM_EASYBOOKRELOADED_AIM'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbaim" id="gbaim" size="32" value="<?php echo $this->entry->gbaim; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbmsn">
<?php echo JText::_('COM_EASYBOOKRELOADED_MSN'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbmsn" id="gbmsn" size="32" value="<?php echo $this->entry->gbmsn; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbyah">
<?php echo JText::_('COM_EASYBOOKRELOADED_YAHOO'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbyah" id="gbyah" size="32" value="<?php echo $this->entry->gbyah; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbskype">
<?php echo JText::_('COM_EASYBOOKRELOADED_SKYPE'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbskype" id="gbskype" size="32" value="<?php echo $this->entry->gbskype; ?>" />
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right" class="key">
                        <label for="gbip">
<?php echo JText::_('COM_EASYBOOKRELOADED_VISITOR_IP'); ?>:
                        </label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="gbip" id="gbip" size="32" value="<?php echo $this->entry->gbip; ?>" />
                    </td>
                </tr>
            </table>
            <?php
            echo $pane->endPanel();
            echo $pane->endPane();
            ?>
        </fieldset>
    </div>

    <div class="clr"></div>

    <input type="hidden" name="option" value="com_easybookreloaded" />
    <input type="hidden" name="id" value="<?php echo $this->entry->id; ?>" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="controller" value="entry" />
<?php echo JHTML::_('form.token'); ?>
</form>