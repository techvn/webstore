<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/3/14
 * Time: 2:35 PM
 * To change this template use File | Settings | File Templates.
 */
namespace User\Controller;
use MDS\Mvc\Controller\Action;

class ResourceController extends Action{

    public function indexAction(){
        $coll = new \User\Libs\Resource\Collection();
        $order_by = $this->params()->fromRoute('order_by');
        $order = $this->params()->fromRoute('order');
        $page = $this->params()->fromRoute('page');
        $redirect = base64_encode($this->getRequest()->getRequestUri());
        $paginator = $coll->bildPagination(
            $order_by,
            $order ,
            $page,
            1,
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
    public function createAction(){

    }
    public function editAction(){

    }
    public function deleteAction(){

    }
}