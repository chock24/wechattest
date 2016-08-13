<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '欧派微信管理',
    'language' => 'zh_cn',
    'timeZone' => 'Asia/Chongqing',
    'theme' => 'ui-darkness',
    // preloading 'log' component
    'preload' => array('log'),
    'theme' => 'weixin',
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
        //*
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('10.10.54.56', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => false,
            'class' => 'WechatWebUser',
            'loginUrl' => array('site/login'),
        ),
        // To redefine the time format
        'format' => array(
            'dateFormat' => 'Y-m-d',
            'datetimeFormat' => 'Y-m-d H:i:s',
        ),
        //文件缓存
        'cache' => array(
            'class' => 'CFileCache',
            'directoryLevel' => 3,
        ),
        'memcache' => array(
            'class' => 'CMemCache',
            'servers' => array(
                array(
                    'host' => getenv('MEMCACHE_HOST'),
                    'port' => getenv('MEMCACHE_PORT'),
                    'weight' => 60,
                ),
            ),
        ),
        'session' => array(
            //'sessionName' => 'PHPSESSID',
            'class' => 'CCacheHttpSession',
            'cacheID' => 'cache',
            //'autoStart' => true,
            'cookieMode' => 'only',
            'timeout' => 1800,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlRuleClass' => 'CUrlRule',
            'urlFormat' => 'path',
            'showScriptName' => false, //hide index.php
            'caseSensitive' => true, //whether routes are case-sensitive.
            'urlSuffix' => '.html', //suffix
            'caseSensitive' => true, //ignore case
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=wechat',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'wc_',
            'enableParamLogging' => false,
            'enableProfiling' => false,
        ),
        // uncomment the following to use a MySQL database
        //      'db' => require(dirname(__FILE__) . '/dbconfig.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'trace, info, error, warning',
                ),
                /* array(//输出页面执行的sql语句和执行的sql时间
                  'class' => 'CProfileLogRoute',
                  'levels' => 'error, warning',
                  ), */
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => true,
                    'levels' => 'trace,error,info,warning', //级别为trace
                   // 'logfile' => 'cosole.log',
                    'categories' => 'system.db.*', //只显示关于数据库信息,包括数据库连接,数据库执行语句
                //'showInFireBug' => true, //显示在fireBug里面
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),
);
