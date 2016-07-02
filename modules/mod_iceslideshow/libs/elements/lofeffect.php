<?php
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	mod_lofflashcontent
 * @copyright	Copyright (C) JAN 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access	

defined('_JEXEC') or die ('Restricted access');
jimport('joomla.filesystem.folder');
  class JFormFieldLofEffect extends JFormField {

    /**
     * @access private
     */
	 
	var	$_name = 'Lofeffect';
	var $_params = null;
	var $filter = ".png|.jpg|.jpeg|.gif";
	function __getValue($name1,$name2, $default=''){
		$val = $this->form->getValue($name1, 'params', $default);
		return is_array($val)&& isset($val[$name2])? $val[$name2]:$default;
	}
	function getInput()
	{   
	
		// function fetchElement($name, $value, &$node, $control_name) {
		$value = $this->value; 

		$name = $this->element->getAttribute("name");
		$cur_index = $this->element->getAttribute("index");
		$control_name ='jform[params]';
		

	
		$elms = array(
					  "caption" => array("text"=>JText::_("Image_Caption") )   ,
					  "link"  => array("text"=>JText::_("Image_Link") )   ); 
		
	 		$ynoptions = array( '0'  => JText::_('No'),
						        '1' =>  JText::_('Yes')
							 );
		$onshow = false;
		$string = '<div style="clear:both" >';
		$enableValue = $this->__getValue( $name,'enable','');
		if(1 == $enableValue || $name == "file1"){
			$enableValue = 1;
			$onshow = true;
		}
		$string .='<input class="lof-showcontainer lof-enable" id="lof-enable'.$cur_index.'" name="'.$control_name.'['.$name.'][enable]" type="hidden" value="'.$this->__getValue( $name,'enable','').'"/>';

		$string .='</div>';
		$strImages = $this->_getListImages( $name, $control_name, "image");
		$string .= '<div class="lof-cols" ><label>'.JText::_("Choose_Image").'</label>'.$strImages.'</div>';
		foreach( $elms as $key=>$elm ){
			$string .= '<div class="lof-cols" ><label>'.$elm['text'].'</label><input type="text" size="30" maxlength="255" value="'. $this->__getValue( $name,$key,'')  .'" id="jform_params_'.$name.'_'.$key.'" name="'.
						$control_name.'['.$name.']['.$key.']'
					.'"/></div>';
		}
		if($name == "file1"){
			$string .= '<div style="clear:both;text-align:right;width:80%" class="lof-cols add_control_'.$name.'"><a href="#add" class="addControl" onclick="addFile('.$cur_index.');" title="'.JText::_("Add").'">+</a></div>';
		}
		elseif($name == "file30"){
			$string .= '<div style="clear:both;text-align:right;width:80%" class="lof-cols add_control_'.$name.'"><a href="#remove" class="removeControl" onclick="removeFile(this);" title="'.JText::_("Remove").'">-</a></div>';
		}
		else{
			$string .= '<div style="clear:both;text-align:right;width:80%" class="lof-cols add_control_'.$name.'"><a href="#add" class="addControl" onclick="addFile('.$cur_index.');" title="'.JText::_("Add").'">+</a>&nbsp;&nbsp;<a href="#remove" class="removeControl" onclick="removeFile(this);" title="'.JText::_("Remove").'">-</a></div>';
		}
		return $string;
	}
	
	function _getListImages($name, $control_name="", $key = "image"){
		$path = "sampledata";
		$str = "";
		$this->makeDir( $path );
		$path .= "/iceslideshow";
		if( !$this->copySampleImages( $path ) ){
		
		}
			$path = "images/".$path;
			if (!is_dir($path)) {
				$path = JPATH_ROOT.'/'.$path;
			}
			$files = JFolder::files($path, $this->filter);
			$value = $this->__getValue( $name, $key );
			$str = '<select id="jform_params_'.$name.'_'.$key.'" name="'.
							$control_name.'['.$name.']['.$key.']'.'">';
			if (is_array($files)) {
				foreach($files as $file) {
					if($file == $value ){
						$str.= '<option value="'.$file.'" selected="selected">'.$file.'</option>';
					}
					else{
						$str.= '<option value="'.$file.'">'.$file.'</option>';
					}
				}
			}
			$str .= '</select>';
		return $str;
	}
	function copySampleImages( $path ){
		$tmppath = JPATH_SITE.DS."images".DS;
		$path = $tmppath.str_replace("/", DS, $path);
		$files = array();
		if( file_exists( $path )){
			$files = JFolder::files($path, $this->filter);
		}
		if( !file_exists( $path ) || count($files)<=1 ){
			$source_path = JPATH_SITE.DS."modules".DS."mod_iceslideshow".DS."assets".DS."sampledata";
			if( file_exists($source_path)){
				if( JFolder::copy( $source_path, $path, "", false,true)){
					return true;
				}
			}
		}
		return false;
	}
	function makeDir( $path ){
			$folders = explode ( '/',  ( $path ) );
			$tmppath = JPATH_SITE.DS."images".DS;
			for( $i = 0; $i <= count ( $folders ) - 1; $i ++) {
				if (! file_exists ( $tmppath . $folders [$i] ) && ! mkdir ( $tmppath . $folders [$i], 0755) ) {
					return false;
				}
				$tmppath = $tmppath . $folders [$i] . DS;
			}
			return true;
		}
	
}
