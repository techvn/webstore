<?php
namespace MDS\View;

use MDS\Registry;
use MDS\Core\Object;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use MDS\View\Resolver\TemplatePathStack;
class Renderer extends Object
{
	protected $renderer;
	public function init()
    {
        $this->checkRenderer();
    }
    public function render($name, array $data = array())
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate($name);
        $viewModel->setVariables($data);

        return $this->renderer->render($viewModel);
    }
    public function addPath($dir)
    {
        $this->checkRenderer();
        $this->renderer->resolver()->addPath($dir);
        return $this;
    }
    protected function checkRenderer()
    {
        if (is_null($this->renderer)) {
            $this->renderer = new PhpRenderer();
            $renderer       = Registry::get('Application')->getServiceManager()->get('Zend\View\Renderer\PhpRenderer');
            $this->renderer->setHelperPluginManager(clone $renderer->getHelperPluginManager());
        }

        return $this;
    }
    public function getRenderer()
    {
        return $this->renderer;
    }
    public function useStreamWrapper()
    {
        $this->renderer->setResolver(new TemplatePathStack());
        $this->renderer->resolver()->setUseStreamWrapper(true);
        return $this;
    }
}