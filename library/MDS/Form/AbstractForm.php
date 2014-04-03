<?php

namespace MDS\Form;

use MDS\Exception;
use MDS\Db\AbstractTable;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Db\NoRecordExists;

abstract class AbstractForm extends Form
{
    const IDENTIFIER_PATTERN = '~^[a-zA-Z0-9._-]+$~';
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
        $this->setUseInputFilterDefaults(false);
        $this->init();
    }

 
    public function init()
    {
    }

    
    public function getAdapter()
    {
        return GlobalAdapterFeature::getStaticAdapter();
    }

 
    public function loadValues(AbstractTable $table)
    {
        $data        = $table->getData();
        $inputFilter = $this->getInputFilter();
        if (is_array($data)) {
            foreach ($data as $elementName => $elementValue) {
                if ($this->has($elementName)) {
                    $element = $this->get($elementName);
                    $this->get($elementName)->setValue($elementValue);
                }

                if ($inputFilter->has($elementName)) {
                    $validators = $inputFilter->get($elementName)->getValidatorChain()->getValidators();

                    foreach ($validators as $validator) {
                        if ($validator['instance'] instanceof NoRecordExists) {
                            $validator['instance']->setExclude(array('field' => 'id', 'value' => $table->getId()));
                        }
                    }
                }
            }
        }

        return $this;
    }

   
    public static function addContent(Fieldset $form, $elements, $prefix = null, $datatypeId = null)
    {
        if (empty($elements)) {
            return;
        }

        if (!empty($prefix) and $datatypeId === null) {
            $datatypeId = mt_rand();
        }

        if (is_array($elements)) {
            if (empty($datatypeId)) {
                $randId = mt_rand();
            }

            foreach ($elements as $element) {
                self::addContent($form, $element, $prefix, $datatypeId);
            }
        } elseif ($elements instanceof Element) {
            if (!empty($prefix)) {
                $id = $elements->getAttribute('id');
                if (empty($id)) {
                    $id = $elements->getAttribute('name');
                }

                $elements->setAttribute('id', $id . $datatypeId);
                $elements->setAttribute('name', $prefix . '[' . $elements->getAttribute('name') . ']');
            }

            $form->add($elements);
        } elseif (is_string($elements)) {
            if (!empty($prefix)) {
                $elements = preg_replace('~name="(.+)(\[.*\])?"~iU', 'name="' . $prefix . '[$1]$2"', $elements);
                $elements = preg_replace(
                    '~name\\\x3D\\\x22(.+)(\\\x5B.*\\\x5D)?\\\x22~iU',
                    'name\\\x3D\\\x22' . $prefix . '\\\x5B$1\\\x5D$2\\\x22',
                    $elements
                );
                $elements = preg_replace('~id="(.+)"~iU', 'id="${1}' . $datatypeId . '"', $elements);
                $elements = preg_replace('~for="(.+)"~iU', 'for="${1}' . $datatypeId . '"', $elements);
                $elements = preg_replace(
                    '~id\\\x3D\\\x22"(.+)\\\x22~iU',
                    'id\\\x3D\\\x22${1}' . $datatypeId . '\\\x22',
                    $elements
                );
                $elements = preg_replace(
                    '~for\\\x3D\\\x22"(.+)\\\x22~iU',
                    'for\\\x3D\\\x22${1}' . $datatypeId . '\\\x22',
                    $elements
                );
                $elements = preg_replace(
                    '~(?:(?!(?<=value=)))("|\')#(.+)("|\')~iU',
                    '${1}#${2}' . $datatypeId . '${3}',
                    $elements
                );
            }

            $hiddenElement = new Element('hidden' . uniqid());
            $hiddenElement->setAttribute('content', $elements);
            $form->add($hiddenElement);
        } else {
            throw new Exception('Invalid element ' . __CLASS__ . '::' . __METHOD__ . ')');
        }
    }

  
    public function getValue($name = null)
    {
        if ($this->has($name)) {
            return $this->get($name)->getValue();
        }

        return null;
    }
}
