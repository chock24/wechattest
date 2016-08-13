<?php

class UserModuleController extends Controller {

    private $districtArr = array(); //定义地区数组
    protected $groupArr = array(); //定义分组数组
    public $levelArr = array(); //定义等级数组
    public $title;
    private $_ACCESS_TOKEN; //定义access_token

    /**
     * @return array action filters
     */

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //    'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('ajaxupdate', 'index', 'admin', 'view', 'update', 'create', 'delete'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('allow', // 无需登录 可操作
                'actions' => array('postattendance', 'friend_relation', 'winning', 'integraluser', 'transmituser', 'sharefriend', 'transmitmsg', 'giftexchange', 'gift_detail', 'allhouse', 'news', 'integral', 'address_list', 'gift', 'aboutintegral', 'share', 'transmit_detail', 'transmit', 'childdistrict', 'address', 'memberdeals', 'swing', 'userlevel', 'attendancerule', 'attendance', 'coupon', 'homepage', 'user', 'userdata', 'province',
                    'city', 'country', 'remark', 'star', 'mobile', 'createquick'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionWinning() {
        $this->layout = '//layouts/member';
        $this->render('winning');
    }

    public function actionFriend_relation() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $user_id = Yii::app()->request->getParam('id');
        $from_user = ''; //邀请人 
        $to_model = ''; //被邀请人
        $ResultList = array(); //被邀请人 数组
        if (!empty($user_id)) {
            $user = User::model()->findByPk($user_id);
            if (!empty($user)) {
                //查询邀请人信息
                $criteria = new CDbCriteria;
                $criteria->compare('attention_openid', $user->openid);
                $criteria->compare('isdelete', 0);
                $from_model = UserRelation::model()->find($criteria);
                //查询被邀请人信息
                $criteria = new CDbCriteria;
                $criteria->compare('from_userid', $user->id);
                $criteria->compare('isdelete', 0);
                $criteria->order = 'time_created DESC';
                $to_model = UserRelation::model()->findAll($criteria);
                if (!empty($from_model)) {
                    //得到邀请人信息
                    $from_user = User::model()->find('id = :id and subscribe =:subscribe', array(':id' => $from_model->from_userid, ':subscribe' => 1));
                }
                if (!empty($to_model)) {
                    $criteria = new CDbCriteria;
                    $criteria->compare('from_userid', $user->id);
                    foreach ($to_model as $key => $t) {
                        $to_user = User::model()->find('openid = :openid and subscribe=:subscribe', array(':openid' => $t->attention_openid, ':subscribe' => 1));
                        if (!empty($to_user)) {
                            $ResultList[$key] = array('nickname' => $to_user->nickname, 'headimgurl' => $to_user->headimgurl, 'time_created' => $t->time_created);
                        }
                    }
                }
            }
        }
        $this->render('friend_relation', array('user' => $user, 'from_user' => $from_user, 'ResultList' => $ResultList));
    }

    /*
     * 积分记录
     */

