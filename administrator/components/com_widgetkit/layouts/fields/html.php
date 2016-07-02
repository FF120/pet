<?php
/**
* @package   Widgetkit
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// set attributes
$attributes = array();
$attributes['id']    = 'html-editor-'.uniqid();
$attributes['class'] = 'html-editor';
$attributes['name']  = $name;

printf('<textarea %s>%s</textarea>', $this['field']->attributes($attributes), htmlspecialchars($value, ENT_COMPAT, 'UTF-8'));

?>

<script>
	
	
	jQuery(function($){
		
		var id     = '<?php echo $attributes["id"]; ?>',
			ele    = $('#' + id),
			editor = false;

		if (window['WFEditor'] || window['JContentEditor'] || window['tinyMCE']) {
			editor = "tinymce";
		}

		if (window['CKEDITOR'] && window.addDomReadyEvent) {
			editor = "jck";
		}

		if (window['CodeMirror']) {
			editor = "codemirror";
		}

		if (!editor || $('#' + id + '_tbl').length) {
			return;
		}

		switch (editor) {
			case "tinymce":
				
				var ed = window['WFEditor'] || window['JContentEditor'] || window['tinyMCE'];

				if (window['WFEditor']) {
					$('#' + id).after('<input type="hidden" id="wf_'+id+'_token" value="'+Math.random()+'">');
				}

				tinymce.dom.Event.domLoaded = true;

				new tinymce.Editor(id, $.extend(ed.settings, {'forced_root_block': ''})).render();

				ele.bind({
					'editor-action-start': function(){ tinyMCE.execCommand('mceRemoveControl', false, id); },
					'editor-action-stop': function(){ tinyMCE.execCommand('mceAddControl', true, id); }
				});

				break;
			case "jck":
				
				window.removeEventListener && 	window.removeEventListener( 'load', editor_implementOnInstanceReady, false ) || window.removeEvent &&  window.removeEvent( 'load', editor_implementOnInstanceReady);
				window.removeEventListener && 	window.removeEventListener( 'dblclick', editor_onDoubleClick, false ) || window.removeEvent &&  window.removeEvent( 'dblclick', editor_onDoubleClick);
			
				window.addDomReadyEvent.add(function() {

					CKEDITOR.config.expandedToolbar = true;
					CKEDITOR.tools.callHashFunction('text',id);
				
					ele.bind({
						'editor-action-start': function() {
							if (id in CKEDITOR.instances) {
								CKEDITOR.instances[id].element.setHtml(CKEDITOR.instances[id].getData());
								CKEDITOR.instances[id].destroy(true);
							}	
						},
						'editor-action-stop': function() {
							if (!(id in CKEDITOR.instances)) CKEDITOR.tools.callHashFunction('text',id);
						}
					});
				});

				break;
			case "codemirror":

				var ed = CodeMirror.fromTextArea(document.getElementById(id), {
					"path":"<?php echo $this["path"]->url("site:media/editors/codemirror/js")."/";?>",
					"parserfile":"parsexml.js",
					"stylesheet": ["<?php echo $this["path"]->url("site:media/editors/codemirror/css/xmlcolors.css");?>"],
				    "onChange": function(){
				      ed.save();
				    }
				});

				ele.bind({
					'editor-action-start': function(){ ed.toTextArea(); },
					'editor-action-stop': function(){}
				});

				break;
		}
	});

</script>