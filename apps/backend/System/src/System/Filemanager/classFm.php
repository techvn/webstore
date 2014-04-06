<?php
namespace System\Filemanager;
define('_REFRESH', 'REFRESH');define('_DELETE', '_DELETE');define('_FM_DELOK', '<span>Success!</span>Directory(s) and file(s) have been deleted');
define('_FM_DELOK_DIR', '<span>Success!</span>Directory(s) have been deleted');
define('_FM_DELOK_FILE', '<span>Success!</span>File(s) have been deleted');
define('_FM_SEL_ERR', '<span>Alert!</span>Please select at least one File/Directory');
define('_FM_DEL_ERR', '<span>Error!</span>There was an Error Deleting File(s) and Directory(s)');
define('_FM_DEL_ERR2', '<span>Error!</span>Invalid File or Directory Selected');
define('_FM_FILENAME_R', '<span>Error!</span>Please enter valid filename.');
define('_FM_FILENAME_T', 'Enter your new file name.');
define('_FM_FILENAME1', '<span>Success!</span>File');
define('_FM_FILENAME2', 'was created.');
define('_FM_FILENAME_ERR', '<span>Error!</span>There was an Error creating File');
define('_FM_DIRPER_OK', '<span>Success!</span>Permissions were successfully changed');
define('_FM_DIRPER_ERR', '<span>Error!</span>There was an error updating permissions for');
define('_FM_DIR_NAME_R', '<span>Error!</span>Please enter directory name');
define('_FM_DIR_NAME_T', 'Enter your new directory name.');
define('_FM_DIR_OK1', '<span>Success!</span>Directory');
define('_FM_DIR_OK2', 'was created.');
define('_FM_DIR_ERR', '<span>Error!</span>There was an Error creating directory ');
define('_FM_DIR_DEL_OK1', '<span>Success!</span>Directory');
define('_FM_DIR_DEL_OK2', 'was fully deleted');
define('_FM_DIR_DEL_ERR', '<span>Error!</span>There was an Error Deleting Directory');
define('_FM_PER_OK1', '<span>Success!</span>Permissions for');
define('_FM_PER_OK2', 'were changed.');
define('_FM_PER_ERR', '<span>Error!</span>There was an error changing permissions for');
define('_FM_PER_OCT_ERR', '<span>Error!</span>Please enter valid value.');
define('_FM_FILE_OK1', '<span>Success!</span>File');
define('_FM_FILE_OK2', 'was deleted');
define('_FM_FILE_ERR', '<span>Error!</span>There was an Error Deleting File');
define('_FM_NO_DIR1', '<div class="msgError"><span>Error!</span>"');
define('_FM_NO_DIR2', 'is not a directory !!!</div>');
define('_FM_ACCESS1', '<div class="msgError"><span>Error!</span>');
define('_FM_ACCESS2', 'Access denied . <br>You do not have enough rights to view the dir</div>');
define('_FM_DELFILE_D', 'Delete File/Directory');
define('_FM_DELFILE_DM', 'This item will be permanently deleted and cannot be recovered. Are you sure?');
define('_FM_DELDIR_D', 'Delete Directory');
define('_FM_DELDIR_DM', 'This will be permanently delete directory and all files inside. Are you sure?');
define('_FM_DELMUL_D', 'Delete Multiple Files/Directories');
define('_FM_DELMUL_DM', 'Do you want to delete this file(s) or folder(s) !');
define('_FM_CHMOD_D', 'CHMOD File/Directory');
define('_FM_CHMOD_DM', 'Please enter the new permissions<br />[ x = 1 , w = 2 , r = 4 ] <br />The value should be octal( 0666 , 0755 etc )');
define('_CHMOD_I', 'CHMOD Item');
define('_CHMOD_M', 'CHMOD Multiple');
define('_FM_TITLE', 'File Manager');
define('_FM_CURDIR', 'Current Directory');
define('_FM_MFILEUPL', 'Multiple File Uploads');
define('_FM_VIEW_ALL', 'Viewing All Files');
define('_FM_SIZE', 'Size');
define('_FM_PERM', 'Permission');
define('_FM_NAME', 'Name');
define('_FM_PATH', 'Path');
define('_FM_CREATE', 'Create');
define('_FM_SEL_ALL', 'Select or deselect all files');
define('_FM_DIRS', 'Directories');
define('_FM_FILES', 'Files');
define('_FM_FILE', 'File');
define('_FM_DELFILE', 'Delete File');
define('_FM_VIEWFILE', 'View File');
define('_FM_NEWFILE', 'New File');
define('_FM_CHGPER', 'Change Permissions');
define('_FM_EDITFILE', 'Edit File');
define('_FM_NEWDIR', 'New Directory');
define('_FM_FILESAVEOK1', '<span>Success!</span>');
define('_FM_FILESAVEOK2', 'was saved successfully');
define('_FM_FILESAVEERR1', '<span>Error!</span>');
define('_FM_FILESAVEERR2', 'Error saving !!!');
define('_FM_EDITING', 'Editing');
define('_FM_UPLOAD', 'Upload');
define('_FM_FILSIZE', 'File size');
define('_FM_FILEOWNER', 'Owner');
define('_FM_FILELM', 'Last modified');
define('_FM_FILEGROUP', 'Group');
define('_FM_FILLA', 'Last accessed');
define('_FM_UPLOAD_ERR1', 'Error: The upload directory doesn\'t exist!');
define('_FM_UPLOAD_ERR2', 'Error: The upload directory is NOT writable!');
define('_FM_UPLOAD_ERR3', 'Not selected');
define('_FM_UPLOAD_ERR4', 'Wrong file extension');
define('_FM_UPLOAD_ERR5', 'Failed to upload. File must be ');
define('_FM_UPLOAD_ERR6', 'already exists.');
define('_FM_UPLOAD_ERR7', 'uploaded successfully.');
define('_FM_UPLOAD_ERR8', 'Failed to upload');
define('_FM_UPLOAD_ERR9', '<span>Error!</span>Please select file to upload');
define('_FM_VIEWING', 'Viewing');
define('_FM_FILE_SEL', 'Choose a File');
function cleanSanitize($string, $trim = false,  $end_char = '&#8230;')
{
	$string = cleanOut($string);
	$string = filter_var($string, FILTER_SANITIZE_STRING);
	$string = trim($string);
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);

	if ($trim) {
		if (strlen($string) < $trim)
		{
			return $string;
		}

		$string = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $string));

		if (strlen($string) <= $trim)
		{
			return $string;
		}

		$out = "";
		foreach (explode(' ', trim($string)) as $val)
		{
			$out .= $val.' ';

			if (strlen($out) >= $trim)
			{
				$out = trim($out);
				return (strlen($out) == strlen($string)) ? $out : $out.$end_char;
			}
		}
	}
	return $string;
}
function sanitize($string, $trim = false, $int = false, $str = false)
{
	$string = filter_var($string, FILTER_SANITIZE_STRING);
	$string = trim($string);
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);

	if ($trim)
		$string = substr($string, 0, $trim);
	if ($int)
		$string = preg_replace("/[^0-9\s]/", "", $string);
	if ($str)
		$string = preg_replace("/[^a-zA-Z\s]/", "", $string);

	return $string;
}
class classFm
{
	private $base_dir;
	private $rel_dir;
	private $show_dir;
	private $cur_dir;
	private $dir_list = array();
	private $file_list = array();
	private $dir_count = 0;
	private $file_count = 0;
	private $cdirs = 0;
	private $cfiles = 0;