    public function actionIntegraluser() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $user_id = Yii::app()->request->getParam('user_id');
        if (empty($user_id)) {
            $user_id = Yii::app()->session['userid'];
        }
        $date = Yii::app()->request->getParam('date');
        $criteria = new CDbCriteria;
        if (!empty($user_id)) {
            if (!empty($date)) {
                if ($date == 1) {
                    //最近一个周
                    $newdate = strtotime("-6 day");
                    $criteria->condition = 'time_created >= ' . $newdate;
                } else if ($date == 2) {
                    //最近一个月
                    $newdate = strtotime("-30 day");
                    $criteria->condition = 'time_created >= ' . $newdate;
                } else if ($date == 3) {
                    //最近三个月
                    $newdate = strtotime("-90 day");
                    $criteria->condition = 'time_created >= ' . $newdate;
                } else if ($date == 4) {
                    //三个月之前
                    $newdate = strtotime("-90 day");
                    $criteria->condition = 'time_created < ' . $newdate;
                }
            }
            $criteria->compare('user_id', $user_id);
            $criteria->order = 'time_created DESC';
            //查询数量
            $num = Yii::app()->request->getParam('num');
            if (!empty($num)) {
                $criteria->limit = $num;
            }
            $userintegral = UserIntegral::model()->findAll($criteria);
            $user = User::model()->findByPk($user_id);
        }
        $this->render('integraluser', array('userintegral' => $userintegral, 'user' => $user, 'date' => $date));
    }

    /*
     * 我的分享 
     */

    public function actionTransmituser() {
        $this->layout = '//layouts/member';
        $user_id = Yii::app()->session['userid'];
        if (!empty($user_id)) {
            $TransmitUser = TransmitUser::model()->findAll('user_id =:user_id', array(':user_id' => $user_id));
        }
        $this->render('transmituser', array('TransmitUser' => $TransmitUser));
    }

    /*
     * 个人兑换礼品记录
     */

    public function actionGiftexchange() {
        $this->layout = '//layouts/member';
        $user_id = Yii::app()->session['userid'];
        if (empty($user_id)) {
            $user_id = Yii::app()->request->getParam('user_id');
        }
        $giftexchange = new GiftExchange;
        if (!empty($user_id)) {
            $criteria = new CDbCriteria();
            $criteria->compare('user_id', $user_id);
            $criteria->order = 'time_created DESC';
            $giftexchange = GiftExchange::model()->findAll($criteria);
        }
        $this->render('giftexchange', array('giftexchange' => $giftexchange));
    }

    /*
     * 礼品商城详情页
     */

    public function actionGift_detail() {

        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');

        $today_date = strtotime(date('Y-m-d', time()));
        $gift_id = Yii::app()->request->getParam('gift_id');
        $user_id = Yii::app()->session['userid'];
        $id = Yii::app()->request->getParam('id');
        //得到收货地址
        $address_id = Yii::app()->request->getParam('address_id');
        if (!empty($address_id)) {
            $nowaddress = UserAddress::model()->findByPk($address_id);
        }
        if (!empty($user_id)) {
            $user = User::model()->findByPk($user_id);
            if (!empty($user)) {
                $public_id = $user->public_id;
            }
        }
        if (!empty($gift_id)) {
            $gift = Gift::model()->findByPk($gift_id);
        }
        //兑换 该礼品
        if (!empty($id) && !empty($user_id)) {

            $giftex = new GiftExchange; //礼品兑换记录
            $gift_one = Gift::model()->findByPk($id);
            Gift::model()->findByPk($gift_id);
            $gift = Gift::model()->findByPk($id);
            $user_integral = $user->integral; //用户 积分
            $public_id = $user->public_id;
            $count_stock = $gift_one->count_stock; //库存数量
            $gift_integral = $gift_one->integral; //需要兑换的积分
            if ($count_stock > 0) {
                if ($user_integral == $gift_integral || $user_integral > $gift_integral) {
                    //减积分 更新用户积分
                    $integral = intval($user_integral) - intval($gift_integral);
                    User::model()->updateAll(array('integral' => $integral), 'id=:id', array(':id' => $user_id));
                    //增加库存修改记录
                    $giftmodel = new GiftOperationLog;
                    $giftmodel->gift_id = $id;
                    $giftmodel->genre = 2; //减少
                    $giftmodel->score = 1;
                    $giftmodel->remark = '被兑换';
                    $giftmodel->time_created = time();
                    $giftmodel->save();
                    //修改库存 数量
                    Gift::model()->updateAll(array('count_stock' => $count_stock - 1), 'id =:id', array(":id" => $id));

                    if (!empty($nowaddress)) {
                        //记录赋值
                        $giftex->public_id = $public_id;
                        $giftex->user_id = $user_id;
                        $giftex->gift_name = $gift_one->name;
                        $giftex->gift_id = $gift_one->id;
                        $giftex->address_id = $nowaddress->id;
                        $giftex->address_sheng = $nowaddress->address_sheng;
                        $giftex->name = $nowaddress->name;
                        $giftex->address_shi = $nowaddress->address_shi;
                        $giftex->address_qu = $nowaddress->address_qu;
                        $giftex->address_other = $nowaddress->address_other;
                        $giftex->postcode = $nowaddress->postcode;
                        $giftex->mobile = $nowaddress->mobile;
                        $giftex->tel = $nowaddress->tel;
                        $giftex->mobile = $nowaddress->mobile;
                        $giftex->score = $gift_one->integral; //分值
                        $giftex->time_created = time();
                        //增加礼品兑换记录
                        if ($giftex->save()) {
                            $intearalModel = new UserIntegral;
                            $intearalModel->setAttribute('public_id', $public_id);
                            $intearalModel->setAttribute('gift_id', $gift_one->id);
                            $intearalModel->setAttribute('user_id', $user_id);
                            $intearalModel->setAttribute('type_id', 7);
                            $intearalModel->setAttribute('score', $gift_integral); //积分 固定为2分 
                            $intearalModel->setAttribute('cause', '兑换礼品扣除积分');
                            $intearalModel->setAttribute('time_created', time()); //保存当天  日期
                            if ($intearalModel->save()) {
                                Yii::app()->user->setFlash('success', "您的礼品兑换成功，我们会尽快处理，谢谢");
                            } else {
                                Yii::app()->user->setFlash('success', "积分记录保存失败");
                            }
                        } else {
                            var_dump($giftex->errors);
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('success', "您的积分不够，不能兑换该礼品，谢谢");
                }
            } else {
                Yii::app()->user->setFlash('success', "该礼品库存不足，不能兑换，谢谢！");
            }
        }

//        $typeid=3;//指定海报id
//        $dataProvider = $this->getPosterbyid($typeid);

        $this->render('gift_detail', array('gift'=>$gift));
    }

    /*
     * 全屋家居
     */

    public function actionAllhouse() {
        $this->layout = '//layouts/member';
        $criteria = new CDbCriteria;
        $criteria->compare('status', 0);
        $criteria->compare('name', '全屋家居');
        $transmit_type = TransmitType::model()->find($criteria);
        $criteria = new CDbCriteria;
        $criteria->compare('isdelete', 0);
        $criteria->compare('type_id', $transmit_type->id);
        $transmit = Transmit::model()->findAll($criteria);
        $this->render('allhouse', array('transmit_type' => @$transmit_type, 'transmit' => @$transmit));
    }

    /*
     * 每日一读
     */

    public function actionNews() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $user_id = Yii::app()->session['userid'];
        $name='家装前沿';
        $typeid=$this->getIdbyname($name);

        if (empty($user_id)) {
            $user_id = Yii::app()->request->getParam('id');
            Yii::app()->session['userid'] = $user_id;
        }
        if (!empty($user_id)) {
            $user = User::model()->findByPk($user_id);
        }
        $type_id = @$_GET['type'];
        $criteria = new CDbCriteria;
        $criteria->compare('status', 0);
        $criteria->compare('name', '家装前沿');
        $transmit_type = TransmitType::model()->find($criteria);
        $criteria = new CDbCriteria;
        if (!empty($type_id)) {
            $criteria->compare('type_id', $type_id);
        }
        $criteria->order = 'order_by DESC';
        $criteria->compare('isdelete', 0);
        $transmit = Transmit::model()->findAll($criteria);
        $dataProvider=$this->getPosterbyid($typeid);
        $this->render('news', array('user' => $user, 'transmit_type' => @$transmit_type, 'transmit' => @$transmit,'dataProvider'=>$dataProvider));
    }

    /*
     * 赚积分
     */

    public function actionIntegral() {
        $this->layout = '//layouts/member';
        $name='赚积分';
        $typeid=$this->getIdbyname($name);//海报类型id
        $dataProvider=$this->getPosterbyid( $typeid);
        $this->render('integral',array('dataProvider'=>$dataProvider));
    }
    /**
     * 获取海报路径和链接
     */
    public function getPosterbyid($typeid){
        $dataProvider=array();
        if(!empty($typeid)){
            $model = new Poster();
            $criteria = new CDbCriteria;
            $criteria->select='`img_url`,`url`';
            $criteria->limit =3;
            $criteria->order ='time_created DESC';
            $criteria->compare('typeid',$typeid);
            $criteria->compare('is_delete',0);
            $data=$model->findAll($criteria);
            if(!empty($data)){
                foreach($data as $k=>$v){
                    $dataProvider[$k]['img_url']=$v['img_url'];
                    $dataProvider[$k]['url']    =$v['url'];
                }
            }
        }
        return $dataProvider;
    }
    public function getIdbyname($name){
        $pmodel=new PosterType();
        $cri = new CDbCriteria;
        $cri->select='`id`';
        $cri->compare('col_name',$name);
        $cri->compare('is_delete','0');
        $pdata=$pmodel->find($cri);
        $id='';
        if(!empty($pdata)){
            $id=$pdata->id;
        }
        return $id;
    }

    /*
     * 收货地址列表
     */

    public function actionAddress_list() {
        $this->layout = '//layouts/member';
        $user_id = @Yii::app()->session['userid'];
        $model = new UserAddress;
        $gift_id = @Yii::app()->request->getParam('gift_id');
        if (empty($user_id)) {
            $user_id = @Yii::app()->request->getParam('user_id');
        }
        if (!empty($user_id)) {
            $criteria = new CDbCriteria;
            $criteria->compare('user_id', $user_id);
            $criteria->compare('isdelete', 0);
            $model = UserAddress::model()->findAll($criteria);
        }
        $this->render('address_list', array('model' => $model));
    }

    /*
     * 礼品 商城
     */

    public function actionGift() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $user_id = Yii::app()->session['userid'];
        $today_date = strtotime(date('Y-m-d', time()));
        if (empty($user_id)) {
            $user_id = Yii::app()->request->getParam('user_id');
        }
        $type_id = Yii::app()->request->getParam('type_id');
        $id = Yii::app()->request->getParam('id');
        //得到收货地址
        $address_id = Yii::app()->request->getParam('address_id');

        if (!empty($address_id)) {
            $nowaddress = UserAddress::model()->findByPk($address_id);
        }
        if (!empty($user_id)) {
            $user = User::model()->findByPk($user_id);
            //查询 默认收货地址
            if (!empty($user)) {
                $public_id = $user->public_id;
            }
        }
        if (!empty($public_id)) {

            $criteria = new CDbCriteria;
            $criteria->condition = 'count_stock > 0';
            if (!empty($type_id)) {
                $criteria->compare('type_id', $type_id);
            }
            $criteria->compare('public_id', $public_id);
            $criteria->compare('isdelete', 0);
            $criteria->order = 'order_by DESC';
            $criteria->compare('status', 1); //状态为上架 1
            $gift = Gift::model()->findAll($criteria);

            $criteria = new CDbCriteria;
            $criteria->condition = 'count_stock = 0'; //库存为0
            if (!empty($type_id)) {
                $criteria->compare('type_id', $type_id);
            }
            $criteria->compare('public_id', $public_id);
            $criteria->compare('isdelete', 0);
            $criteria->order = 'order_by DESC';

            //  $criteria->compare('status', 0); //状态为下架 0
            $gift_null = Gift::model()->findAll($criteria);
        }
        //兑换 该礼品

        if (!empty($id) && !empty($user_id)) {

            $giftex = new GiftExchange; //礼品兑换记录
            $gift_one = Gift::model()->findByPk($id);
            $user = User::model()->findByPk($user_id);
            $openid = $user->openid;
            $user_integral = $user->integral; //用户 积分
            $public_id = $user->public_id;
            $count_stock = $gift_one->count_stock; //库存数量
            $gift_integral = $gift_one->integral; //需要兑换的积分
            if ($count_stock > 0) {
                if ($user_integral >= $gift_integral) {
                    //减积分 更新用户积分
                    $integral = intval($user_integral) - intval($gift_integral);
                    User::model()->updateAll(array('integral' => $integral), 'id=:id', array(':id' => $user_id));
                    //增加库存修改记录
                    $giftmodel = new GiftOperationLog;
                    $giftmodel->gift_id = $id;
                    $giftmodel->genre = 2; //减少
                    $giftmodel->score = 1;
                    $giftmodel->remark = '被兑换';
                    $giftmodel->time_created = time();
                    $giftmodel->save();
                    //修改库存 数量
                    Gift::model()->updateAll(array('count_stock' => $count_stock - 1), 'id =:id', array(":id" => $id));
                    if (!empty($nowaddress)) {
                        //记录赋值
                        $giftex->public_id = $public_id;
                        $giftex->user_id = $user_id;
                        $giftex->gift_name = $gift_one->name;
                        $giftex->gift_id = $gift_one->id;
                        $giftex->address_id = $nowaddress->id;
                        $giftex->address_sheng = $nowaddress->address_sheng;
                        $giftex->name = $nowaddress->name;
                        $giftex->address_shi = $nowaddress->address_shi;
                        $giftex->address_qu = $nowaddress->address_qu;
                        $giftex->address_other = $nowaddress->address_other;
                        $giftex->postcode = $nowaddress->postcode;
                        $giftex->mobile = $nowaddress->mobile;
                        $giftex->tel = $nowaddress->tel;
                        $giftex->mobile = $nowaddress->mobile;
                        $giftex->score = $gift_one->integral; //分值
                        $giftex->time_created = time();
                        //增加礼品兑换记录
                        if ($giftex->save()) {
                            $intearalModel = new UserIntegral;
                            $intearalModel->setAttribute('public_id', $public_id);
                            $intearalModel->setAttribute('gift_id', $gift_one->id);
                            $intearalModel->setAttribute('user_id', $user_id);
                            $intearalModel->setAttribute('type_id', 7);
                            $intearalModel->setAttribute('score', $gift_integral); //积分 固定为2分 
                            $intearalModel->setAttribute('cause', '兑换礼品扣除积分');
                            $intearalModel->setAttribute('time_created', time()); //保存当天  日期
                            if ($intearalModel->save()) {
                                Yii::app()->user->setFlash('success', "您的礼品兑换成功，我们会尽快处理，谢谢");
                                /* 兑换成功 给用户发信息 */
                                //主动发送给 邀请人信息------------------------------------开始
                                $messagecontent = '恭喜您在礼品商城使用' . @$gift_integral . '积分成功兑换到' . @$gift_one->name . '，礼品我们将在10个工作日内备货寄出，敬请期待。若您还有疑问可直接咨询微信客服，感谢您对我们的关注与支持。';
                                //得到公众号信息 
                                $access_token = 0;
                                if (!empty($public_id)) {
                                    $publicmodel = WcPublic::model()->findByPk($public_id);
                                    if (!empty($publicmodel)) {
                                        $publicArr = array(
                                            'appid' => $publicmodel->appid,
                                            'appsecret' => $publicmodel->appsecret,
                                        );
                                        $access_token = WechatStaticMethod::getAccessToken($publicArr);
                                        if ($messagecontent && !empty($openid)) {
                                            $dataProvider = array(
                                                'touser' => $openid,
                                                'msgtype' => 'text',
                                                'text' => array(
                                                    'content' => urlencode($messagecontent),
                                                ),
                                            );
                                            $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
                                            $result = WechatStaticMethod::https_request($url, urldecode(json_encode($dataProvider)));
                                        }
                                    }
                                }

                                //主动发送给 邀请人信息------------------------------------结束
                            } else {
                                Yii::app()->user->setFlash('success', "积分记录保存失败");
                            }
                        } else {
                            var_dump($giftex->errors);
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('success', "您的积分不够，不能兑换该礼品，谢谢");
                }
            } else {
                Yii::app()->user->setFlash('success', "该礼品库存不足，不能兑换，谢谢！");
            }
        }
        //查询所有分类
        $crite = new CDbCriteria();
        $crite->compare('status', 0);
        $gift_type = GiftType::model()->findAll($crite);
        $this->render('gift', array(
            'gift' => $gift,
            'user' => $user,
            'gift_type' => $gift_type,
            'gift_null' => $gift_null,
        ));
    }

    /*
     * 关于积分
     */

    public function actionAboutintegral() {
        $this->layout = '//layouts/member';
        $this->render('aboutintegral');
    }

    /*
     * 分享页面 分享给朋友的页面
     */

    public function actionSharefriend() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.basis.models.Quickmark');
        $user_id = Yii::app()->request->getParam('user_id');
        if (!empty($user_id)) {
            //查询 二维码
            $quickmoark = Quickmark::model()->find('user_id =:user_id', array(':user_id' => $user_id));
        }
        $this->render('sharefriend', array('quickmoark' => $quickmoark));
    }

    /*
     * 分享页面
     */

    public function actionShare() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.basis.models.Quickmark');
        $user_id = Yii::app()->session['userid'];
        if (empty($user_id)) {
            $user_id = Yii::app()->request->getParam('id');
        }

        if (!empty($user_id)) {
            $user = User::model()->findByPk($user_id);
            if (!empty($user)) {
                //得到公众号信息
                $publicmodel = WcPublic::model()->findByPk($user->public_id);
            }

            $quickmoark = Quickmark::model()->find('user_id =:user_id', array(':user_id' => $user_id));
            if (!empty($quickmoark)) {
                
            } else {

                $user = User::model()->findByPk($user_id);
                if (!empty($user)) {
                    //得到公众号信息
                    $publicmodel = WcPublic::model()->findByPk($user->public_id);
                }
                $publicid = $publicmodel->id;
                $wcpublic = WcPublic::model()->findByPk($publicid);
                $publicArr = array(
                    'appid' => $publicmodel->appid,
                    'appsecret' => $publicmodel->appsecret,
                );

                //创建二维码
                $model = new Quickmark;
                $model->title = $user->nickname;
                $model->description = $user->nickname . '创建';

                $model->user_id = $user_id;
                $model->public_id = $publicid;
                $model->group_id = $user->group_id;
                if ($model->save()) {
                    $scene_id = $model->id;
                    $model->scene_id = $scene_id;
                    $access_token = WechatStaticMethod::getAccessToken($publicArr);
                    //永久二维码
                    $model->action_info = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
                    $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;
                    $result = WechatStaticMethod::https_request($url, $model->action_info);
                    $jsoninfo = json_decode($result, true);
                    $model->ticket = $jsoninfo['ticket'];
                    $model->url = $jsoninfo['url'];
                    $model->action_info = serialize($model->action_info);
                    $model->path = ($model->action_name == 'QR_SCENE' ? 'upload/quickmark/temp/' : 'upload/quickmark/eternal/') . time() . '.jpg';
                    $photoPath = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($model->ticket);
                    $photoDataProvider = WechatStaticMethod::downloadImageFromWeichat($photoPath);
                    file_put_contents($model->path, $photoDataProvider['body']);

                    if ($model->save()) {
                        //生成 带logo的二维码图片   
                        $qucikname = $model->path;
                        $logopng = 'logosunli.png';
                        $logo = Yii::getPathOfAlias('webroot') . '/upload/quickmark/eternal/' . $logopng; //准备好的logo图片   
                        $QR = Yii::getPathOfAlias('webroot') . '/' . $qucikname; //已经生成的原始二维码图   
                        if (file_exists($QR)) {
                            if ($logo !== FALSE) {
                                $QR = imagecreatefromstring(file_get_contents($QR));
                                $logo = imagecreatefromstring(file_get_contents($logo));
                                $QR_width = imagesx($QR); //二维码图片宽度   
                                $QR_height = imagesy($QR); //二维码图片高度   
                                $logo_width = imagesx($logo); //logo图片宽度   
                                $logo_height = imagesy($logo); //logo图片高度   
                                $logo_qr_width = $QR_width / 3.5;
                                $scale = $logo_width / $logo_qr_width;
                                $logo_qr_height = $logo_height / $scale;
                                $from_width = ($QR_width - $logo_qr_width) / 2;
                                //重新组合图片并调整大小   
                                imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                            }
                            //输出图片   
                            imagepng($QR, Yii::getPathOfAlias('webroot') . '/' . $qucikname);
                        }

                        $quickmoark = Quickmark::model()->find('user_id=:user_id', array(':user_id' => $user_id));
                    }
                } else {
                    var_dump($model->errors);
                }
            }
        }
        $this->render('share', array('user' => $user, 'publicmodel' => $publicmodel, 'quickmoark' =>
            $quickmoark, 'user_id' => $user_id));
    }

    /*
     * 创建二维码
     */

    private function createquick() {

        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.basis.models.Quickmark');
        $user_id = Yii::app()->session['userid'];
        if (empty($user_id)) {
            $user_id = Yii::app()->request->getParam('id');
        }
        if (!empty($user_id)) {
            $user = User::model()->findByPk($user_id);
            if (!empty($user)) {
                //得到公众号信息
                $publicmodel = WcPublic::model()->findByPk($user->public_id);
            }
            //创建二维码
            $model = new Quickmark;
            $model->title = $publicmodel->nickname;
            $model->description = $publicmodel->nickname . '创建';
            $publicArr = array(
                'appid' => $publicmodel->appid,
                'appsecret' => $publicmodel->appsecret,
            );
            $publicid = Yii::app()->user->getState('public_id');
            $wcpublic = WcPublic::model()->findByPk($publicid);
            $scene_id = $user_id;
            $access_token = WechatStaticMethod::getAccessToken($publicArr);
            //永久二维码
            $model->action_info = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
            $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;
            $result = WechatStaticMethod:: https_request($url, $model->action_info);
            $jsoninfo = json_decode($result, true);
            $model->ticket = $jsoninfo['ticket'];
            $model->url = $jsoninfo['url'];
            $model->action_info = serialize($model->action_info);
            $model->path = ($model->action_name == 'QR_SCENE' ? 'upload/quickmark/temp/' : 'upload/quickmark/eternal/') . time() . '.jpg';
            $photoPath = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($model->ticket);
            // echo $photoPath;exit;
            $photoDataProvider = WechatStaticMethod:: downloadImageFromWeichat($photoPath);
            file_put_contents($model->path, $photoDataProvider['body']);
            if ($model->save()) {
                $quickmoark = Quickmark::model()->find('user_id=:user_id', array(':user_id' =>
                    $user_id));
            }
        }
    }

    /*
     * 转发 文章列表 详情页面
     */

    public function actionTransmit_detail() {
        $this->layout = '//layouts/transmit';
        Yii::import('application.modules.users.models.User');
        $id = Yii::app()->request->getParam('id');
        $openid = Yii::app()->request->getParam('openid');
        if (empty($openid)) {
            $openid = Yii::app()->session['openid'];
        }
        Yii::app()->session['openid'] = $openid;
        if (!empty($openid)) {
            //user信息
            $usermodel = User::model()->find('openid =:openid', array(':openid' => $openid));
            if (!empty($usermodel)) {
                //得到公众号信息
                $publicmodel = WcPublic::model()->findByPk($usermodel->public_id);
            }
        }

        $criteria = new CDbCriteria;
        $criteria->compare('id', $id);
        $criteria->compare('isdelete', 0);
        $model = Transmit::model()->find($criteria);
        $contnetname = $model->content;
        $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/transmit/' . $contnetname;
        //读取文件 内容
        if (file_exists($textname)) {
            $contents = file_get_contents($textname);
            $model->content = @$contents;
        }
        Transmit::model()->updateAll(array('number' => $model->number + 1), 'id=:id', array(':id' => $id));

        $this->render('transmit_detail', array('model' =>
            $model, 'publicmodel' => $publicmodel));
    }

    /*
     * 转发 文章列表
     */

    public function actionTransmit() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');

        $type_id = @$_GET['type'];
        $criteria = new CDbCriteria;
        $criteria->compare('status', 0);
        $criteria->compare('name', '有奖活动');
        $transmit_type = TransmitType::model()->find($criteria);
        $criteria = new CDbCriteria;
        if (!empty($type_id)) {
            $criteria->compare('type_id', $type_id);
        }
        $criteria->compare('isdelete', 0);
        $criteria->order = 'order_by DESC';
        $transmit = Transmit::model()->findAll($criteria);
        foreach ($transmit as $key => &$t) {
            if ($t->transmit_type->name == '活动预告') {
                $t->number = 0;
            }
        }

        $name='有奖活动';
        $typeid=$this->getIdbyname($name);//获取相关海报图片和链接
        $dataProvider= $this->getPosterbyid($typeid);

        $this->render('transmit', array('transmit_type' =>
            $transmit_type, 'transmit' => $transmit,
            'dataProvider'=>$dataProvider,
        ));
    }

    /*
     * 分享好友  添加数据库 
     */

    public function actionTransmitmsg() {
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $type = '6'; //转发  type_id 为6
        $today_date = strtotime(date('Y-m-d', time()));
        $openid = @$_POST['openid'];
        $transmit_id = $_POST['transmit_id'];
        $type_id = $_POST['type_id'];
        //echo $openid.'transmitid是'.$transmit_id;exit;
        if (!empty($openid) && !empty($transmit_id) && !empty($type_id)) {
            $usermodel = User::model()->find('openid = :openid ', array(':openid' => $openid));
            $user_id = $usermodel->id;
            $public_id = $usermodel->public_id;
            $TransmitUser = new TransmitUser; //转发用户列表
            $TransmitUser->setAttribute('transmit_id', $transmit_id);
            $TransmitUser->setAttribute('user_id', $user_id);
            $TransmitUser->setAttribute('type', $type_id); //转发 类型 1为活动
            $TransmitUser->setAttribute('remark', '转发');
            $TransmitUser->setAttribute('time_created', $today_date);
            if ($TransmitUser->save()) {//增加转发记录 
                $intearalModel = new UserIntegral;
                $intearalModel->setAttribute('public_id', $public_id);
                $intearalModel->setAttribute('transmit_id', $transmit_id);
                $intearalModel->setAttribute('user_id', @$user_id);
                $intearalModel->setAttribute('type_id', $type);
                $intearalModel->setAttribute('score', 2); //积分 固定为2分 
                $intearalModel->setAttribute('cause', '转发获得的积分');
                $intearalModel->setAttribute('time_created', $today_date); //保存当天  日期
                $UserIntegral = UserIntegral::model()->find('user_id= :user_id and transmit_id = :transmit_id', array(":user_id" => $user_id, ':transmit_id' => $transmit_id));
                if (!empty($UserIntegral)) {
                    //该文章 已增加过几分    
                    echo '转发成功！';
                } else {
                    $allintegral = UserIntegral::model()->findAll('user_id =:user_id and time_created=:time_created', array(':user_id' => $user_id, ':time_created' => $today_date));
                    if (count($allintegral) < 6) {//小于5条 也就是积分不能超过10分
                        if ($intearalModel->save()) {//增加积分记录表  一条记录
                            //更新 用户积分 
                            User::model()->updateAll(array('integral' => $usermodel->integral + 2), 'id=:id', array(':id' => $user_id));
                            echo '转发成功！恭喜您获得<span>2个积分</span>！';
                        } else {
                            print_r($intearalModel->error);
                            echo 'error1';
                        }
                    } else {
                        echo ' 转发成功！您转发的奖励积分已达到今日上限！';
                    }
                }
            } else {
                print_r($TransmitUser->error);
                echo "error2";
            }
        } else {
            echo 'openid或transmit_id为空';
        }

// echo json_encode(array('id' => $openid));
    }

    /**
     * Manages all models.
     */
    public function actionAddress() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $model = new UserAddress;
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            $model = UserAddress::model()->findByPk($id);
        }
        $gift_id = @$_GET['gift_id'];

        //查询 省 
        $districtmodel = District::model()->findAll('parent_id=:parent_id and status=:status', array(':parent_id' => '1', ':status' => '0'));
        $trantype = array();
        if (!empty($districtmodel)) {
            foreach ($districtmodel as $c) {
                $trantype[] = array("id" => $c->id, "name" => $c->name);
            }
        }
        //查询 省 结束
        if (isset($_POST['UserAddress'])) {
            $model->attributes = $_POST['UserAddress'];

            $user_id = Yii::app()->session['userid'];
            if (!empty($user_id)) {
                $model->user_id = $user_id;
// var_dump($model);exit;
                if ($model->save()) {
                    $this->redirect(array('address_list', 'gift_id' => $gift_id,));
                }
            }
        }
        $isdelete = Yii::app()->request->getParam('isdelete');
        if (!empty($isdelete) && !empty($id)) {
            UserAddress::model()->updateAll(array('isdelete' => 1), 'id=:id', array(':id' => $id));
            $this->redirect(array('address_list'));
        } $id = Yii::app()->request->getParam('id');
        $this->render('address', array(
            'trantype' => $trantype,
            'model' => $model,
        ));
    }

    /*
     * 会员尊享
     */

    public function actionMemberdeals() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $userid = Yii::app()->request->getParam('id');
        $model = new User;
        if (!empty($userid)) {
            $model = User::model()->findByPk($userid);
        }
        $this->render('memberdeals', array
            ('model' => $model));
    }

    /*
     * 摇一摇
     */

    public function actionSwing() {
        $this->layout = '//layouts/member';
        $this->render('swing');
    }

    /*
     * 会员等级说明
     */

    public function actionUserLevel() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $userid = Yii::app()->request->getParam('id');
        $model = new User;
        if (!empty($userid)) {
            $model = User::model()->findByPk($userid);
        }
        $this->render('userlevel', array
            ('model' => $model));
    }

    /*
     * 签到规则页面
     */

    public function actionAttendancerule() {
        $this->layout = '//layouts/member';

        $this->render('attendancerule');
    }

    /*
     * post修改签到
     */

    public function actionPostattendance() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        if (!empty($_POST['queryString'])) {
            $openid = $_POST['queryString'];
            if (empty($openid)) {
                $openid = Yii ::app()->session['openid'];
            }
            $yesterday = date("Y-m-d", strtotime("-1 day"));
            $intearalModel = new UserIntegral;
            $public_id = Yii::app()->session['public_id'];
            $model = User::model()->find('openid = :openid ', array(':openid' => $openid));

            //是否存在该用户
            if (!empty($model)) {
                $id = $model->id;
                $zero1 = strtotime(date("y-m-d"));
                $zero2 = $model->last_attendance_time;
                $differ = ceil(($zero1 - $zero2) / 86400);
                $type = 5; //定义签到  类型为5
                //如果有签到记录
                if (@ $differ > 0) {//时间大一天
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
                        echo $integral;
                        exit;
                    } else {
                        var_dump($intearalModel->errors);
                        exit;
                    }
                } else {
                    echo "已签到";
                    exit;
                }
            }
        }
    }

    /*
     * 签到页面
     */

    public function actionAttendance() {
        //点击签到
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');

        $openid = Yii::app()->session['openid'];
        $monthcount = 0; //本月签到次数
        if (empty($openid)) {
            $openid = Yii:: app()->request->getParam('openid');
        }
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $model = new User;
        $intearalModel = new UserIntegral;

        if (!empty($openid)) {
            $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
            $id = $model->id;
            //昨天是否签到
            $criteria = new CDbCriteria;
            $criteria->select = 'id,sign_in_count,cause';
            $criteria->compare('user_id', $id);
            $criteria->compare('type_id', 5);
            $yesterday = strtotime(date("Y-m-d", strtotime("-1 day")));
            $criteria->compare('time_created', $yesterday);
            $userintegral = UserIntegral::model()->find($criteria);
            //今天是否签到
            $criteria = new CDbCriteria;
            $criteria->select = 'id,sign_in_count,cause';
            $criteria->compare('user_id', $id);
            $today = strtotime(date('Y-m-d'));
            $criteria->compare('type_id', 5);
            $criteria->compare('time_created', $today);
            $todayuserintegral = UserIntegral::model()->find($criteria);
            //本月所有 签到
            $criteria = new CDbCriteria;
            $criteria->select = 'id,time_created';
            $criteria->compare('user_id', $id);
            $criteria->compare('type_id', 5);
            $monthuserintegral = UserIntegral::model()->findAll($criteria);
            $monthnow = strtotime(date("Y-m"));
            foreach ($monthuserintegral as $m) {
                $createmonth = strtotime(date('Y-m', $m->time_created));
                if ($monthnow == $createmonth) {
                    $monthcount = $monthcount + 1;
                }
            }
        }

        $this->render('attendance', array('openid' => $openid, 'monthcount' => @$monthcount, 'model' => $model, 'userintegral' => @$userintegral,
            'todayuserintegral' => @$todayuserintegral));
    }

    /*
     * 优惠券页面
     */

    public function actionCoupon() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $openid = $_GET['openid'];
        if (!empty($openid)) {
            $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
            if (!empty($model)) {
                $couponexchange = $this->getcouponexchange($model->id);
            }
        }
        $this->render('coupon', array(
            'couponexchange' => @$couponexchange));
    }

    /*
     * 前台首页 不用权限 查看
     */

    public function actionHomepage() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $model = new User;
        $intearalModel = new UserIntegral;
        $criteria = new CDbCriteria;
        $criteria->compare('isdelete', 0);
        $usermodule = UserModule::model()->findAll($criteria);
        $public_id = 0;
        $appId = Yii::app()->request->getparam('appid'); //接受参数appid 从链接url得到
        //appid不为空
        if (!empty($appId)) {
            Yii::app()->session['appId'] = $appId;
        } else {
            $appId = Yii::app()->session['appId'];
        }
        //根据appid查询公众号 信息
        $wcpublic = WcPublic::model()->find('appid =:appid', array
            (':appid' => $appId));

        if (!empty($wcpublic)) {
            $public_id = $wcpublic->id;
            Yii::app()->session['public_id'] = $public_id;
            $secret = $wcpublic->appsecret;
        }
        //---------------------------------------------------* 链接接口   
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
                    $usermodel = User::model()->find('openid = :openid', array(':openid' => $openid));
                    if (!empty($usermodel)) {
                        $couponexchange = $this->getcouponexchange($usermodel->id);
                        Yii::app()->session['userid'] = $usermodel->id;
                    } else {
                        $userDataProvider = $this->getUser(Yii::app()->session['public_id'], $openid);
                        Yii::app()->session['userid'] = $userDataProvider->id;
                    }
                    Yii::app()->session['openid'] = $openid;
                    Yii::app()->user->setFlash('openid', $openid);
                }
            };
        }
