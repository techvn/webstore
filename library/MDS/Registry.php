<?php
namespace MDS;
use ArrayObject;
use RuntimeException;
class Registry extends ArrayObject
{
    private static $registry = null;
    public static function getInstance()
    {
        if (self::$registry === null) {
            self::init();
        }
        return self::$registry;
    }
    public static function setInstance(Registry $registry)
    {
        if (self::$registry !== null) {
            throw new RuntimeException('Registry is already initialized');
        }
        self::$registry = $registry;
    }
    protected static function init()
    {
        self::setInstance(new self());
    }
    public static function unsetInstance()
    {
        self::$registry = null;
    }
    public static function get($index)
    {
        $instance = self::getInstance();
        if (!$instance->offsetExists($index)) {
            throw new RuntimeException("No entry is registered for key '$index'");
        }
        return $instance->offsetGet($index);
    }
    public static function set($index, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($index, $value);
    }
    public static function isRegistered($index)
    {
        if (self::$registry === null) {
            return false;
        }
        return self::$registry->offsetExists($index);
    }
    public function __construct($array = array(), $flags = parent::ARRAY_AS_PROPS)
    {
        parent::__construct($array, $flags);
    }
    public function offsetExists($index)
    {
        return array_key_exists($index, $this);
    }
}
