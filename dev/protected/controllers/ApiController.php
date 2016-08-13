<?php

/**
 * 微信接口类操作
 * 与微信端口相关的基本功能
 * @property string $_WEICH Description
 */
class ApiController extends Controller {

    private $_WECHATTOKEN = 'oppein'; //定义token
    private $_PUBLICINFO = array(); //定义appid和appsecret
    private $_ACCESS_TOKEN; //定义access_token
    private $_OPENID = ''; //客户的openid   唯一
    private $_MSGTYPE = ''; //接收的信息类型
    private $_MSGEVENT = ''; //接收的事件类型
    private $_ORIGINAL = ''; //接收的事件类型
    private $_CREATETIME = 0; //发生时间
    private $_REPLY = ''; //回复内容
    private $_RECEIVE = array(); //接收内容
    private $_SEND = array(); //发送的消息
    private $_FROMOPENID = 0;
    private $_ORIGINAL_PAI_DATA = '';

    /**
     * 自动调用方法
     */
    public function actionIndex() {
        $wechat = new Wechat($_GET);
        $media_model = new MediaId();
        $wechat->token = $this->_WECHATTOKEN;
        //$wechat->debug = true; //是否开启调试bug

        /* -------------------------验证密钥------------------------- */
        if (isset($_REQUEST['echostr'])) {
            $wechat->valid();
        }
        /* -------------------------验证密钥------------------------- */

        $wechat->init(); //初始化微信类，绑定各参数
        
        //调试用,先把原始的api信息记录,稍后可注释掉
        $this->_ORIGINAL_PAI_DATA = empty($GLOBALS["HTTP_RAW_POST_DATA"]) ? '' : $GLOBALS["HTTP_RAW_POST_DATA"];

        $this->_MSGTYPE = empty($wechat->msg->MsgType) ? '' : strtolower($wechat->msg->MsgType);
        $this->_MSGEVENT = empty($wechat->msg->Event) ? '' : strtolower($wechat->msg->Event);
        $this->_OPENID = $wechat->msg->FromUserName; //用户openid
        $this->_ORIGINAL = $wechat->msg->ToUserName; //公众号
        $this->_CREATETIME = (int) $wechat->msg->CreateTime; //创建时间

        $this->_PUBLICINFO = WechatStaticMethod::getPublicInfo($this->_ORIGINAL); //获取公众号信息
        $this->_ACCESS_TOKEN = WechatStaticMethod::getAccessToken($this->_PUBLICINFO); //获取access_token
        //var_dump($this->_ACCESS_TOKEN);exit;
        $publicArr = array(
            'appid' => $this->_PUBLICINFO['appid'],
            'appsecret' => $this->_PUBLICINFO['appsecret'],
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        /* -------------------------判断传入类型------------------------- */
        switch ($this->_MSGTYPE) {
            case 'text':
                $this->_RECEIVE = array(
                    'fromusername' => $this->_OPENID,
                    'tousername' => $this->_ORIGINAL,
                    'public_id' => $this->_PUBLICINFO['id'],
                    'createtime' => $this->_CREATETIME,
                    'receive' => 1,
                    'auto' => 2,
                    'msgid' => $wechat->msg->MsgId,
                    'content' => $wechat->msg->Content,
                    'type' => 1,
                ); //接收的内容 

                if (isset($this->_PUBLICINFO['change']) && $this->_PUBLICINFO['change'] == 1) { //如果开启转接至多客服系统
                    //TODO:微信多客服功能开发
                    /*
                     * 联合欧派集团总部的客服平台,对微信用户的咨询信息进行整合.
                     */
                    $this->_REPLY = $wechat->makeService();
                } else {
                    /* ----------------------关键字回复------------------------- */
                    $ruleId = $this->matchKeyword($wechat->msg->Content, $this->_PUBLICINFO['id']); //得到关键字ID数组
                    if ($ruleId) {
                        $model = $this->findRule($ruleId);
                        if ($model) {
                            $replyData = $this->getReply($model);
                            if (isset($replyData['type'])) {
                                //判断类型为图片 音频 视频 获取mediaid 

                                if ($replyData['type'] == 2 || $replyData['type'] == 3 || $replyData['type'] == 4) {
                                    $source_file_id = $replyData['source_file_id'];
                                    $media_id = 0;
                                    if (!empty($source_file_id)) {
                                        $criteria = new CDbCriteria();
                                        $criteria->select = 'media_id';
                                        $criteria->compare('source_file_id', $source_file_id);
                                        $mediam = $media_model->find($criteria);
                                        if (!empty($mediam)) {
                                            $media_id = $mediam->media_id;
                                        }
                                    }
                                }
                                switch ($replyData['type']):
                                    case 1:
                                        $this->_SEND = array(
                                            'fromusername' => $this->_ORIGINAL,
                                            'tousername' => $this->_OPENID,
                                            'public_id' => $this->_PUBLICINFO['id'],
                                            'receive' => 2,
                                            'auto' => 1,
                                            'createtime' => time(),
                                            'type' => 1,
                                            'content' => $replyData['content'],
                                        ); //回复的消息
                                        $this->_REPLY = $wechat->makeText($replyData['content']);
                                        break;
                                    case 2:

                                        $this->_SEND = array(
                                            'fromusername' => $this->_ORIGINAL,
                                            'tousername' => $this->_OPENID,
                                            'public_id' => $this->_PUBLICINFO['id'],
                                            'receive' => 2,
                                            'auto' => 1,
                                            'createtime' => time(),
                                            'type' => 2,
                                            'source_file_id' => $replyData['source_file_id'],
                                            'multi' => 0,
                                        ); //回复的消息
                                        $this->_REPLY = $wechat->makeImage($media_id);
                                        break;
                                    case 3:
                                        $this->_SEND = array(
                                            'fromusername' => $this->_ORIGINAL,
                                            'tousername' => $this->_OPENID,
                                            'public_id' => $this->_PUBLICINFO['id'],
                                            'receive' => 2,
                                            'auto' => 1,
                                            'createtime' => time(),
                                            'type' => 3,
                                            'source_file_id' => $replyData['source_file_id'],
                                            'multi' => 0,
                                        ); //回复的消息
                                        $this->_REPLY = $wechat->makeVoice($media_id);
                                        break;
                                    case 4:
                                        $this->_SEND = array(
                                            'fromusername' => $this->_ORIGINAL,
                                            'tousername' => $this->_OPENID,
                                            'public_id' => $this->_PUBLICINFO['id'],
                                            'receive' => 2,
                                            'auto' => 1,
                                            'createtime' => time(),
                                            'type' => 4,
                                            'source_file_id' => $replyData['source_file_id'],
                                            'multi' => 0,
                                        ); //回复的消息
                                        $this->_REPLY = $wechat->makeVideo($media_id, $replyData['sourceFile']['title'], $replyData['sourceFile']['description']);
                                        break;
                                    case 5:
                                        $this->_SEND = array(
                                            'fromusername' => $this->_ORIGINAL,
                                            'tousername' => $this->_OPENID,
                                            'public_id' => $this->_PUBLICINFO['id'],
                                            'receive' => 2,
                                            'auto' => 1,
                                            'createtime' => time(),
                                            'type' => 5,
                                            'source_file_id' => $replyData['source_file_id'],
                                            'multi' => $replyData['multi'],
                                        ); //回复的消息
                                        $this->_REPLY = $wechat->makeNews($this->searchSourceFile($replyData['source_file_id'], $replyData['multi']));
                                        break;
                                endswitch;
                            }
                        }
                    }
                    /* ----------------------关键字回复------------------------- */

                    /* ----------------------自动回复------------------------- */
                    if (!$this->_REPLY) {
                        $auto = $this->auto($this->_PUBLICINFO['id']); //判断是否设置了自动回复
                        if (isset($auto['type'])) {
                            //判断类型为图片 音频 视频 获取mediaid 
                            if ($auto['type'] == 2 || $auto['type'] == 3 || $auto['type'] == 4) {
                                $media_model = new MediaId();
                                $source_file_id = $auto['source_file_id'];
                                $media_id = 0;
                                if (!empty($source_file_id)) {
                                    $criteria = new CDbCriteria();
                                    $criteria->select = 'media_id';
                                    $criteria->compare('source_file_id', $source_file_id);
                                    $mediam = $media_model->find($criteria);
                                    if (!empty($mediam)) {
                                        $media_id = $mediam->media_id;
                                    }
                                }
                            }
                            switch ($auto['type']):
                                case 1:
                                    $this->_SEND = array(
                                        'fromusername' => $this->_ORIGINAL,
                                        'tousername' => $this->_OPENID,
                                        'public_id' => $this->_PUBLICINFO['id'],
                                        'receive' => 2,
                                        'auto' => 1,
                                        'createtime' => time(),
                                        'type' => 1,
                                        'content' => $auto['content'],
                                    ); //回复的消息
                                    $this->_REPLY = $wechat->makeText($auto['content']);
                                    break;
                                case 2:
                                    $this->_SEND = array(
                                        'fromusername' => $this->_ORIGINAL,
                                        'tousername' => $this->_OPENID,
                                        'public_id' => $this->_PUBLICINFO['id'],
                                        'receive' => 2,
                                        'auto' => 1,
                                        'createtime' => time(),
                                        'type' => 2,
                                        'source_file_id' => $auto['source_file_id'],
                                        'multi' => 0,
                                    ); //回复的消息
                                    $this->_REPLY = $wechat->makeImage($media_id);
                                    break;
                                case 3:
                                    $this->_SEND = array(
                                        'fromusername' => $this->_ORIGINAL,
                                        'tousername' => $this->_OPENID,
                                        'public_id' => $this->_PUBLICINFO['id'],
                                        'receive' => 2,
                                        'auto' => 1,
                                        'createtime' => time(),
                                        'type' => 3,
                                        'source_file_id' => $auto['source_file_id'],
                                        'multi' => 0,
                                    ); //回复的消息
                                    $this->_REPLY = $wechat->makeVoice($media_id);
                                    break;
                                case 4:
                                    $this->_SEND = array(
                                        'fromusername' => $this->_ORIGINAL,
                                        'tousername' => $this->_OPENID,
                                        'public_id' => $this->_PUBLICINFO['id'],
                                        'receive' => 2,
                                        'auto' => 1,
                                        'createtime' => time(),
                                        'type' => 4,
                                        'source_file_id' => $auto['source_file_id'],
                                        'multi' => 0,
                                    ); //回复的消息
                                    $this->_REPLY = $wechat->makeVideo($media_id, $auto['title'], $auto['description']);
                                    break;
                                case 5:
                                    $this->_SEND = array(
                                        'fromusername' => $this->_ORIGINAL,
                                        'tousername' => $this->_OPENID,
                                        'public_id' => $this->_PUBLICINFO['id'],
                                        'receive' => 2,
                                        'auto' => 1,
                                        'createtime' => time(),
                                        'type' => 5,
                                        'source_file_id' => $auto['source_file_id'],
                                        'multi' => $auto['multi'],
                                    ); //回复的消息
                                    $this->_REPLY = $wechat->makeNews($this->searchSourceFile($auto['source_file_id'], $auto['multi']));
                                    break;
                            endswitch;
                        }
                    }

                    /* ----------------------自动回复------------------------- */
                }
                break;/*----------------------case text结束--------------------*/
            case 'image':
                $this->_RECEIVE = array(
                    'fromusername' => $this->_OPENID,
                    'tousername' => $this->_ORIGINAL,
                    'public_id' => $this->_PUBLICINFO['id'],
                    'createtime' => $this->_CREATETIME,
                    'receive' => 1,
                    'auto' => 2,
                    'msgid' => $wechat->msg->MsgId,
                    'picurl' => $wechat->msg->PicUrl,
                    'mediaid' => $wechat->msg->MediaId,
                    'type' => 2,
                ); //接收的内容 
                break;
            case 'location':
                $this->_RECEIVE = array(
                    'fromusername' => $this->_OPENID,
                    'tousername' => $this->_ORIGINAL,
                    'public_id' => $this->_PUBLICINFO['id'],
                    'createtime' => $this->_CREATETIME,
                    'receive' => 1,
                    'auto' => 2,
                    'msgid' => $wechat->msg->MsgId,
                    'location_x' => $wechat->msg->Location_X,
                    'location_y' => $wechat->msg->Location_Y,
                    'type' => 6,
                ); //接收的内容 
                break;
            case 'link':
                $this->_RECEIVE = array(
                    'fromusername' => $this->_OPENID,
                    'tousername' => $this->_ORIGINAL,
                    'public_id' => $this->_PUBLICINFO['id'],
                    'createtime' => $this->_CREATETIME,
                    'receive' => 1,
                    'auto' => 2,
                    'msgid' => $wechat->msg->MsgId,
                    'title' => $wechat->msg->Title,
                    'description' => $wechat->msg->Description,
                    'url' => $wechat->msg->Url,
                    'type' => 7,
                ); //接收的内容 
                break;
            case 'voice':
                $voice_media_id = $wechat->msg->MediaId;
                $voice_file_name = time();
                $voice_path = 'upload/sourcefile/voice/' . $voice_file_name . '.' . $wechat->msg->Format;
                $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . "&media_id=" . $voice_media_id;
                $photoDataProvider = WechatStaticMethod::downloadImageFromWeichat($url);
                file_put_contents($voice_path, $photoDataProvider['body']);

                $this->_RECEIVE = array(
                    'fromusername' => $this->_OPENID,
                    'tousername' => $this->_ORIGINAL,
                    'public_id' => $this->_PUBLICINFO['id'],
                    'createtime' => $this->_CREATETIME,
                    'receive' => 1,
                    'auto' => 2,
                    'title' => $voice_file_name,
                    'msgid' => $wechat->msg->MsgId,
                    'mediaid' => $wechat->msg->MediaId,
                    'format' => $wechat->msg->Format,
                    'recognition' => $wechat->msg->Recognition,
                    'type' => 3,
                ); //接收的内容 
                break;
            case 'video':
                $this->_RECEIVE = array(
                    'fromusername' => $this->_OPENID,
                    'tousername' => $this->_ORIGINAL,
                    'public_id' => $this->_PUBLICINFO['id'],
                    'createtime' => $this->_CREATETIME,
                    'receive' => 1,
                    'auto' => 2,
                    'msgid' => $wechat->msg->MsgId,
                    'mediaid' => $wechat->msg->MediaId,
                    'thumbmediaid' => $wechat->msg->ThumbMediaId,
                    'type' => 4,
                ); //接收的内容 
                break;
            case 'event':
                if ($wechat->msg->Event == 'subscribe') {//用户关注公众号触发
                    $from_openid = 0;
                    Yii::app()->session['openid'] = '';
                    if (!empty($wechat->msg->EventKey)) {
                        $group_id = $this->checkQuickMark($this->_PUBLICINFO['id'], $wechat->msg->EventKey); //得到分组id
                        $fromuser = $this->getScene_id($this->_PUBLICINFO['id'], $wechat->msg->EventKey); //得到分组id
                        //如果存在 来自 用户
                        if (!empty($fromuser)) {
                            $frommodel = $this->getOpenid($fromuser->user_id);
                            $publicmodel = $this->getWcpublic($fromuser->public_id);
                        }
                        if (!empty($frommodel)) {
                            $this->_FROMOPENID = $frommodel->openid;
                            Yii::app()->session['openid'] = $frommodel->openid;
                        }
                    } else {
                        $group_id = 0;
                    }
                    //增加 relation 关注用户 关系
                    $returnnum = -1; //返回1 为邀请成功 0为重复邀请 默认为2 自助关注
                    $find_user = 0; //重复 关注
                    $find_user = $this->findUser($this->_PUBLICINFO['id'], $this->_OPENID);
                    if (!empty($fromuser)) {
                        if (!empty($fromuser->user_id)) {
                            //增加关系 更新积分
                            $returnnum = $this->createRelation($fromuser->user_id, $this->_OPENID);
                        }
                    }
                    $userDataProvider = $this->getUser($this->_PUBLICINFO['id'], $this->_OPENID, $this->_CREATETIME, $group_id); //得到用户资料
                    if ($userDataProvider) {
                        //-----------给邀请人发信息  开始
                        if ($returnnum == '1') {
                            $invitemsg = $this->invitefriend($userDataProvider, $this->_PUBLICINFO['id'], $returnnum);
                        } else if ($returnnum == '0') {//已经邀请过
                            $invitemsg = $this->invitefriend($userDataProvider, $this->_PUBLICINFO['id'], $returnnum);
                        }

                        $this->_SEND = array(
                            'fromusername' => $this->_ORIGINAL,
                            'tousername' => $this->_FROMOPENID,
                            'public_id' => $this->_PUBLICINFO['id'],
                            'receive' => 2,
                            'auto' => 1,
                            'createtime' => time(),
                            'type' => 1,
                            'content' => $invitemsg['content'],
                        ); //邀请好友后 发送给 邀请人的信息
                        //  $this->_REPLY = $wechat->makeTexttofrom($invitemsg['content'],Yii::app()->session['openid'] );
                        if (is_array($this->_SEND) && !empty($this->_SEND)) {
                            $this->createMessage($this->_SEND, 1); //保存发送的信息进数据库
                        }
                        //主动发送给 邀请人信息------------------------------------开始
                        $messagecontent = $invitemsg['content'];
                        //得到公众号信息
                        $access_token = 0;
                        if (!empty($publicmodel)) {
                            $publicArr = array(
                                'appid' => $publicmodel->appid,
                                'appsecret' => $publicmodel->appsecret,
                            );
                            $access_token = WechatStaticMethod::getAccessToken($publicArr);
                            if ($messagecontent) {
                                $dataProvider = array(
                                    'touser' => $this->_FROMOPENID,
                                    'msgtype' => 'text',
                                    'text' => array(
                                        'content' => urlencode($messagecontent),
                                    ),
                                );
                                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
                                $result = WechatStaticMethod::https_request($url, urldecode(json_encode($dataProvider)));
                            }
                        }

                        //主动发送给 邀请人信息------------------------------------结束
                        $welcomeDataProvider = $this->welcome($userDataProvider, $this->_PUBLICINFO['id'], $find_user, $group_id); //將用户资料及公众号传入欢迎语，返回拼装后的内容
                        //
                        //判断类型为图片 音频 视频 获取mediaid 
                        if ($welcomeDataProvider['type'] == 2 || $welcomeDataProvider['type'] == 3 || $welcomeDataProvider['type'] == 4) {
                            $source_file_id = $welcomeDataProvider['source_file_id'];
                            $media_id = 0;
                            if (!empty($source_file_id)) {
                                $criteria = new CDbCriteria();
                                $criteria->select = 'media_id';
                                $criteria->compare('source_file_id', $source_file_id);
                                $mediam = $media_model->find($criteria);
                                if (!empty($mediam)) {
                                    $media_id = $mediam->media_id;
                                }
                            }
                        }
                        switch ($welcomeDataProvider['type']):
                            case 1:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 1,
                                    'content' => $welcomeDataProvider['content'],
                                ); //回复的消息
                                $welcometext = $welcomeDataProvider['content'];
                                $this->_REPLY = $wechat->makeText($welcometext);
                                break;
                            case 2:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 2,
                                    'source_file_id' => $welcomeDataProvider['source_file_id'],
                                    'multi' => 0,
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeImage($media_id);
                                break;
                            case 3:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 3,
                                    'source_file_id' => $welcomeDataProvider['source_file_id'],
                                    'multi' => 0,
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeVoice($media_id);
                                break;
                            case 4:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 4,
                                    'source_file_id' => $welcomeDataProvider['source_file_id'],
                                    'multi' => 0,
                                );
//回复的消息
                                $this->_REPLY = $wechat->makeVideo($media_id, $welcomeDataProvider['sourceFile']['title'], $welcomeDataProvider['sourceFile']['description']);
                                break;
                            case 5:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 5,
                                    'source_file_id' => $welcomeDataProvider['source_file_id'],
                                    'multi' => $welcomeDataProvider['multi'],
                                ); //回复的消息
                                // $this->_REPLY = $wechat->makeNews($this->searchSourceFile($welcomeDataProvider['source_file_id'], $welcomeDataProvider['multi']));
                                $this->_REPLY = $wechat->makeNews($this->searchSourceFile($welcomeDataProvider['source_file_id'], $welcomeDataProvider['multi']), $userDataProvider);
                                break;
                        endswitch;
                    } else {
                        $this->_SEND = array(
                            'fromusername' => $this->_ORIGINAL,
                            'tousername' => $this->_OPENID,
                            'public_id' => $this->_PUBLICINFO['id'],
                            'receive' => 2,
                            'auto' => 1,
                            'createtime' => time(),
                            'type' => 1,
                            'content' => '非常感谢您的关注我们的公众号，我们会竭诚为您提供最优质的服务。',
                        ); //回复的消息
                        $this->_REPLY = $wechat->makeText('非常感谢您的关注我们的公众号，我们会竭诚为您提供最优质的服务。');
                    }
                } elseif ($wechat->msg->Event == 'unsubscribe') {//用户取消关注
                    $this->unsubscribeUser($this->_PUBLICINFO['id'], $this->_OPENID);
                } elseif ($wechat->msg->Event == 'CLICK') {//自定义菜单事件
                    $this->_RECEIVE = array(
                        'fromusername' => $this->_OPENID,
                        'tousername' => $this->_ORIGINAL,
                        'public_id' => $this->_PUBLICINFO['id'],
                        'createtime' => $this->_CREATETIME,
                        'receive' => 1,
                        'auto' => 2,
                        'menukey' => $wechat->msg->EventKey,
                        'type' => 8,
                        'menutype' => 1,
                    ); //接收的内容

                    $menu = $this->matchMenu($wechat->msg->EventKey, $this->_PUBLICINFO['id']); //判断是否设置了自动回复
                    if (isset($menu['type'])) {

                        //判断类型为图片 音频 视频 获取mediaid 
                        if ($menu['type'] == 2 || $menu['type'] == 3 || $menu['type'] == 4) {
                            $media_model = new MediaId();
                            $source_file_id = $menu['source_file_id'];
                            $media_id = 0;
                            if (!empty($source_file_id)) {
                                $criteria = new CDbCriteria();
                                $criteria->select = 'media_id';
                                $criteria->compare('source_file_id', $source_file_id);
                                $mediam = $media_model->find($criteria);
                                if (!empty($mediam)) {
                                    $media_id = $mediam->media_id;
                                }
                            }
                        }
                        switch ($menu['type']):
                            case 1:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 1,
                                    'content' => $menu['content'],
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeText($menu['content']);
                                break;
                            case 2:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 2,
                                    'source_file_id' => $menu['source_file_id'],
                                    'multi' => 0,
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeImage($media_id);
                                break;
                            case 3:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 3,
                                    'source_file_id' => $menu['source_file_id'],
                                    'multi' => 0,
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeVoice($media_id);
                                break;
                            case 4:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 4,
                                    'source_file_id' => $menu['source_file_id'],
                                    'multi' => 0,
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeVideo($media_id, $auto['title'], $auto['description']);
                                break;
                            case 5:
                                $this->_SEND = array(
                                    'fromusername' => $this->_ORIGINAL,
                                    'tousername' => $this->_OPENID,
                                    'public_id' => $this->_PUBLICINFO['id'],
                                    'receive' => 2,
                                    'auto' => 1,
                                    'createtime' => time(),
                                    'type' => 5,
                                    'source_file_id' => $menu['source_file_id'],
                                    'multi' => $menu['multi'],
                                ); //回复的消息
                                $this->_REPLY = $wechat->makeNews($this->searchSourceFile($menu['source_file_id'], $menu['multi']));
                                break;
                        endswitch;
                    }
                } elseif ($wechat->msg->Event == 'VIEW') {//自定义菜单事件
                    $this->_RECEIVE = array(
                        'fromusername' => $this->_OPENID,
                        'tousername' => $this->_ORIGINAL,
                        'public_id' => $this->_PUBLICINFO['id'],
                        'createtime' => $this->_CREATETIME,
                        'receive' => 1,
                        'auto' => 2,
                        'content' => $wechat->msg->EventKey,
                        'type' => 8,
                        'menutype' => 2,
                    ); //接收的内容
                } elseif ($wechat->msg->Event == 'MASSSENDJOBFINISH') {//发送群发消息返回数据
                    $dataProvider = array(
                        'msg_id' => $wechat->msg->MsgID,
                        'title' => '微信服务器返回群发数据',
                        'msg_status' => $wechat->msg->Status,
                        'totalcount' => $wechat->msg->TotalCount,
                        'filtercount' => $wechat->msg->FilterCount,
                        'sendcount' => $wechat->msg->SentCount,
                        'errorcount' => $wechat->msg->ErrorCount,
                    );
                    $this->pushReturn($dataProvider);
                }
                break;/*--------------------case event 结束------------------*/
            default:
                $this->_REPLY = $wechat->makeText('无效内容输入哦');
                break;
        }
        if (is_array($this->_RECEIVE) && !empty($this->_RECEIVE)) {
            $this->createMessage($this->_RECEIVE); //保存接收的信息进数据库
        }
        if (is_array($this->_SEND) && !empty($this->_SEND)) {
            $this->createMessage($this->_SEND, 1); //保存发送的信息进数据库
        }
        $wechat->reply($this->_REPLY);
    }

    /* ---------------------------------以下针对用户操作调用------------------------------------ */

    /**
     * 保存消息
     * @param array $dataProvider 从微信端获取的数据
     * @param integer $type 类型 0:接收 1:发送
     */
    private function createMessage($dataProvider = array(), $type = 0) {
        var_dump($dataProvider);
        $model = new Message();
        $model->fromusername = isset($dataProvider['fromusername']) ? $dataProvider['fromusername'] : '';
        $model->tousername = isset($dataProvider['tousername']) ? $dataProvider['tousername'] : '';
        $model->public_id = isset($dataProvider['public_id']) ? $dataProvider['public_id'] : 0;
        $model->createtime = isset($dataProvider['createtime']) ? $dataProvider['createtime'] : 0;
        $model->receive = isset($dataProvider['receive']) ? $dataProvider['receive'] : 0;
        $model->auto = isset($dataProvider['auto']) ? $dataProvider['auto'] : 0;
        $model->msgid = isset($dataProvider['msgid']) ? $dataProvider['msgid'] : 0;
        $model->type = isset($dataProvider['type']) ? $dataProvider['type'] : 0;
        $model->menutype = isset($dataProvider['menutype']) ? $dataProvider['menutype'] : 0;
        $model->content = isset($dataProvider['content']) ? $dataProvider['content'] : '';
        $model->picurl = isset($dataProvider['picurl']) ? $dataProvider['picurl'] : '';
        //音频表示
        $model->recognition = isset($dataProvider['recognition']) ? $dataProvider['recognition'] : '';
        //增加 picurl 判断   
        $pictureurl = isset($dataProvider['picurl']) ? $dataProvider['picurl'] : '';
        $inval = 'mmbiz.qpic.cn/mmbiz';
        //内容中包含 微信服务器图片 
        if (!empty($pictureurl)) {
            $success = explode($pictureurl, $inval);
            if (count($success) > 0) {
                $image = file_get_contents($pictureurl);
                $imagename = date("Ymdhis") . ".jpg";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/message/' . $imagename;
                file_put_contents($filepath, $image);
                $model->picurl = $imagename;
            }
        }
        //判断结束
        $model->mediaid = isset($dataProvider['mediaid']) ? $dataProvider['mediaid'] : '';
        $model->location_x = isset($dataProvider['location_x']) ? $dataProvider['location_x'] : '';
        $model->location_y = isset($dataProvider['location_y']) ? $dataProvider['location_y'] : '';
        $model->title = isset($dataProvider['title']) ? $dataProvider['title'] : '';
        $model->description = isset($dataProvider['description']) ? $dataProvider['description'] : '';
        $model->url = isset($dataProvider['url']) ? $dataProvider['url'] : '';
        $model->format = isset($dataProvider['format']) ? $dataProvider['format'] : '';
        $model->thumbmediaid = isset($dataProvider['thumbmediaid']) ? $dataProvider['thumbmediaid'] : '';
        $model->source_file_id = isset($dataProvider['source_file_id']) ? $dataProvider['source_file_id'] : 0;
        $model->multi = isset($dataProvider['multi']) ? $dataProvider['multi'] : 0;
        $model->menukey = isset($dataProvider['menukey']) ? $dataProvider['menukey'] : 0;
        $model->status = 1; //表示为未读
        Yii::import('application.modules.users.models.User');
        $openid = $type == 1 ? $model->tousername : $model->fromusername;
        $criteria = new CDbCriteria();
        $criteria->select = 'id';
        $criteria->compare('openid', $openid);
        print_r($criteria);
        $dataProvider = User::model()->find($criteria);

        if ($dataProvider) {
            $model->user_id = $dataProvider->id;
        }
        var_dump($model->user_id);exit;
        $model->save();
    }

    /**
     * 创建关注用户
     * @param array $dataProvider 
     * @param int $group_id 用户组Id
     */
    private function createUser($public_id = 0, $dataProvider = array(), $group_id = 0) {
        Yii::import('application.modules.users.models.User');
        $model = new User();
        $model->attributes = $dataProvider;
        $model->public_id = $public_id; //保存用户组id
        $model->group_id = $group_id; //保存用户组id

        /* -----------------將字符串型转为int型---------------- */
        $district = PublicStaticMethod::getDistrictDataProvider();
        $model->country = array_search($model->country, $district);
        $model->country = $model->country ? $model->country : 0;
        $model->province = array_search($model->province, $district);
        $model->province = $model->province ? $model->province : 0;
        $model->city = array_search($model->city, $district);
        $model->city = $model->city ? $model->city : 0;
        $model->status = 1; //表示已经获取用户信息
        $flag = $model->save();
        
        if ($flag) {
            return $model->attributes; //返回用户资料 
        }
    }

