<?php

namespace System\Controller;
use MDS\Mvc\Controller\Action;
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
class FileManagerController extends Action
{
    public function indexAjaxAction(){
        $request = $this->getRequest();
        $post = $this->getRequest()->getPost();
        $response = $this->getResponse();
        $fm = new \System\Filemanager\Filemanager();
        $action = (isset($_REQUEST['fmaction'])) ? \sanitize($_REQUEST['fmaction']) : "default";
        $name = (isset($_POST['name'])) ? \sanitize($_POST['name']) : "";
        $path = (isset($_POST['path'])) ? \sanitize($_POST['path']) : "";
        $filepath = (isset($_POST['filepath'])) ? \sanitize($_POST['filepath']) : "";
        $octal = (isset($_POST['octal'])) ? \sanitize($_POST['octal']) : "";
        $core =new \System\Filemanager\Show();
        switch ($action) {
            case "deleteSingle":
                $fm->delete($path, $name);
                break;
            case "chmodSingle":
                if (empty($octal)) {
                    $core->msgError(_FM_PER_OCT_ERR);
                } else {
                    $fm->chmodall($path, $octal, $name);
                }
                break;

            case "createDir":
                if (empty($name)) {
                    $core->msgError(_FM_DIR_NAME_R);
                } else {
                    $fm->makeDirectory($path, $name);
                }
                break;

            case "createFile":
                if (empty($name)) {
                    $core->msgError(_FM_FILENAME_R);
                } else {
                    $fm->makeFile($path, $name);
                }
                break;

            case "deleteMulti":
                if (empty($_POST['multid']) && empty($_POST['multif'])) {
                    $core->msgAlert(_FM_SEL_ERR);
                } else {
                    if (isset($_POST['multid'])) {
                        foreach ($_POST['multid'] as $deldir) {
                            $action = $fm->delete($deldir);
                        }
                        if ($action)
                            $core->msgOK(_FM_DELOK_DIR);
                    }
                    if (isset($_POST['multif'])) {
                        foreach ($_POST['multif'] as $delfile) {
                            $action = $fm->delete($filepath . $delfile);
                        }
                        if ($action)
                            $core->msgOK(_FM_DELOK_FILE);
                    }
                }
                break;

            case "viewItem":
                $fm->viewItem($path, $name);
                break;

            case "editItem":
                $fm->editItem($path, $name);
                break;

            case "saveItem":
                $fm->saveItem($path, $name, $_POST['filecontent']);
                break;

            case "uploadFile":
                if (empty($_FILES['newfile']['name'])) {
                    $core->msgError(_FM_UPLOAD_ERR9);
                } else {
                    $filepath = $_POST['filepath'];
                    $fm->uploadFile($filepath);
                }
                break;

            default:
                $fm->renderAll();
                break;
        }
        return $response;
    }
    public function viewtreeAction(){
        $layout = $this->layout();
        $layout->setTemplate('layout/system/editor');
        return array();
    }
    public function ajaxAction(){
        $request = $this->getRequest();
        $post = $this->getRequest()->getPost();
        $response = $this->getResponse();
        $action = (isset($_REQUEST['fmaction'])) ? sanitize($_REQUEST['fmaction']) : "default";
        $name = (isset($post['name'])) ? sanitize($post['name']) : "";
        $path = (isset($post['path'])) ? sanitize($post['path']) : "";
        $filepath = (isset($post['filepath'])) ? sanitize($post['filepath']) : "";
        $octal = (isset($post['octal'])) ? sanitize($post['octal']) : "";
        $fm = new \System\Filemanager\classFm();
        switch ($action) {
            case "deleteSingle":
                $fm->delete($path, $name);
                break;
            case "createDir":
                if (empty($name)) {

                } else {
                    $fm->makeDirectory($path, $name);
                }
                break;
            case "uploadFile":
                if (empty($_FILES['newfile']['name'])) {
                    // echo "1102";
                } else {
                    $filepath = $_POST['filepath'];
                    // $fm->uploadFile($filepath);
                    $fm->uploadUploadZend2($filepath);
                }
                break;

            default:
                $fm->renderAll();
                break;
        }
        //$response->setContent(\Zend\Json\Json::encode(array("flag"=>true,"data"=>$post)));
        return $response;
    }
}
