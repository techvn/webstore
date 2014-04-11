<?php
namespace Category;
use MDS\Module\AbstractModule;
use Zend\EventManager\EventInterface as Event;
class Module extends AbstractModule
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    public function onBootstrap(Event $e)
    {
        $this->events()->attach('System\Controller\IndexController', 'dashboard', array($this, 'dashboard'));
    }
    public function dashboard(Event $event)
    {
        $widgets = $event->getParam('widgets');

        $widgets['test1']['id']      = 'blog';
        $widgets['test1']['title']   = 'Category information';
        $widgets['test1']['content'] = $this->addPath(__DIR__ . '/views')->render(
            'dashboard.phtml',
            array(
                'unactiveComments' => 12,
                'activeComments'   => 17,
            )
        );
        $event->setParam('widgets', $widgets);
    }
}