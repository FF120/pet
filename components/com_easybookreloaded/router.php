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

function EasybookReloadedBuildRoute(&$query)
{
    $segments = array();

    if(isset($query['controller']))
    {
        $segments[] = $query['controller'];
        unset($query['controller']);
    }

    if(isset($query['task']))
    {
        $segments[] = $query['task'];
        unset($query['task']);
    }

    if(isset($query['cid']))
    {
        $segments[] = $query['cid'];
        unset($query['cid']);
    }

    if(isset($query['view']))
    {
        if(!isset($query['Itemid']))
        {
            $segments[] = $query['view'];
        }
        unset($query['view']);
    }
    return $segments;
}

function EasybookReloadedParseRoute($segments)
{
    $vars = array();

    if($segments[0] == 'entry')
    {
        switch($segments[1])
        {
            case 'add':
                {
                    $vars['controller'] = 'entry';
                    $vars['task'] = 'add';
                }
                break;

            case 'remove':
                {
                    $vars['controller'] = 'entry';
                    $vars['task'] = 'remove';
                    $vars['cid'] = $segments[2];
                }
                break;

            case 'publish':
                {
                    $vars['controller'] = 'entry';
                    $vars['task'] = 'publish';
                    $vars['cid'] = $segments[2];
                }
                break;

            case 'unpublish':
                {
                    $vars['controller'] = 'entry';
                    $vars['task'] = 'unpublish';
                    $vars['cid'] = $segments[2];
                }
                break;

            case 'edit':
                {
                    $vars['controller'] = 'entry';
                    $vars['task'] = 'edit';
                    $vars['cid'] = $segments[2];
                }
                break;

            case 'comment':
                {
                    $vars['controller'] = 'entry';
                    $vars['task'] = 'comment';
                    $vars['cid'] = $segments[2];
                }
                break;
        }

        return $vars;
    }
}
?>