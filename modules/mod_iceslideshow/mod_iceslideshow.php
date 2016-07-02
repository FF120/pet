<?php 
/**
 * IceSlideshow Module for Joomla 1.7 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2012 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/IceSlideshow.html
 * @Support 	http://www.icetheme.com/Forums/IceSlideshow/
 *
 */
 
 
// no direct access
defined('_JEXEC') or die;


// Include the syndicate functions only once
require_once dirname(__FILE__).DS.'helper.php';
$list = modIceSlideshowHelper::getList($params);

$group 			= $params->get('group','content');
$tmp 		 	= $params->get('module_height', 'auto');
$moduleHeight   = ($tmp=='auto') ? 'auto' : (int)$tmp.'px';
$tmp 			= $params->get('module_width', 'auto');
$moduleWidth    = ($tmp=='auto') ? 'auto': (int)$tmp.'px';
$themeClass 	= $params->get('theme' , 'candy');
$openTarget 	= $params->get('open_target', 'parent');
$class 			= !$params->get('navigator_pos', 0) ? '':'ice-'.$params->get('navigator_pos', 0);
$theme		    = $params->get('theme', ''); 
$showReadmore 	= $params->get('show_readmore',1);
$params->set('item-content', 'desc-image');
$params->set('replacer', '...');
$itemContent	= $params->get('item-content','desc-image');

$navPos			= $params->get('navigator_pos', 0);
$navwidth		= (int)$params->get('navitem_width', 12);
$navheight		= (int)$params->get('navitem_height', 12);
$main_height	= (int)$params->get('main_height', 300);
$slidecaption = (int)$params->get("slide_caption", 0);
$zoom = $params->get('zoom', 'rand');
$pan = $params->get('pan', 'rand');
$pansize = $params->get('pansize', 30);

switch($navPos)
{
	case "left":
		$navcss		= "height:".$navheight."px;";
		$maincss	= "margin-left:".$navwidth."px;";
	break;	
	case "bottom":
		$navcss		= "margin-top:".$main_height."px";
		$maincss	= "";
	break;
	case "top":
	case "right":
	default:
		$navcss		= "height:".$navheight."px;";
		$maincss	= "";
	break;
}

// load custom theme
if($theme && $theme != -1) {
	require(modIceSlideshowHelper::getLayoutByTheme($module, $group, $theme));
} else {
	require(JModuleHelper::getLayoutPath($module->module));
}
modIceSlideshowHelper::loadMediaFiles($params, $module, $theme);
?>
<script type="text/javascript">
	var _lofmain = $('iceslideshow<?php echo $module->id; ?>');
	var object = new IceSlideShow(_lofmain.getElement('.ice-main-wapper'), 
								  _lofmain.getElement('.ice-navigator-outer .ice-navigator'),
								  _lofmain.getElement('.ice-navigator-outer'),
								  {
									  fxObject:{
										transition:<?php echo $params->get('effect', 'Fx.Transitions.Sine.easeInOut');?>,  
										duration:<?php echo (int)$params->get('duration', '700')?>
									  },
									  fxCaptionObject:{
										transition:<?php echo $params->get('effect', 'Fx.Transitions.Sine.easeInOut');?>,  
										duration:<?php echo (int)$params->get('caption_duration', '700')?>
									  },
									  transition:<?php echo $params->get('effect', 'Fx.Transitions.Sine.easeInOut');?>,  
									  slideDuration:<?php echo $params->get('slide_duration', 2000); ?>,
									  slideCaption: <?php echo $slidecaption==1?'true':'false'; ?>,
									  captionHeight: <?php echo (int)$params->get('caption_height', 70); ?>,
									  captionOpacity: <?php echo $params->get('caption_opacity', 0.7); ?>,
									  mainItemSelector: 'div.ice-main-item',
									  interval:<?php echo (int)$params->get('interval', '3000'); ?>,
									  direction :'<?php echo $params->get('layout_style','opacity');?>', 
									  navItemHeight:<?php echo $params->get('navitem_height', 100) ?>,
									  navItemWidth:<?php echo $params->get('navitem_width', 290) ?>,
									  navItemsDisplay:<?php echo $params->get('max_items_display', 3) ?>,
									  navPos:'<?php echo $params->get('navigator_pos', 0); ?>',
									  zoom: <?php echo is_numeric($zoom)?(int)$zoom:"'".$zoom."'"; ?>,
									  pan: <?php echo is_numeric($pan)?(int)$pan:"'".$pan."'"; ?>,
									  pansize: <?php echo (int)$pansize; ?>,
									  wdirection: "<?php echo $params->get('wdirection',"left"); ?>"
								  });
	<?php if($params->get('display_button', '')): ?>
		object.registerButtonsControl('click', {next:_lofmain.getElement('.ice-next'),previous:_lofmain.getElement('.ice-previous')});
	<?php endif; ?>
		object.start(<?php echo $params->get('auto_start',1)?>, _lofmain.getElement('.preload'));
</script>