<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/User for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;
use MDS\Mvc\Controller\Action;
class IndexController extends Action
{
    protected $aclPage = array('resource' => 'content', 'permission' => 'document');
    public function indexAction()
    {
        return array();
    }
    public function loginAction(){
        $this->layout('layout/system/login');
        if($this->getServiceLocator()->get('Auth')->hasIdentity()){
            return $this->redirect()->toRoute('system/default',array('controller'=>'Index','action'=>'index'));
        }
        $redirect = $this->params()->fromRoute('redirect');

        $form = new \User\Forms\Login\Form();
        $form->setAttribute("action",$this->url()->fromRoute('user/login',array('action'=>'login','redirect'=>$redirect)));
        $post = $this->getRequest()->getPost();

        if($form->setData($post->toArray())
            and $this->getRequest()->isPost()
            and $form->isValid()
        ){
            $data = $post->toArray();
            $userModel =new \User\Libs\Model();
            $userModel->authenticate($data['username'],$data['password']);
            if($redirect)
                return $this->redirect()->toUrl(base64_decode($redirect));
            else
                return $this->redirect()->toRoute('system');
        }
        return array('form'=>$form,'redirect'=>$redirect);
    }
    public function createAction(){

    }
    public function logoutAction(){
        $this->getServiceLocator()->get('Auth')->clearIdentity();
        return $this->redirect()->toRoute('user/login',array('action'=>'login'));
    }
    public function not_permissionAction(){

    }
}
