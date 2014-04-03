<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();


/* $configuration = include '/../config/application.config.php';
// Run the application!
$application = Zend\Mvc\Application::init($configuration);
\MDS\Registry::set('Application', $application);
$application->run(); */
