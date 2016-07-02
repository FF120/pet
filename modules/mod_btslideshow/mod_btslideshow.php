<?php
/**
 * @version		$Id: images.php 1 Aug 20, 2011 9:51:20 AM Thomas $
 * @package		BTShowcase
 * @copyright	Copyright (C) 2011 Bow Themes. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

$items = json_decode(base64_decode($params->get('gallery')));

if (count($items) == 0) {
	echo JText::_('MOD_BTSLIDESWHO_NOTICE_NO_IMAGES');
	return;
}

$moduleID = $module->id;

// Clean images that haven't used
require_once (JPATH_ROOT . '/modules/mod_btslideshow/helpers/files.php');
BTFilesHelper::cleanFiles($items, $moduleID);

// Make thumbnail & slideshow images if haven't created or just change the size
require_once (JPATH_ROOT . '/modules/mod_btslideshow/helpers/images.php');
$dir = JPATH_ROOT . '/modules/mod_btslideshow/images/' . $moduleID;
foreach ($items as $item) {
	BTImageHelper::createImage("{$dir}/original/{$item->file}", "{$dir}/slideshow/{$item->file}", $params->get('width'), $params->get('height'), true, $params->get('jpeg-compression'));
	BTImageHelper::createImage("{$dir}/original/{$item->file}", "{$dir}/thumbnail/{$item->file}", $params->get('thumb-width'), $params->get('thumb-height'), true, $params->get('jpeg-compression'));
}

require JModuleHelper::getLayoutPath('mod_btslideshow', $params->get('layout', 'default'));
?>