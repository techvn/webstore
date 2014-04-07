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
        $form = new \User\Forms\Resource\Form();
        $form->setAttribute('action', $this->url()->fromRoute('user/resource-manager',array('action'=>'create')));
        $post = $this->getRequest()->getPost();
        if ($this->getRequest()->isPost()) {
            $form->setData($post->toArray());
            if ($form->isValid()) {
                $model = new \User\Libs\Resource\Model();
                $model->setData($post->toArray());
                $model->save();
                $this->flashMessenger()->addSuccessMessage('This view has been create');
            }
        }
        return array('form'=>$form);
    }

    public function editAction(){
        $id = $this->params()->fromRoute('id');
        $model = \User\Libs\Resource\Model::fromId($id);
        $redirect = $this->params()->fromRoute('redirect');
        if(!$model){
            return $this->redirect()->toRoute('user/resource-manager',array('action'=>'index'));
        }
        $form = new \User\Forms\Resource\Form();
        $form->loadValues($model);

        $form->setAttribute('action', $this->url()->fromRoute('user/resource-manager',array('action'=>'edit','id'=>$id,'redirect'=>$redirect)));
        $post = $this->getRequest()->getPost();
        if ($this->getRequest()->isPost()) {
            $form->setData($post->toArray());
            if ($form->isValid()) {
                $model->addData($post->toArray());
                $model->save();
                $this->flashMessenger()->addSuccessMessage('This view has been edit');
                if(!empty($redirect))
                    return $this->redirect()->toUrl(base64_decode($redirect));
                return $this->redirect()->toRoute('user/user-manager',array('action'=>'index'));

            }
        }
        return array('form'=>$form);
    }
    public function deleteAction(){
        $id = $this->params()->fromRoute('id');
        $redirect = $this->params()->fromRoute('redirect');
        $userModel = \User\Libs\Model::fromId($id);
        if($userModel){
            $userModel->delete();
        }
        $this->flashMessenger()->addSuccessMessage('This view has been delete');
        if(!empty($redirect))
            return $this->redirect()->toUrl(base64_decode($redirect));
        return $this->redirect()->toRoute('user/user-manager',array('action'=>'index'));
    }
}