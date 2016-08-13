<?php

class AttendanceController extends Controller {

    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('update'),
                'roles' => array('1', '2', '3'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('view', 'create', 'admin', 'delete', 'validate', 'member'),
                'roles' => array('1'),
            ),
            array('allow', // 无需登录 可操作
                'actions' => array('monkey', 'allpeople', 'test', 'activitynews', 'christmas2', 'christmas', 'duoshou', 'postjump', 'moneytree', 'index','shake'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

//
    public function actionPostjump() {
        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
    }

    public function actionTest() {
//        $postArr = array();
//        $voice_media_id = 'rrR2jGKsvo5IoAIPzuWbgIRCqCOWffB1b5Gejbi7sufuI8d4r6FMBEQ36jKn6dWM';
//        $voice_file_name = time();
//        $voice_path = 'upload/sourcefile/voice/' . $voice_file_name . '.amr';
//        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=xKIDfcDp0dn-75evAdkviWsECHGq5GqvnGFNcdmXUOCBMOoFDwrTzWOjPjG8EQe-SizwoTgidNwmBfIMgUlQ_JsVXMJVChd9QnZ11foOkP8MYHcAGATFO';
//        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=xKIDfcDp0dn-75evAdkviWsECHGq5GqvnGFNcdmXUOCBMOoFDwrTzWOjPjG8EQe-SizwoTgidNwmBfIMgUlQ_JsVXMJVChd9QnZ11foOkP8MYHcAGATFO&media_id=' . $voice_media_id;
//        $postArr['media_id'] = $voice_media_id;
//        //$result = WechatStaticMethod::https_request($url,$postArr);
//        $photoDataProvider = WechatStaticMethod::downloadImageFromWeichat($url);
//        var_dump($photoDataProvider);
//        file_put_contents($voice_path, $photoDataProvider['body']);
//        //$result = json_decode($result, true);

        $this->renderPartial('test');
    }

    /*
     * 芈月 活动 跳转链接
     */

    public function actionActivitynews() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $model = new User;
        $intearalModel = new UserIntegral;
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';
//---------------------------------------------------* 链接接口   
        $fopenid = 0;
        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Activitynews/index");
        if (!empty($_GET['fopenid'])) {
            $fopenid = $_GET['fopenid'];
        }
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
//非授权 得到openid 
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if (!empty($openid)) {
//用户 数据 
                    $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                    if (!empty($usermodel)) {
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Activitynews/index");
//                        $params = array();
//                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activitynews/index';
//                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    } else {
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Activitynews/index");
                    }
                    Yii::app()->user->setflash('openid', $openid);
                }
            };
        }

        $this->render('christmas', array(
            'appId' => $appId,
            'usermodule' => $model,
        ));
    }

    /*
     * 摇一摇 活动
     */

    public function actionMoneytree() {
        $this->layout = '//layouts/member';
        $appId = 'wx2846a5047326ce12'; //接受参数appid
        $dataProvider3 = null;
//增加 type 类型
        $source = @Yii::app()->request->getParam('source');
        if (!empty($source)) {
            Yii::app()->cache->set('source', $source, 3600);
        }
//appid不为空
        if (!empty($appId)) {
            Yii::app()->cache->set('appId', $appId, 7200);
        } else {
            $appId = @Yii::app()->cache->get('appId');
            if (empty($appId) || $appId == 0) {
                $appId = 'wx2846a5047326ce12';
                Yii::app()->cache->set('appId', $appId, 7200);
            }
        }
        $secret = '952d6efd51d48380c7159a252a31de2c'; //修改为对应公众号的
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
            if (Yii::app()->request->getparam('state') == '2') {
                /*
                 * 授权操作 步骤
                 */
                $url3 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $dataProvider->access_token . '&openid=' . $dataProvider->openid . '&lang=zh_CN';
                $result3 = WechatStaticMethod::https_request($url3);
                $dataProvider3 = json_decode($result3);
                Yii::app()->cache->set('openid', $dataProvider3->openid, 7200);
//header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=fendactivity/index&actid=1&openid=" . $dataProvider3->openid . "&source=" . @Yii::app()->cache->get('source'));
                $params = array();
                $params['source'] = @Yii::app()->cache->get('source');
                $params['openid'] = $dataProvider3->openid;
                $params['actid'] = '1';
                $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=fendactivity/index&actid=1&source=' . $params['source'];
                $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                exit;
            }
        }
