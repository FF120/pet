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
<div id="easybook">
    <?php if($this->params->get('show_page_title', 1))
    { ?>
        <h2 class="componentheading"><?php echo $this->heading ?></h2>
    <?php } ?>
    <div class="easy_entrylink">
        <strong><a class="view" href="<?php echo JRoute::_('index.php?option=com_easybookreloaded'); ?>" style="text-decoration: none !important;"><?php echo JText::_('COM_EASYBOOKRELOADED_READ_GUESTBOOK'); ?><?php echo JHTML::_('image', 'components/com_easybookreloaded/images/book.png', JText::_('COM_EASYBOOKRELOADED_READ_GUESTBOOK').":", 'height="16" border="0" width="16" class="png" style="vertical-align: middle; padding-left: 3px;"'); ?></a></strong>
        <br /><br />
        <script type="text/javascript">
            function x()
            {
                return;
            }

            function insertprompt(insert, input, start, end, revisedMessage, currentMessage)
            {
                // Internet Explorer
                if (typeof document.selection != 'undefined')
                {
                    var range = document.selection.createRange();
                    range.text = insert;
                    var range = document.selection.createRange();
                    range.move('character', 0);
                    range.select();
                }
                // Gecko Software
                else if (typeof input.selectionStart != 'undefined')
                {
                    revisedMessage = currentMessage.substr(0, start) + insert + currentMessage.substr(end);
                    document.gbookForm.gbcomment.value=revisedMessage;
                    document.gbookForm.gbcomment.focus();
                    var pos;
                    pos = start + insert.length;
                    input.selectionStart = pos;
                    input.selectionEnd = pos;
                }
            }

            function insert(aTag, eTag)
            {
                var input = document.forms['gbookForm'].elements['gbcomment'];
                input.focus();
                // Internet Explorer
                if(typeof document.selection != 'undefined')
                {
                    var range = document.selection.createRange();
                    var insText = range.text;
                    range.text = aTag + insText + eTag;
                    range = document.selection.createRange();
                    if (insText.length == 0)
                    {
                        range.move('character', -eTag.length);
                    }
                    else
                    {
                        range.moveStart('character', aTag.length + insText.length + eTag.length);
                    }
                    range.select();
                }
                // Gecko Software
                else if (typeof input.selectionStart != 'undefined')
                {
                    var start = input.selectionStart;
                    var end = input.selectionEnd;
                    var insText = input.value.substring(start, end);
                    input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
                    var pos;
                    if (insText.length == 0)
                    {
                        pos = start + aTag.length;
                    }
                    else
                    {
                        pos = start + aTag.length + insText.length + eTag.length;
                    }
                    input.selectionStart = pos;
                    input.selectionEnd = pos;
                }
                else
                {
                    var pos;
                    var re = new RegExp('^[0-9]{0,3}$');
                    while (!re.test(pos))
                    {
                        pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
                    }
                    if (pos > input.value.length)
                    {
                        pos = input.value.length;
                    }
                    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
                    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
                }
            }

            function insertsmilie(thesmile)
            {
                var input = document.forms['gbookForm'].elements['gbcomment'];
                input.focus();
                // Internet Explorer
                if(typeof document.selection != 'undefined')
                {
                    var range = document.selection.createRange();
                    var insText = range.text;
                    range.text = " "+thesmile+" ";
                    range = document.selection.createRange();
                    range.move('character', 0);
                    range.select();
                }
                // Gecko Software
                else if (typeof input.selectionStart != 'undefined')
                {
                    var start = input.selectionStart;
                    var end = input.selectionEnd;
                    var insText = input.value.substring(start, end);
                    input.value = input.value.substr(0, start) + " "+thesmile+" " + input.value.substr(end);
                    var pos;
                    pos = start + (thesmile.length + 2);
                    input.selectionStart = pos;
                    input.selectionEnd = pos;
                }
                else
                {
                    var pos;
                    var re = new RegExp('^[0-9]{0,3}$');
                    while (!re.test(pos))
                    {
                        pos = prompt("Einfügen an Position (0.." + input.value.length + "):", "0");
                    }
                    if (pos > input.value.length)
                    {
                        pos = input.value.length;
                    }
                    var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
                    input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
                }
            }

