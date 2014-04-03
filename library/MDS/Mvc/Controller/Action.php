<?php


namespace MDS\Mvc\Controller;

use MDS\Event\StaticEventManager;
// use MyZendTrung\Module\Model as ModuleModel;
use User\Libs\Acl;
use User\Libs\Model as UserModel;
use User\Libs\Role\Model as RoleModel;
use MDS\Registry;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\JsonModel;
class Action extends AbstractActionController
{
    protected $routeMatch = null;
    protected $session = null;
    public function onDispatch(MvcEvent $e)
    {
        $resultResponse = $this->construct();
        if (!empty($resultResponse)) {
            return $resultResponse;
        }
        $resultResponse = $this->init();
        if (!empty($resultResponse)) {
            return $resultResponse;
        }

        return parent::onDispatch($e);
    }
    public function init()
    {

    }
    protected function construct()
    {
        $routeName = $this->getRouteMatch()->getMatchedRouteName();

        // /**
        //  * Installation check, and check on removal of the install directory.
        //  */

        $config = $this->getServiceLocator()->get('Config');
        if (!isset($config['db'])
            and !in_array($routeName, $this->installerRoutes)
        ) {
            //return $this->redirect()->toRoute('install');
        } else{

            $auth = $this->getServiceLocator()->get('Auth');

            if (!$auth->hasIdentity()) {
                if (!in_array(
                    $routeName,
                    array(
                        'user/login'
                    )
                )
                ) {
                    return $this->redirect()->toRoute(
                        'user/login',
                        array('action'=>'login','redirect' => base64_encode($this->getRequest()->getRequestUri()))
                    );
                }
            } else {
              if (!in_array($routeName, array('user/login','user/forbidden','user/logout'))) {
                    $resultResponse = $this->checkAcl($auth->getIdentity());
                    if (!empty($resultResponse)) {
                        return $resultResponse;
                    }
                }
            }
        }
        $this->layout()->routeParams = $this->getRouteMatch()->getParams();
        $this->useFlashMessenger(false);
    }
    public function getRouteMatch()
    {
        if (empty($this->routeMatch)) {
            $this->routeMatch = $this->getEvent()->getRouteMatch();
        }

        return $this->routeMatch;
    }
    public function getSession()
    {
        if ($this->session === null) {
            $this->session = new SessionContainer();
        }

        return $this->session;
    }
    public function returnJson(array $data)
    {
        $jsonModel = new JsonModel();
        $jsonModel->setVariables($data);
        $jsonModel->setTerminal(true);
        return $jsonModel;
    }
    public function useFlashMessenger($forceDisplay = true)
    {
        $flashMessenger = $this->flashMessenger();
        $flashMessages  = array();
        foreach (array('error', 'success', 'info', 'warning') as $namespace) {
            $flashNamespace = $flashMessenger->setNameSpace($namespace);
            if ($forceDisplay) {
                if ($flashNamespace->hasCurrentMessages()) {
                    $flashMessages[$namespace] = $flashNamespace->getCurrentMessages();
                    $flashNamespace->clearCurrentMessages();
                }
            } else {
                if ($flashNamespace->hasMessages()) {
                    $flashMessages[$namespace] = $flashNamespace->getMessages();
                }
            }
        }
        $this->layout()->flashMessages = $flashMessages;
    }
    public function events()
    {
        return StaticEventManager::getInstance();
    }
    public function getViewHelper($helperName)
    {
        return $this->getServiceLocator()->get('viewhelpermanager')->get($helperName);
    }
    protected function checkAcl(UserModel $userModel)
    {
        if (!empty($this->aclPage) and $userModel->getRole(true)->getName() !== RoleModel::PROTECTED_NAME) {
            $isAllowed  = false;
            $permission = null;
            $acl        = $userModel->getAcl(true);
            if ($this->aclPage['resource'] == 'modules') {
                $moduleId = $this->getRouteMatch()->getParam('m');

                if (empty($moduleId)) {
                    $action     = $this->getRouteMatch()->getParam('action');
                    $permission = ($action === 'index' ? 'list' : $action);
                } else {
                    $moduleModel = ModuleModel::fromId($moduleId);
                    if (!empty($moduleModel)) {
                        $permission = $moduleModel->getName();
                    }
                }
            } else {
                $permission = empty($this->aclPage['permission']) ?
                    null :
                    $this->aclPage['permission'];
                if ($this->aclPage['permission'] != 'index' and
                    !in_array($this->aclPage['resource'], array('content', 'stats'))
                ) {
                    $action      = $this->getRouteMatch()->getParam('action');
                    $permission .= (!empty($permission) ? '/' : '') . ($action === 'index' ? 'list' : $action);
                }
            }

            if (!$acl->isAllowed(
                $userModel->getRole()->getName(),
                $this->aclPage['resource'],
                $permission
            )) {
                die('khong co quyen');
                //return $this->redirect()->toRoute('user/not-permission');
            }
        }
    }
    
    
}