//-------------------------------------------------------* 签到 结束
        // $openid = @Yii::app()->session['openid'];
        if (Yii::app()->user->hasFlash('openid')) {
            $openid = Yii::app()->user->getFlash('openid');
        } if (!empty($openid)) {
            Yii::app()->user->setFlash('openid', $openid);
            $model = User::model()->find('openid=:openid', array(':openid' => $openid));
            if (!empty($model)) {
                $couponexchange = $this->getcouponexchange($model->id);
            }
        }
        $this->render('homepage', array(
            'model' => $model,
            'appId' => $appId,
            'usermodule' => $usermodule,
            'couponexchange' => @$couponexchange,
        ));
    }

    /*
     * 个人中心页面
     */

    public function actionUser() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        $openid = $_GET['openid'];
        $model = new User;
        if (!empty($openid)) {
            $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
        }
        $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
        $couponexchange = $this->getcouponexchange($model->id);
        $this->render('user', array('model' => $model,
            'couponexchange' => $couponexchange));
    }

    /*
     * 个人资料详细页面
     */

    public function actionUserData() {
        $this->layout = '//layouts/member';
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $this->districtArr = PublicStaticMethod::getDistrictDataProvider();
        $openid = @$_GET['openid'];
        $model = new User;
        $userdetail = new UserDetail;
        if (!empty($openid)) {
            $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
            $userdetail = UserDetail::model()->find('openid = :openid ', array(':openid' => $openid));
        }
        if (isset($_POST['User'])) {
            if (empty($userdetail)) {
                $userdetail = new UserDetail;
            }
            $userdetail->openid = $openid;
            $userdetail->attributes = $_POST['User'];
            if (!empty($_POST['User']['mobile'])) {
                $userdetail->mobile = $_POST['User']['mobile'];
            }if (!empty($_POST['User']['age'])) {
                $userdetail->age = $_POST['User']['age'];
            }if (!empty($_POST['User']['sex'])) {
                $userdetail->sex = $_POST['User']['sex'];
            }if (!empty($_POST['User']['province'])) {
                $userdetail->province = $_POST['User']['province'];
            }if (!empty($_POST['User']['city'])) {
                $userdetail->city = $_POST['User']['city'];
            }if (!empty($_POST['User']['district'])) {
                $userdetail->district = $_POST['User']['district'];
            }
            if ($userdetail->save()) {
                //增加积分
                if (!empty($model)) {
                    $userintefral = UserIntegral::model()->find('user_id = :user_id and type_id = :type_id', array(':user_id' => $model->id, ':type_id' => 4));
                    if (empty($userintefral)) {
                        $userintefral = new UserIntegral;
                        $userintefral->user_id = $model->id;
                        $userintefral->public_id = $model->public_id;
                        $userintefral->type_id = 4;
                        $userintefral->score = 30;
                        $userintefral->cause = '完善个人资料';
                        $userintefral->status = 0;
                        $userintefral->time_created = time();
//积分记录 增加积分
                        if ($userintefral->save()) {
//用户总分 user 表增加记录
                            $integral = $model->integral + 30;
                            User::model()->updateAll(array('integral' => $integral), 'id=:id', array(':id' => $model->id));
                        } else {
                            var_dump($userintefral->errors);
                            exit;
                        }
                    }
                }
            } else {
                var_dump($userdetail->errors);
                exit;
            }
        }
//查询 省 
        $districtmodel = District::model()->findAll('parent_id=:parent_id and status=:status', array(':parent_id' => '1', ':status' => '0'));
        $trantype = array();
        if (!empty($districtmodel)) {
            foreach ($districtmodel as $c) {
                $trantype[] = array("id" => $c->id, "name" => $c->name);
            }
        }
        $model = User::model()->find('openid = :openid ', array(':openid' => $openid));
        $this->render('userdata', array('model' => $model, 'trantype' =>
            $trantype, 'userdetail' => $userdetail));
    }

    /*
     * 删除 
     */

    public function actionDelete($id) {
        if (!empty($id)) {
            UserModule::model()->updateAll(array('isdelete' => '1'), 'id=:id', array
                (':id' => $id));
        }
        $this->redirect(array('index'));
    }

    public function actionIndex() {
        $model = new UserModule('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
        $criteria->compare('isdelete', 0);
        $criteria->order = 'order_by ASC';
        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $this->render('index'
                , array('dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new UserModule('search');
// $model = Transmit::model()->findAll('status=:status', array(':status' => '0'));
//$model->unsetAttributes();  // clear any default values
        $districtmodel = District::model()->findAll('parent_id=:parent_id and status=:status', array(':parent_id' => '1', ':status' => '0'));
        $trantype = array();
        if (!empty($districtmodel)) {
            foreach ($districtmodel as $t) {
                $trantype[$t->id] = $t->name;
            }
        }
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            $criteria = new CDbCriteria;
            $criteria->compare('user_id', $id);
            $transmituser = TransmitUser::model()->findAll($criteria);
            Yii::import('application.modules.users.models.User');
            $user = User::model()
                    ->findByPk($id);
        }
        if (isset($_GET['UserModule']))
            $model->attributes = $_GET['UserModule'];
        $this->render('admin', array(
            'model' => $model,
            'trantype' => $trantype,
            'transmituser' => $transmituser,
            'user' => $user,
        ));
    }

    /*
     * 新建 转发新闻 
     */

    public function actionCreate() {
        $model = new UserModule;

// Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['UserModule'])) {
            $model->attributes = $_POST['UserModule'];
            $model->public_id = Yii::app()->user->public_id;
//从图库选择的图片 赋值
            if (!empty($_POST['UserModule']['bg_img'])) {
                $imgname = @$_POST['UserModule']['bg_img'];
                $model->setAttribute('bg_img', $imgname);
                if ($model->save()) {
                    $this->redirect(array('index'));
                } else {
                    print_r($model->errors);
                    exit;
                }
            }
//上传图片
            else {
                $files = CUploadedFile::getInstance($model, 'files');
                if (@$files->size > 2097152) {
//超过2M  
                    Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
                } else {
                    $filename = PublicStaticMethod::generateFileName();
                    if (is_object($files) && get_class($files) === 'CUploadedFile') {
                        $filename = PublicStaticMethod::generateFileName();

                        if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
                            PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
                            $model->setAttribute('bg_img', @$filename . '.' . $files->extensionName);
                            $extensionName = $files->extensionName;

                            if ($model->save()) {
                                $model = new SourceFile();
                                $model->attributes = $_POST['UserModule'];
                                $model->setattribute('type', '2');
                                $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                                $model->setattribute('filename', $filename);
                                $model->setattribute('ext', $files->extensionName);
                                PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                                if ($model->save()) {
                                    $this->redirect(array('index'));
                                }
                            } else {
                                var_dump($model->errors);
                                exit;
                            }
                        }
                    }
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /*
     * 修改 
     */

    public function actionUpdate($id = 0) {
//$id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            $model = $this->loadModel($id);
        } else {
            $model = new UserModule;
        }
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        if (isset($_POST['UserModule'])) {
            $model->attributes = $_POST['UserModule'];

//从图库选择的图片 赋值
            if (!empty($_POST['UserModule']['bg_img'])) {
                $imgname = @$_POST['UserModule']['bg_img'];
                $model->setAttribute('bg_img', $imgname);
//   $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
            }
//上传图片
            $files = CUploadedFile::getInstance($model, 'files');
            if (@$files->size > 2097152) {
//超过2M  
                Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
            } else {
                $filename = PublicStaticMethod::generateFileName();
                if (is_object($files) && get_class($files) === 'CUploadedFile') {
                    $filename = PublicStaticMethod::generateFileName();
                    if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
                        PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
                        $model->setAttribute('bg_img', @$filename . '.' . $files->extensionName);
                        $extensionName = $files->extensionName;
                        if ($model->save()) {
                            $model = new SourceFile();
                            $model->attributes = $_POST['UserModule'];
                            $model->setattribute('type', '2');
                            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                            $model->setattribute('filename', $filename);
                            $model->setattribute('ext', $files->extensionName);
                            PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                            if ($model->save()) {
                                $this->redirect(array('index'));
                            }
                        }
                    }
                }
            }
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->render('update', array
            (
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);

        $model = UserModule::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException
            (404, '请求的页面不存在。');
        return $model;
    }

//index 页面ajax 修改内容 GIFT
    public function actionAjaxUpdate() {
        $id = $_POST['id'];
        $data_name = $_POST ['data_name'];
        $value = $_POST['value'];
        if ($id && $data_name && $value) {
            if ($data_name == 'data-title') {
                $data['title'] = $value;
            } else if ($data_name == 'data-url') {
                $data['url'] = urlencode($value);
            } else if ($data_name = 'data-orderby') {
                $data['order_by'] = $value;
            }
            UserModule::model()->updateAll($data, 'id=:id', array(':id' => $id));

            echo 'success';
        }
    }

    /*
     * 根据id 查询二级地址
     */

    public function actionChildDistrict() {
        $id = @$_POST['id'];
        if (!empty($id)) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,name,status';
            $criteria->compare('parent_id', $id);
            $criteria->compare('status', 0);
            $childtype = District::model()->findAll($criteria);
            $childdistrict = array();
            if (!empty($childtype)) {
                foreach ($childtype as $c) {
                    $childdistrict[] = array("id" => $c->id, "name" => $c->name);
                }
            }
            echo json_encode($childdistrict);
        }
    }

    /* ------------------------------------非Action部分------------------------------------------ */

    protected function getcouponexchange($userid) {
        return CouponExchange::model()->findAll('user_id = :user_id and isdelete = :isdelete', array(
                    ':user_id' => $userid, ':isdelete' => 0));
    }

    /**
     * 给用户赋值国家
     */
    protected function country($data, $row) {
        return isset($this->districtArr[$data->country]) ? $this->districtArr[$data->country] : '';
    }

    /**
     * 给用户赋值省份
     */
    protected function province($data, $row) {
        return isset($this->districtArr[$data->province]) ? $this->districtArr[$data->province] : '';
    }

    /**
     * 给用户赋值城市
     */
    protected function city($data, $row) {
        return isset($this->districtArr[$data->city]) ? $this->districtArr[$data->city] : '';
    }

    /**
     * 给用户赋值 区县
     */
    protected function district($data, $row) {
        return isset($this->districtArr[$data->district]) ? $this->districtArr[$data->district] : '';
    }

    /**
     * 给用户赋值等级
     */
    protected function level($data, $row) {
        return isset($this->levelArr[$data->level]) ? $this->levelArr[$data->level] : '';
    }

    /**
     * 给用户赋值分组
     */
    protected function group($data, $row) {
        return isset($this->groupArr[$data->group_id]) ? $this->groupArr[$data->group_id] : '';
    }

    protected function headimgurl($data, $row) {
        if ($data->headimgurl) {
            return $data->subscribe ? "<span class=\"subscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/subscribe.png", "关注中", array("class" => "sub_image")) . CHtml::image(substr($data->headimgurl, 0, -1) . "64") .
                    "</span>" : "<span class=\"unsubscribe\">" . CHtml:: image(Yii:: app()->baseUrl
                            . "/images/unsubscribe.png", "已取消关注", array("class" => "sub_image")) . CHtml::image(substr($data->headimgurl, 0, -1) . "64") . "</span>";
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
        if (!empty($public_id)) {
            $publicmodel = WcPublic::model()->findByPk($public_id);
            $publicArr = array(
                'appid' => $publicmodel->appid,
                'appsecret' => $publicmodel->appsecret,
            );
            $this->_ACCESS_TOKEN = WechatStaticMethod::getAccessToken($publicArr); //获取access_token
            $criteria = new CDbCriteria();
            $criteria->select = 'id,nickname,subscribe,subscribe_time';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('openid', $openid);
            $criteria->compare('isdelete', 0);
            $model = User::model()->find($criteria);
            if ($model === null) {
//从微信服务器获取客户资料
                $infoUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$this->_ACCESS_TOKEN&openid=$openid&lang=zh_CN"; //获得用户数据
                $dataProvider = json_decode(WechatStaticMethod::https_request($infoUrl), true);

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
        $district = PublicStaticMethod:: getDistrictDataProvider();
        $model->country = array_search($model->country, $district);
        $model->country = $model->country ? $model->country : 0;
        $model->province = array_search($model->province, $district);
        $model->province = $model->province ? $model->province : 0;
        $model->city = array_search($model->city, $district);
        $model->city = $model->city ? $model->city : 0;
        $model->status = 1; //表示已经获取用户信息
        if ($model->save()) {
            return $model->attributes; //返回用户资料 
        }
    }

}
