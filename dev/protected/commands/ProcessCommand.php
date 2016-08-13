<?php

/**
 * 自动化执行 命令行模式
 */
class ProcessCommand extends CConsoleCommand {

    public function run($args) {

        $dataProvider = Yii::app()->db->createCommand()
                ->select(array('id', 'openid', 'public_id'))
                ->from('{{user}}')
                //  ->where(array('AND', 'id BETWEEN ' . $args[0] . ' and ' . $args[1], 'status=0', 'isdelete=0'))
                //--------------------修改对应的public_id-------------------*/
                ->where(array('AND', 'status=0', 'isdelete=0'))
                ->limit(200)
                ->queryAll(); //查询用户列表数据

        if (is_array($dataProvider) && !empty($dataProvider)) {

            /* -----------------获取公众号列表------------------ */
            $publics = Yii::app()->db->createCommand()
                    ->select(array('id', 'appid', 'appsecret'))
                    ->from('{{public}}')
                    ->where(array('isdelete=0'))
                    ->queryAll(); //查询公众号数据
            $publicDataProvider = array();
            if (!empty($publics) && is_array($publics)) {
                foreach ($publics as $public) {
                    $publicDataProvider[$public['id']]['appid'] = $public['appid'];
                    $publicDataProvider[$public['id']]['appsecret'] = $public['appsecret'];
                }
            }
            /* -----------------获取公众号列表------------------ */

            foreach ($dataProvider as $value) {
                if (is_array($publicDataProvider) && !empty($publicDataProvider)) {
                    $access_token = WechatStaticMethod::getAccessToken($publicDataProvider[$value['public_id']]); //获取access_token
                    $infoUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=" . $value['openid'] . "&lang=zh_CN"; //获得用户数据
                    $result = json_decode(WechatStaticMethod::https_request($infoUrl), true);
                    $district = PublicStaticMethod::getDistrictDataProvider();
                    //判断是否又返回值
                    if (!empty($result)) {
                        //token 不是最新 进行修改更新
                        if (!empty($result['errcode'])) {
                            $success = '1';
                            $access_token = WechatStaticMethod::getAccessToken($publicDataProvider[$value['public_id']], $success); //获取access_token
                            $infoUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=" . $value['openid'] . "&lang=zh_CN"; //获得用户数据
                            $result = json_decode(WechatStaticMethod::https_request($infoUrl), true);
                        }
                        if ($access_token == false) {
                            echo 'token错误';
                            break;
                        }

                        $subscribe = !empty($result['subscribe']) ? 1 : 0;
                        $openid = isset($result['openid']) ? $result['openid'] : $value['openid'];
                        if ($subscribe > 0) {

                            $updateArr = array(
                                'subscribe' => $subscribe,
                                'nickname' => $result['nickname'],
                                'sex' => $result['sex'],
                                'language' => $result['language'],
                                'city' => array_search($result['city'], $district),
                                'province' => array_search($result['province'], $district),
                                'country' => array_search($result['country'], $district),
                                'headimgurl' => $result['headimgurl'],
                                'subscribe_time' => $result['subscribe_time'],
                                'status' => 1,
                                    //'unionid'=>$result['unionid'],
                            );
                            $user = Yii::app()->db->createCommand()->update('{{user}}', $updateArr, 'openid="' . $openid . '" AND isdelete=0');
                        } else {
                            $updateArr = array(
                                'subscribe' => $subscribe,
                                'status' => 1,
                            );
                            $user = Yii::app()->db->createCommand()->update('{{user}}', $updateArr, 'openid="' . $openid . '" AND isdelete=0');
                        }
                    } else {
                        echo '$result为空';
                    }
                }
            }
        }
    }

}