	protected $color;
	protected $ext = array();
	private $fsize = 0;
	private $fileext = array(".gif", ".jpg", ".jpeg", ".png", ".txt", ".nfo", ".doc", ".htm", ".zip", ".rar", ".css", ".pdf", ".swf", ".mp4", ".mp3");


	private $show;
      /**
       * Filemanager::__construct()
       * 
       * @return
       */
      function __construct()
      {
       // $this->setting = \MDS\Registry::get('Setting');
      	$this->show = new Show();
      	$this->base_dir = str_replace("\\", "/", UPLOAD_PATH);

      	if (isset($_REQUEST['rel_dir'])) {
      		$this->rel_dir = str_replace("../", "", $_REQUEST['rel_dir']);
      		$this->rel_dir = str_replace(".", "", $_REQUEST['rel_dir']);
      	} else
      	$this->rel_dir = '';

      	if (isset($_REQUEST['rel_dir'])) {
      		if ($_REQUEST['rel_dir'] == $this->base_dir) {
      			$this->show_dir = $this->base_dir;
      			$_REQUEST['rel_dir'] = "";
      		} else
      		$this->rel_dir = urldecode($_REQUEST['rel_dir']);
      		$this->show_dir = $this->base_dir . $_REQUEST['rel_dir'];
      	} else
      	$this->show_dir = $this->base_dir;
      	$_REQUEST['rel_dir'] = "";

      	$this->cur_dir = $this->base_dir . $this->rel_dir;
      	$this->getDir();

      	if (!is_dir($this->show_dir))
      		echo "is_dir ";

      	if (!($dir = opendir($this->show_dir)))
      		die($this->show->msgError(_FM_ACCESS1 . $this->show_dir . _FM_ACCESS2, false));
      }

