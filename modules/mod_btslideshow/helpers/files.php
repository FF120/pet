<?php
/**
 * @version		$Id: file.php 1 Aug 22, 2011 10:47:09 PM Thomas $
 * @package		BTShowcase
 * @copyright	Copyright (C) 2011 Bow Themes. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

class BTFilesHelper extends JObject {
	static function cleanFiles($items, $moduleId) {
		$files = array();
		if (is_array($items)) {
			foreach ($items as $item) {
				$files[$item->file] = true;
			}
		}
		
		$dir = JPATH_ROOT . '/modules/mod_btslideshow/images/' . $moduleId;
		self::_cleanFiles($files, $dir . '/manager');
		self::_cleanFiles($files, $dir . '/original');
		self::_cleanFiles($files, $dir . '/slideshow');
		self::_cleanFiles($files, $dir . '/thumbnail');
	}
	static function _cleanFiles($files, $dir) {
		if (!JFolder::exists($dir)) return;
		foreach (JFolder::files($dir) as $file) {
			if (!array_key_exists($file, $files)) {
				JFile::delete($dir . '/' . $file);
			}
		}
	}
}
?>