<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace System\Controller;
use MDS\Mvc\Controller\Action;
class IndexController extends Action
{
  //  protected $aclPage = array('resource' => 'settings', 'permission' => 'user');
    public function indexAction()
    {
      //  $arr = $this->getServiceLocator()->get('config');
      //  echo "<pre>".print_r($arr,1)."</pre>";
        return array();
    }
}
