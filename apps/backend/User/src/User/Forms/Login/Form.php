<?php
namespace User\Forms\Login;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;
class Form extends \MDS\Form\AbstractForm{
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'username'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                        array(
                            'name' => 'db\\record_exists',
                            'options' => array(
                                'table' => 'mds_user',
                                'field' => 'username',
                                'adapter' => $this->getAdapter(),
                            ),
                        ),
                    )
                ),
                'password'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    ),
                )
            )
        );
        $this->setInputFilter($inputFilter);
        $username = new Element('username');
        $username->setLabel("UserName");
        $this->add($username);

        $password = new Element('password');
        $password->setLabel("Password");
        $this->add($password);

        $this->add(new Element('redirect'));
    }
}