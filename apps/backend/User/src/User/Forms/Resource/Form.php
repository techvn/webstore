<?php
namespace User\Forms\Resource;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;
class Form extends \MDS\Form\AbstractForm{
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'resource'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                        array(
                            'name' => 'db\\norecord_exists',
                            'options' => array(
                                'table' => 'mds_user_acl_resource',
                                'field' => 'resource',
                                'adapter' => $this->getAdapter(),
                            ),
                        ),
                    )
                ),

            )
        );

        $this->setInputFilter($inputFilter);
        $resource = new Element('resource');
        $resource->setLabel("Resource");
        $this->add($resource);
    }
}