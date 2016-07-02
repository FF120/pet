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

if($this->params->get('show_logo', true) == 1)
{
    ?>
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