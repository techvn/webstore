<?php
use TrungDm\SystemDb\User\Model as UserModel;
use TrungDm\System\View\Helper;
return array(
	'view_helpers' => array(
		'factories' => array(

		),
		'invokables' => array(
            'modulePlugin'      => 'MDS\View\Helper\ModulePlugin',
            'isCheck'           => 'MDS\View\Helper\isCheck',
            'buttonEdit'        => 'MDS\View\Helper\buttonEdit'
		),
	),
);