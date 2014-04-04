<?php
namespace System\Navigation\Core;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;
class MyNavigation extends DefaultNavigationFactory
{
    protected function getPages(ServiceLocatorInterface $serviceLocator)
    {
        if (null === $this->pages) {
            //FETCH data from table menu :
            // $fetchMenu = array(
            // 			array(
            // 			"name"=>"Login",
            // 			"icon"=>"icon-picture",
            // 			"label"=>"Login",
            // 			"route"=>'admin/login',
            // 			'resource'=>'development/view',
            // 			"pages"=>array(
            //         		       array(
            //              	        'label' => 'Child #1',
            //                         'route' => 'admin/login',
            //                         'resource'=>'edit',
            //                        )
            //         		    )
            // 			),
            // 			array(
            // 			"name"=>"Logout",
            // 			"icon"=>"icon-list-alt",
            // 			"label"=>"Logout",
            // 			"route"=>'admin',
            // 			'resource'=>'development/view',
            // 			"pages"=>array(
            //         		       array(
            //              	        'label' => 'Logout',
            //                         'route' => 'admin/index',
            //                         'resource'=>'edit',
            //                        )
            //         		    )
            // 			),
            // 			array(
            // 			"name"=>"Index",
            // 			"icon"=>"icon-list-alt",
            // 			"label"=>"Trang Ch?",
            // 			"route"=>'admin/index',
            // 			'resource'=>'development/view',
            // 			"pages"=>array()
            // 			),
            // );
        	$fetchMenu = $serviceLocator->get("config");

//            echo"<pre>".print_r($fetchMenu['navigation_backend'],1)."</pre>";
//            exit;
        	$fetchMenu = $fetchMenu['sidebar'];

            $configuration['navigation'][$this->getName()] = array();
            foreach($fetchMenu as $key=>$row)
            {
                $configuration['navigation'][$this->getName()][$row['name']] = array(
                    'label' => $row['label'],
                    'route' => $row['route'],
                    'pages' => $row['pages'],
                    'resource'=>$row['resource'],
                    'params' => $row['params'],
                );
            }


            if (!isset($configuration['navigation'])) {
                throw new \Exception\InvalidArgumentException('Could not find navigation configuration key');
            }
            if (!isset($configuration['navigation'][$this->getName()])) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Failed to find a navigation container by the name "%s"',
                    $this->getName()
                ));
            }
            $application = $serviceLocator->get('Application');
            $routeMatch  = $application->getMvcEvent()->getRouteMatch();
            $router      = $application->getMvcEvent()->getRouter();
            $pages       = $this->getPagesFromConfig($configuration['navigation'][$this->getName()]);
            $this->pages = $this->injectComponents($pages, $routeMatch, $router);
        }
        return $this->pages;
    }
}
