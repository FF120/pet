<?php

/**
 * @version		$Id: gallery 1 Sep 13, 2011, 10:52:36 AM Thomas $
 * @package		BowThemes
 * @copyright	Copyright (C) 2011 Bow Themes. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

/*
 * This trick allows us to extend the correct class, based on whether it's Joomla! 1.5 or 1.6
 */
if (!class_exists('JFakeElementBase')) {
	if (version_compare(JVERSION, '1.6.0', 'ge')) {
		class JFakeElementBase extends JFormField {
			// This line is required to keep Joomla! 1.6/1.7 from complaining
			protected function getInput() {
			}
		}
	} else {
		class JFakeElementBase extends JElement {
		}
	}
}

class JFakeElementGallery extends JFakeElementBase {
	
	protected $type = 'Gallery';
	public $_name = 'Gallery';
	
	protected function getLabel() {
		return '';
	}

	function fetchElement($name, $value, &$node, $control_name) {
		$id = JRequest::getInt('id', 0);
		if (!$id) {
			$cid = JRequest::getVar('cid', array(0));
			$id = $cid[0];
		}
		return $this->_build($id, 'params['.$name.']', $value);
	}
	
	protected function _build($moduleID, $name, $value) {
		/* @var JDocument $document */
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root() . "modules/mod_btslideshow/assets/css/btslideshow.css");

		if (version_compare(JVERSION, '1.6.0', 'ge')) {
			$document->addScript(JURI::root() . "modules/mod_btslideshow/assets/js/btslideshow.min.js");
			$document->addScript(JURI::root() . "modules/mod_btslideshow/assets/js/btbase64.min.js");
			?>
			<script>
			window.addEvent('domready', function() {
				initGallery();
			});
			</script>
			<?php
		}
		else {
			$document->addScript(JURI::root() . "modules/mod_btslideshow/assets/js/btloader.min.js");
			// Hack, replace mootools by newer
			foreach ($document->_scripts as $key => $tmp) {
				if (preg_match('#media/system/js/mootools.js#is', $key)) {
					unset($document->_scripts[$key]);
				}
			}
			$mootools = array(
			    JURI::root() . "modules/mod_btslideshow/assets/js/mootools-core.js" => 'text/javascript',
			    JURI::root() . "modules/mod_btslideshow/assets/js/mootools-more.js" => 'text/javascript'
			);
			$document->_scripts = $mootools + $document->_scripts;
			?>
			<script>
			
			(function(){
				var libs = [
							'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/js/mootools-core.js', 
							'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/js/mootools-more.js', 
							'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/js/btslideshow.min.js',
							'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/js/btbase64.min.js',
							'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/squeezebox/squeezebox.min.js'
				];
			
				BT.Loader.js(libs, function(){
					initGallery();
				});
				BT.Loader.css('<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/squeezebox/assets/squeezebox.css');
				
				window.addEvent('load', function() {
					document.combobox = null;
					var combobox = new JCombobox();
					document.combobox = combobox;					
				});

			})();
			</script>		
			<?php
		}

		// Load fileuploader library
		$document->addScript(JURI::root() . "modules/mod_btslideshow/assets/fileuploader/fileuploader.min.js");
		$document->addStyleSheet(JURI::root() . "modules/mod_btslideshow/assets/fileuploader/fileuploader.css");
		
		// Remove temp files
		$items = json_decode(base64_decode($value));
		require_once (JPATH_ROOT . '/modules/mod_btslideshow/helpers/files.php');
		BTFilesHelper::cleanFiles($items, $moduleID);
		
		$html = '
			<div id="btss-message" class="clearfix"></div>
			<div id="btss-file-uploader">		
				<noscript>			
					<p>' . JText::_('MOD_BTSLIDESHOW_NOTICE_JAVASCRIPT') . '</p>
				</noscript>         
			</div>
			<input id="btss-gallery-hidden" type="hidden" name="' . $name. '" value="" />
			<ul id="btss-gallery-container" class="clearfix"></ul>
			';
		
