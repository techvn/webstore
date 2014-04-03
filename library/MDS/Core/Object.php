<?php
namespace MDS\Core;
use SimpleXMLElement;
use Zend\Json\Json;
abstract class Object
{
   /**
    * [$origData description]
    * @var array
    */
    protected $origData;
    /**
     * [$data description]
     * @var array
     */
    protected $data = array();
    /**
     * [$underscoreCache description]
     * @var array
     */
    protected static $underscoreCache = array();
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->init();
    }
    /**
     * [setId description]
     * @param int $id [description]
     */
    protected function setId($id = null)
    {
        return $this->setData('id', $id);
    }
    /**
     * [init description]
     * @return void [description]
     */
    public function init()
    {
    }
    /**
     * [addData description]
     * @param array $array [description]
     */
    public function addData(array $array)
    {
        foreach ($array as $index => $value) {
            $this->setData($index, $value);
        }
        return $this;
    }
   /**
    * [setData description]
    * @param string $key   [description]
    * @param string $value [description]
    * @return this
    */
    public function setData($key, $value = null)
    {
        if (is_array($key)) {
            $this->data = $key;
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }
    /**
     * [unsetData description]
     * @param  string $key [description]
     * @return this      [description]
     */
    public function unsetData($key = null)
    {
        if (is_null($key)) {
            $this->data = array();
        } else {
            unset($this->data[$key]);
        }

        return $this;
    }
    /**
     * [getData description]
     * @param  string $key   [description]
     * @param  string $index [description]
     * @return this        [description]
     */
    public function getData($key = '', $index = null)
    {
        if ('' === $key) {
            return $this->data;
        }

        $default = null;

        // accept a/b/c as ['a']['b']['c']
        // Not  !== false no need '/a/b always return null
        if (strpos($key, '/')) {
            $keyArray = explode('/', $key);
            $data     = $this->data;
            foreach ($keyArray as $i => $k) {
                if ($k === '') {
                    return $default;
                }

                if (is_array($data)) {
                    if (!isset($data[$k])) {
                        return $default;
                    }

                    $data = $data[$k];
                }
            }

            return $data;
        }

        // legacy functionality for $index
        if (isset($this->data[$key])) {
            if (is_null($index)) {
                return $this->data[$key];
            }

            $value = $this->data[$key];
            if (is_array($value)) {
                if (isset($value[$index])) {
                    return $value[$index];
                }

                return null;
            } elseif (is_string($value)) {
                $array = explode(PHP_EOL, $value);
                return(isset($array[$index])
                    &&(!empty($array[$index])
                    || strlen($array[$index]) > 0)) ? $array[$index] : null;
            } elseif ($value instanceof Object) {
                return $value->getData($index);
            }

            return $default;
        }

        return $default;
    }
    /**
     * [hasData description]
     * @param  string  $key [description]
     * @return boolean      [description]
     */
    public function hasData($key = '')
    {
        if (empty($key) || !is_string($key)) {
            return !empty($this->data);
        }

        return array_key_exists($key, $this->data);
    }
    /**
     * [__toArray description]
     * @param  array  $array [description]
     * @return [array]        [description]
     */
    public function __toArray(array $array = array())
    {
        if (empty($array)) {
            return $this->data;
        }

        $arrayResult = array();
        foreach ($array as $attribute) {
            if (isset($this->data[$attribute])) {
                $arrayResult[$attribute] = $this->data[$attribute];
            } else {
                $arrayResult[$attribute] = null;
            }
        }

        return $arrayResult;
    }
    /**
     * [toArray description]
     * @param  array  $array [description]
     * @return [array]        [description]
     */
    public function toArray(array $array = array())
    {
        return $this->__toArray($array);
    }
    /**
     * [__toXml description]
     * @param  array   $array      [description]
     * @param  string  $rootName   [description]
     * @param  boolean $addOpenTag [description]
     * @param  boolean $addCdata   [description]
     * @return [string xml]        [description]
     */
    protected function __toXml(
        array $array = array(),
        $rootName = 'item',
        $addOpenTag = false,
        $addCdata = true
    ) {
        $xml = '';
        if ($addOpenTag) {
            $xml .= '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        }

        if (empty($array)) {
            $array = $this->toArray();
        }

        if (!empty($rootName) and !is_numeric($rootName)) {
            $xml .= '<' . $rootName;
            if (isset($array['id'])) {
                $xml .= ' id="' . $array['id'] . '"';
                unset($array['id']);
            }

            $xml .= '>' . PHP_EOL;
        }

        foreach ($array as $fieldName => $fieldValue) {
            if (is_array($fieldValue)) {
                if (!empty($fieldValue)) {
                    $xml .= $this->__toXml($fieldValue, $fieldName);
                    continue;
                }
                $fieldValue = '';
            } elseif (is_object($fieldValue) and method_exists($fieldValue, 'toXml')) {
                $xml .= $fieldValue->toXml(array(), $fieldValue->name);
                continue;
            }

            if ($addCdata === true) {
                $fieldValue = '<![CDATA[' . $fieldValue . ']]>';
                $xml       .= '<' . $fieldName . '>' . $fieldValue . '</' . $fieldName . '>' . PHP_EOL;


            } else {
                $fieldValue = htmlentities($fieldValue);
                $xml       .= '<' . $fieldName . '>' . $fieldValue . '</' . $fieldName . '>' . PHP_EOL;
            }
        }

        if (!empty($rootName) and !is_numeric($rootName)) {
            $xml .= '</' . $rootName . '>' . PHP_EOL;
        }

        return $xml;
    }
   /**
    * [toXml description]
    * @param  array   $array      [description]
    * @param  string  $rootName   [description]
    * @param  boolean $addOpenTag [description]
    * @param  boolean $addCdata   [description]
    * @return [string xml]              [description]
    */
    public function toXml(array $array = array(), $rootName = 'item', $addOpenTag = false, $addCdata = true)
    {
        return $this->__toXml($array, $rootName, $addOpenTag, $addCdata);
    }
    /**
     * [__toJson description]
     * @param  array  $array [description]
     * @return [sring xml]        [description]
     */
    protected function __toJson(array $array = array())
    {
        return Json::encode($this->toArray($array));
    }
    /**
     * [toJson description]
     * @param  array  $array [description]
     * @return [string json]        [description]
     */
    public function toJson(array $array = array())
    {
        return $this->__toJson($array);
    }
    /**
     * [toString description]
     * @param  string $format [description]
     * @return string         [description]
     */
    
    public function toString($format = '')
    {
        if (empty($format)) {
            $str = implode(', ', $this->getData());
        } else {
            preg_match_all('/\{\{([a-z0-9_]+)\}\}/is', $format, $matches);
            foreach ($matches[1] as $var) {
                $format = str_replace('{{' . $var . '}}', $this->getData($var), $format);
            }

            $str = $format;
        }

        return $str;
    }
    /**
     * [__call description]
     * @param  [type] $method [description]
     * @param  [type] $args   [description]
     * @return [type]         [description]
     */
    public function __call($method, $args)
    {
        switch(substr($method, 0, 3)) {
            case 'get':
                $key  = $this->underscore(substr($method, 3));
                $data = $this->getData($key, isset($args[0]) ? $args[0] : null);
                return $data;
                break;
            case 'set':
                $key    = $this->underscore(substr($method, 3));
                $result = $this->setData($key, isset($args[0]) ? $args[0] : null);
                return $result;
                break;
            case 'uns':
                $key    = $this->underscore(substr($method, 3));
                $result = $this->unsetData($key);
                return $result;
                break;
            case 'has':
                $key = $this->underscore(substr($method, 3));
                return isset($this->data[$key]);
                break;
        }
        throw new \MDS\Exception('Invalid method ' . get_class($this) . '::' . $method . '(' . print_r($args, 1) . ')');
    }
    /**
     * [underscore description]
     * @param  [string] $name [description]
     * @return [string]       [description]
     */
    protected function underscore($name)
    {
        if (isset(self::$underscoreCache[$name])) {
            return self::$underscoreCache[$name];
        }

        $result                       = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $name));
        self::$underscoreCache[$name] = $result;

        return $result;
    }
    /**
     * [offsetSet description]
     * @param  [type] $offset [description]
     * @param  [type] $value  [description]
     * @return [type]         [description]
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }
    /**
     * [offsetExists description]
     * @param  [string] $offset        [description]
     * @return [string|object]         [description]
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }
    /**
     * [offsetUnset description]
     * @param  [type] $offset [description]
     * @return [type]         [description]
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
    /**
     * [offsetGet description]
     * @param  [type] $offset [description]
     * @return [type]         [description]
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }
    /**
     * [getOrigData description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function getOrigData($key = null)
    {
        if (is_null($key)) {
            return $this->origData;
        }

        return isset($this->origData[$key]) ? $this->origData[$key] : null;
    }
    /**
     * [setOrigData description]
     * @param [type] $key  [description]
     * @param [type] $data [description]
     */
    public function setOrigData($key = null, $data = null)
    {
        if (is_null($key)) {
            $this->origData = $this->data;
        } else {
            $this->origData[$key] = $data;
        }

        return $this;
    }
    /**
     * [hasDataChangedFor description]
     * @param  [type]  $field [description]
     * @return boolean        [description]
     */
    public function hasDataChangedFor($field)
    {
        $newdata  = $this->getData($field);
        $origdata = $this->getOrigData($field);

        return $newdata != $origdata;
    }
}
