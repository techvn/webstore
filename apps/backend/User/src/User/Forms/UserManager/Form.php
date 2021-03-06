<?php
namespace User\Forms\UserManager;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;
class Form extends \MDS\Form\AbstractForm{
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'email'=>array(
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
                'fullname'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
                'phone'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),
                'username'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                ),

            )
        );
        $this->setInputFilter($inputFilter);
        $fullname = new Element('fullname');
        $fullname->setLabel("Fullname");
        $this->add($fullname);

        $email = new Element('email');
        $email->setLabel("Email");
        $this->add($email);

        $phone = new Element('phone');
        $phone->setLabel("Phone");
        $this->add($phone);

        $username = new Element('username');
        $username->setLabel("Username");
        $this->add($username);

        $email = new Element('password');
        $email->setLabel("Password");
        $this->add($email);

        $this->add($this->elementActive());
        $this->add($this->elementRole());
    }
    public function passwordRequired()
    {
        $filter = $this->getInputFilter();
        $filter->add(
            array(
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'password'
        );
        return $this;
    }
    private function elementRole(){

        $roleEle           = new Element\Select('user_acl_role_id');
        $roleEle->setLabel(" Role ");

        $roleCollection = new \User\Libs\Role\Collection();
        $rolesList      = $roleCollection->getRoles();
        $selectOptions  = array();
        $selectOptions["Select Role"] = "Select Role";
        foreach ($rolesList as $role) {
            $selectOptions[$role->getId()] = $role->getName();
        }
        $roleEle->setValueOptions($selectOptions)
            ->setAttribute('class', 'form-control')
            ->setEmptyOption("Select Role");
        return $roleEle;
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