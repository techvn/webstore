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
    public function createAction(){

        $form = new \User\Forms\Permission\Form();
        $form->setAttribute('action', $this->url()->fromRoute('user/permission-manager',array('action'=>'create')));
        $post = $this->getRequest()->getPost();
        if ($this->getRequest()->isPost()) {
            $form->setData($post->toArray());
            if ($form->isValid()) {
                $permssionModel = new \User\Libs\Permission\Model();
                $post = $post->toArray();
                $permssionModel->setData($post);
                $permssionModel->save();
                $this->flashMessenger()->addSuccessMessage('This view has been create');
            }
        }
        return array('form'=>$form);
    }
    public function editAction(){
        $id = $this->params()->fromRoute('id');
        $redirect = $this->params()->fromRoute('redirect');
        $permssionModel = \User\Libs\Permission\Model::fromId($id);
        if(!$permssionModel){
            return $this->redirect()->toRoute('user/permission-manager',array('action'=>'index'));
        }
        $form = new \User\Forms\Permission\Form();
        $form->setAttribute('action', $this->url()->fromRoute('user/permission-manager',array('action'=>'edit','id'=>$id,'redirect'=>$redirect)));
        $form->loadValues($permssionModel);
        $post = $this->getRequest()->getPost();
        if ($this->getRequest()->isPost()) {
            $form->setData($post->toArray());
            if ($form->isValid()) {
                $post = $post->toArray();
                $permssionModel->addData($post);
                $permssionModel->save();
                $this->flashMessenger()->addSuccessMessage('This view has been edit');
                if(!empty($redirect))
                    return $this->redirect()->toUrl(base64_decode($redirect));
                return $this->redirect()->toRoute('user/permission-manager',array('action'=>'index'));
            }
        }
        return array('form'=>$form);
    }
    public function deleteAction(){
        $id = $this->params()->fromRoute('id');
        $redirect = $this->params()->fromRoute('redirect');
        $permssionModel = \User\Libs\Permission\Model::fromId($id);
        if($permssionModel){
            $permssionModel->delete();
        }
        $this->flashMessenger()->addSuccessMessage('This view has been delete');
        if(!empty($redirect))
            return $this->redirect()->toUrl(base64_decode($redirect));
        return $this->redirect()->toRoute('user/permission-manager',array('action'=>'index'));
    }
}