<?php
namespace MDS\Event;

use Zend\EventManager\SharedEventManager;
use Zend\EventManager\SharedEventManagerInterface;
class StaticEventManager extends SharedEventManager
{
    protected static $instance;
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::setInstance(new static());
        }

        return static::$instance;
    }
    public static function setInstance(SharedEventManagerInterface $instance)
    {
        static::$instance = $instance;
    }

   
    public static function hasInstance()
    {
        return (static::$instance instanceof SharedEventManagerInterface);
    }
    public static function resetInstance()
    {
        static::$instance = null;
    }
    public function getEvent($id)
    {
        if (!array_key_exists($id, $this->identifiers)) {
            return false;
        }

        return $this->identifiers[$id];
    }

  
    public function trigger($id, $event, $target = null, $argv = array(), $callback = null)
    {
        $e = $this->getEvent($id);
        if (empty($e)) {
            return false;
        }

        return $e->trigger($event, $target, $argv, $callback);
    }
}
