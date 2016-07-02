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
defined('JPATH_BASE') or die;
jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldEBRTitle extends JFormField
{
    protected $type = 'EBRTitle';

    protected function getInput()
    {
        return '';
    }

    protected function getLabel()
    {
        JHTML::stylesheet('administrator/components/com_easybookreloaded/css/easybookreloaded.css');
        echo '<div class="clr"></div>';

        if($this->element['default'])
        {
            return '<div style="padding: 5px 5px 5px 0; font-size: 16px;"><strong>'.JText::_($this->element['default']).'</strong></div>';
        }
        else
        {
            return parent::getLabel();
        }

        echo '<div class="clr"></div>';
    }
}
?>