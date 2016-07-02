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
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldACL extends JFormFieldList
{
    protected $type = 'ACL';

    protected function getOptions()
    {
        $options = array();

        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $query = $db->getQuery(true);

        $query->select('a.id AS value, a.title AS text, COUNT(DISTINCT b.id) AS level');
        $query->from('#__usergroups AS a');
        $query->join('LEFT', '`#__usergroups` AS b ON a.lft > b.lft AND a.rgt < b.rgt');

        if($id = $this->form->getValue('id'))
        {
            $query->join('LEFT', '`#__usergroups` AS p ON p.id = '.(int) $id);
            $query->where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');
        }

        $query->group('a.id');
        $query->order('a.lft ASC');

        $db->setQuery($query);
        $options = $db->loadObjectList();

        if($db->getErrorNum())
        {
            JError::raiseWarning(500, $db->getErrorMsg());
        }

        $n = count($options);

        for($i = 0; $i < $n; $i++)
        {
            if($user->authorise('core.admin') || (!JAccess::checkGroup($options[$i]->value, 'core.admin')))
            {
                $options[$i]->text = str_repeat('- ', $options[$i]->level).$options[$i]->text;
            }
            else
            {
                unset($options[$i]);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }
}
?>