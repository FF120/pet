<?php

/**
 * @version		$Id: uploader 1 Sep 13, 2011, 4:01:49 PM Thomas $
 * @package		BowThemes
 * @copyright	Copyright (C) 2011 Bow Themes. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

function toBytes($str) {
	$val = trim($str);
	$last = strtolower($str[strlen($str) - 1]);
	switch ($last) {
		case 'g': $val *= 1024;
		case 'm': $val *= 1024;
		case 'k': $val *= 1024;
	}
	return $val;
}

// Set flag that this is a parent file
define('_JEXEC', 1);
define('DS', DIRECTORY_SEPARATOR);

$pathBase = dirname(__FILE__);
$pathBase = preg_replace('#[\\\\/]modules[\\\\/]mod_btslideshow[\\\\/]*#is', '', $pathBase);

if (file_exists($pathBase . '/defines.php')) {
	include_once $pathBase . '/defines.php';
}

if (!defined('_JDEFINES')) {
	define('JPATH_BASE', $pathBase);
	require_once JPATH_BASE.'/includes/defines.php';
}

require_once JPATH_BASE.'/includes/framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('administrator');

$jlang = JFactory::getLanguage();
$jlang->load('mod_btslideshow', JPATH_SITE, null, true);

// Upload process
require_once JPATH_BASE . '/modules/mod_btslideshow/fileuploader.php';

if (isset($_GET['qqfile'])) {
	$file = new qqUploadedFileXhr();
} elseif (isset($_FILES['qqfile'])) {
	$file = new qqUploadedFileForm();
} else {
	$file = false; 
}

$pathinfo = pathinfo($file->getName());
if (version_compare(JVERSION, '1.6.0', 'ge')) {
	$filename = JApplication::stringURLSafe($pathinfo['filename']);
} 
else {
	$filename = JFilterOutput::stringURLSafe($pathinfo['filename']);
}
$ext = $pathinfo['extension'];

// Max size to upload (10MB)
$sizeLimit = 10 * 1024 * 1024;
$postSize = toBytes(ini_get('post_max_size'));
$uploadSize = toBytes(ini_get('upload_max_filesize'));        


// allowed extensions to upload
$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

$result = array('success' => false, 'message' => '');

// stored image files location
$moduleID = JRequest::getInt('id', 0);
$dir = JPATH_BASE . '/modules/mod_btslideshow/images';

// Check login & permission
$user = JFactory::getUser();
if (!$user->id) {
	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_NOT_LOGIN');
}
//else if (!$user->authorise('core.edit', 'com_modules')) {
//	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_PERMISSION');
//}
else if (!$file) {
	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_NO_FILES');
}
else if ($file->getSize() == 0) {
	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_FILE_EMPTY');
}
else if ($file->getSize() > $sizeLimit) {
	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_TOO_LARGE');
}
else if ($postSize < $file->getSize() || $uploadSize < $file->getSize()) {
	$result['message'] = sprintf(JText::_('MOD_BTSLIDESHOW_ERROR_UPLOAD_MAX_SIZE'), $file->getSize());
}
else if (!is_writable($dir)) {
	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_NOT_WRITABLE');
}
else if (!in_array(strtolower($ext), $allowedExtensions)) {
	$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_INVALID_EXTENSION');
}
else {
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
	require_once JPATH_BASE . '/modules/mod_btslideshow/helpers/images.php';

	// Make necessary folder
	$dir = $dir . '/' . $moduleID;
	if (!JFolder::exists($dir)) JFolder::create($dir);
	if (!JFolder::exists($dir . '/original')) JFolder::create($dir . '/original');
	if (!JFolder::exists($dir . '/slideshow')) JFolder::create($dir . '/slideshow');
	if (!JFolder::exists($dir . '/thumbnail')) JFolder::create($dir . '/thumbnail');
	if (!JFolder::exists($dir . '/manager')) JFolder::create($dir . '/manager');
	
	$i = '';
	while (JFile::exists($dir . "/original/{$filename}{$i}.{$ext}")) {
		$i++;
	}
	$filename = "{$filename}{$i}.{$ext}";


	if (!$file->save("{$dir}/original/{$filename}")) {
		$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_COULD_NOT_SAVE');
	}
	else {
		$imagesize = getimagesize("{$dir}/original/{$filename}", $imageinfo);
		$mime = $imagesize['mime'];
		if (!preg_match('#^image/#is', $mime)) {
			$result['message'] = JText::_('MOD_BTSLIDESHOW_ERROR_IMAGE_INVALID');
			JFile::delete("{$dir}/original/{$filename}");
		}
		else {
			BTImageHelper::resize($dir . "/original/{$filename}", $dir . "/manager/{$filename}", 128, 96);
			$result['success'] = true;
			$result['file'] = $filename;
		}
	}
}

echo json_encode($result);
?>