//}
        /*
         * 授权操作 步骤结束
         */

        $this->render('moneytree', array(
            'appId' => $appId,
            'dataProvider3' => $dataProvider3,
        ));
    }

    /*
     * 猴年  活动
     */

    public function actionMonkey() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $model = new User;
        $intearalModel = new UserIntegral;
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';
//---------------------------------------------------* 链接接口   
        $fopenid = 0;
        if (!empty($_GET['fopenid'])) {
            $fopenid = $_GET['fopenid'];
        }
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
//非授权 得到openid 
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if (!empty($openid)) {
//用户 数据
                    $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                    if (!empty($usermodel)) {
                        $params = array();
                        $params['openid'] = $usermodel->openid;
                        $params['nickname'] = $usermodel->nickname;
//父类 openid
                        $params['fopenid'] = $fopenid;
                        $params['focus'] = 1;
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Activitymonkey/index&openid=" . $usermodel->openid . "&focus=1&nickname=" . $usermodel->nickname . '&fopenid=' . $fopenid);
                    } else {
                        //未关注
                        $params = array();
                        $params['openid'] = $openid;
//父类 openid
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Activitymonkey/index&openid=" . $openid . "&focus=0");
                    }
                    Yii::app()->user->setflash('openid', $openid);
                }
            };
        }

        $this->render('christmas', array(
            'appId' => $appId,
        ));
    }

    /*
     * 感恩节 活动
     */

    public function actionAllpeople() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $model = new User;
        $intearalModel = new UserIntegral;
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';
//---------------------------------------------------* 链接接口   
        $fopenid = 0;
        if (!empty($_GET['fopenid'])) {
            $fopenid = $_GET['fopenid'];
        }
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
//非授权 得到openid 
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if (!empty($openid)) {
//用户 数据
                    $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                    if (!empty($usermodel)) {
                        $params = array();
                        $params['openid'] = $usermodel->openid;
                        $params['nickname'] = $usermodel->nickname;
//父类 openid
                        $params['fopenid'] = $fopenid;
                        $params['focus'] = 1;
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=activitynewyear/index&openid=" . $usermodel->openid . "&focus=1&nickname=" . $usermodel->nickname . '&fopenid=' . $fopenid);
                    } else {
                        //未关注
                        $params = array();
                        $params['openid'] = $openid;
//父类 openid
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=activitynewyear/index';
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=activitynewyear/index&openid=" . $openid . "&focus=0");
                    }
                    Yii::app()->user->setflash('openid', $openid);
                }
            };
        }

        $this->render('christmas', array(
            'appId' => $appId,
        ));
    }

    /*
     * 感恩节 活动
     */

    public function actionChristmas() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $model = new User;
        $intearalModel = new UserIntegral;
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';
//---------------------------------------------------* 链接接口   
        $fopenid = 0;
        if (!empty($_GET['fopenid'])) {
            $fopenid = $_GET['fopenid'];
        }
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
//非授权 得到openid 
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if (!empty($openid)) {
//用户 数据
                    $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                    if (!empty($usermodel)) {
                        $params = array();
                        $params['openid'] = $usermodel->openid;
                        $params['nickname'] = $usermodel->nickname;
                        $params['headimgurl'] = $usermodel->headimgurl;
                        $params['actid'] = '3';
//父类 openid
                        $params['fopenid'] = $fopenid;
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Chrismasrecord/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    } else {
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Chrismasrecord/follow");
                    }
                    Yii::app()->user->setflash('openid', $openid);
                }
            };
        }

        $this->render('christmas', array(
            'appId' => $appId,
            'usermodule' => $model,
        ));
    }

    /*
     * 感恩节 活动 copy 一份
     */

    public function actionChristmas2() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $model = new User;
        $intearalModel = new UserIntegral;
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';
//---------------------------------------------------* 链接接口   
        $fopenid = 0;
        if (!empty($_GET['fopenid'])) {
            $fopenid = $_GET['fopenid'];
        }
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
//非授权 得到openid 
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if (!empty($openid)) {
//用户 数据
                    $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                    if (!empty($usermodel)) {
                        $params = array();
                        $params['openid'] = $usermodel->openid;
                        $params['nickname'] = $usermodel->nickname;
                        $params['headimgurl'] = $usermodel->headimgurl;
                        $params['actid'] = '3';
//父类 openid
                        $params['fopenid'] = $fopenid;
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Chrismasrecord/newindex';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    } else {
                        header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Chrismasrecord/follow");
                    }
                    Yii::app()->user->setflash('openid', $openid);
                }
            };
        }

        $this->render('christmas', array(
            'appId' => $appId,
            'usermodule' => $model,
        ));
    }

    /*
     * 剁手活动
     */

    public function actionDuoshou() {
        $this->layout = '//layouts/member';
        $appId = 'wxcdf4e48a30470336'; //接受参数appid  绑定为欧派家居商城 测试号
        $dataProvider3 = null;
//增加 type 类型
        $source = @Yii::app()->request->getParam('source');
        if (!empty($source)) {
            Yii::app()->cache->set('source', $source, 3600);
        }
//appid不为空
        if (!empty($appId)) {
            Yii::app()->cache->set('appId', $appId, 7200);
        } else {
            $appId = @Yii::app()->cache->get('appId');
            if (empty($appId) || $appId == 0) {
                $appId = 'wxcdf4e48a30470336';
                Yii::app()->cache->set('appId', $appId, 7200);
            }
        }
        $secret = 'f3aedaea26adeac3c8b856ffb2d48918'; //修改为对应公众号的
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
            if (Yii::app()->request->getparam('state') == '2') {
                /*
                 * 授权操作 步骤
                 */
                $url3 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $dataProvider->access_token . '&openid=' . $dataProvider->openid . '&lang=zh_CN';
                $result3 = WechatStaticMethod::https_request($url3);
                $dataProvider3 = json_decode($result3);
                Yii::app()->cache->set('openid', $dataProvider3->openid, 7200);
                $params = array();
                $params['source'] = @Yii::app()->cache->get('source');
                $params['openid'] = $dataProvider3->openid;
                $params['nickname'] = $dataProvider3->nickname;
                $params['actid'] = '2';
//$url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityduoshou/index&actid=2&source=' . $params['source'];
                header("location:http://www.oppein.cn/oppein/edmsys/index.php?r=Activityduoshou/index&actid=2&openid=" . $dataProvider3->openid . "&nickname=" . $dataProvider3->nickname);
//$this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                exit;
            }
        }
