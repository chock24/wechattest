<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '欧派微信管理',
    'timeZone' => 'Asia/Chongqing',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.wechat.*',
    ),
    'modules' => array(
        'systems', //系统管理模块
        'basis', //基础功能模块
        'users', //用户中心模块
        'interacts', //互动中心模块
        'additions', //附加功能模块
        'publics', //公众号中心模块
    ),
    // application components
    'components' => array(
        //文件缓存
        'cache' => array(
            'class' => 'CFileCache',
            'directoryLevel' => 3,
            /*'servers'=>array(
                array(
                    'host'=>'localhost',
                    'port'=>11211,
                    'weight'=>60,//权重
                ),
            ),*/
        ),
        // uncomment the following to use a MySQL database
        'db' => require(dirname(__FILE__) . '/dbconfig.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);
