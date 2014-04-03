<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/2/14
 * Time: 2:58 PM
 * To change this template use File | Settings | File Templates.
 */
namespace User\Controller;
use MDS\Mvc\Controller\Action;
class UserManagerController extends Action{
    
   // protected $aclPage = array('resource' => 'content', 'permission' => 'document');
        public function indexAction(){
        $coll_user = new \User\Libs\Collection();
        $order_by = $this->params()->fromRoute('order_by');
        $order = $this->params()->fromRoute('order');
        $page = $this->params()->fromRoute('page');
        $redirect = base64_encode($this->getRequest()->getRequestUri());
        $paginator = $coll_user->bildPagination(
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
            $form = new \User\Forms\UserManager\Form();
            $post = $this->getRequest()->getPost();
            if ($this->getRequest()->isPost()) {
                $form->setData($post->toArray());
                $form->passwordRequired();
                if ($form->isValid()) {
                    $userModel = new \User\Libs\Model();
                    $post = $post->toArray();
                    $userModel->setData($post);
                    $userModel->setPassword($post['password']);
                    if($userModel->setEmail($post['email'])){
                        $userModel->save();
                        $this->flashMessenger()->addSuccessMessage('This view has been create');
                    }
                }
            }
            return array('form'=>$form);
        }
        public function editAction(){
            $id = $this->params()->fromRoute('id');
            $userModel = \User\Libs\Model::fromId($id);
            if(!$userModel){
                return $this->redirect()->toRoute('user/user-manager',array('action'=>'index'));
            }
            $form = new \User\Forms\UserManager\Form();
            $form->loadValues($userModel);
            $post = $this->getRequest()->getPost();
            if($this->getRequest()->isPost()
               and $form->setData($post)
               and $form->isValid()
            ){
                $userModel->addData($post->toArray());
                if(isset($post['password']) && !empty($post['password'])){
                    $userModel->setPassword($post['password']);
                }
                if($userModel->setEmail($post['email'])){
                    $userModel->save();
                    $this->flashMessenger()->addSuccessMessage('This view has been edit');
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
            if($redirect)
                return $this->redirect()->toUrl(base64_decode($redirect));
            return $this->redirect()->toRoute('user/user-manager',array('action'=>'index'));
        }
        public function ajaxAction(){
            $request = $this->getRequest();
            $response = $this->getResponse();
            $post=array('data'=>false);
            if($this->getRequest()->isXmlHttpRequest()){
                $post = $request->getPost();
                $userModel = \User\Libs\Model::fromId($post['pk']);
                $userModel->update_columns(array('user_acl_role_id'=>$post['value']));
            }
            $response->setContent(\Zend\Json\Json::encode($post));
            return $response;
        }
}