//}
        /*
         * 授权操作 步骤结束
         */

        $this->render('duoshou', array(
            'appId' => $appId,
            'dataProvider3' => $dataProvider3,
        ));
    }
    /**
     * 2016摇一摇活动
     */
    public function actionShake() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';

//---------------------------------------------------* 链接接口

        $sourceid =isset($_GET['sourceid'])?$_GET['sourceid']:'';
        $picid    =isset($_GET['picid'])?$_GET['picid']:'';

        $allow =0;
        if(!empty($picid)&&($picid==10||$picid==11||$picid==12)){ //判断是否抽到了实物奖品
            $allow=1;
        }

        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
            //var_dump($dataProvider);exit;
//非授权 得到openid
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if(!empty($sourceid)&&$allow==1){
                    if (!empty($openid)) {
                        $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                        $smodel  = User::model()->find('openid = :openid and subscribe =:subscribe',array(':openid' => $sourceid, ':subscribe' => '1'));
                        $params = array();
                        if (!empty($usermodel)&&!empty($smodel)) {
                            $params['openid'] = $smodel->openid;
                            $params['nickname'] = $smodel->nickname;
                            $params['fopenid'] = $usermodel->openid;
                            $params['fnickname'] =$usermodel->nickname;
                            $params['actid'] = '5';
                        }else{
                            $params['isjump'] ='3';
                            $params['actid'] = '5';
                        }
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityshake/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }else{
                        $params = array();
                        $params['isjump'] ='3';
                        $params['actid'] = '5';
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityshake/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }
                }else{
                    if (!empty($openid)) {
                        $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe', array(':openid' => $openid, ':subscribe' => '1'));
                        $params = array();
                        if (!empty($usermodel)) {
                            $params['openid'] = $usermodel->openid;
                            $params['nickname'] = $usermodel->nickname;
                            $params['actid'] = '5';
                        }else{
                            $params['actid'] = '5';
                            $params['isjump'] ='3';
                        }
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityshake/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }else{
                        $params = array();
                        $params['isjump'] ='3';
                        $params['actid'] = '5';
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityshake/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }
                }
            }
        }
        $this->render('shake', array(
            'appId' => $appId,
        ));
    }

    /**
     * 父亲节摇一摇活动(欧派家居商城)
     */
    public function actionFather() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