	  /**
	   * Filemanager::topNav()
	   * 
	   * @return
	   */
	  private function topNav()
	  {
	  	$data = '
	  	<div class="box">
	  	<div style="float:left"><img src="'.URL_WEB.'/assets/backend/system/upload-file/filemanager/images/folder.png" alt="" title="' . _FM_CURDIR . '" class="tooltip" style="margin-right:8px"/>
	  	<strong>' . _FM_CURDIR . ':</strong>&nbsp;&nbsp;' . $this->rel_dir . '</div>
	  	<div style="float:right"><a href=""><img src="'.URL_WEB.'/assets/backend/system/upload-file/filemanager/images/icons/home.png" alt="" title="Home" class="tooltip" style="margin-right:8px"/></a>
	  	<a href="javascript:void(0);" id="create-dir" rel="' . $this->rel_dir . '"><img src="'.URL_WEB.'/assets/backend/system/upload-file/filemanager/images/new-folder.png" title="' . _FM_NEWDIR . '" style="margin-right:8px"/></a>
	  	<a href="javascript:void(0);" id="' . $this->rel_dir . '" class="dirchange">
	  	<img src="'.URL_WEB.'/assets/backend/system/upload-file/filemanager/images/icons/refresh.png" alt="" title="' . _REFRESH . '" class="tooltip"/></a></div>
	  	<div class="clear"></div>
	  	</div>';
	  	return $data;
	  }
	  
	  /**
	   * Filemanager::getNav()
	   * 
	   * @return
	   */
	  private function getNav()
	  {
	  	$data = '<a href="';
	  	$p_ar = explode("/", $this->rel_dir, strlen($this->rel_dir));
	  	$p_dir = "";

	  	for ($i = 0; $i < count($p_ar) - 2; $i++) {
	  		$p_dir = $p_dir . $p_ar[$i];
	  		if ($i != count($p_ar) - 2)
	  			$p_dir = $p_dir . "/";
	  	}

	  	if ($p_dir == "") {
	  		$data .= "filemanager.php";
	  		$p_dir = "/";
	  	} 

	  	$data .= '" class="dirchange" id="' . $p_dir . '" style="text-decoration: none;"><img src="'.URL_WEB.'/assets/backend/system/upload-file/filemanager/images/category.png" alt="" /><strong>...</strong>
	  	</a>';
	  	return $data;
	  }
	  
	  /**
	   * Filemanager::renderAll()
	   * 
	   * @return
	   */
	  public function renderAll()
	  {
	  	print $this->topNav();
	  	print '
	  	<form action="" method="post" name="admin_form" id="admin_form">
	  	<div style="height:390px;overflow:auto">
	  	<table cellpadding="0" cellspacing="0" class="display" id="dataholder">
	  	<thead>
	  	<tr style="background-color:transparent">
	  	<td>' . $this->getNav() . '</td>
	  	</tr>
	  	</thead>
	  	<tbody>
	  	' . $this->renderDirectories() . '
	  	' . $this->renderFiles() . '
	  	</tbody>
	  	</table></div>
	  	<div class="box">
	  	<input name="newfile" type="file" class="inputbox"/> <input name="dofile" id="fileupload" rel="' . $this->rel_dir . '" type="submit" value="' . _FM_UPLOAD . '" class="button-sml"/>
	  	<input name="filepath" type="hidden" value="' . $this->rel_dir . '" />
	  	</div>
	  	</form>';
	  }

