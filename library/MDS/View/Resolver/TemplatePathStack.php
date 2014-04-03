<?php
namespace MDS\View\Resolver;
use SplFileInfo;
use Zend\View\Exception;
use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\View\Resolver\TemplatePathStack as PathStack;
class TemplatePathStack extends PathStack{
	public function resolve($name ,Renderer $renderer = null){
		$this->useViewStream     = true;

        $this->lastLookupFailure = false;
        if ($this->isLfiProtectionOn() && preg_match('#\.\.[\\\/]#', $name)) {
            throw new Exception\DomainException(
                'Requested scripts may not include parent directory traversal ("../", "..\\" notation)'
            );
        }
        if ($this->useStreamWrapper()) {

            // If using a stream wrapper, prepend the spec to the path
            $streamFilePath = 'zend.view://' . $name;

            if (file_exists($streamFilePath)) {
                
                return $streamFilePath;
            }
        }
        if (!count($this->paths)) {
            $this->lastLookupFailure = static::FAILURE_NO_PATHS;
            return false;
        }
        $defaultSuffix = $this->getDefaultSuffix();
        if (pathinfo($name, PATHINFO_EXTENSION) != $defaultSuffix) {
            $name .= '.' . $defaultSuffix;
        }
        foreach ($this->paths as $path) {
            $file = new SplFileInfo($path . $name);
            if ($file->isReadable()) {
                // Found! Return it.
                if (($filePath = $file->getRealPath()) === false && substr($path, 0, 7) === 'phar://') {
                    // Do not try to expand phar paths (realpath + phars == fail)
                    $filePath = $path . $name;
                    if (!file_exists($filePath)) {
                        break;
                    }
                }

                return $filePath;
            }
        }

        $this->lastLookupFailure = static::FAILURE_NOT_FOUND;
        return false;
	}

}