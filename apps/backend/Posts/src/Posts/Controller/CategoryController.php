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
use Posts\Form\CategoryForm;

use Posts\Model\Collection;


class CategoryController extends Action
{

    public function indexAction()
    {
    	$categoryCollection = new Collection();
        $order_by = $this->params()->fromRoute('order_by');
        $order = $this->params()->fromRoute('order');
        $page = $this->params()->fromRoute('page');
        $redirect = base64_encode($this->getRequest()->getRequestUri());
        $paginator = $categoryCollection->bildPagination(
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
    	$form = new CategoryForm();
    	$form->setAttribute('action', $this->url('posts/cate-manager',array('action'=>'create')));
    
    	if ($this->getRequest()->isPost()) {
    		$data = $this->getRequest()->getPost()->toArray();
    		$form->setData($data);
    		if (!$form->isValid()) {
    			$this->flashMessenger()->addErrorMessage('Can not save view');
    			$this->useFlashMessenger();
    		} else {
    			$viewModel = new \Posts\Model\Model();
    			$viewModel->setData($data);
    			$viewModel->save();
    
    			$this->flashMessenger()->addSuccessMessage('This view has been created');
    			return $this->redirect()->toRoute('posts/cate-manager', array('id' => $viewModel->getId()));
    		}
    	}
        $categoryCollection = new Collection();
    	return array('form' => $form,'cates'=>$categoryCollection->getcategory());
    }
    
    
    public function editAction()
    {
    	$viewId    = $this->getRouteMatch()->getParam('id', null);
    	$viewModel = \Posts\Model\Model::fromId($viewId);
    	if (empty($viewId) or empty($viewModel)) {
    		return $this->redirect()->toRoute('posts/cate-manager',array('action'=>'index'));
    	}
    
    	$viewForm = new CategoryForm();
    	$viewForm->setAttribute('action', $this->url()->fromRoute('posts/cate-manager', array(array('action'=>'edit'),'id' => $viewId)));
    	$viewForm->loadValues($viewModel);
    	if ($this->getRequest()->isPost()) {
    		$data = $this->getRequest()->getPost()->toArray();
    		$viewForm->setData($data);
    		if (!$viewForm->isValid()) {
    			$this->flashMessenger()->addErrorMessage('Can not save view');
    			$this->useFlashMessenger();
    		} else {
    		    $viewModel->addData($data);
    			$viewModel->save();
    
    			$this->flashMessenger()->addSuccessMessage('This view has been saved');
    			return $this->redirect()->toRoute('posts/cate-manager', array('id' => $viewId));
    		}
    	}
        $categoryCollection = new Collection();
        return array('form' => $viewForm,'viewId' => $viewId,'cates'=>$categoryCollection->getcategory());

    }
   public function deleteAction()
    {
        $view = \Posts\Model\Model::fromId($this->getRouteMatch()->getParam('id', null));
        if (!empty($view)) {
            $view->delete();
        }
        //return $this->returnJson(array('success' => false, 'message' => 'View does not exists'));
        $this->flashMessenger()->addSuccessMessage('View does not exists');
        return $this->redirect()->toRoute('posts/cate-manager');
    }
    
    

}
