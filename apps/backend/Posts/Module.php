<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Posts for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Posts;

use MDS\Mvc;

/**
 * Content module
 *
 * @category   Gc_Application
 * @package    Content
 * @subpackage Module
 */
class Module extends Mvc\Module
{
	/**
	 * Module directory path
	 */
	protected $directory = __DIR__;

	/**
	 * Module namespace
	 */
	protected $namespace = __NAMESPACE__;
}