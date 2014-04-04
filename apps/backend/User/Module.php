<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/User for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;
use MDS\Mvc;
class Module extends Mvc\Module
{
    protected $directory = __DIR__;
    protected $namespace = __NAMESPACE__;
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'acl'   => function ($pm) {
                    return new \User\Helper\Acl(
                        $pm->getServiceLocator()->get('auth')->getIdentity()
                    );
                },
                'acl_check'   => function ($pm) {
                    return new \User\Helper\AclCheck(
                        $pm->getServiceLocator()->get('auth')->getIdentity()
                    );
                },
                'user_system'   => function ($pm) {
                    return new \User\Helper\UserSystem(
                        $pm->getServiceLocator()->get('auth')->getIdentity()
                    );
                }
            )
        );
    }
}