//欧派 家居商城 公众号
        $appId = 'wx0cd263ec9a49f194'; //接受参数appid 从链接url得到
        $secret = '6348729a7faff115de49d0701316047f';

//---------------------------------------------------* 链接接口

        $sourceid =isset($_GET['sourceid'])?$_GET['sourceid']:'';
        $picid    =isset($_GET['picid'])?$_GET['picid']:'';

        $allow =0;
        if(!empty($picid)&&($picid==10||$picid==11||$picid==12)){ //判断是否抽到了实物奖品
            $allow=1;
        }

        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
            //var_dump($dataProvider);exit;
//非授权 得到openid
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if(!empty($sourceid)&&$allow==1){
                    if (!empty($openid)) {
                        $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe and public_id=:public_id', array(':openid' => $openid, ':subscribe' => '1',':public_id'=>'3'));
                        $smodel  = User::model()->find('openid = :openid and subscribe =:subscribe and public_id=:public_id',array(':openid' => $sourceid, ':subscribe' => '1',':public_id'=>'3'));
                        $params = array();
                        if (!empty($usermodel)&&!empty($smodel)) {
                            $params['openid'] = $smodel->openid;
                            $params['nickname'] = $smodel->nickname;
                            $params['fopenid'] = $usermodel->openid;
                            $params['fnickname'] =$usermodel->nickname;
                            $params['actid'] = '6';
                            $params['is_2d'] = '1';
                        }else{
                            $params['isjump'] ='3';
                            $params['actid'] = '6';
                            $params['is_2d'] = '1';
                        }
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }else{
                        $params = array();
                        $params['isjump'] ='3';
                        $params['actid'] = '6';
                        $params['is_2d'] = '1';
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }
                }else{
                    if (!empty($openid)) {
                        $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe and public_id=:public_id', array(':openid' => $openid, ':subscribe' => '1',':public_id'=>'3'));
                        $params = array();
                        if (!empty($usermodel)) {
                            $params['openid'] = $usermodel->openid;
                            $params['nickname'] = $usermodel->nickname;
                            $params['actid'] = '6';
                            $params['is_2d'] = '1';
                        }else{
                            $params['actid'] = '6';
                            $params['isjump'] ='3';
                            $params['is_2d'] = '1';
                        }
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }else{
                        $params = array();
                        $params['isjump'] ='3';
                        $params['actid'] = '6';
                        $params['is_2d'] = '1';
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }
                }
            }
        }
        $this->render('shake', array(
            'appId' => $appId,
        ));
    }

    /**
     * 父亲节摇一摇活动(欧派广州分公司)
     */
    public function actionFatherson() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
      //广分账号
        $appId = 'wx962e9b9fcf490ac5'; //接受参数appid 从链接url得到
        $secret = '02fe880790fa47c1fdc110f4e1db3509';
//---------------------------------------------------* 链接接口
        $sourceid =isset($_GET['sourceid'])?$_GET['sourceid']:'';
        $picid    =isset($_GET['picid'])?$_GET['picid']:'';

        $allow =0;
        if(!empty($picid)&&($picid==10||$picid==11||$picid==12)){ //判断是否抽到了实物奖品
            $allow=1;
        }
        if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');
            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
            //var_dump($dataProvider);exit;
