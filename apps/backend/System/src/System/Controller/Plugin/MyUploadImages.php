<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 3/2/14
 * Time: 4:24 PM
 * To change this template use File | Settings | File Templates.
 */
namespace System\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Imagick\Imagine;
use Zend\Filter\File\RenameUpload;

 class MyUploadImages extends AbstractPlugin{
    public function doUpload($images_name,$filedir=null){
	  	$newfile = $_FILES[$images_name];
	  	$filename = $newfile['name'];
	  	$filename = str_replace(' ', '_', $filename);
	  	$filetmp = $newfile['tmp_name'];
	  	$filesize = $newfile['size'];
	  	$ext = strrchr($filename, '.');
	    $error = array();
	  //	if (getimagesize($filetmp)) {
	  		$fileinfo = pathinfo($filedir ."/". $_FILES[$images_name]['name']);
	  		$newName = $fileinfo['filename'];
	  		$handle = new \MyLibs\libraryUpload\upload($_FILES[$images_name], 'vn_VN');
	  		if ($handle->uploaded) {
	  			$handle->file_new_name_body   = $newName;
	  			$handle->process($filedir);

	  			if ($handle->processed) {
	  				if (!is_dir($filedir."/_thumb")) {
	  					mkdir($filedir."/_thumb");
	  				}
	  				!getimagesize($filedir .'/'. $handle->file_dst_name) || $this->uploadThumb($handle,$filedir);
	  				$handle->clean();
                    $error['flag'] = 'oke';
                    $error['data'] = $handle->file_dst_name;
	  			} else {
	  			$error['data']=$handle->error;
	  			}
	  		}else{
	  			$error['data'] = $handle->error;
	  		}
       return $error;
    }
    public function uploadThumb($handle,$filedir,$option=array()){
	  	if(is_dir($filedir.'/'."_thumb")){
	  		$image = $handle->file_dst_name;
	  		$thumb = new \MyLibs\libraryUpload\upload($handle->file_dst_pathname);
	  		$thumb->image_resize = true;
	  		$thumb->image_x = 80;
	  		$thumb->image_y = 77;
	  		$thumb->file_name_body_pre = 'thumb_';
	  		$thumb->process($filedir."/_thumb");
            
	  	}else{
	  		return $handle->error;
	  	}
	}
 }