<?php 
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

	$widget_id       = $widget->id.'-'.uniqid();
	$settings        = $widget->settings;
	$images          = $this['gallery']->images($widget);
	$thumbs          = $this['gallery']->images($widget, array('width' => $settings['thumb_width'], 'height' => $settings['thumb_height']));
	$thumb_max_width = is_int($width = 100 / count($thumbs)) ? $width : number_format($width, 3);

	$i = 0;
?>

<?php if (count($images)) : ?>
<div id="gallery-<?php echo $widget_id; ?>" class="wk-slideshow wk-slideshow-inside" data-widgetkit="slideshow" data-options='<?php echo json_encode($settings); ?>'>
	<div>
		<ul class="slides">

			<?php foreach ($images as $image) : ?>
            
				<?php

					$navigation[] = '<li style="max-width:'.$thumb_max_width.'%;"><img src="'.$thumbs[$i]['cache_url'].'" width="'.$thumbs[$i]['width'].'" height="'.$thumbs[$i]['height'].'" alt="'.$thumbs[$i]['filename'].'" /></li>';
					$captions[]   = '<li>'.(strlen($image['caption']) ? $image['caption']:"").'</li>';
					$lightbox     = '';

					/* Prepare Lightbox */
					if ($settings['lightbox'] && !$image['link']) {
						$lightbox = 'data-lightbox="group:'.$widget_id.'"';
					}
					
					/* Prepare Image */
					$content = '<img src="'.$image['cache_url'].'" width="'.$image['width'].'" height="'.$image['height'].'" alt="'.$image['filename'].'" />';
					
					/* Lazy Loading */				
					$content = ($i==$settings['index']) ? $content : $this['image']->prepareLazyload($content);
				?>

				<?php if ($settings['lightbox'] || $image['link']) : ?>
					<li><a class="" href="<?php echo $image['link'] ? $image['link'] : $image['url']; ?>" <?php echo $lightbox; ?>><?php echo $content; ?></a></li>
				<?php else : ?>		
					<li><?php echo $content; ?></li>
				<?php endif; ?>
				
				<?php $i=$i+1;?>
			<?php endforeach; ?>

		</ul>
        <?php if ($settings['buttons']): ?><div class="next"></div><div class="prev"></div><?php endif; ?>
		<div class="caption"></div><ul class="captions"><?php echo implode('', $captions);?></ul>
	</div>
	<?php echo ($settings['navigation'] && count($navigation)) ? '<ul class="nav">'.implode('', $navigation).'</ul>' : '';?>
</div>
	
<?php else : ?>
	<?php echo "No images found."; ?>
<?php endif;