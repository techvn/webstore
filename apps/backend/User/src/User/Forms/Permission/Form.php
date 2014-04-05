<?php
namespace User\Forms\Permission;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;
class Form extends \MDS\Form\AbstractForm{
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'permission'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                        array(
                            'name' => 'db\\norecord_exists',
                            'options' => array(
                                'table' => 'mds_user',
                                'field' => 'email',
                                'adapter' => $this->getAdapter(),
                            ),
                        ),
                    )
                ),

            )
        );
        $this->setInputFilter($inputFilter);
        $permission = new Element('permission');
        $permission->setLabel("permission");
        $this->add($permission);
        $this->add($this->elementResource());
        $this->add($this->elementActive());
    }
    private function elementResource(){

        $resourceEle           = new Element\Select('user_acl_resource_id');
        $resourceEle->setLabel(" Resource ");

        $roleCollection = new \User\Libs\Resource\Collection();
        $rolesList      = $roleCollection->getResources();
        $selectOptions  = array();
        $selectOptions["Select Role"] = "Select Resource";
        foreach ($rolesList as $role) {
            $selectOptions[$role->getId()] = $role->getResource();
        }
        $resourceEle->setValueOptions($selectOptions)
            ->setAttribute('class', 'form-control')
            ->setEmptyOption("Select Resource");
        return $resourceEle;
    }
    private function elementActive(){
        $element = new Element\Radio('active');
        $element->setLabel("Active")->setLabelAttributes(array("class"=>"radio inline"));
        $element->setValueOptions(
            array(
                '0' => 'No',
                '1' => 'Yes',
            ));
        $element->setValue(1);
        return $element;
    }
}