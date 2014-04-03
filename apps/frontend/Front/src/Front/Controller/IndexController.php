<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Front\Controller;

use MDS\Mvc\Controller\Action;

use Quok\Mvc\Controller\FrontAc;
use Zend\View\Model\ViewModel;

class IndexController extends Action
{
    public function indexAction()
    {
        $this->layout()->setTemplate('layout/front.phtml');
        return new ViewModel();
    }
}
