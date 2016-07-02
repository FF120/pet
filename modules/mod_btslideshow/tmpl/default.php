<?php
/**
 * @version		$Id: default.php 1 Aug 23, 2011 10:26:51 AM Thomas $
 * @package		BTShowcase
 * @copyright	Copyright (C) 2011 Bow Themes. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/* @var JDocument $document */
$document = JFactory::getDocument();
$document->addScript(JURI::root() . "modules/mod_btslideshow/assets/js/btloader.min.js");
$document->addStyleSheet(JURI::root() . "modules/mod_btslideshow/assets/skitter/css/skitter.styles.css");

?>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<div style="clear: both;"></div>
<div id="mod_btslideshow_<?php echo $module->id; ?>" class="box_skitter mod_btslideshow" style="width:<?php echo $params->get('width'); ?>px; height:<?php echo $params->get('height'); ?>px;">
<ul>
<?php
foreach ($items as $item) {
	if (!empty($item->link)) {
		$img = '<a href="' . $item->link . '"><img class="cubeRandom" src="' . JURI::root() . "modules/mod_btslideshow/images/{$module->id}/slideshow/{$item->file}" . '" rel="' . JURI::root() . "modules/mod_btslideshow/images/{$module->id}/thumbnail/{$item->file}" . '" /></a>';
	}
	else {
		$img = '<img class="cubeRandom" src="' . JURI::root() . "modules/mod_btslideshow/images/{$module->id}/slideshow/{$item->file}" . '" rel="' . JURI::root() . "modules/mod_btslideshow/images/{$module->id}/thumbnail/{$item->file}" . '" />';
	}
	$desc = '';
	if (!empty($item->title)) {
		$desc .= '<h4>' . $item->title . '</h4>';
	}
	if (!empty($item->desc)) {
		$desc .= '<p>' . $item->desc . '</p>';
	}
	?>
	<li>
		<?php echo $img; ?>
		<div class="label_text"><?php echo $desc; ?></div>
	</li>
	<?php
}
$options = array();
$options[] = "width:{$params->get('width')}";
$options[] = "height:{$params->get('height')}";
$options[] = "animation: '{$params->get('effect')}'";
if ($params->get('navigation-type') == 'thumbs') {
	$options[] = 'thumbs: true';
}
if ($params->get('navigation-type') == 'dots') {
	$options[] = 'dots: true';
	$options[] = "animateNumberOut: {backgroundColor:'#555', color:'#fff'}";
	$options[] = "animateNumberOver: {backgroundColor:'#333', color:'#fff'}";
	$options[] = "animateNumberActive: {backgroundColor:'#004499', color:'#fff'}";
}
if ($params->get('navigation-type') == 'numbers') {
	$options[] = 'numbers: true';
} 

$options = implode(",\n", $options);
//$out = sprintf("jQuery('#mod_btslideshow_" . $module->id . "').skitter({%s});", $options);

?>
</ul>
</div>
<div style="clear: both;"></div>
<script>

(function(){
	var libs = [
		'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/js/jquery-1.6.2.min.js', 
		'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/skitter/js/jquery.skitter.min.js', 
		'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/skitter/js/jquery.easing.1.3.min.js', 
		'<?php echo JURI::root(); ?>modules/mod_btslideshow/assets/skitter/js/jquery.animate-colors-min.js'
	];
	
	BT.Loader.js(libs, function(){
		jQuery.noConflict();
		<?php
			if ($params->get('navigation-type') == 'dots') {
				echo "jQuery('#mod_btslideshow_{$module->id}').css({'margin-bottom':'50px'});\n\t\t";
			}
			?>
			jQuery('#mod_btslideshow_<?php echo $module->id; ?>').skitter({
				<?php echo $options; ?>,
				structure:			
					'<a href="#" class="prev_button">prev</a>' +
					'<a href="#" class="next_button">next</a>' +
					'<span class="info_slide"></span>' +
					'<div class="container_skitter">' +
						'<div class="image">' +
							'<a target="_blank" href=""><img class="image_main" /></a>' +
							'<div class="label_skitter"></div>' +
						'</div>' +
					'</div>',
				velocity: 1.3,
				interval: <?php echo $params->get('time-interval'); ?>,
				thumb_width: '<?php echo $params->get('thumb-width'); ?>px',
				thumb_height: '<?php echo $params->get('thumb-height'); ?>px',
				caption: '<?php echo $params->get('caption'); ?>',
				caption_width: '<?php echo $params->get('caption-width'); ?>',
				navigation: <?php echo $params->get('show-button'); ?>,
				fullscreen: false
			});
	});
})();

</script>