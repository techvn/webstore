<?php
namespace MDS\View;
use Zend\Filter\Word\UnderscoreToCamelCase;
class Stream{
	protected static $position = array();
	protected $path = null;
	protected static $data = array();
	protected $stat = array();
	protected $mode;
	public function __call($method,$args){
		$filter = new UnderscoreToCamelCase();
		$method = lcfirst($filter->filter($method));
		if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $args);
        }
	}
	public function streamOpen($path,$mode,$option,&$openedpath){
		$this->mode = $mode;
		$this->path = $this->removeWrapperName($path);
		self::$position[$this->path] = 0;
		if (empty(self::$data[$this->path]) or $this->mode == 'wb') {
			self::$data[$this->path] = null;
			self::$position[$this->path] = 0;
		}
		return true;
	}
	public function streamWrite($data){
		$left = substr(self::$data[$this->path], 0,self::$position[$this->path]);
		$right = substr(self::$data[$this->path],self::$position[$this->path]+strlen($data));
		self::$data[$this->path] = $left . $data . $right;
		self::$position[$this->path] += strlen($left . $data);
		return strlen($data);
	}
	public function streamTell(){
		return self::$position[$this->path];
	}
	public function streamStat(){
		return $this->stat;
	}
	   public function streamSeek($offset, $whence)
    {
        switch ($whence) {
            case SEEK_SET:
                if ($offset < strlen(self::$data[$this->path]) and $offset >= 0) {
                    self::$position[$this->path] = $offset;
                    return true;
                } else {
                    return false;
                }
                break;
            case SEEK_CUR:
                if ($offset >= 0) {
                    self::$position[$this->path] += $offset;
                    return true;
                } else {
                    return false;
                }
                break;
            case SEEK_END:
                if (strlen(self::$data[$this->path]) + $offset >= 0) {
                    self::$position[$this->path] = strlen(self::$data[$this->path]) + $offset;
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
        }
    }
    public function urlStat($path, $flags)
    {
        $path = $this->removeWrapperName($path);
        if (!isset(self::$data[$path])) {
            return false;
        }

        return array();
    }
     public static function register($name = 'zend.view', $overwrite = true)
    {
        if (in_array($name, stream_get_wrappers())) {
            if (!$overwrite) {
                return;
            }

            stream_wrapper_unregister($name);
        }

        stream_wrapper_register($name, 'MDS\View\Stream');
    }
    protected function removeWrapperName($path)
    {
        return str_replace('zend.view://', '', $path);
    }
}