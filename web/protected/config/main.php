<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My First Yii Item',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin',
		'member',
		'wap',
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(  
			'urlFormat'=>'path',
			'showScriptName'=>false, // 隐藏入口文件 index
			'urlSuffix' => '.html',	//定义文件后缀
			'rules'=>array(
				'' => '/site',
				'/master'=>'/admin',
				'/master/<controller:\w+>'=>'/admin/<controller>',
				'/master/<controller:\w+>/<action:\w+>'=>'/admin/<controller>/<action>',
		/*		'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',*/

//                '/jxjs'=>'/study/index',
//				'/msjj_<page:\d+>'=>'/teacher/index',
//				'/msjj'=>'/teacher/index',
//				'/sscs_<sid:\d+>'=>'/test/index',
//				'/sscs'=>'/test/index',
//				'/xqjs_<cid:\d+>_<page:\d+>'=>'/school/index/',
//				'/xqjs_<cid:\d+>'=>'/school/index',
//				'/xqjj_<cid:\d+>'=>'/school/cate',
//				'/kcjs_<id:\d+>'=>'/school/detail',
//				'/mszd_<cid:\d+>'=>'/use/index',
//				'/gszp_<cid:\d+>'=>'/resume/index',
//				'/shzp_<cid:\d+>'=>'/resume/social',
//				'/xyzp_<cid:\d+>'=>'/resume/school',
//				'/jkcs_<cid:\d+>_<id:\d+>'=>'about/index',
//				'/gywm_<cid:\d+>_<page:\d+>'=>'/about/index',
//				'/gywm_<cid:\d+>'=>'/about/index',
//				'/mtbd_<id:\d+>'=>'/about/detail',

/*				'/<controller:\w+>/<cid:\d+>'=>'/<controller>/index/',
				'/<controller:\w+>/<id:\>'=>'/<controller>/index/',
			    '/<controller:\w+>/<id:\d+>'=>'/<controller>/detail',
                '/<controller:\w+>/<cid:\d+>*/

			),
		),
		

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute', // 调试信息日志文件记录
//					'class'=>'CProfileLogRoute', // 调试信息页面输出
					'levels'=>'error, warning, profile',
				),
				// uncomment the following to show log messages on web pages

//				array(
//					'class'=>'CWebLogRoute',
//				),

				array(  
		            'class' => 'CFileLogRoute',  
		            'levels' => 'error, warning',  
		            'categories'=> 'orders.*',  
		            'logFile'=> 'order/orders_'.date('Ymd').'.log',
		        ), 
			),
		),
		'thumb'=>array(
  			'class'=>'ext.CThumb',
		),
		'curl'=>array(
			'class'=>'ext.Curl',
			// CURL 默认配置参数
			'options'=>array(),
		),
		'querylist'=>array(
			'class'=>'ext.QueryList',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require('custom.php'),
);
