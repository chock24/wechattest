<?php

/**
 * 自动化执行 命令行模式
 */
class DownloadCommand extends CConsoleCommand {

    public function run($args) {
        $appid = $args[0];
        $appsecret = $args[1];
        $pulibc_id = $args[2];
        $next_openid = isset($args[3])?$args[3]:"";
        
        $test = array(
            'appid' => $appid,
            'appsecret'=> $appsecret,
        );
        /* -----------------获取公众号列表------------------ */
        $access_token = WechatStaticMethod::getAccessToken($test); //获取access_token
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$next_openid";
        $dataProvider = WechatStaticMethod::https_request($url);
        $dataProvider = json_decode($dataProvider, true);
        echo $dataProvider['next_openid'];
        if (isset($dataProvider['data']) && isset($dataProvider['data']['openid'])) {
            foreach ($dataProvider['data']['openid'] as $value) {
                $insertData = array(
                    'public_id' => $pulibc_id,
                    'openid' => $value,
                );
                $user = Yii::app()->db->createCommand()->insert('{{user}}', $insertData);
            }
        } else {
            return false;
        }
        
    }

}
