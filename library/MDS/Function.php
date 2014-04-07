<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/7/14
 * Time: 10:09 AM
 * To change this template use File | Settings | File Templates.
 */


function get_resource($Resources){
    $_resources = "";
    $_permission = null;
    if (strpos($Resources, '/')) {
        $res_array = explode("/", $Resources);
        $_res_count = count($res_array);
        if ($_res_count==2) {
            $_resources = $res_array[0];
            $_permission = $res_array[1];
        }
    }else{
        $_resources = $Resources;
        $_permission = null;
    }
    return array(
        'resources'=>$_resources,
        'permission'=>$_permission
    );
}
function get_resource_sub($Resources,$Resources_Sub){
    $_resources = $Resources['resources'];
    $_permission = $Resources['permission'];

    if(($Resources_Sub != "")){
        if (strpos($Resources_Sub, '/')) {
            $keyArray = explode('/', $Resources_Sub);
            $_count = count($keyArray);
            if($_count>=3){
                $_resources = $keyArray[0];
                unset($keyArray[0]);
                $_permission = implode('/',$keyArray);
            }else if($_count==2){
                $_permission = $keyArray[0]."/".$keyArray[1];
                $app = \MDS\Registry::get('Application');
                $event = $app->getMvcEvent();
                $action = $event->getRouteMatch()->getParam('action');
                $_permission.=(!empty($_permission) ? '/' : '') . ($action === 'index' ? 'list' : $action);
            }
        }else{
            if (is_null($_permission)) {
                $_permission=$Resources_Sub;
            }else{
                $_permission.="/".$Resources_Sub;
            }
        }
    }
    return array(
        'resources'=>$_resources,
        'permission'=>$_permission
    );
}