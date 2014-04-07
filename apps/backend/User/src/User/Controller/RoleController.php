<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/2/14
 * Time: 11:50 PM
 * To change this template use File | Settings | File Templates.
 */
namespace User\Controller;
use MDS\Mvc\Controller\Action;

class RoleController extends Action{
        public function indexAction(){
            $coll = new \User\Libs\Role\Collection();
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
    public function ajaxAction(){
        $request = $this->getRequest();
        $response = $this->getResponse();
        $post = $request->getPost();
        $model =  \User\Libs\Role\Model::fromId($post['pk']);
        if($model){
            $model->update_columns(
                array(
                    'description'=>$post['value']
                )
            );
        }
        $response->setContent(\Zend\Json\Json::encode($post));
        return $response;
    }
    public function createAction(){

    }
    public function editAction(){

    }
}
