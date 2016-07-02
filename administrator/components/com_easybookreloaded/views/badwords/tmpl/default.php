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

<form action="<?php echo JRoute::_('index.php?option=com_easybookreloaded'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="20">
                        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                    </th>
                    <th width="10">
                        <?php echo JText::_('COM_EASYBOOKRELOADED_WORD_NUMBER'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('COM_EASYBOOKRELOADED_WORD'); ?>
                    </th>
                </tr>
            </thead>
            <?php
            $k = 0;
            $n = count($this->items);

            for($i = 0; $i < $n; $i++)
            {
                $row = $this->items[$i];
                $checked = JHTML::_('grid.id', $i, $row->id);
                $link = JRoute::_('index.php?option=com_easybookreloaded&controller=badwords&task=edit&cid[]='.$row->id);
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td>
                        <?php echo $checked; ?>
                    </td>
                    <td>
                        <?php echo $row->id; ?>
                    </td>
                    <td>
                        <a href="<?php echo $link ?>"><?php echo $row->word; ?></a>
                    </td>
                </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" name="option" value="com_easybookreloaded" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="badwords" />
    <?php echo JHTML::_('form.token'); ?>
</form>