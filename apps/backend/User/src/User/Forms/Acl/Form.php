<?php
namespace User\Forms\Acl;
use MDS\Form\AbstractForm;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\Factory as InputFilterFactory;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;


class Form extends AbstractForm{

	protected $resource_acl;
	protected $id;

	public function init()
	{
		$app = \MDS\Registry::get('Application');
		$event = $app->getMvcEvent();
		$this->id  = $event->getRouteMatch()->getParam('id');
	}
	public function permission_role1(){
		$generalFieldset = new Fieldset('permission_option');
		$generalFieldset->setLabel('Permission Option');
		$list_all = new \User\Libs\Permission\Collection();
		$list_action = $this->resource($list_all,$this->id);
        $field_set = array();
		foreach ($list_all->getPermissions() as $key => $value) {
            $field_set[$key]= new Fieldset($key);
            echo $key.'->';
            $_demo = array();
			foreach ($value as $k => $v) {
                $group = explode('/',$v);
                if(count($group)){
                    $a = array_shift($group);
                    if(!isset($_demo[$a])){
                        $_demo[$a] = new Fieldset($a);
                        echo $a.":(";
                    }else{
                        $name = implode('-',$group);
                        echo $name.'-';
                        $checkbox = new Element\Checkbox($a.'-'.$name);
                        $checkbox->setLabel('A checkbox');
                        $checkbox->setValue($k);
                        if(isset($list_action[$key][$k])){
                            $checkbox->setCheckedValue($k);
                        }

//                        $checkbox->setCheckedValue("good");

                        $_demo[$a]->add($checkbox);
                    }
                }else{
                   // $_demo[$v] = new Fieldset($v);
                    echo $v;
                }
                echo ")";
			}
            echo "<-";
            echo "<BR>";
             $field_set[$key]->add($_demo[$a]);
            //echo "<pre>".print_r($_demo,1)."</pre>";
            //$field_set[$key]->add($_demo);
		}
        echo "<pre>";
        print_r($field_set);
        echo "</pre>";
      //  $generalFieldset->add($field_set);
		//$this->add($field_set);
       // echo "<pre>".print_r($list_all->getPermissions(),1)."</pre>";
        exit;
	}
    public function permission_role2(){
        $generalFieldset = new Fieldset('permission_option');
        $generalFieldset->setLabel('Permission Option');
        $list_all = new \User\Libs\Permission\Collection();
        $list_action = $this->resource($list_all,$this->id);
        foreach ($list_all->getPermissions() as $key => $value) {
            foreach ($value as $k => $v) {
                $element = new Element\Checkbox($key.'active'.$v);
                $element->setAttributes(array("class"=>'setpermission'));

                @$element->setLabel($key." ".$v)
                    ->setLabelAttributes(array(
                        'group'=>$key,
                        "value"=>$v,
                        "class"=>"radio inline"
                    ));
                $ac1 = base64_encode($this->id.'-'.$k.'-1');
                $ac0 = base64_encode($this->id.'-'.$k.'-0');
                if(isset($list_action[$key][$k])){

                    $element->setCheckedValue("good");
                }
                $element->setCheckedValue("good");
                $active = (isset($list_action[$key][$k]))?$ac1:$ac0;
              //  $element->setValue($v);
                $generalFieldset->add($element);
            }
        }
        $this->add($generalFieldset);
        //echo "<pre>".print_r($list_all->getPermissions(),1)."</pre>";
        // exit;
    }
    public function permission_role(){
        $generalFieldset = new Fieldset('permission_option');
        $generalFieldset->setLabel('Permission Option');
        $list_all = new \User\Libs\Permission\Collection();
        $list_action = $this->resource($list_all,$this->id);
        foreach ($list_all->getPermissions() as $key => $value) {
            foreach ($value as $k => $v) {
                $element = new Element\Radio($key.'active'.$v);
                $element->setAttributes(array("class"=>'setpermission'));

                @$element->setLabel($key." ".$v)
                    ->setLabelAttributes(array(
                        'group'=>$key,
                        "value"=>$v,
                        "class"=>"radio inline"
                    ));
                $ac1 = base64_encode($this->id.'-'.$k.'-1');
                $ac0 = base64_encode($this->id.'-'.$k.'-0');
                $element->setValueOptions(
                    array(
                        $ac1 => '/',
                        $ac0 => '',
                    ));
                $active = (isset($list_action[$key][$k]))?$ac1:$ac0;
                $element->setValue($active);
                $generalFieldset->add($element);
            }
        }
        $this->add($generalFieldset);
        //echo "<pre>".print_r($list_all->getPermissions(),1)."</pre>";
        // exit;
    }
	public function resource($list,$role){
		$userRole  = \User\Libs\Role\Model::fromId($role);
		$acl = new Acl();
		$acl->addRole(new Role($userRole->getName()));
		$resources = new \User\Libs\Resource\Collection();
		$resources = $resources->getResources();
		foreach ($resources as $key => $value) {
			if (!$acl->hasResource($value->getResource())) {
				$acl->addResource(new Resource($value->getResource()));
			}
		}
		$resources = $userRole->getUserPermissions();
		foreach ($resources as $resource => $permissions) {
			$acl->allow($userRole->getName(), $resource, 'index');
			foreach ($permissions as $permission) {
				if (strpos($permission, '/') !== false) {
					$path = explode('/', $permission);
					$acl->allow($userRole->getName(), $resource, $path[0]);
				}
				$acl->allow($userRole->getName(), $resource, $permission);
			}
		}
		$arr = array();
		foreach ($list->getPermissions() as $key => $value) {
			foreach ($value as $k => $v) {
				if($acl->isAllowed($userRole->getName(),$key,$v)){

					$arr[$key][$k] = $v;
				} 
			}
		}

		return $arr;
	}

}