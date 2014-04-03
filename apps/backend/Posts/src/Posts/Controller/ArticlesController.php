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
use MDS\View;
use Zend\View\Model\ViewModel;


class ArticlesController extends Action
{
    public function indexAction()
    {
         return new ViewModel();
    }

    
    public function createAction()
    {
    	 return new ViewModel();
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    
    public function deleteAction()
    {
    	return new ViewModel();
    }
    
    
    
    
}
