<?php
namespace System\Filemanager;
define('_ACTIONS', 'Actions');
define('_FM_DELOK', '<span>Success!</span>Directory(s) and file(s) have been deleted');
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
define('_REFRESH', 'Refresh');
define('_DELETE', 'Delete');

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
  class Filemanager
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
	  private $fileext = array(".gif", ".jpg", ".jpeg", ".png", ".txt", ".nfo", ".doc", ".htm", ".zip", ".rar", ".css", ".pdf", ".swf");
      
      
      
      /**
       * Filemanager::__construct()
       * 
       * @return
       */
      function __construct()
      {

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
              die($this->show->msgError(_FM_NO_DIR1 . $this->show_dir . _FM_NO_DIR2, false));
			  
          if (!($dir = opendir($this->show_dir)))
              die($this->show->msgError(_FM_ACCESS1 . $this->show_dir . _FM_ACCESS2, false));
      }
	  

	  private function topNav()
	  {
		 $data = '
			  <div class="box-title">
				<table cellpadding="0" cellspacing="0" class="formtable">
				  <tr style="background-color:transparent" class="panel-heading">
					<td><strong>' . _FM_CURDIR . ':</strong>&nbsp;&nbsp;' . $this->rel_dir . '</td>
					<td class="right">
					   <a href="index.php?do=filemanager">
					    <img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/home.png" alt="" title="Home" class="" style="margin-right:8px"/>
					   </a>
					<a href="javascript:void(0);" id="' . $this->rel_dir . '" class="dirchange">
					<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/refresh.png" alt="" title="' . _REFRESH . '" class=""/></a>
					</td>
				  </tr>
				</table>
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
			  $data .= "index.php?do=filemanager";
			  $p_dir = "/";
		  } 
		  
		  $data .= '" class="dirchange" id="' . $p_dir . '"><strong>...</strong>
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
			  <table cellpadding="0" cellspacing="0" class="display" id="dataholder">
				<thead>
				  <tr>
					<th colspan="5" class="left">' . _FM_VIEW_ALL . '</th>
				  </tr>
				  <tr>
					<th width="25">&nbsp;</th>
					<th class="left">' . _FM_NAME . '</th>
					<th width="15%" class="left" nowrap="nowrap">' . _FM_SIZE . '</th>
					<th width="15%" class="left" nowrap="nowrap">' . _FM_PERM . '</th>
					<th width="15%" class="right">' . _ACTIONS . '</th>
				  </tr>
				  <tr>
					<td><img src="/'.FILE_MANAGER_ASSETS.'/manager/images/mime/folder.gif" alt="" /></td>
					<td>' . $this->getNav() . '</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td class="right"><input type="checkbox" name="masterCheckbox" id="masterCheckbox" title="' . _FM_SEL_ALL . '" /></td>
				  </tr>
				</thead>
				<tbody>
				' . $this->renderDirectories() . '
				' . $this->renderFiles() . '
				  </tbody>
			  </table>
			</form>';
	  }
		
      /**
       * Filemanager::getDir()
       * 
       * @return
       */
      private function getDir()
      {
          if ($handle = opendir($this->cur_dir)) {
              while (false !== ($name = readdir($handle))) {
                  if ($name == ".." || $name == "." || $name == "index.php" || $name == "index.html" || $name == "Thumbs.db" || $name == ".htaccess")
                      continue;
                  
                  if (is_dir($this->show_dir . $name))
                      $this->dir_list[$this->dir_count++] = $name;
                  if (is_file($this->show_dir . $name))
                      $this->file_list[$this->file_count++] = $name;
              }
              closedir($handle);
          }
      }

	  /**
	   * Filemanager::renderDirectories()
	   * 
	   * @return
	   */
	  private function renderDirectories()
	  {
		  $data = '';
		  for ($i = 0; $i < $this->dir_count; $i++) {
			  if ($this->cdirs % 2 == 0) {
				  $this->color = "even";
			  } else {
				  $this->color = "odd";
			  }
			  
			  $data .= '
			  <tr class="' . $this->color . '" id="multid-' . $i . '">
				<td><img src="/'.FILE_MANAGER_ASSETS.'/manager/images/mime/folder.png" alt="folder" /></td>
				<td><a href="javascript:void(0);"';
				  if ($this->rel_dir == "") {
					$path = $this->rel_dir . $this->dir_list[$i];
				  } else
					$path = $this->rel_dir . $this->dir_list[$i];
					
				  $data .= 'id="' . $path . '/" class="dirchange">';
				  $data .= $this->dir_list[$i];
				  $data .= '</a></td>
				<td>&nbsp;</td>
				<td>' . $this->getPerms(fileperms($this->base_dir . $path)) . '</td>
				<td class="right">
				<a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->dir_list[$i] . '" class="chmod-single">'
				.'<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/lock.png" alt=""   title="' . _FM_CHGPER . '" /></a>
				<a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->dir_list[$i] . '" class="del-single">'
				.'<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/delete.png" alt="" title="' . _FM_DELDIR_D . '" /></a>
				<input name="multid[]" type="checkbox" id="multid-' . $i . '" rel="'.$this->dir_list[$i].'" value="' . $path . '" /></td>
			  </tr>';
			  
			  $this->cdirs++;
		  }
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
		  for ($i = 0; $i < $this->file_count; $i++) {
			  if ($this->cfiles % 2 == 0) {
				  $this->color = "even";
			  } else
				  $this->color = "odd";
			  
			  $path = $this->base_dir . $this->rel_dir . $this->file_list[$i];
			  $modified = filemtime($path);
			  $size = filesize($path);
			  $fsize = $this->getSize($size);

			  $this->ext = explode(".", $this->file_list[$i], strlen($this->file_list[$i]));
			  $extn = $this->ext[count($this->ext) - 1];	
			  		  
			  $data .= '<tr class="' . $this->color . '" id="multif-' . $i . '">
				  <td><img src="/'.FILE_MANAGER_ASSETS.'/manager/images/mime/' . $this->getFileType($extn) . '" alt="" class="" title="' . $this->getTitleDesc($path, $fsize) . '" /></td>';
			  $data .= '
				  <td><a href="' . $this->setting->getSiteUrl() . '/uploads/' . $this->rel_dir . $this->file_list[$i] . '" ';
				  if($this->isimage($extn))
				  $data .= 'rel="single"';
				  $data .= 'title="' . $this->file_list[$i] . '" class="pirobox">' . $this->file_list[$i] . '</a></td>
				  <td>' . $fsize . '</td>
				  <td>' . $this->getPerms(fileperms($path)) . '</td>
				  <td class="right">';
			  if ($this->iseditable($extn)) {
				  $data .= '<a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->file_list[$i] . '" class="edit-single">'
				  .'<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/edit.png" class="" alt="" title="' . _FM_EDITFILE . '" /></a> ';
			  }
			  
			  if ($this->isviewable($extn) || $this->isimage($extn)) {
				  $data .= '<a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->file_list[$i] . '" class="view-single">'
				  .'<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/view.png" class="" alt="" title="' . _FM_VIEWFILE . '" /></a> ';
			  }
			  $data .= '<a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->file_list[$i] . '" class="chmod-single">'
			  .'<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/lock.png" alt="" class="" title="' . _FM_CHGPER . '" /></a> ';
			  $data .= '<a href="javascript:void(0);" id="' . $this->rel_dir . '" rel="' . $this->file_list[$i] . '" class="del-single">'
			  .'<img src="/'.FILE_MANAGER_ASSETS.'/manager/images/icons/delete.png" alt="" class="" title="' . _FM_DELFILE . '" /></a> ';
			  $data .= '<input name="multif[]" type="checkbox" id="multif-' . $i . '" value="' . $this->file_list[$i] . '" />';
			  $data .= '
				  </td>
				</tr>';
			  $this->cfiles++;
		  }

			  $data .='<tr style="background-color:transparent"><td colspan="5"><strong>'._FM_DIRS.': '.$this->cdirs.' '._FM_FILES.': ' .$this->cfiles.'</strong></td></tr>';
			  $data .='<tr style="background-color:transparent">
			  <td style="text-align:right" colspan="5">
			     <div style="float:left;" class="box">
				   <input name="newfile" type="file" class="inputbox"/> <input name="dofile" id="fileupload" rel="' . $this->rel_dir . '" type="submit" value="' . _FM_UPLOAD . '" class="button-sml"/>
				   <input name="filepath" type="hidden" value="' . $this->rel_dir . '" />
				 </div>
				<div style="float:right" class="box">';
				$data .='<a href="javascript:void(0);" class="button-sml" id="create-file" rel="' . $this->rel_dir . '">'._FM_NEWFILE.'</a>
				<a href="javascript:void(0);" class="button-sml" id="create-dir" rel="' . $this->rel_dir . '">'._FM_NEWDIR.'</a>
				<a href="javascript:void(0);" class="button-alt-sml" id="delete-multi">'._DELETE.'</a>
				</div><div class="clear"></div></td>
			</tr>';
		  return $data;
	  }

	  /**
	   * Filemanager::viewItem()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @return
	   */
	  public function viewItem($path, $name)
	  {
		  $fulpath = $this->base_dir . $path . $name;
		  $style=' style="border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #ccc;"';
		  print '
		    <h4>'._FM_VIEWING.' &rsaquo; '. $name .'</h4>
			<table cellspacing="2" cellpadding="2">
			  <tr>
				<td'.$style.'><strong>' . _FM_FILE . ':</strong></td>
				<td colspan="3"'.$style.'>' . $name . '</td>
			  </tr>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILSIZE . ':</strong></td>
				<td'.$style.'>' . $this->getSize(filesize($fulpath)) . '</td>
				<td'.$style.'><strong>' . _FM_FILEOWNER . ':</strong></td>
				<td'.$style.'>' . fileowner($fulpath) . '</td>
			  </tr>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILELM . ':</strong></td>
				<td'.$style.'>' . date("d/M/y G:i:s", filemtime($fulpath)) . '</td>
				<td'.$style.'><strong>' . _FM_FILEGROUP . ': </strong></td>
				<td'.$style.'>' . filegroup($fulpath) . '</td>
			  </tr>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILLA . ':</strong></td>
				<td'.$style.'>' . date("d/M/y G:i:s", fileatime($fulpath)) . '</td>
				<td'.$style.'><strong>' . _FM_PERM . ': </strong></td>
				<td'.$style.'>' . $this->getPerms(fileperms($fulpath)) . '</td>
			  </tr>
			  <tr>';
			  
			  $this->ext = explode(".", $fulpath, strlen($fulpath));
			  $extn = $this->ext[count($this->ext) - 1];
			   
				  if ($this->isimage($extn)) {
					  $filename = basename($fulpath);
					  $iurl = $this->setting->getSiteUrl() . "/uploads/" . $path . $filename;
					  print ' <td colspan="4" align="center"><img src="' . $iurl . '" class=" thumb" alt="' . $filename . '" title="' . $filename . '" /></td>';
				  } else {
					  $line_num = 0;
					  print '<td colspan="4">' . $this->get_sourcecode($fulpath, $line_num) . '</td>';
				  }
				  print ' </tr>
			</table>';
	  }
 
 	  /**
	   * Filemanager::editItem()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @return
	   */
	  public function editItem($path, $name)
	  {
		  $fulpath = $this->base_dir . $path . $name;
		  $style=' style="border-bottom-width: 1px; border-bottom-style: dotted; border-bottom-color: #ccc;"';
		  print '
		    <h4>'._FM_EDITING.' &rsaquo; '. $name .'</h4>
			<table cellspacing="2" cellpadding="2" style="width:600px>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILE . ':</strong></td>
				<td colspan="3"'.$style.'>' . $name . '</td>
			  </tr>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILSIZE . ':</strong></td>
				<td'.$style.'>' . $this->getSize(filesize($fulpath)) . '</td>
				<td'.$style.'><strong>' . _FM_FILEOWNER . ':</strong></td>
				<td'.$style.'>' . fileowner($fulpath) . '</td>
			  </tr>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILELM . ':</strong></td>
				<td'.$style.'>' . date("d/M/y G:i:s", filemtime($fulpath)) . '</td>
				<td'.$style.'><strong>' . _FM_FILEGROUP . ': </strong></td>
				<td'.$style.'>' . filegroup($fulpath) . '</td>
			  </tr>
			  <tr>
				<td'.$style.'><strong>' . _FM_FILLA . ':</strong></td>
				<td'.$style.'>' . date("d/M/y G:i:s", fileatime($fulpath)) . '</td>
				<td'.$style.'><strong>' . _FM_PERM . ': </strong></td>
				<td'.$style.'>' . $this->getPerms(fileperms($fulpath)) . '</td>
			  </tr>
			  <tr>
			  </table>';
		  print '<form name="form" method="post" action="" id="itemsave">
				<textarea name="filecontent" cols="10" rows="20" class="inputbox" id="filecontent" style="width:450px">';
					  $line_num = 0;
					  $fp = fopen($fulpath, "r");
					  while (!feof($fp)) {
						  $line = fgets($fp, 1024);
						  echo htmlspecialchars($line);
						  $line_num++;
					  }
					  fclose($fp);
		  print ' </textarea>
					</form>';
	  }
	  
 	  /**
	   * Filemanager::saveItem()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @param mixed $content
	   * @return
	   */
	  public function saveItem($path, $name, $content)
	  {

		  
		  $fulpath = $this->base_dir . $path . $name;
		  $fp = fopen($fulpath, "w");
		  {
			  if (fwrite($fp, $content, strlen($content))) {
                  $this->show->msgOk(_FM_FILESAVEOK1 . '<strong> ' . $name . ' </strong>' . _FM_FILESAVEOK2);
			  } else {
                  $this->show->msgError(_FM_FILESAVEERR1 . '<strong> ' . $name . ' </strong>' . _FM_FILESAVEERR2);
			  }
		  }
		  fclose($fp);
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
	   * Filemanager::iseditable()
	   * 
	   * @param mixed $str
	   * @return
	   */
	  private function iseditable($str)
      {
          $edit_file = array("php", "txt", "htm", "html", "php3", "asp", "xml", "css", "inc", "js");
          for ($f = 0; $f < count($edit_file); $f++) {
              if ($str == $edit_file[$f])
                  return true;
          }
          return false;
      }
      
	  /**
	   * Filemanager::isviewable()
	   * 
	   * @param mixed $str
	   * @return
	   */
	  private function isviewable($str)
      {
          $edit_file = array("php", "txt", "htm", "html", "php3", "asp", "xml", "css", "inc", "js");
          for ($f = 0; $f < count($edit_file); $f++) {
              if ($str == $edit_file[$f])
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

		  if (is_dir($this->base_dir . $path)) {
			  if ($this->purge($this->base_dir . $path)) {
				  if ($name) {
                      $this->show->msgOK(_FM_DIR_DEL_OK1 . '<strong> ' . $name . ' </strong>' . _FM_DIR_DEL_OK2);
				  } else
					  return true;
			  } else
                  $this->show->msgOK(_FM_DIR_DEL_ERR . '<strong> ' . $name . ' </strong>');
		  } elseif (file_exists($this->base_dir . $path)) {
			  if (unlink($this->base_dir . $path)) {
				  if ($name) {
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
	   * Filemanager::chmodall()
	   * 
	   * @param mixed $path
	   * @param mixed $perm
	   * @param mixed $name
	   * @return
	   */
	  public function chmodall($path, $perm, $name)
      {


		  if (chmod($this->base_dir . $path, octdec($perm))) {
              $this->show->msgOK(_FM_PER_OK1 . '<strong> ' . $name . ' </strong>' . _FM_PER_OK2);
		  } else
              $this->show->msgError(_FM_PER_ERR . '<strong> ' . $name . ' </strong>');
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
			  if (!$multi)
                  $this->show->msgOK(_FM_DIR_OK1 . '<strong> ' . $name . ' </strong>' . _FM_DIR_OK2);
		  } else
		      if (!$multi)
                  $this->show->msgError(_FM_DIR_ERR . '<strong> ' . $name . ' </strong>');
      }

	  /**
	   * Filemanager::makeFile()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @return
	   */
	  public function makeFile($path, $name)
      {


		  if (!file_exists($this->base_dir . $path . $name)) {
			  touch($this->base_dir . $path . $name);
              $this->show->msgOK(_FM_FILENAME1 . '<strong> ' . $name . ' </strong>' . _FM_FILENAME2);
		  } else
              $this->show->msgError(_FM_FILENAME_ERR . '<strong> ' . $name . ' </strong>');
      }

	  /**
	   * Filemanager::uploadFile()
	   * 
	   * @param mixed $path
	   * @param mixed $name
	   * @return
	   */
	  public function uploadFile($path)
	  {

		  
		  if (!is_dir($this->base_dir . $path))
			  die( $this->show->msgError(_FM_UPLOAD_ERR1));
		  
		  if (!is_writeable($this->base_dir . $path))
			  die( $this->show->msgError(_FM_UPLOAD_ERR2));
		  
		  $upldir = $this->base_dir . htmlspecialchars($path, ENT_QUOTES);
		  $newfile = $_FILES['newfile'];
		  $filename = $newfile['name'];
		  
		  $filename = str_replace(' ', '_', $filename);
		  $filetmp = $newfile['tmp_name'];
		  $filesize = $newfile['size'];
		  
		  if (!is_uploaded_file($filetmp)) {
              $this->show->msgs['file'] = _FM_FILE . ' <strong> ' . $filename . ' </strong> ' . _FM_UPLOAD_ERR3;
		  }
		  
		  $ext = strrchr($filename, '.');
		  if (!in_array(strtolower($ext), $this->fileext)) {
              $this->show->msgError(_FM_FILE . ' <strong> ' . $filename . ' </strong> ' . _FM_UPLOAD_ERR4);
		  }
		  
		  if (file_exists($upldir . $filename)) {
              $this->show->msgs['file'] = _FM_FILE . ' <strong> ' . $filename . ' </strong> ' . _FM_UPLOAD_ERR6;
		  }
		  
		  if (empty( $this->show->msgs)) {
			  if (move_uploaded_file($filetmp, $upldir . $filename)) {
                  $this->show->msgOk(_FM_FILE . ' <strong> ' . $filename . ' </strong> ' . _FM_UPLOAD_ERR7);
			  } else
                  $this->show->msgs['file'] = _FM_FILE . ' <strong> ' . $filename . ' </strong> ' . _FM_UPLOAD_ERR8;
		  } else
              $this->show->msgStatus();
	  }
	  	  	        
	  /**
	   * Filemanager::xcopy()
	   * 
	   * @param mixed $basedir
	   * @param mixed $txtFolderName
	   * @param mixed $action
	   * @return
	   */
	  public function xcopy($basedir, $txtFolderName, $action)
      {
          if ($handle = @opendir($basedir)) {
              while (false !== ($dir = readdir($handle))) {
                  if ($dir != '.' && $dir != '..') {
                      if (is_dir($basedir . "/" . $dir)) {
                          $mkSuccess = mkdir($txtFolderName . "/" . $dir);
                          $this->xcopy($basedir . "/" . $dir, $txtFolderName . "/" . $dir, $action);
                          if ($action == "cut")
                              $this->purge($basedir . "/" . $dir);
                      } else {
                          copy($basedir . "/" . $dir, $txtFolderName . "/" . $dir);
                          if ($action == "cut")
                              unlink($basedir . "/" . $dir);
                      }
                  }
              }
              closedir($handle);
          }
      }

	  /**
	   * Filemanager::get_sourcecode()
	   * 
	   * @param mixed $filename
	   * @param integer $first_line_num
	   * @param string $num_color
	   * @return
	   */
	  public function get_sourcecode($filename, $first_line_num = 1, $num_color = "#1DA4F3")
      {
          $html_code = highlight_file($filename, true);
          
          if (substr($html_code, 0, 6) == "<code>") {
              $html_code = substr($html_code, 6, strlen($html_code));
          }
          
          $xhtml_convmap = array('<font' => '<span', '</font>' => '</span>', 'color="' => 'style="color:');
          
          $html_code = strtr($html_code, $xhtml_convmap);
          
          $arr_html_code = explode("<br />", $html_code);
          $total_lines = count($arr_html_code);
          
          $retval = "";
          $line_counter = 0;
          $last_line_num = $first_line_num + $total_lines;
          foreach ($arr_html_code as $html_line) {
              $current_line = $first_line_num + $line_counter;
              
              $retval .= str_repeat("&nbsp;", strlen($last_line_num) - strlen($current_line)) . "<span style=\"color:{$num_color}\">{$current_line}: </span>" . $html_line . "<br />";
              
              $line_counter++;
          }
          
          $retval = "<code>" . $retval;
          
          return $retval;
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
	   * Filemanager::getTitleDesc()
	   * 
	   * @param mixed $path
	   * @param mixed $fsize
	   * @return
	   */
	  private function getTitleDesc($path, $fsize) 
	  {
		  
		  $display =  _FM_PATH . ": " . $path;
		  $fmodified = date("d/M/y G:i:s", filemtime($path));
		  $faccessed = date("d/M/y G:i:s", fileatime($path));
		  $display .= "<br />" . _FM_FILSIZE . ": " . $fsize;
		  $display .= "<br />" . _FM_FILELM . ": " . $fmodified;
		  $display .= "<br />" . _FM_FILLA . ": " . $faccessed;
		  $display .= "<br />" . _FM_FILEOWNER . ": " . fileowner($path);
		  $display .= "<br />" . _FM_FILEGROUP . ": " . filegroup($path);
		  $display .= "<br />" . _FM_PERM . ": ";
		  $display .= $this->getPerms(fileperms($path));
		  
		  return $display;

	  }
	  
	  
	  /**
	   * Filemanager::getPerms()
	   * 
	   * @param mixed $mode
	   * @return
	   */
	  private function getPerms($mode)
	  {
		  $owner["read"] = ($mode & 00400) ? "r" : "-";
		  $owner["write"] = ($mode & 00200) ? "w" : "-";
		  $owner["execute"] = ($mode & 00100) ? "x" : "-";
		  $group["read"] = ($mode & 00040) ? "r" : "-";
		  $group["write"] = ($mode & 00020) ? "w" : "-";
		  $group["execute"] = ($mode & 00010) ? "x" : "-";
		  $world["read"] = ($mode & 00004) ? "r" : "-";
		  $world["write"] = ($mode & 00002) ? "w" : "-";
		  $world["execute"] = ($mode & 00001) ? "x" : "-";

		  switch(true){
			  case ($mode & 0xC000) === 0xC000:
				  $type = "s";
				  break;
			  case ($mode & 0x4000) === 0x4000:
				  $type = "d";
				  break;
			  case ($mode & 0xA000) === 0xA000:
				  $type = "l";
				  break;
			  case ($mode & 0x8000) === 0x8000:
				  $type = "-";
				  break;
			  case ($mode & 0x6000) === 0x6000:
				  $type = "b";
				  break;
			  case ($mode & 0x2000) === 0x2000:
				  $type = "c";
				  break;
			  case ($mode & 0x1000) === 0x1000:
				  $type = "p";
				  break;				  
			  default:
				  $type = "?";
				  break;
		  }
	  
		  if ($mode & 0x800)
			  $owner["execute"] = ($owner["execute"] == "x") ? "s" : "S";

		  if ($mode & 0x400)
			  $group["execute"] = ($group["execute"] == "x") ? "s" : "S";

		  if ($mode & 0x200)
			  $world["execute"] = ($world["execute"] == "x") ? "t" : "T";
		  
		  $result = $type . join("", $owner) . join("", $group) . join("", $world);
		  return $result;
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
			case "gif":
			case "png":
				return "jpg.png";
				break;
				
			case "bmp":
			case "dib":
				return "bmp.png";
				break;
				
			case "txt":
			case "log":
			case "sql":
				return "txt.png";
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
				
			default:
				return "ukn.png";
				break;
		}	

	  }
  }
?>