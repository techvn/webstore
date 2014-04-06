<?php

/*
 * author @quocky
 * Create @2014
 * version $1.0
 * 
 */ 

/* URL [PUBLIC,UPLOAD,PRIVATE TEMPLATE,FRONT TEMPLATE] */
define('PATH',__DIR__);
define('URL_WEB','http://webzend.dev/');
define('PUBLIC_PATH', realpath(dirname(__FILE__) . '/public'));
define('UPLOAD_PATH', __DIR__ . '/public/uploads');
define('PRIVATE_PATH', realpath(dirname(__FILE__) . '/public/temp/private'));
define('FRONT_PATH', realpath(dirname(__FILE__) . '/public/temp/front'));

define('FILE_MANAGER_ASSETS','assets/backend/system/upload-file');