		?> 
		<script>
		function initGallery() {
			BTSlideshow = new BT.Slideshow({
				liveUrl: '<?php echo JURI::root(); ?>',
				encodedItems: '<?php echo $value; ?>',
				moduleID: '<?php echo $moduleID; ?>',
				galleryContainer: 'btss-gallery-container',
				dialogTemplate:
					'<fieldset class="adminform">' +
						'<ul class="adminformlist">' +
							'<li>' +
								'<label id="btss-title-lbl" class="hasTip" title="<?php echo JText::_('MOD_BTSLIDESHOW_FIELD_TITLE_DESC');?>" for="btss-title"><?php echo JText::_('MOD_BTSLIDESHOW_FIELD_TITLE_LABEL');?></label>' +
								'<input id="btss-title" type="text" name="btss-title" size="37" />' +
							'</li>' +
							'<li>' +
								'<label id="btss-link-lbl" class="hasTip" title="<?php echo JText::_('MOD_BTSLIDESHOW_FIELD_LINK_DESC');?>" for="btss-link"><?php echo JText::_('MOD_BTSLIDESHOW_FIELD_LINK_LABEL');?></label>' +
								'<input id="btss-link" type="text" name="btss-link" size="37" />' +
							'</li>' +
							'<li>' +
								'<label id="btss-desc-lbl" class="hasTip" title="<?php echo JText::_('MOD_BTSLIDESHOW_FIELD_DESCRIPTION_DESC');?>" for="btss-desc"><?php echo JText::_('MOD_BTSLIDESHOW_FIELD_DESCRIPTION_LABEL');?></label>' +
								'<textarea id="btss-desc" name="btss-desc" rows="5" cols="20"></textarea>' +
							'</li>' +
						'</ul>' +
					'</fieldset>' +
					'<button class="btss-dialog-ok" style="margin-left: 10px;"><?php echo JText::_('MOD_BTSLIDESHOW_BTN_OK');?></button><button class="btss-dialog-cancel" style="margin-left: 10px;"><?php echo JText::_('MOD_BTSLIDESHOW_BTN_CANCEL');?></button>'
			});
			
			var uploader = new qq.FileUploader({
				element: $('btss-file-uploader'),
				action: '<?php echo JURI::root() . "modules/mod_btslideshow/uploader.php"; ?>',
				params: {
					id: '<?php echo $moduleID; ?>'
				},
				sizeLimit: 10 * 1024 * 1024,
				allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
				debug: false,
				template: 
					'<div class="qq-uploader">' + 
						'<div class="qq-upload-drop-area"><span><?php echo JText::_('MOD_BTSLIDESHOW_UPLOAD_DROP_AREA'); ?></span></div>' +
						'<div class="qq-upload-button"><?php echo JText::_('MOD_BTSLIDESHOW_UPLOAD_BUTTON'); ?></div>' +
						'<ul class="qq-upload-list"></ul>' + 
					'</div>',
				onComplete: function (id, filename, responseJSON) {
					if (!responseJSON.success) {
						BTSlideshow.showMessage('btss-message', '<b>' + filename + '</b> - ' + responseJSON.message);
					}
					else {
						var item = {
							file: responseJSON.file
						};
						BTSlideshow.add(item);
						BTSlideshow.removeLog('btss-file-uploader');
					}
				}
			});
		};
		</script>
		<?php
		return $html;
	}

	
	protected function getInput() {
		JHtml::_('behavior.framework', true);
		JHtml::_('behavior.modal');

		$moduleID = $this->form->getValue('id');
		return $this->_build($moduleID, $this->name, $this->value);
	}
}

/*
 * Part two of our trick; we define the proper element name, depending on whether it's Joomla! 1.5 or 1.6
 */
if (version_compare(JVERSION, '1.6.0', 'ge')) {
	class JFormFieldGallery extends JFakeElementGallery {
	}
} else {
	class JElementGallery extends JFakeElementGallery {
	}
}
?>