//根据 id 得到openid
    private function getOpenid($user_id = 0) {
        Yii::import('application.modules.users.models.User');
        $criteria = new CDbCriteria();
        $criteria->select = 'id,nickname,subscribe,openid';
        $criteria->compare('isdelete', 0);
        $model = User::model()->findByPk($user_id);
        return $model;
    }

    //根据 public_id 得到 public 信息
    private function getWcpublic($public_id = 0) {
        Yii::import('application.models.UserRelation');
        $criteria = new CDbCriteria();
        $criteria->compare('isdelete', 0);
        $model = WcPublic::model()->findByPk($public_id);
        return $model;
    }

    /**
     * 邀请好友 返回信息
     * @param int $public_id　公众号ID
     */
    private function invitefriend($dataProvider = '', $public_id = 0, $success = 0) {
        $message = array();
        $message['type'] = 1;
        if ($success == 1) {
            $message['content'] = " 恭喜您，您的好友" . $dataProvider ['nickname'] . "也成为了欧派家居商城的粉丝，您由于推荐有功，获得10个积分奖励哦！ ";
        } else if ($success == 0) {
            $message['content'] = " 您邀请的好友" . $dataProvider ['nickname'] . "已经关注过了，不能增加积分哦！到会员中心去邀请更多好友，增加积分吧！";
        }
        return $message;
    }

    /*
     * 根据被关注人user_id 以及新增用户openid 
     * 增加 用户关系
     */

    private function createRelation($from_userid = 0, $openid = '') {
        Yii::import('application.models.UserRelation');
        Yii::import('application.modules.users.models.User');

        if (!empty($from_userid) && !empty($openid)) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,from_userid,attention_openid';
            $criteria->compare('from_userid', $from_userid);
            $criteria->compare('attention_openid', $openid);
            $UserRelation = UserRelation::model()->findAll($criteria); //查询是否存在]
//已存在 推荐 关注的关系
            if (count($UserRelation) > 0) {
                return '0';
            } else {//不存在
                $usermodel = User::model()->find('openid=:openid', array(":openid" => $openid));
                if (!empty($usermodel)) {
                    return '0';
                } else {
                    $model = new UserRelation;
                    $model->from_userid = $from_userid;
                    $model->attention_openid = $openid;
                    $model->time_created = time();
                    $model->time_updated = time();
//保存关系 记录
                    if ($model->save()) {
//更改积分
                        $criteria = new CDbCriteria();
                        $criteria->select = 'integral';
                        $umodel = User::model()->findByPk($from_userid);
                        $integral = $umodel->integral + 10; //推荐好友加10分
//积分增加20
                        User::model()->updateAll(array('integral' => $integral), 'id=:id AND isdelete=:isdelete', array(':id' => $from_userid, ':isdelete' => 0));
                        return '1';
                    } else {
                        var_dump($model->errors);
                        exit;
                    }
                }
            }
        }
    }

    /*
     * 查询 用户是否已存在（重新关注用户）
     */

    private function findUser($public_id = 0, $openid = '') {
        Yii::import('application.modules.users.models.User');
        $criteria = new CDbCriteria();
        $criteria->select = 'id,nickname,subscribe,subscribe_time,headimgurl';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('openid', $openid);
        $criteria->compare('isdelete', 0);
        $model = User::model()->find($criteria);
        if ($model === null) {
            return '0';
        } else {
            return '1';
        }
    }

    /**
     * 从服务器获得关注用户资料
     * @param int $public_id
     * @param string $openid
     * @param int $group_id 用户分组Id
     */
    private function getUser($public_id = 0, $openid = '', $createtime = 0, $group_id = 0) {
        Yii::import('application.modules.users.models.User');
        //从微信服务器获取客户资料
        $infoUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->_ACCESS_TOKEN."&openid=$openid&lang=zh_CN"; //获得用户数据
        $returnData = WechatStaticMethod::https_request($infoUrl);
        $dataProvider = json_decode($returnData, true);
        //调试用,如果出现用户信息异常就记录所有的反馈
        if ($dataProvider['errcode']) {
            //记录所有的收到的信息.
            $log = $this->_ORIGINAL_PAI_DATA.$returnData;
            WechatStaticMethod::logdata($log);
        }
        
        $criteria = new CDbCriteria();
        $criteria->select = 'id,nickname,subscribe,subscribe_time,headimgurl';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('openid', $openid);
        $criteria->compare('isdelete', 0);
        $model = User::model()->find($criteria);
        if ($model === null) {
            return $this->createUser($public_id, $dataProvider, $group_id); //保存关注用户信息
        } else {
            if (!$model->subscribe) {
                $model->setAttribute('group_id', $group_id);
                $model->setAttribute('subscribe', 1);
                $model->setAttribute('subscribe_time', time());
                $model->save();
            }
            return $model->attributes;
        }
    }

    /**
     * 取消关注用户
     * @param int $public_id
     * @param string $openid
     */
    private function unsubscribeUser($public_id = 0, $openid = '') {
        Yii::import('application.modules.users.models.User');
        return User::model()->updateAll(array('subscribe' => 0), 'public_id=:public_id AND openid=:openid AND isdelete=:isdelete', array(':public_id' => $public_id, ':openid' => $openid, ':isdelete' => 0));
    }

    /* ---------------------------------以下针对被动回复调用------------------------------------ */

    /**
     * 欢迎语
     * @param int $public_id　公众号ID
     */
    private function welcome($dataProvider = '', $public_id = 0, $find_user = 0, $group_id = 0) {
        if ($group_id != 0) {
            //查询 二维码自带的欢迎语
            $criteria = new CDbCriteria();
            $criteria->select = 'id,type,description,multi,title';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('group_id', $group_id);
            $criteria->compare('isdelete', 0);
            $quickmark = Quickmark::model()->find($criteria);
            //如果二维码 没有欢迎语 则使用 默认欢迎语
            if ($quickmark === null) {
                $message['type'] = 1;
                $message['content'] = "欢迎您再次关注欧派家居商城！到会员中心去邀请好友，获取积分吧!";
            } else {
                //二维码 欢迎语
                $message = array();
                $message['type'] = $quickmark->type;
                switch ($quickmark->type):
                    case 1://文本类型
                        //$quickmark->description
                        $message['content'] = $dataProvider['nickname'] . $quickmark->description; // PublicStaticMethod::replaceNickname($dataProvider['nickname'].$quickmark->description);
                        break;
                    case 2://图片类型
                        $message['source_file_id'] = $quickmark->description;
                        break;
                    case 3://音频类型
                        $message['source_file_id'] = $quickmark->description;
                        break;
                    case 4://视频类型
                        $message['source_file_id'] = $quickmark->description;
                        break;
                    case 5://新闻类型（图文）
                        $message['multi'] = $quickmark->multi;
                        $message['source_file_id'] = $quickmark->description;
                        break;
                endswitch;
            }
        }else {
            //查询welcome 欢迎语
            $criteria = new CDbCriteria();
            $criteria->select = 'type,content,multi,source_file_id';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('isdelete', 0);
            $welcome = Welcome::model()->find($criteria);
            $message = array();
            if ($welcome === null) {//如果未设置欢迎词
                $message['type'] = 1;
                $message['content'] = $dataProvider['nickname']
                        . ":欢迎您关注我们的微信号,我们会为您提供最优质的服务。";
            } else {
                $message['type'] = $welcome->type;
                //判断为 重新 关注 欢迎语 改变
//            if ($find_user == '1') {
//                $message['content'] = "欢迎您再次关注欧派家居商城！到会员中心去邀请好友，获取积分吧!";
//            } else {
                switch ($welcome->type):
                    case 1://文本类型
                        $message['content'] = PublicStaticMethod::replaceNickname($welcome->content, $dataProvider['nickname']);
                        break;
                    case 2://图片类型
                        $message['source_file_id'] = $welcome->source_file_id;
                        break;
                    case 3://音频类型
                        $message['source_file_id'] = $welcome->source_file_id;
                        break;
                    case 4://视频类型
                        $message['source_file_id'] = $welcome->source_file_id;
                        break;
                    case 5://新闻类型（图文）
                        $message['multi'] = $welcome->multi;
                        $message['source_file_id'] = $welcome->source_file_id;
                        break;
                endswitch;
                // }
            }
        }



        return $message;
    }

    /**
     * 匹配关键字回复
     * @param string $content 用户输入的内容
     * @param int $public_id 公众号ID
     */
    private function matchKeyword($content = '', $public_id = '') {
        $criteria = new CDbCriteria();
        $criteria->select = 'rule_id';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('isdelete', 0);
        $criteria->compare('type', 1);
        $criteria->compare('title', $content);
        $model = Keyword::model()->find($criteria);

        if (!$model) { //没有找到关键字，选择模糊查找
            $criteria = new CDbCriteria();
            $criteria->select = 'rule_id';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('isdelete', 0);
            $criteria->compare('type', 0);
            $criteria->compare('title', $content, true);
            $model = Keyword::model()->find($criteria);
        }
        return $model;
    }

    /**
     * 找到规则
     * @param array $model
     */
    private function findRule($model = array()) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,entire';
        $criteria->compare('isdelete', 0);
        return Rule::model()->findByPk($model['rule_id'], $criteria);
    }

    /**
     * 得到回复内容
     * @param array $model Description
     */
    private function getReply($model = array()) {
        $message = array();
        $criteria = new CDbCriteria();
        $criteria->select = 'type,multi,content,source_file_id';
        $criteria->compare('isdelete', 0);
        $criteria->compare('rule_id', $model['id']);
        $criteria->order = 'sort DESC';
        $dataProvider = Reply::model()->find($criteria);
        if ($dataProvider) {
            $message['type'] = $dataProvider->type;
            switch ($dataProvider->type):
                case 1://文本类型
                    $message['content'] = $dataProvider->content;
                    break;
                case 2://图片类型
                    $message['source_file_id'] = $dataProvider->source_file_id;
                    break;
                case 3://音频类型
                    $message['source_file_id'] = $dataProvider->source_file_id;
                    break;
                case 4://视频类型
                    $message['source_file_id'] = $dataProvider->source_file_id;
                    break;
                case 5://新闻类型（图文）
                    $message['multi'] = $dataProvider->multi;
                    $message['source_file_id'] = $dataProvider->source_file_id;
                    break;
            endswitch;
        }
        return $message;
    }

    /**
     * 自动回复
     * @param int $public_id 公众号ID
     */
    private function auto($public_id = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'timing,time_start,time_end,type,content,multi,source_file_id';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('status', 1);
        $criteria->compare('isdelete', 0);
        $model = Auto::model()->find($criteria);
        $message = array();
        $status = 0;
        if ($model !== null) {
            if ($model->timing == 1) {//如果开启定时
                $timeStart = $model->time_start - strtotime(date('Y-m-d 00:00:00', $model->time_start));
                $timeEnd = $model->time_end - strtotime(date('Y-m-d 00:00:00', $model->time_end));
                $timeNow = time() - strtotime(date('Y-m-d 00:00:00'));
                if ($timeStart > $timeEnd) {//如果开始时间大于结束时间
                    if (!($timeNow < $timeStart && $timeNow > $timeEnd)) {
                        $status = 1;
                    }
                } else {
                    if ($timeNow > $timeStart && $timeNow < $timeEnd) {
                        $status = 1;
                    }
                }
            } else {
                $status = 1;
            }
            if ($status) {
                $message['type'] = $model->type;
                switch ($model->type):
                    case 1://文本类型
                        $message['content'] = $model->content;
                        break;
                    case 2://图片类型
                        $message['source_file_id'] = $model->source_file_id;
                        break;
                    case 3://音频类型
                        $message['source_file_id'] = $model->source_file_id;
                        break;
                    case 4://视频类型
                        $message['source_file_id'] = $model->source_file_id;
                        break;
                    case 5://新闻类型（图文）
                        $message['multi'] = $model->multi;
                        $message['source_file_id'] = $model->source_file_id;
                        break;
                endswitch;
            }
        }
        return $message;
    }

    /* ---------------------------------以下针对带参数二维码调用------------------------------------ */

    /**
     * 检查是否是通过带参数二维码关注进来的用户
     * @param string $eventKey 二维码参数
     */
    private function checkQuickMark($public_id = 0, $eventKey = '') {
        if ($eventKey) {
            $scene_id = substr($eventKey, 8); //得到key
            $criteria = new CDbCriteria();
            $criteria->select = 'id,group_id,title,admin_id,public_id,user_id';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('scene_id', $scene_id);
            $criteria->compare('isdelete', 0);
            Yii::import('application.modules.basis.models.Quickmark');
            $dataProvider = Quickmark::model()->find($criteria);
//关注来源
// $focusfrom = new Focusfrom;
            if ($dataProvider) {
                return $dataProvider->group_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

//得到scene_id
    private function getScene_id($public_id = 0, $eventKey = '') {
        if ($eventKey) {
            $scene_id = substr($eventKey, 8); //得到key
            $criteria = new CDbCriteria();
            $criteria->select = 'scene_id,public_id,user_id';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('scene_id', $scene_id);
            $criteria->compare('isdelete', 0);
            Yii::import('application.modules.basis.models.Quickmark');
            $dataProvider = Quickmark::model()->find($criteria);
            if ($dataProvider) {
                return $dataProvider;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /* ---------------------------------图文调用素材------------------------------------ */

    /**
     * 查询素材文件
     * @param int $public_id 公众号ID
     * @param int $source_file_id 素材id
     * @param int $multi 是否是多图文
     */
    private function searchSourceFile($source_file_id = 0, $multi = 0) {
        if ($multi) {
            $fileIdArr = array();
            $criteria = new CDbCriteria();
            $criteria->select = 'file_id';
            $criteria->compare('group_id', $source_file_id);
            $criteria->compare('isdelete', 0);
            $criteria->order = '`sort` ASC';
            $models = SourceFileDetail::model()->findAll($criteria);
            if ($models) {
                $dataProvider = array();
                foreach ($models as $model) {
                    $criteria = new CDbCriteria();
                    $criteria->select = 'id,title,filename,ext,description';
                    $criteria->compare('type', 5);
                    $criteria->compare('isdelete', 0);
                    $dataProvider[] = SourceFile::model()->findByPk($model->file_id, $criteria);
                }
                return $this->generateNewsArr($dataProvider);
            }
        } else {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,title,filename,ext,description';
            $criteria->compare('isdelete', 0);
            $criteria->compare('type', 5);
            $criteria->compare('id', $source_file_id);
            $dataProvider = SourceFile::model()->findAll($criteria);
            return $this->generateNewsArr($dataProvider);
        }
    }

    /**
     * 生成新闻数组
     * @param type $sourceFile
     * @return type
     */
    private function generateNewsArr($sourceFile = array()) {
        $dataProvider = array('items');
        if (is_array($sourceFile) && !empty($sourceFile)) {
            foreach ($sourceFile as $key => $value) {
                $dataProvider['items'][$key]['title'] = $value['title'];
                $dataProvider['items'][$key]['description'] = $value['description'];
                $fileSize = $key ? 'thumb' : 'medium'; //判断是否是封面
                $dataProvider['items'][$key]['picurl'] = PublicStaticMethod::returnSourceFile($value['filename'], $value['ext'], 'image', $fileSize);
                $dataProvider['items'][$key]['url'] = Yii::app()->createAbsoluteUrl('site/view', array('id' => $value['id']));
            }
            return $dataProvider;
        }
    }

    /* ---------------------------------匹配自定义菜单eventKey------------------------------------ */

    /**
     * 匹配自定义菜单回复
     * @param string $eventKey 菜单键值
     * @param int $public_id 公众号ID
     */
    private function matchMenu($eventKey = '', $public_id = '') {
        $criteria = new CDbCriteria();
        $criteria->select = 'category,description,multi,source_file_id';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('isdelete', 0);
        $criteria->compare('type', 1);
        $criteria->compare('`key`', $eventKey);
        $model = Menu::model()->find($criteria);
        if ($model) {
            $message = array();
            $message['type'] = $model->category;
            switch ($model->category):
                case 1://文本类型
                    $message['content'] = $model->description;
                    break;
                case 2://图片类型
                    $message['source_file_id'] = $model->source_file_id;
                    break;
                case 3://音频类型
                    $message['source_file_id'] = $model->source_file_id;
                    break;
                case 4://视频类型
                    $message['source_file_id'] = $model->source_file_id;
                    break;
                case 5://新闻类型（图文）
                    $message['multi'] = $model->multi;
                    $message['source_file_id'] = $model->source_file_id;
                    break;
            endswitch;
            return $message;
        }
    }

    /* ---------------------------------群发消息返回记录------------------------------------ */

    /**
     * 记录群发消息的返回数据
     * @param array $dataProvider 微信返回数据
     */
    private function pushReturn($dataProvider = array()) {
        if (is_array($dataProvider) && !empty($dataProvider)) {
            $model = new PushReturn();
            $model->attributes = $dataProvider;
            $model->save();
        }
    }
    
//     /**
//      * 测试获取用户的信息
//      * 稍后会删除这个函数  
//      */
//     public function actionGetUserInfo(){
// //         $wechat = new Wechat($_GET);
// //         $media_model = new MediaId();
// //         $wechat->token = $this->_WECHATTOKEN;
// //         //$wechat->debug = true; //是否开启调试bug
        
// //         /* -------------------------验证密钥------------------------- */
// //         if (isset($_REQUEST['echostr'])) {
// //             $wechat->valid();
// //         }
// //         /* -------------------------验证密钥------------------------- */
        
// //         $wechat->init(); //初始化微信类，绑定各参数
        
// //         $this->_MSGTYPE = empty($wechat->msg->MsgType) ? '' : strtolower($wechat->msg->MsgType);
// //         $this->_MSGEVENT = empty($wechat->msg->Event) ? '' : strtolower($wechat->msg->Event);
// //         $this->_OPENID = $wechat->msg->FromUserName; //用户openid
// //         $this->_ORIGINAL = $wechat->msg->ToUserName; //公众号
// //         $this->_CREATETIME = (int) $wechat->msg->CreateTime; //创建时间
        
// //         $this->_PUBLICINFO = WechatStaticMethod::getPublicInfo($this->_ORIGINAL); //获取公众号信息
// //         $this->_ACCESS_TOKEN = WechatStaticMethod::getAccessToken($this->_PUBLICINFO); //获取access_token
// //         $publicArr = array(
// //             'appid' => $this->_PUBLICINFO['appid'],
// //             'appsecret' => $this->_PUBLICINFO['appsecret'],
// //         );
// //         $access_token = WechatStaticMethod::getAccessToken($publicArr);
//         //ntxgJOuzHoZxkJRnPktjBd6KESLfrKwI7izlexujDHRnMLaXr4B3nHQ1HPBgqgoUeo2wwk_1JVtuEz4l43YqCTKQRI3HF9nvrt9XZ6yGLQFN4HWFtbiyVZ6Dr-sQOPiARKRjAEAHAH
// //         $open_id = Yii::app()->getParams('open_id');
//         $this->_ACCESS_TOKEN = 'Yp6_6YgvE6TZFh7oB8o-L5scIyWdtDJ7zlYsRypmjqMCXKwsidV63Ofmc-uFZ3_L6jN_zekV66VRpFx3yvoI_OxC4ELA3_bIe2Oh0lQ1JISpNL9JfPliEJ0isC8ej-nFKOPaAHAQUV'; //获取access_token
// //         $open_id = $this->_OPENID;
//         $open_id = 'ojf3esn6UpXXc-F-KzQ_LgFAFGR7';
//         $pubilc_id = 10;
//         $created_time = time();
//         $group_id = 0;
//         $array =  $this->getUser($pubilc_id,$open_id,$created_time,$group_id);
//         var_dump($array);
        
//     }
    
    

}
