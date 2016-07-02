<?php
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// set attributes
$attributes = array();
$attributes['type']  = 'text';
$attributes['name']  = $name;
$attributes['value'] = $value;
$attributes['class'] = 'title widefat '.(isset($class) ? $class : '');
$attributes['data-id'] = uniqid("title-");

printf('<input %s />', $this['field']->attributes($attributes, array('label', 'description', 'default')));

?>

<script>

	jQuery(function($){
		
		$('input.title[data-id="<?php echo $attributes['data-id'];?>"]').on('keyup.title', function() {
			$(this).trigger('update');
		});

	});

</script>
