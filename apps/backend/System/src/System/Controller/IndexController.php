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
        $data['customeWidgets'] = array();
        $this->events()->trigger(__CLASS__, 'dashboard', $this, array('widgets' => &$data['customeWidgets']));
        return $data;;
    }
}
