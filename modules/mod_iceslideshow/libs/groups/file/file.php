<?php
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @subpackage	$Subpackage
 * @copyright	Copyright (C) May 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website 	htt://landofcoder.com
 * @license		GNU General Public License version 2
 */
if( !class_exists('IceSliderGroupFile') ){  
	class IceSliderGroupFile extends IceSliderGroupBase{
		/**
		 * @var string $__name;
		 *
		 * @access private
		 */
		var $__name = 'file';
 
		/**
		 * override method: get list image from articles.
		 */
		function getListByParameters($params){
			$maxFiles = 30;
			$thumbWidth    = (int)$params->get('thumbnail_width', 35);
			$thumbHeight   = (int)$params->get('thumbnail_height', 60);
			$imageHeight   = (int)$params->get('imagemain_height', 300) ;
			$imageWidth    = (int)$params->get('imagemain_width', 660) ;
			$isThumb       = $params->get('auto_renderthumb',1);
			$image_quanlity = $params->get('image_quanlity', 100);
			
			
			$baseURI = JURI::base();
			$subbase = JURI::base(true);
			$path = 'images/sampledata/iceslideshow/';
			 $output = array(); 
		
			 for( $i=1; $i<=$maxFiles; $i++ ){
 
				$obj = $params->get('file'.$i);
					
				if( is_object($obj) && $obj->enable  ){
				
					$obj->path =  str_replace($subbase."//",$subbase.'/',$baseURI.str_replace("//","/",str_replace( DS,"/",$path.$obj->image)));
					$obj->mainImage =   str_replace($subbase."//",$subbase.'/',$baseURI.str_replace("//","/",str_replace( DS,"/",$path.$obj->image)));
				
					if( isset($obj->mainImage) && trim($obj->image) ){
						$obj->thumbnail = $obj->path;	
					} else {
						$obj->thumbnail  = $obj->mainImage; 	
					}
					$obj->title = $obj->caption;
					$obj->subtitle = $obj->title;
					$obj->description = $obj->introtext = "";
					if(!empty($obj->link) && strpos($obj->link,"http://") === false){
						$obj->link = "http://".$obj->link;
					}
					if($obj->mainImage &&  $image=self::renderThumb($obj->mainImage, $imageWidth, $imageHeight, $obj->title, $isThumb,$image_quanlity)){
						$obj->mainImage = $image;
					}
					if($obj->thumbnail &&  $image = self::renderThumb($obj->thumbnail, $thumbWidth, $thumbHeight, $obj->title, $isThumb,$image_quanlity)){
						$obj->thumbnail = $image;
					}
					$output[]=$obj;
			
				}
			 }
			return $output; 
		}
	}
}
?>