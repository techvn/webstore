<?php

/*
 * author @quocky
 * Create @2014
 * version $1.0
 * 
 */ 

/* URL [PUBLIC,UPLOAD,PRIVATE TEMPLATE,FRONT TEMPLATE] */
define('PATH',__DIR__);

define('PUBLIC_PATH', realpath(dirname(__FILE__) . '/public'));
define('UPLOAD_PATH', realpath(dirname(__FILE__) . '/public/upload'));
define('PRIVATE_PATH', realpath(dirname(__FILE__) . '/public/temp/private'));
define('FRONT_PATH', realpath(dirname(__FILE__) . '/public/temp/front'));

