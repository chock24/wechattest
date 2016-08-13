<?php
//echo 1111111111;exit;
$str='keep_move';
function getNewstr($str){
    $new ='';
    $transmit=explode('_',$str);
    foreach($transmit as $v){
        $da=ucfirst($v);
        $new=$new.$da;
    }
    return $new;
}
echo getNewstr($str);exit;



error_reporting(E_ALL^E_NOTICE);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

//ini_set('session.cookie_domain','wechat.oppein.cn');
// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_DEBUG') or define('YII_DEBUG',false); 
require_once($yii);
Yii::createWebApplication($config)->run();
