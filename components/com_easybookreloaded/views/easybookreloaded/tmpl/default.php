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

if($this->params->get('offline'))
{
    echo $this->loadTemplate('header');
    echo JText::_('COM_EASYBOOKRELOADED_GUESTBOOK_OFFLINE_FRONTEND');
    echo $this->loadTemplate('footer');
    echo '</div></div>';
}
else
{
    echo $this->loadTemplate('header');
    echo $this->loadTemplate('entries');

    if($this->params->get('show_count_entries'))
    {
        ?>
        <div>
            <br /><strong class='easy_pagination'><?php echo $this->count ?><br />
                <?php
                if($this->count == 1)
                {
                    echo JText::_('COM_EASYBOOKRELOADED_ENTRY_IN_THE_GUESTBOOK');
                }
                else
                {
                    echo JText::_('COM_EASYBOOKRELOADED_ENTRIES_IN_THE_GUESTBOOK');
                }
                ?>
            </strong>
        </div>
    <?php
    }

    if($this->pagination->total > $this->pagination->limit)
    {
        echo '<div class="easy_pagination">';
        echo $this->pagination->getPagesLinks();
        echo '</div>';
    }

    echo $this->loadTemplate('footer');
    ?>
    </div>
    </div>
<?php } ?>