      /**
       * Filemanager::getDir()
       * 
       * @return
       */
      private function getDir()
      {
//          echo $this->cur_dir;
      	if ($handle = opendir($this->cur_dir)) {

      		while (false !== ($name = readdir($handle))) {
      			if ($name == ".." || $name == "." || $name == "index.php" || $name == "index.html" || $name == "Thumbs.db" || $name == ".htaccess")
      				continue;
                  //print_r($this->show_dir.$name);
      			if (is_dir($this->show_dir . $name))
      				$this->dir_list[$this->dir_count++] = $name;
      			if (is_file($this->show_dir . $name))
      				$this->file_list[$this->file_count++] = $name;
      		}
      		closedir($handle);
      	}
         // print_r($this->file_list);
      }

	  /**
	   * Filemanager::renderDirectories()
	   * 
	   * @return
	   */
	  private function renderDirectories()
	  {
	  	$data = '';

	  	$data .= '<tr style="background-color:transparent"><td>';
	  	for ($i = 0; $i < $this->dir_count; $i++) {

	  		if($this->dir_list[$i] =="_thumb")
	  			continue;
	  		$data .= '<div class="thumbview"><div class="inner">';
	  		$data .= '<a href="javascript:void(0);"';
	  		if ($this->rel_dir == "") {
	  			$path = $this->rel_dir . $this->dir_list[$i];
	  		} else
	  		$path = $this->rel_dir . $this->dir_list[$i];

	  		$data .= 'id="' . $path . '/" class="dirchange">';
	  		$data .= '<img src="'.URL_WEB.FILE_MANAGER_ASSETS.'/filemanager/images/icons/_Close.png" alt="folder" /></a></div>';
	  		$data .= '<span>'.sanitize($this->dir_list[$i],15).'</span>';
	  		$data .= '<p class="control"><a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->dir_list[$i] . '" class="del-single">
	  		<img src="'.URL_WEB.'/'.FILE_MANAGER_ASSETS.'/filemanager/images/delete.png" alt="" title="'._DELETE.'"/></a></p>';
	  		$data .= '</div>';
	  	}  
	  	$data .= '</td></tr>';
	  	$this->cdirs++;	

	  	return $data;
	  }
	  
	  /**
	   * Filemanager::renderFiles()
	   * 
	   * @return
	   */
	  private function renderFiles()
	  {
	  	sort($this->file_list);
	  	$data = '';
	  	$dir_thumb = (in_array($this->rel_dir,array("_thumb")))?$this->rel_dir:$this->rel_dir."_thumb/thumb_";
	  	$data .= '<tr style="background-color:transparent"><td>';
	  	for ($i = 0; $i < $this->file_count; $i++) {
	  		$this->ext = explode(".", $this->file_list[$i], strlen($this->file_list[$i]));
	  		$extn = $this->ext[count($this->ext) - 1];
	  		$data .= '<div class="thumbview"><div class="inner">';
	  		$data .= '<a href="javascript:void(0);" class="getfile" rel="' . $this->rel_dir . $this->file_list[$i] . '">';
	  		if ($this->isimage($extn)) {
	  			$data .= '<img src="' .URL_WEB . '/uploads/' . $dir_thumb . $this->file_list[$i] . '" alt="" />';
	  		} else {
	  			$data .= '<img src="'.URL_WEB.'/'.FILE_MANAGER_ASSETS.'/filemanager/images/mime/large/' . $this->getFileType($extn) . '" alt="" />';
	  		}
	  		$data .='</a></div>';
	  		$data .= '<span>'.sanitize($this->file_list[$i],13).'</span>';
	  		$data .= '<p class="control"><a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->file_list[$i] . '" class="del-single">
	  		<img src="'.URL_WEB.'/'.FILE_MANAGER_ASSETS.'/filemanager/images/delete.png" alt="" title="'._DELETE.'"/></a></p>';
	  		$data .= '</div>';
	  	}		 
	  	$this->cfiles++;
	  	$data .= ' </td>
	  	</tr>';
	  	return $data;
	  }


	  /**
	   * Filemanager::isimage()
	   * 
	   * @param mixed $str
	   * @return
	   */
	  private function isimage($str)
	  {
	  	$image_file = array("gif", "jpg", "jpeg", "png", "GIF", "JPG", "JPEG", "PNG");
	  	for ($f = 0; $f < count($image_file); $f++) {
	  		if ($str == $image_file[$f])
	  			return true;
	  	}
	  	return false;
	  }

