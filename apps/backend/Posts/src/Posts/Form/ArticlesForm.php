<?php
namespace Posts\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;
class ArticlesForm extends \MDS\Form\AbstractForm{
    public function init()
    {
        $inputFilterFactory = new InputFilterFactory();
        $inputFilter        = $inputFilterFactory->createInputFilter(
            array(
                'title'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    )
                ),

                'content'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),
                    )
                ),
            ));
        $this->setInputFilter($inputFilter);
        $name = new Element('title');
        $name->setLabel("Name title");
        $this->add($name);
        $name = new Element('slug');
        $name->setLabel("Name Slug");
        $this->add($name);

        $name = new Element('cid');
        $name->setLabel("Name Category");
        $this->add($name);

        $file = new Element\File('image-file');
        $file->setLabel('Avatar Image Upload')
            ->setAttribute('id', 'image-file');
        $this->add($file);

        $name = new Element('content');
        $name->setLabel("Content");
        $this->add($name);

        $name = new Element('meta_des');
        $name->setLabel("Name Meta Key");
        $this->add($name);

        $name = new Element('meta_key');
        $name->setLabel("Name Meta Desc");
        $this->add($name);

        $this->add($this->elementActive());
    }
    public function slugRequired(){
        $filter = $this->getInputFilter();
        $filter->add(
            array(
                'required' => true,
                'validators' => array(
                    array('name' => 'not_empty'),
                ),
            ),
            'slug'
        );
        return $this;
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