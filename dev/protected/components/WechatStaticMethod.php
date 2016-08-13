<?php

/**
 * 微信公共函数类
 */
class WechatStaticMethod {

    /**
     * 得到公众号信息
     * @param string $original
     * @return boolean or array
     */
    public static function getPublicInfo($original = array()) {
        $criteria = new CDbCriteria();
        $criteria->select = '`id`,`appid`,`appsecret`,`change`';
        $criteria->compare('`original`', $original);
        $criteria->compare('isdelete', 0);
        $model = WcPublic::model()->find($criteria);
        if ($model) {
            return array(
                'id' => $model->id, 
                'appid' => $model->appid, 
                'appsecret' => $model->appsecret,
                'change' => $model->change,
            );
        }
    }

//     /**
//      * 获得AccessToken 
//      * @param array $dataProvider 得到accessToken
//      * 老版本
//      */
//     public static function getAccessToken($dataProvider = array(),$success=0) {
//         $appid = isset($dataProvider['appid']) ? $dataProvider['appid'] : '';
//         if (Yii::app()->cache->get($appid)&&$success!=1) {
//             return Yii::app()->cache->get($appid);
//         } else {
//             $appsecret = $dataProvider['appsecret'];
//             $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
//             $ch = curl_init();
//             curl_setopt($ch, CURLOPT_URL, $url);
//             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//             //curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1); 
//             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//             $output = curl_exec($ch);
//             curl_close($ch);
//             $result = json_decode($output, true);
//             if(isset($result["access_token"])){
//                 Yii::app()->cache->set($appid, $result["access_token"], 1800);
//                 return $result["access_token"];
//             }else{
//                 return false;
//             }
//         }
//     }
    
    /**
     * 拿到access_token
     * 新版本
     * @author 陈永杰 2016年6月30日9:41:07
     * @param array $dataProvider
     * @param number $success
     * @throws CHttpException
     * @return boolean|mixed|string|mixed
     */
    public static function getAccessToken($dataProvider = array(),$success=0){
        $appid      = isset($dataProvider['appid'])     ? $dataProvider['appid'] : '';
        $appsecret  = isset($dataProvider['appsecret']) ? $dataProvider['appsecret'] : '';
        $access_token = self::getAccessTokenFromMem($appid);
        //从memcache里获得access_token
        if ($access_token && $success!=1) {
            //返回access_token
            return $access_token;
        } else {
            //从微信服务器重新拿access_token
            $result = self::getAccessTokenFromWeChat($appid, $appsecret);
            if ($result['access_token']){
                //如果有正确值返回
                $flag_save = self::saveAccessTokenToMem($appid,$result['access_token']);
                if($flag_save){
                    //保存成功后,返回值
                    return $result['access_token'];
                }else{
                    //抛出一个异常
                    throw new CHttpException('400','储存access_token值时发生错误');
                }
            }else{
                //没有正确值返回.可能是超过调用次数了.
                throw new CHttpException('400',$result['errmsg']);
            }
        }
    }

    /**
     * 从微信接口拿新的access_token
     * @author 陈永杰 2016年6月30日9:34:29
     * @param string $appid
     * @param string $appsecret
     */
    public static function getAccessTokenFromWeChat($appid='',$appsecret=''){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output, true);
//         if(isset($result["access_token"])){
//             return $result["access_token"];
//         }else{
//             return false;
//         }
        return $result;
    }
    
    /**
     * 从memcache里拿access_token
     * @author 陈永杰 2016年6月30日9:33:26
     * @param string $appid
     * @return boolean|mixed|boolean|string
     */
    public static function getAccessTokenFromMem($appid = ''){
        $last_time = Yii::app()->cache->get($appid.'access_token_expire');
        if ($last_time){
            //如果有上一次的存入时间记录,就继续流程
            if(time() - $last_time > 7000){
                //超时
                return false;
            }else{
                //不超时
                return Yii::app()->cache->get($appid);
            }
        }else{
            //没有上一次的存入时间记录
            return false;
        }
    }
    
    /**
     * 存放access_token值到memcache
     * @author 陈永杰 2016年6月30日9:32:39
     * @param string $appid
     * @param string $access_token
     * @return boolean
     */
    public static function saveAccessTokenToMem($appid='',$access_token=''){
        //记录这次的存放时间
        $flag1 = Yii::app()->cache->set($appid.'access_token_expire', time(),0);
        //记录access_token
        $flag2 = Yii::app()->cache->set($appid, $access_token, 7200);
        if ($flag1 && $flag2){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 使用微信ip接口检查access_token有效性
     * 暂时用不上
     * @author 陈永杰 2016年6月30日9:31:20
     * @param string $access_token
     * @return boolean
     */
    public static function checkAccessToken($access_token =''){
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($output, true);
        if(!$result['ip_list'] || !empty($result['errcode'])){
            //如果拿不到服务器的ip的话,就返回一个失败的响应
            return false;
        }else {
            return true;
        }
    }
    

    /**
     * 提交到微信服务器
     * @param url 要提交的地址
     * @param data 要提交的json数据
     */
    public static function https_request($url, $data = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 从微信下载文件
     * @param url 下载的地址
     */
    public static function downloadImageFromWeichat($url = null) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_NOBODY, 0); //只取body头
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        $httpinfo = curl_getinfo($curl);
        curl_close($curl);
        return array_merge(array('body' => $output), array('header' => $httpinfo));
    }
    
    /**
     * 把发送过来的信息记录下来.
     * 用于排查错误
     * @author 陈永杰 2016年7月4日21:29:40
     */
    public static function logdata($log){
        $file_name = Yii::getPathOfAlias('application') .'/runtime/weixin_log/'.date('Y-m-d-H').'_weixin_log.txt';
        file_put_contents($file_name, var_export($log, true) . "\n\r", FILE_APPEND);
    }
    

}
