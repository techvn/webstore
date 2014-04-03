<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/3/14
 * Time: 2:07 PM
 * To change this template use File | Settings | File Templates.
 */
namespace User\Controller;
use MDS\Mvc\Controller\Action;
class PermissionController extends Action{
    public function indexAction(){
        $coll = new \User\Libs\Permission\Collection();
        $order_by = $this->params()->fromRoute('order_by');
        $order = $this->params()->fromRoute('order');
        $page = $this->params()->fromRoute('page');
        $redirect = base64_encode($this->getRequest()->getRequestUri());
        $paginator = $coll->bildPagination(
            $order_by,
            $order ,
            $page,
            10,
            7
        );
        return array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
            'redirect'=>$redirect
        );
    }
}