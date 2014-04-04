<?php
/**
 * Zend Framework (http://framework.zend.com/)
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use MDS\Mvc\Controller\Action;
use Zend\View\Model\ViewModel;

class AclController extends Action
{
    //protected $aclPage = array('resource' => 'content', 'permission' => 'media');

    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $request = $this->getRequest();
            $post = $this->getRequest()->getPost();
            $response = $this->getResponse();
            // base64_decode
            $data = base64_decode($post['data']);
            $data_explode = explode('-', $data);
            $object = \User\Libs\Acl\Model::check($data_explode[1],$data_explode[0]);
            if ($data_explode[2]==0) {
                if ($object) {
                   $object->delete();
                }
            }else{
                if (!$object) {
                    $model = new \User\Libs\Acl\Model();
                    $model->setData(array(
                            'user_acl_permission_id'=>$data_explode[1],
                            'user_acl_role_id'=>$data_explode[0])
                    );
                    $model->setOrigData();
                    $model->save();
                }
            }

            $response->setContent(\Zend\Json\Json::encode(
                    array(
                        "router"=>true,
                        "data"=> $data_explode
                    ))
            );
            return $response;
        }else{
            $id = $this->params()->fromRoute('id');
            $role =\User\Libs\Role\Model::fromId($id);
            if(!$role)
                return $this->redirect()->toRoute('admin-acl/default',array('controller'=>'index'));
           // $this->getViewHelper('HeadScript')->appendFile('/backend/js/permission_role.js');
            $form = new \User\Forms\Acl\Form();
            $form->permission_role();
            return array("form"=>$form,'rows'=>$role);
        }
    }
    public function fooAction()
    {
        return array();
    }
    public function ajaxAction(){
        if ($this->getRequest()->isXmlHttpRequest()) {
            $request = $this->getRequest();
            $post = $this->getRequest()->getPost();
            $response = $this->getResponse();
            // base64_decode
            $data = base64_decode($post['data']);
          //  $data_explode = explode('-', $data);
//            $object = \User\Libs\Acl\Model::check($data_explode[1],$data_explode[0]);
//
//            if ($data_explode[2]==0) {
//                if ($object) {
//                    // $object->delete();
//                }
//            }else{
//                if (!$object) {
//                    $model = new \User\Libs\Acl\Model();
//                    $model->setData(array(
//                            'user_acl_permission_id'=>$data_explode[1],
//                            'user_acl_role_id'=>$data_explode[0])
//                    );
//                    $model->setOrigData();
//                    // $model->save();
//                }
//            }
            // $router = new \TrungDm\System\Core\Routers();
            $response->setContent(\Zend\Json\Json::encode(
                    array(
                        "router"=>true,
                        "data"=> $data_explode
                    ))
            );
            return $response;
        }
    }
}
