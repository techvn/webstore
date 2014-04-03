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

                'parrent_id'=>array(
                		'required' => true,
                		'validators' => array(
                				array('name' => 'not_empty'),
                		    array(
                		    		'name' => 'Callback',
                		    		'options' => array(
                		    				'messages' => array(
                		    						\Zend\Validator\Callback::INVALID_VALUE => 'The arrival time is less than the departure time',
                		    				),
                		    				'callback' => function($value, $context = array()) {
                		    				     return true;
                		    				},
                		    		),
                		    ),
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
        
        $category = new Element\Select('parrent_id');
        $category->setLabel("Category")->setLabelAttributes(array('class'=>'control-label'));
        $category->setAttribute('parrent_id','input-xlarge');
        $parrentid = new \Posts\Model\Model();
        
        $Collection = new \Posts\Model\Collection();
        $parrent = $Collection->getcategory();
        $parrentarray = array();
        $parrentarray[0] = 'Choose Category';
        //$parrentrouteId    = $this->params()->fromRoute('id');
        foreach ($parrent as $parrentid){
            $parrentarray[$parrentid->getId()] = $parrentid->getTitle();
        }
        $category->setValueOptions($parrentarray);
        $this->add($category);
        
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