<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Posts for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Posts\Controller;

use MDS\Mvc\Controller\Action;
use Posts\Form\ArticlesForm;
use Posts\Model\Collection;
use MDS\View;
class ArticlesController extends Action
{
    public function indexAction()
    {
        $article = new \Posts\Model\Articles\Collection();
        $order_by = $this->params()->fromRoute('order_by');
        $order = $this->params()->fromRoute('order');
        $page = $this->params()->fromRoute('page');
        $redirect = base64_encode($this->getRequest()->getRequestUri());
        $paginator = $article->bildPagination(
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
    public function createAction()
    {
        $form = new \Posts\Form\ArticlesForm();
        $post = $this->getRequest()->getPost();
        $form->setAttribute('action', $this->url()->fromRoute('posts/articles/create'));

        if ($this->getRequest()->isPost()) {
            $form->setData($post->toArray());
            $form->slugRequired();
            if ($form->isValid()) {
                $user = $this->getServiceLocator()->get('Auth')->getIdentity();
                $data = $this->MyUploadImages()->doUpload('image-file',UPLOAD_PATH.'/articles');
                if($data['flag']=='oke'){
                    $newfile = $data['data'];
                    $Articles = new \Posts\Model\Articles\Model();
                    $post = $post->toArray();
                    $Articles->setData(array_merge($post,array('thumb'=>$newfile,'uid'=>$user->getId())));
                    $Articles->setSlug($post['slug'],$post['title']);
                    $Articles->save();
                    $this->flashMessenger()->addSuccessMessage('This view has been create');


                }else{
                    $form->setMessages(array('image-file'=>$data['data'] ));
                }

            }
        }
        $categoryCollection = new Collection();
    	 return array(
             'form' =>$form,
             'cates'=>$categoryCollection->getcategory()
         );
    }
    
    public function editAction()
    {
        $viewId    = $this->getRouteMatch()->getParam('id', null);
        $viewModel = \Posts\Model\Articles\Model::fromId($viewId);
        if (empty($viewId) or empty($viewModel)) {
            return $this->redirect()->toRoute('posts/category');
        }
        $form = new \Posts\Form\ArticlesForm();
        $post = $this->getRequest()->getPost();
        $form->setAttribute('action', $this->url()->fromRoute('posts/articles/edit',array('id'=>$viewId)));
        $form->loadValues($viewModel);
        if ($this->getRequest()->isPost()) {
            $form->setData($post->toArray());

            if ($form->isValid()) {
                $user = $this->getServiceLocator()->get('Auth')->getIdentity();

                if(isset($_FILES['image-file']) && !empty($_FILES['image-file']['name'])){
                    $data = $this->MyUploadImages()->doUpload('image-file',UPLOAD_PATH.'/articles');
                    if($data['flag']=='oke'){
                        $viewModel->setThumb($data['data']);
                    }
                }
                $post = $post->toArray();
                $viewModel->addData(array_merge($post,array('uid'=>$user->getId())));
                $viewModel->setSlug($post['slug'],$post['title']);
                $viewModel->save();
                $this->flashMessenger()->addSuccessMessage('This view has been edit');
                $redirect    = $this->getRouteMatch()->getParam('redirect', null);
                if(!empty($redirect))
                    return $this->redirect()->toUrl(base64_decode($redirect));
                return $this->redirect()->toRoute('posts/articles/default',array('action'=>'index'));
            }
        }
        $categoryCollection = new Collection();
        return array(
            'form' =>$form,
            'cates'=>$categoryCollection->getcategory()
        );
    }
    
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $redirect = $this->params()->fromRoute('redirect');
        $userModel = \Posts\Model\Articles\Model::fromId($id);
        if($userModel){
            $userModel->delete();
        }
        $this->flashMessenger()->addSuccessMessage('This view has been delete');
        if(!empty($redirect))
            return $this->redirect()->toUrl(base64_decode($redirect));
        return $this->redirect()->toRoute('posts/articles/default',array('action'=>'index'));
    }
}
