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
    	return array('category' => $categoryCollection->getcategory());
    }
    
    
    public function createAction()
    {
    	$form = new CategoryForm();
    	$form->setAttribute('action', $this->url()->fromRoute('posts/category/create'));
    
    	if ($this->getRequest()->isPost()) {
    		$data = $this->getRequest()->getPost()->toArray();
    		$form->setData($data);
    		if (!$form->isValid()) {
    			$this->flashMessenger()->addErrorMessage('Can not save view');
    			$this->useFlashMessenger();
    		} else {
    			$viewModel = new \Posts\Model\Model();
    			$viewModel->setParrentId($form->getValue('parrent_id'));
    			$viewModel->setTitle($form->getValue('title'));
    			$viewModel->setSlug($form->getValue('slug'));
    			$viewModel->setActive($form->getValue('active'));
    			$viewModel->setMetakey($form->getValue('metakey'));
    			$viewModel->setMetades($form->getValue('metades'));
    			$viewModel->save();
    
    			$this->flashMessenger()->addSuccessMessage('This view has been created');
    			return $this->redirect()->toRoute('posts/category/edit', array('id' => $viewModel->getId()));
    		}
    	}
    
    	return array('form' => $form);
    }
    
    
    public function editAction()
    {
    	$viewId    = $this->getRouteMatch()->getParam('id', null);
    	$viewModel = \Posts\Model\Model::fromId($viewId);
    	if (empty($viewId) or empty($viewModel)) {
    		return $this->redirect()->toRoute('posts/category');
    	}
    
    	$viewForm = new CategoryForm();
    	$viewForm->setAttribute('action', $this->url()->fromRoute('posts/category/edit', array('id' => $viewId)));
    	$viewForm->loadValues($viewModel);
    
    	if ($this->getRequest()->isPost()) {
    		$data = $this->getRequest()->getPost()->toArray();
    		$viewForm->setData($data);
    		if (!$viewForm->isValid()) {
    			$this->flashMessenger()->addErrorMessage('Can not save view');
    			$this->useFlashMessenger();
    		} else {
    		    $viewModel->setParrentId($viewForm->getValue('parrent_id'));
    			$viewModel->setTitle($viewForm->getValue('title'));
    			$viewModel->setSlug($viewForm->getValue('slug'));
    			$viewModel->setActive($viewForm->getValue('active'));
    			$viewModel->setMetakey($viewForm->getValue('metakey'));
    			$viewModel->setMetades($viewForm->getValue('metades'));
    			$viewModel->save();
    
    			$this->flashMessenger()->addSuccessMessage('This view has been saved');
    			return $this->redirect()->toRoute('posts/category/edit', array('id' => $viewId));
    		}
    	}
    
    	return array('form' => $viewForm, 'viewId' => $viewId);
    }
    
    
   public function deleteAction()
    {
        $view = \Posts\Model\Model::fromId($this->getRouteMatch()->getParam('id', null));
        if (!empty($view) and $view->delete()) {
            //return $this->returnJson(array('success' => true, 'message' => 'This view has been deleted'));
            $this->flashMessenger()->addSuccessMessage('This view has been deleted');
            return $this->redirect()->toRoute('posts/category');
        }

        //return $this->returnJson(array('success' => false, 'message' => 'View does not exists'));
        $this->flashMessenger()->addSuccessMessage('View does not exists');
        return $this->redirect()->toRoute('posts/category');
    }
    
    

}
