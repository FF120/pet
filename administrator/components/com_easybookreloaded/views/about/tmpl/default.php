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

<h1>Easybook Reloaded</h1>
<?php echo JTEXT::_('COM_EASYBOOKRELOADED_ABOUT_EASYBOOK_RELOADED'); ?>
<p><strong>Easybook Reloaded Version: <?php echo _EASYBOOK_VERSION; ?></strong></p>
<p><?php echo JText::_('COM_EASYBOOKRELOADED_SUPPORT_THE_FURTHER_DEVELOPMENT_AND_FREE_AVAILABILITY_OF_THE_EASYBOOK_WITH_A_SMALL_DONATION_THANK_YOU'); ?></p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
    <div>
        <input type="hidden" name="cmd" value="_donations" />
        <input type="hidden" name="business" value="joomla@kubik-rubik.de" />
        <input type="hidden" name="item_name" value="Joomla! Extension / Erweiterung" />
        <input type="hidden" name="item_number" value="Easybook Reloaded" />
        <input type="hidden" name="no_shipping" value="0" />
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="currency_code" value="EUR" />
        <input type="hidden" name="tax" value="0" />
        <input type="hidden" name="bn" value="PP-DonationsBF" />
        <input type="image" src="<?php echo $this->donate_image ?>" name="submit" alt="PayPal Button - Spende an Viktor Vogel - Kubik-Rubik.de" style="border: none !important; background-color: transparent !important;" />
        <img alt="Spende" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
    </div>
</form>