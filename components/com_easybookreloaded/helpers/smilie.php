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

class EasybookReloadedHelperSmilie
{
    function getSmilies()
    {
        $smiley[':zzz'] = "sm_sleep.gif";
        $smiley[';)'] = "sm_wink.gif";
        $smiley['8)'] = "sm_cool.gif";
        $smiley[':p'] = "sm_razz.gif";
        $smiley[':roll'] = "sm_rolleyes.gif";
        $smiley[':eek'] = "sm_bigeek.gif";
        $smiley[':grin'] = "sm_biggrin.gif";
        $smiley[':)'] = "sm_smile.gif";
        $smiley[':sigh'] = "sm_sigh.gif";
        $smiley[':?'] = "sm_confused.gif";
        $smiley[':cry'] = "sm_cry.gif";
        $smiley[':('] = "sm_mad.gif";
        $smiley[':x'] = "sm_dead.gif";
        $smiley[':upset'] = "sm_upset.gif";

        return $smiley;
    }
}
?>