      /**
       * Filemanager::delete()
       * 
	   * @param mixed $path
	   * @param bool $name
	   * @return
       */
      public function delete($path, $name = '')
      {
      	global $core;
          // echo $path ." ".$name;
      	if (is_dir($this->base_dir . $path)) {
      		if ($this->purge($this->base_dir . $path)) {
      			if ($name) {
      				$this->show->msgOK(_FM_DIR_DEL_OK1 . '<strong> ' . $name . ' </strong>' . _FM_DIR_DEL_OK2);
      			} else
      			return true;
      		} else{
                  // echo "NO Delete";
      			$this->show->msgOK(_FM_DIR_DEL_ERR . '<strong> ' . $name . ' </strong>');
      		}

      	} elseif (file_exists($this->base_dir . $path)) {
      		$is_img = getimagesize($this->base_dir . $path);
      		if (@unlink($this->base_dir . $path)) {
      			if ($name) {
      				if ($is_img) {
      					@unlink($this->base_dir ."_thumb/thumb_". $path);
      				}
      				$this->show->msgOK(_FM_FILE_OK1 . '<strong> ' . $name . ' </strong>' . _FM_FILE_OK2);
      			} else
      			return true;
      		} else
      		$this->show->msgOK(_FM_FILE_ERR . '<strong> ' . $name . ' </strong>');
      	} else
      	$this->show->msgError(_FM_DEL_ERR2);
      }
      
      /**
       * Filemanager::purge()
       * 
       * @param mixed $dir
       * @param bool $delroot
       * @return
       */
      private function purge($dir, $delroot = true)
      {
      	if (!$dh = @opendir($dir))
      		return;

      	while (false !== ($obj = readdir($dh))) {
      		if ($obj == '.' || $obj == '..' || $obj == 'index.php' || $obj == 'index.html')
      			continue;

      		if (!@unlink($dir . '/' . $obj))
      			$this->purge($dir . '/' . $obj, true);
      	}

      	closedir($dh);

      	if ($delroot)
      		@rmdir($dir);
      	return true;
      }

	  /**
	   * Filemanager::makeDirectory()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @param bool $multi
	   * @return
	   */
	  public function makeDirectory($path, $name, $multi = false)
	  {

	  	if (mkdir($this->base_dir . $path . $name)) {
			 // if (!$multi)
			     //$core->msgOK(_FM_DIR_OK1 . '<strong> ' . $name . ' </strong>' . _FM_DIR_OK2);
	  	} else{

	  	}
		     // if (!$multi)
			 // $core->msgError(_FM_DIR_ERR . '<strong> ' . $name . ' </strong>');
         // exit;
	  }


	  /**
	   * Filemanager::uploadFile()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @return
	   */
	  public function uploadUploadZend2($path){
	  	if (!is_dir($this->base_dir . $path))
	  		die($this->show->msgError(_FM_UPLOAD_ERR1));

	  	if (!is_writeable($this->base_dir . $path))
	  		die($this->show->msgError(_FM_UPLOAD_ERR2));
	  	$upldir = $this->base_dir . htmlspecialchars($path, ENT_QUOTES);
	  	$newfile = $_FILES['newfile'];
	  	$filename = $newfile['name'];

	  	$filename = str_replace(' ', '_', $filename);
	  	$filetmp = $newfile['tmp_name'];
	  	$filesize = $newfile['size'];
	  	$ext = strrchr($filename, '.');
	  	if (!in_array(strtolower($ext), $this->fileext)) {
	  		die($this->show->msgError(_FM_FILE . ' <strong> ' . $filename . ' </strong> ' . _FM_UPLOAD_ERR4));
	  	}
	  	if (getimagesize($filetmp)) {
	  		$filedir = $this->base_dir . $path;
	  		$fileinfo = pathinfo($filedir . $_FILES['newfile']['name']);
	  		$newName = \MDS\Core\ParanoiaSeo::paranoia($fileinfo['filename']);
	  		
	  		$handle = new \MyLibs\libraryUpload\upload($_FILES['newfile'], 'vn_VN');
	  		if ($handle->uploaded) {
	  			$handle->file_new_name_body   = $newName;
	  			$handle->process($filedir);

	  			if ($handle->processed) {
	  				if (!is_dir($filedir."_thumb")) {
	  					mkdir($filedir."_thumb");         
	  				}
	  				!getimagesize($filedir . $handle->file_dst_name) || $this->uploadThumb($handle,$filedir);
	  				$handle->clean();
	  			} else {
	  				echo 'error : ' . $handle->error;
	  			}
	  		}else{
	  			echo "Error:".$handle->error;
	  		}
	  	}
	  	
	  }
	  private function uploadThumb($handle,$filedir,$option=array()){
	  	if(is_dir($filedir."_thumb")){
	  		$image = $handle->file_dst_name;
	  		$thumb = new \MyLibs\libraryUpload\upload($handle->file_dst_pathname);
	  		$thumb->image_resize = true;
	  		$thumb->image_x = 80;
	  		$thumb->image_y = 77;
	  		$thumb->file_name_body_pre = 'thumb_';
	  		$thumb->process($filedir."_thumb");
	  	}else{
	  		echo "nono";
	  	}
	  }