//非授权 得到openid
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = @$dataProvider->openid;
                if(!empty($sourceid)&&$allow==1){
                    if (!empty($openid)) {
                        $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe and public_id=:public_id', array(':openid' => $openid, ':subscribe' => 1,':public_id'=>5));
                        $smodel  = User::model()->find('openid = :openid and subscribe =:subscribe and public_id=:public_id',array(':openid' => $sourceid, ':subscribe' => 1,':public_id'=>5));
                        $params = array();
                        if (!empty($usermodel)&&!empty($smodel)) {
                            $params['openid'] = $smodel->openid;
                            $params['nickname'] = $smodel->nickname;
                            $params['fopenid'] = $usermodel->openid;
                            $params['fnickname'] =$usermodel->nickname;
                            $params['actid'] = '7';
                            $params['is_2d'] = '2';
                        }else{
                            $params['isjump'] ='3';
                            $params['actid'] = '7';
                            $params['is_2d'] = '2';
                        }
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }else{
                        $params = array();
                        $params['isjump'] ='3';
                        $params['actid'] = '7';
                        $params['is_2d'] = '2';
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }
                }else{
                    if (!empty($openid)) {
                        $usermodel = User::model()->find('openid = :openid and subscribe =:subscribe and public_id=:public_id', array(':openid' => $openid, ':subscribe' => '1',':public_id'=>'5'));
                        $params = array();
                        if (!empty($usermodel)) {
                            $params['openid'] = $usermodel->openid;
                            $params['nickname'] = $usermodel->nickname;
                            $params['actid'] = '7';
                            $params['is_2d'] = '2';
                        }else{
                            $params['actid'] = '7';
                            $params['isjump'] ='3';
                            $params['is_2d'] = '2';
                        }
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }else{
                        $params = array();
                        $params['isjump'] ='3';
                        $params['actid'] = '7';
                        $params['is_2d'] = '2';
                        $url = 'http://www.oppein.cn/oppein/edmsys/index.php?r=Activityfather/index';
                        $this->renderPartial('postjump', array('url' => $url, 'params' => $params));
                    }
                }
            }
        }
        $this->render('shake', array(
            'appId' => $appId,
        ));
    }
    /*
     * 会员中心页面
     */

    public function actionMember() {
        $this->layout = '//layout/operation';

        $this->render('member', array());
    }

    /*
     * 绑定手机号
     */

    public function actionValidate() {
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $model = new User;
        $queryString = @$_POST['queryString'];
        $code = @$_POST['code'];
        $openid = @$_POST['openid'];
        $mobile = $queryString;
//发送验证码 以及绑定手机
        if (!empty($code) && !empty($mobile)) {
            if (Yii::app()->session['suiji'] == $code) {
                $model = new User;
                $openid = $openid; //Yii::app()->request->getparam('openid');
                $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
                $model->updateByPk($model->id, array('mobile' => $mobile));
                Yii::app()->user->setFlash('mobilemessage', '绑定成功可以签到');
                echo "绑定成功可以签到";
//   $this->redirect(array('index', 'mobile' => $mobile));
            } else {
                Yii::app()->user->setFlash('mobilemessage', '验证码错误');
                echo "验证码错误";
            }
            exit;
        } elseif ($mobile > 0) {
            if (preg_match("/1[34568]{1}\d{9}$/", $mobile)) {
                $suiji = rand(100000, 999999);
                Yii::app()->session['suiji'] = $suiji;
// $suiji = Yii::app()->session['suiji'];
                $message = mb_convert_encoding("尊敬的用户您好：你的验证码是：" . $suiji . "请勿泄露给他人，谢谢", "gb2312", "utf-8");
                $URL = 'http://web.mobset.com/SDK/Sms_Send.asp';
                $can = 'CorpID=121447&Passwd=220130&LoginName=oppeincn&send_no=' . $mobile . '&msg="' . $message . '"';
                $fanhui = Controller::post($URL, array('CorpID' => '121447', 'Passwd' => '220130', 'LoginName' => 'oppeincn', 'send_no' => $mobile, 'msg' => $message));
                $result = $fanhui[0];
                if ($result == '1') {
                    Yii::app()->user->setFlash('mobilemessage', '我们已成功发送短信，注意查收。');
                    echo '我们已成功发送短信，注意查收。';
                } else {
                    Yii ::app()->user->setFlash('mobilemessage', '短信发送失败，请确认手机号码');
                    echo '短信发送失败，请确认手机号码';
                }
            } else {
                Yii::app()->user->setFlash('mobileerrors', '请正确 填写手机号，谢谢');
                echo '请正确 填写手机号，谢谢';
            }
            exit;
        } elseif (empty($mobile)) {
            Yii::app()->user->setFlash('mobileerrors', '请填写手机号');
        } else {
            
        }
//$this->redirect(array('validate', 'mobile' => $mobile));

        $this->render('validate', array(
            'model' => $model,
        ));
    }

    /*
     * 签到页面
     */

    public function actionIndex() {
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $model = new User;
        $intearalModel = new UserIntegral;
        $public_id = 0;

        $appId = Yii::app()->request->getparam('appid'); //接受参数appid
//appid不为空
        if (!empty($appId)) {
            Yii::app()->cache->set('appId', $appId, 7200);
        } else {
            $appId = Yii::app()->cache->get('appId');
        }
//根据appid查询公众号 信息
        $wcpublic = WcPublic::model()->find('appid =:appid', array
            (':appid' => $appId));
        if (!empty($wcpublic)) {
            $public_id = $wcpublic->id;
            Yii::app()->cache->set('public_id', $public_id, 7200);
            $secret = $wcpublic->appsecret;
        }
//点击签到
        if (Yii ::app()->request->getparam('openid')) {

            $openid = Yii::app()->request->getparam('openid');
            $public_id = Yii::app()->cache->get('public_id');
            $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
            $id = $model->id;
//是否存在该用户
            if (!empty($model)) {

                $zero1 = strtotime(date("y-m-d"));
                $zero2 = $model->last_attendance_time;
                $differ = ceil(($zero1 - $zero2) / 86400);
                $type = 5; //定义签到  类型为5
//如果有签到记录
                if (@$differ > 0) {//时间大一天
                    $intearalModel->setAttribute('public_id', $public_id);
                    $intearalModel->setAttribute('user_id', $id);
                    $intearalModel->setAttribute('type_id', $type);
                    $intearalModel->setAttribute('cause', '签到');
                    $intearalModel->setAttribute('time_created', strtotime(date("y-m-d")));
//积分 按签到 日期 计算
//昨天
                    $yesterday = strtotime(date("Y-m-d", strtotime("-1 day")));
//查询昨天签到日期总和
                    $yestermodel = $intearalModel->find('user_id =:user_id and time_created=:time_created', array(':user_id' => $id, ':time_created' => $yesterday));
                    if (!empty($yestermodel)) {
                        $sign_in_count = $yestermodel->sign_in_count;
                        $todaycount = $sign_in_count + 1;
//签到次数  增加1
                        $intearalModel->setAttribute('sign_in_count', $todaycount);
                        if ($todaycount == 2 || ($todaycount % 7 == 2)) {
                            $integral = 2;
                        } else if ($todaycount == 3 || ($todaycount % 7 == 3)) {
                            $integral = 3;
                        } else if ($todaycount == 4 || ($todaycount % 7 == 4)) {
                            $integral = 4;
                        } else if ($todaycount == 5 || $todaycount == 6 || ($todaycount % 7 == 0) || ($todaycount % 5 == 5) || ($todaycount % 7 == 6)) {
                            $integral = 5;
                        } else if ($todaycount == 8) {
                            $integral = 1;
                        }
                    }
//没有昨天记录按照第一天计算  1分
                    else {
                        $integral = 1;
                        $intearalModel->setAttribute('sign_in_count', '1');
                    }
                    $intearalModel->setAttribute('score', $integral); //积分 值  
                    if ($intearalModel->save()) {//增加积分记录表  
//更新 最后签到时间
                        $model->updateByPk($id, array('integral' => $model->integral + $integral,
                            'last_attendance_time' => strtotime(date("y-m-d"))));
                        $model->setAttribute('integral', $model->integral + $integral);
                    } else {
                        var_dump($intearalModel->errors);
                        exit;
                    }
                } else {
                    echo "已签到";
                }
            }
        }
//---------------------------------------------------* 链接接口   
        else if (Yii::app()->request->getparam('code')) {
            $code = Yii::app()->request->getparam('code');

            $url2 = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
            $result2 = WechatStaticMethod::https_request($url2);
            $dataProvider = json_decode($result2);
//非授权 得到openid 
            if (Yii::app()->request->getparam('state') == '1') {
                $openid = $dataProvider->openid;
                $usermodel = User::model()->find('openid = :openid', array(':openid' => $openid));
                if (!empty($usermodel)) {
                    if ($usermodel->subscribe == '1') {
                        echo $usermodel->nickname;
                        echo $usermodel->id;
                        Yii::app()->cache->set('openid', $openid, 7200);
                        echo "已关注";
                    } else {
                        echo "请重新关注";
                    }
                }
            } else {
                ;                /*
                 * 授权操作 步骤
                 */
                $url3 = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $dataProvider->access_token . '&openid=' . $dataProvider->openid . '&lang=zh_CN';
                $result3 = WechatStaticMethod::https_request($url3);
                $dataProvider3 = json_decode($result3);
                var_dump($dataProvider3);
                exit;
                $model = User::model()->find('openid = :openid ', array(':openid' => $dataProvider3->openid));
                Yii::app()->cache->set('openid', $dataProvider3->openid, 7200);
            }
        }

//}
        /*
         * 授权操作 步骤结束
         */
//-------------------------------------------------------* 签到 结束
        $openid = @Yii::app()->cache->get('openid');
        if ($openid) {
            $model = User::model()->find('openid=:openid', array(':openid' => $openid));
        }

        $this->render('index', array(
            'model' => $model,
            'appId' => $appId,
        ));
    }

}
