<?php
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// load widgetkit
require_once(JPATH_ADMINISTRATOR.'/components/com_widgetkit/widgetkit.php');

// get widgetkit
$widgetkit = Widgetkit::getInstance();

// Joomla 3.0 fixes core parameter "style" conflict
if ($params->exists("style_")) {
	$params->set("style", $params->get("style_"));
}

// render twitter tweets
echo $widgetkit['twitter']->render($params->toArray());