<?php if($this->params->get('support_bbcode', false))
{ ?>
                        function DoPrompt(action)
                        {
                            var input = document.forms['gbookForm'].elements['gbcomment'];
                            input.focus();

                            var start = input.selectionStart;
                            var end = input.selectionEnd;
                            var revisedMessage;
                            var currentMessage = document.gbookForm.gbcomment.value;

    <?php if($this->params->get('support_link', false))
    { ?>
                                        if (action == "url")
                                        {
                                            var thisURL = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_HERE'); ?>", "http://");
                                            var thisTitle = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_WEB_PAGE_TITLE'); ?>", "<?php echo JTEXT::_('COM_EASYBOOKRELOADED_WEB_PAGE_TITLE'); ?>");
                                            if (thisURL != undefined && thisTitle != undefined)
                                            {
                                                if  (thisURL != "" && thisTitle != "")
                                                {
                                                    var urlBBCode = "[URL="+thisURL+"]"+thisTitle+"[/URL]";
                                                    insertprompt(urlBBCode, input, start, end, revisedMessage, currentMessage);
                                                }
                                            }
                                            return;
                                        }
    <?php } ?>
    <?php if($this->params->get('support_mail', true))
    { ?>
                                        if (action == "email")
                                        {
                                            var thisEmail = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_EMAIL_ADDRESS'); ?>", "");
                                            if (thisEmail != undefined)
                                            {
                                                if  (thisEmail != "")
                                                {
                                                    var emailBBCode = "[EMAIL]"+thisEmail+"[/EMAIL]";
                                                    insertprompt(emailBBCode, input, start, end, revisedMessage, currentMessage);
                                                }
                                            }
                                            return;
                                        }
    <?php } ?>
                            if (action == "code")
                            {
                                var thisLanguage = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_WHICH_LANGUAGE'); ?>", "");
                                if (thisLanguage != undefined)
                                {
                                    if  (thisLanguage != "")
                                    {
                                        var codeBBCode = "[CODE="+thisLanguage+"]\n\n[/CODE]";
                                        insertprompt(codeBBCode, input, start, end, revisedMessage, currentMessage);
                                    }
                                }
                                return;
                            }
                            if (action == "youtube")
                            {
                                var thisYoutube = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_YOUTUBE_VIDEO_ID'); ?>", "");
                                if (thisYoutube != undefined)
                                {
                                    if  (thisYoutube != "")
                                    {
                                        var codeBBCode = "[YOUTUBE]"+thisYoutube+"[/YOUTUBE]";
                                        insertprompt(codeBBCode, input, start, end, revisedMessage, currentMessage);
                                    }
                                }
                                return;
                            }
    <?php if($this->params->get('support_pic', false))
    { ?>
                                        if (action == "image")
                                        {
                                            var thisImage = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_OF_THE_PICTURE_YOU_WANT_TO_SHOW'); ?>", "http://");
                                            if (thisImage != undefined)
                                            {
                                                if  (thisImage != "")
                                                {
                                                    var imageBBCode = "[IMG]"+thisImage+"[/IMG]";
                                                    insertprompt(imageBBCode, input, start, end, revisedMessage, currentMessage);
                                                }
                                            }
                                            return;
                                        }
                                        if (action == "image_link")
                                        {
                                            var thisImage = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_OF_THE_PICTURE_YOU_WANT_TO_SHOW'); ?>", "http://");
                                            var thisURL = prompt("<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_THE_URL_HERE'); ?>", "http://");
                                            if (thisImage != undefined && thisURL != undefined)
                                            {
                                                if  (thisImage != "" && thisURL != "")
                                                {
                                                    var imageBBCode = "[IMGLINK="+thisURL+"]"+thisImage+"[/IMGLINK]";
                                                    insertprompt(imageBBCode, input, start, end, revisedMessage, currentMessage);
                                                }
                                            }
                                            return;
                                        }
    <?php } ?>
                        }
<?php } ?>
        </script>
        <form name='gbookForm' action='<?php JRoute::_('index.php'); ?>' target='_top' method='post'>
            <input type='hidden' name='option' value='com_easybookreloaded' />
            <input type="hidden" name='task' value='savecomment'/>
            <input type='hidden' name='controller' value='entry' />
            <input type='hidden' name='id' value='<?php echo $this->entry->id; ?>' />

            <table align='center' width='90%' cellpadding='0' cellspacing='4' border='0' >
                <?php
                // Switch for BB Code support
                if($this->params->get('support_bbcode', false))
                {
                    ?>
                    <tr>
                        <td width='130'></td>
                        <td>
                            <?php if($this->params->get('support_link', false))
                            { ?>
                                <a href='javascript:x()' onclick='DoPrompt("url");'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/world_link.png' hspace='3' border='0' alt='' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_WEB_ADDRESS'); ?>' height='16' width='16' /></a>
                            <?php
                            }
                            if($this->params->get('support_mail', true))
                            {
                                ?>
                                <a href='javascript:x()' onclick='DoPrompt("email");'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/email_link.png' hspace='3' border='0' alt='' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_EMAIL_ADDRESS'); ?>' height='16' width='16' /></a>
                            <?php
                            }
                            if($this->params->get('support_pic', false))
                            {
                                ?>
                                <a href='javascript:x()' onclick='DoPrompt("image_link");'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/picture_link.png' hspace='3' border='0' alt='' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_SHOW_IMAGE_WITH_A_LINK'); ?>' height='16' width='16' /></a>
                            <?php
                            }
                            if($this->params->get('support_pic', false))
                            {
                                ?>
                                <a href='javascript:x()' onclick='DoPrompt("image");'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/picture.png' hspace='3' border='0' alt='' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_SHOWS_IMAGE_FROM_AN_URL'); ?>' height='16' width='16' /></a>
                            <?php
                            }
                            if($this->params->get('support_code', false))
                            {
                                ?>
                                <a href='javascript:x()' onclick='DoPrompt("code");'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/code.png' hspace='3' border='0' alt='' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ENTER_CODE'); ?>' height='16' width='16' /></a>
    <?php
    }
    if($this->params->get('support_youtube', false))
    {
        ?>
                                <a href='javascript:x()' onclick='DoPrompt("youtube");'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/youtube.png' hspace='3' border='0' alt='' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_YOUTUBE'); ?>' height='16' width='16' /></a>
                            <?php } ?>
                            <a href='javascript:x()' onclick='insert("[B]", "[/B]")'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/text_bold.png' hspace='3' border='0' alt='Bold' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_BOLD'); ?>' height='16' width='16' /></a>
                            <a href='javascript:x()' onclick='insert("[I]", "[/I]")'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/text_italic.png' hspace='3' border='0' alt='Italic' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ITALIC'); ?>' height='16' width='16' /></a>
                            <a href='javascript:x()' onclick='insert("[U]", "[/U]")'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/text_underline.png' hspace='3' border='0' alt='Underline' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_UNDERLINE'); ?>' height='16' width='16' /></a>
                            <a href='javascript:x()' onclick='insert("[CENTER]", "[/CENTER]")'><img src='<?php echo $this->baseurl ?>/components/com_easybookreloaded/images/text_align_center.png' hspace='3' border='0' alt='Center' title='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_CENTER'); ?>' height='16' width='16' /></a>
                        </td>
                    </tr>
                        <?php } ?>
                <tr>
                    <td width='130' valign='top'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_ADMIN_COMMENT'); ?>
                        <br />
                        <br />
                        <?php
                        # Switch for Smilie Support
                        if($this->params->get('support_smilie', true))
                        {
                            $count = 1;
                            $smiley = EasybookReloadedHelperSmilie::getSmilies();

                            foreach($smiley as $i => $sm)
                            {
                                if($this->params->get('smilie_set') == 0)
                                {
                                    echo "<a href=\"javascript:insertsmilie('$i')\" title='$i'>".JHTML::_('image', 'components/com_easybookreloaded/images/smilies/'.$sm, $sm, 'border="0"')."</a> ";
                                }
                                else
                                {
                                    echo "<a href=\"javascript:insertsmilie('$i')\" title='$i'>".JHTML::_('image', 'components/com_easybookreloaded/images/smilies2/'.$sm, $sm, 'border="0"')."</a> ";
                                }
                                if($count % 4 == 0)
                                {
                                    echo "<br />";
                                }
                                $count++;
                            }
                        }
                        ?>
                    </td>
                    <td valign='top'><textarea style='width:245px;' rows='8' cols='50' name='gbcomment' class='inputbox'><?php echo $this->entry->gbcomment; ?></textarea></td>
                </tr>
                <tr><td></td><td><input type="checkbox" name="inform" id="inform" value="1"> <label for='inform'><?php echo JTEXT::_('COM_EASYBOOKRELOADED_INFORM'); ?></label></td></tr>
                <tr>
                    <td width='130'></td>
                    <td style='padding-left: 130px;'><br /><input type='submit' name='send' value='<?php echo JTEXT::_('COM_EASYBOOKRELOADED_SUBMIT_ENTRY'); ?>' class='button' /></td>
                </tr>
            </table>
        </form>
        <?php if($this->params->get('show_logo', true) == 1)
        { ?>
            <p id="easyfooter">
                <a href="http://joomla-extensions.kubik-rubik.de" title="Easybook Reloaded - Joomla! Erweiterung by Kubik-Rubik.de - Viktor Vogel" target="_blank"><img src="<?php echo JURI::base(); ?>components/com_easybookreloaded/images/logo.png" class="png" alt="EasyBook Reloaded - Logo" title="Easybook Reloaded - Joomla Erweiterung by Kubik-Rubik.de - Viktor Vogel" border="0" width="80" height="36" /></a>
            </p>
        <?php
        }
        elseif($this->params->get('show_logo', true) == 2)
        {
            ?>
            <p id="easyfooter">
                <a href="http://joomla-extensions.kubik-rubik.de" title="Easybook Reloaded - Joomla! Erweiterung by Kubik-Rubik.de - Viktor Vogel" target="_blank">Easybook Reloaded by Kubik-Rubik.de</a>
            </p>
<?php
}
elseif($this->params->get('show_logo', true) == 3)
{
    ?>
            <p id="easyfooterinv">
                <a href="http://joomla-extensions.kubik-rubik.de" title="Easybook Reloaded - Joomla! Erweiterung by Kubik-Rubik.de - Viktor Vogel" target="_blank">Easybook Reloaded by Kubik-Rubik.de</a>
            </p>
<?php } ?>
    </div>
</div>
