<?php
namespace Category\Controller;
use MDS\Module\Controller\AbstractController;
class IndexController extends AbstractController
{
    public function indexAction()
    {
        $model = new \Category\Model\Model();
        return array('lists'=>$model->getList());
    }
    public function createAction(){
        return array();
    }
    public function editAction(){
        return array();
    }
    public function deleteAction(){
        return array();
    }
}
