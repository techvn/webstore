<?php
namespace Posts\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFilterFactory;
class CategoryForm extends \MDS\Form\AbstractForm{
    
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
                'slug'=>array(
                    'required' => true,
                    'validators' => array(
                        array('name' => 'not_empty'),

                    )
                ),
                'active'=>array(
                		'required' => true,
                		'validators' => array(
                				array('name' => 'not_empty'),
                		)
                ),
                
                'metakey'=>array(
                		'required' => true,
                		'validators' => array(
                				array('name' => 'not_empty'),
 
                		)
                ),
                'metades'=>array(
                		'required' => true,
                		'validators' => array(
                				array('name' => 'not_empty'),
                		)
                ),
                 
            )
        );

        $this->setInputFilter($inputFilter);
        $category = new Element('title');
        $category->setLabel('Title')->setLabelAttributes(array('class'=>'control-label'));
        $category->setAttribute('class','input-xlarge');
        $this->add($category);

        $category = new Element('slug');
        $category->setLabel("Slug")->setLabelAttributes(array('class'=>'control-label'));
        $category->setAttribute('class','input-xlarge');
        $this->add($category);

        $name = new Element('parent_id');
        $name->setLabel("Name Category");
        $this->add($name);

        
        $category = new Element\Checkbox('active');
        $category->setLabel("Active")->setLabelAttributes(array('class'=>'control-label'));
        $category->setAttribute('class','input-xlarge');
        $category->setOptions(
        	array(
        	 '0' =>'UnActive',
        	 '1' =>'Active'   
            )            
        );
        $category->setChecked(0);
        $this->add($category);

        $category = new Element('metakey');
        $category->setLabel("Metakey")->setLabelAttributes(array('class'=>'control-label'));
        $category->setAttribute('type', 'textarea');
        $category->setAttribute('class','input-block-level');
        $this->add($category);
        
        $category = new Element('metades');
        $category->setLabel("Metades")->setLabelAttributes(array('class'=>'control-label'));
        $category->setAttribute('type', 'textarea');
        $category->setAttribute('class','input-block-level');
        $this->add($category);
        
        
        
        
        $this->add(new Element('redirect'));
    }
}