	  /**
	   * Filemanager::getSize()
	   * 
	   * @param mixed $size
	   * @param integer $precision
	   * @param bool $long_name
	   * @param bool $real_size
	   * @return
	   */
	  private function getSize($size, $precision = 2, $long_name = false, $real_size = true)
	  {
	  	$base = $real_size ? 1024 : 1000;
	  	$pos = 0;
	  	while ($size > $base) {
	  		$size /= $base;
	  		$pos++;
	  	}
	  	$prefix = $this->_getSizePrefix($pos);
	  	@$size_name = ($long_name) ? $prefix . "bytes" : $prefix[0] . "B";
	  	return round($size, $precision) . ' ' . ucfirst($size_name);
	  }

	  /**
	   * Filemanager::_getSizePrefix()
	   * 
	   * @param mixed $pos
	   * @return
	   */
	  private function _getSizePrefix($pos)
	  {
	  	switch ($pos) {
	  		case 00:
	  		return "";
	  		case 01:
	  		return "kilo";
	  		case 02:
	  		return "mega";
	  		case 03:
	  		return "giga";
	  		default:
	  		return "?-";
	  	}
	  }
	  
	  
	  /**
	   * Filemanager::getFileType()
	   * 
	   * @param mixed $extn
	   * @return
	   */
	  private function getFileType($extn) {

	  	switch ($extn) {
	  		case "css":
	  		return "css.png";
	  		break;

	  		case "csv":
	  		return "csv.png";
	  		break;

	  		case "fla":
	  		case "swf":
	  		return "fla.png";
	  		break;

	  		case "mp3":
	  		case "wav":
	  		return "mp3.png";
	  		break;

	  		case "jpg":
	  		case "JPG":
	  		case "jpeg":
	  		return "jpg.png";
	  		break;

	  		case "png":
	  		return "png.png";
	  		break;

	  		case "gif":
	  		return "gif.png";
	  		break;

	  		case "bmp":
	  		case "dib":
	  		return "bmp.png";
	  		break;

	  		case "txt":
	  		case "log":
	  		return "txt.png";
	  		break;

	  		case "sql":
	  		return "sql.png";
	  		break;

	  		case "js":
	  		echo "js.png";
	  		break;

	  		case "pdf":
	  		return "pdf.png";
	  		break;

	  		case "zip":
	  		case "rar":
	  		case "tgz":
	  		case "gz":
	  		return "zip.png";
	  		break;

	  		case "doc":
	  		case "docx":
	  		case "rtf":
	  		return "doc.png";
	  		break;

	  		case "asp":
	  		case "jsp":
	  		echo "asp.png";
	  		break;

	  		case "php":
	  		return "php.png";
	  		break;

	  		case "htm":
	  		case "html":
	  		return "htm.png";
	  		break;

	  		case "ppt":
	  		return "ppt.png";
	  		break;

	  		case "exe":
	  		case "bat":
	  		case "com":
	  		return "exe.png";
	  		break;

	  		case "wmv":
	  		case "mpg":
	  		case "mpeg":
	  		case "wma":
	  		case "asf":
	  		return "wmv.png";
	  		break;

	  		case "midi":
	  		case "mid":
	  		return "midi.png";
	  		break;

	  		case "mov":
	  		return "mov.png";
	  		break;

	  		case "psd":
	  		return "psd.png";
	  		break;

	  		case "ram":
	  		case "rm":
	  		return "rm.png";
	  		break;

	  		case "xml":
	  		return "xml.png";
	  		break;

	  		case "xls":
	  		return "xls.png";
	  		break;

	  		default:
	  		return "default.png";
	  		break;
	  	}	

	  }
	}
	?>