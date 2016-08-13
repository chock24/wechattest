<?php

/*
 * 数据库配置文件
 * 从环境变量中读取数据库配置信息
 * 返回db数组给对应框架配置文件
 */

return array(
    'connectionString' => 'mysql:host='.getenv('WECHAT_DB_MASTER_HOST').';port='.getenv('WECHAT_DB_MASTER_PORT').';dbname='.getenv('WECHAT_DB_MASTER_DATABASE'),
    'emulatePrepare' => true,
    'username' => getenv('WECHAT_DB_MASTER_USERNAME'),
    'password' => getenv('WECHAT_DB_MASTER_PASSWORD'),
    'charset' => 'utf8',
    'tablePrefix' => 'wc_',
);