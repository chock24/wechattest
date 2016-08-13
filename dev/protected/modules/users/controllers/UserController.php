<?php

class UserController extends Controller {

    private $districtArr = array(); //定义地区数组
    protected $groupArr = array(); //定义分组数组
    public $levelArr = array(); //定义等级数组

    /**
     * @return array action filters
     */

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('admin', 'import', 'level', 'tag', 'integral', 'remark', 'star', 'mobile', 'age', 'sex', 'group', 'language', 'headimage', 'refresh', 'updateusergroup','showAccesstoken'),
                'roles' => array('1', '2', '3'),
            ),
            array('allow', // 登录后才能进行的操作
                'actions' => array('view', 'sourcefile'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id, $order = '') {
        $messageModel = new Message();

        $model = $this->loadModel($id);
        $this->districtArr = PublicStaticMethod::getDistrictDataProvider();
        $userModel['user'] = $model;
        //將未读的消息转为已读
        Message::model()->updateAll(array('status' => 0), 'user_id=:user_id AND public_id=:public_id AND status=:status AND isdelete=:isdelete', array(':user_id' => $id, ':public_id' => Yii::app()->user->getState('public_id'), ':status' => 1, ':isdelete' => 0));
        $criteria = new CDbCriteria;
        $criteria->select = 'id,format,type,receive,auto,user_id,content,title,description,url,picurl,createtime,remark,star,multi,source_file_id,menutype,menukey';
        if (!empty($_GET['Message']['content'])) {
            $criteria->compare('content', $_GET['Message']['content'], true);
        }

        /* ------------------按条件筛选消息------------------ */
        if ($order == 'remark') {
            $criteria->order = '`id` DESC';
            $criteria->addCondition('remark!=""', 'AND');
            $criteria->addCondition('user_id=:user_id', 'AND');
        } elseif ($order == 'old') {
            $criteria->order = '`id` ASC';
            $criteria->addCondition('user_id=:user_id', 'AND');
        } elseif ($order == 'star') {
            $criteria->order = '`id` DESC';
            $criteria->addCondition('star=1', 'AND');
            $criteria->addCondition('user_id=:user_id', 'AND');
        } else {
            $criteria->order = '`id` DESC';
            $criteria->addCondition('user_id=:user_id', 'AND');
        }

        if (isset($_GET['remark'])) {
            $criteria->compare('remark', $_GET['remark'], true);
        }
        if (isset($_GET['filtershow'])) {
            foreach ($_GET['filtershow'] as $value) {
                if ($value == 1) {
                    $criteria->compare('auto', 1);
                }
                if ($value == 2) {
                    $criteria->compare('type', 8);
                }
            }
        }
        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 1) {
                $criteria->compare('auto', '!=1');
            } elseif ($_GET['filter'] == 2) {
                $criteria->compare('type', '!=8');
            }
        }

        $criteria->params += array(
            ':user_id' => $id,
        );
        $dataProvider = new CActiveDataProvider('Message', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
        /* -------------------------回复信息-------------------------- */
        if (isset($_POST['Message'])) {
            $multi = $_POST['Message']['multi'] ? $_POST['Message']['multi'] : 0;
            $source_file_id = $_POST['Message']['source_file_id'] ? $_POST['Message']['source_file_id'] : '0';
            $messagecontent = @$_POST['Message']['content'];
            $messageModel->setAttribute('tousername', $model->openid);
            $messageModel->setAttribute('source_file_id', intval($source_file_id));
            $messageModel->setAttribute('multi', $_POST['Message']['multi'] ? $_POST['Message']['multi'] : 0);
            $role_id = Yii::app()->user->getState('roles');
            //判断 是否 为 客服
            if ($role_id == 4) {
                //根据用户id查询 public 信息
                $usermodel = User::model()->findByPk($id);
                if (!empty($usermodel)) {
                    $public_id = $usermodel->public_id;
                    if (!empty($public_id)) {
                        $wcpublicmodel = WcPublic::model()->findByPk($public_id);
                        if (!empty($wcpublicmodel)) {
                            //得到 原本的username
                            $fromusername = $wcpublicmodel->original;
                            $publicArr = array(
                                'appid' => $wcpublicmodel->appid,
                                'appsecret' => $wcpublicmodel->appsecret,
                            );
                        }
                    }
                }
                $messageModel->setAttribute('fromusername', $fromusername);
                $messageModel->setAttribute('public_id', $public_id);

                //如果 是公众号 操作
            } else {
                $messageModel->setAttribute('fromusername', Yii::app()->user->getState('public_original'));
                $messageModel->setAttribute('public_id', Yii::app()->user->getState('public_id'));
                //如果 是公众号 操作
                $publicArr = array(
                    'appid' => Yii::app()->user->getState('public_appid'),
                    'appsecret' => Yii::app()->user->getState('public_appsecret'),
                );
            }
            $messageModel->setAttribute('user_id', $model->id);
            $messageModel->setAttribute('receive', 2); //发出
            $messageModel->setAttribute('auto', 2); //手动
            $messageModel->setAttribute('type', $_POST['Message']['type'] ? $_POST['Message']['type'] : 1); //信息类型

            $messageModel->setAttribute('createtime', time());
            $messageModel->setAttribute('content', $_POST['Message']['content']);
            if ($messageModel->save()) {
                //如果管理员 操作代替 公众号 回复
                $access_token = WechatStaticMethod::getAccessToken($publicArr);
                if ($messagecontent) {
                    $dataProvider = array(
                        'touser' => $model->openid,
                        'msgtype' => 'text',
                        'text' => array(
                            'content' => urlencode($messageModel->content),
                        ),
                    );
                } else {
                    $mtype = @$_POST['Message']['type'];
                    if ($mtype == 2) {//图片文件
                        $wechatInfo = $this->returnPart($source_file_id, $mtype); //返回微信端数据
                        $dataProvider = array(
                            'touser' => $model->openid,
                            'msgtype' => 'image',
                            'image' => array(
                                'media_id' => $wechatInfo['media_id'],
                            ),
                        );
                    } else if ($mtype == 3) {//音频文件
                        $wechatInfo = $this->returnPart($source_file_id, $mtype); //返回微信端数据
                        $dataProvider = array(
                            'touser' => $model->openid,
                            'msgtype' => 'voice',
                            'voice' => array(
                                'media_id' => $wechatInfo['media_id'],
                            ),
                        );
                    } else if ($mtype == 4) {//视频文件
                        $wechatInfo = $this->returnPart($source_file_id, $mtype); //返回微信端数据
                        $dataProvider = array(
                            'touser' => $model->openid,
                            'msgtype' => 'video',
                            'video' => array(
                                'media_id' => $wechatInfo['media_id'],
                            ),
                        );
                    } else if ($mtype == 5) {
                        $dataProvider = array();
                        $dataProvider['touser'] = $model->openid;
                        $dataProvider['msgtype'] = 'news';
                        $dataProvider['news'] = array(
                            'articles' => $this->searchSourceFile($source_file_id, $multi),
                        );
                    }
                }
                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
                $result = WechatStaticMethod::https_request($url, urldecode(json_encode($dataProvider)));
                $this->refresh();
            } else {
                var_dump($messageModel->errors);
                exit;
            }
        }
        /* -------------------------回复信息-------------------------- */

        $this->render('view', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'userModel' => $userModel,
            'messageModel' => $messageModel,
        ));
    }

    /**
     * 返回图片 信息部分
     * @param int $id
     */
    private function returnPart($id = 0, $type = 0) {
        $dataProvider = array();
        $criteria = new CDbCriteria();
        $criteria->select = array(
            'id',
            'type',
            'title',
            'filename',
            'ext',
        );
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $model = SourceFile::model()->findByPk($id, $criteria);

        $criteria = new CDbCriteria();
        $criteria->select = 'media_id';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('source_file_id', $id);
        $criteria->compare('type', $type);
        $criteria->compare('isdelete', 0);
        $criteria->order = '`time_created` DESC';
        $media = MediaId::model()->find($criteria);
        if ($model !== null) {//如果素材存在
            if ($media !== null) {//如果media存在
                $dataProvider['media_id'] = $media->media_id;
                $dataProvider['title'] = $model->title;
            } else {
                $publicArr = array(
                    'appid' => Yii::app()->user->getState('public_appid'),
                    'appsecret' => Yii::app()->user->getState('public_appsecret'),
                );
                $access_token = WechatStaticMethod::getAccessToken($publicArr);
                //图片类型
                if ($type == 2) {
                    //上传图片 永久素材
                    // $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=" . $access_token;
                    //上传 为临时图片
                    $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $access_token . "&type=image";
                    $postArr = array();
                    if (class_exists('\CURLFile', FALSE)) {
                        $postArr['media'] = new CURLFile(PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'image', 'source'));
                    } else {
                        $postArr['media'] = '@' . PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'image', 'source');
                    }
                    $result = WechatStaticMethod::https_request($url, $postArr);
                    $result = json_decode($result, true);
                    if (isset($result['media_id'])) {
                        $media = new MediaId();
                        $media->type = $model->type;
                        $media->source_file_id = intval($model->id);
                        $media->media_id = $result['media_id'];
                        $media->media_create_time = $result['created_at'];
                        //返回url 未保存$result['url'];
                        if ($media->save()) {
                            $dataProvider['media_id'] = $media->media_id;
                            $dataProvider['title'] = $model->title;
                        }
                    } else {
                        if ($result['errcode'] == '40006') {
                            echo '不合法的文件大小';
                            exit;
                        }
                        return false;
                    }
                }
            }
        }

        return $dataProvider;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $model->_select = 'id,star,subscribe,headimgurl,nickname,group_id,level,integral,mobile,subscribe_time,province,city';
        $model->public_id = Yii::app()->user->getState('public_id');
        $this->districtArr = PublicStaticMethod::getDistrictDataProvider();

        $groupCriteria = new CDbCriteria();
        $groupCriteria->select = 'id,name';
        $groupCriteria->compare('public_id', $model->public_id);
        $groupCriteria->compare('isdelete', 0);
        $userGroupDataProvider = UserGroup::model()->findAll($groupCriteria);
        foreach ($userGroupDataProvider as $value) {
            $this->groupArr[$value->id] = $value->name;
        }
        $levelCriteria = new CDbCriteria();
        $levelCriteria->select = 'id,title';
        $levelCriteria->compare('public_id', $model->public_id);
        $levelCriteria->compare('isdelete', 0);
        $levelDataProvider = UserLevel::model()->findAll($levelCriteria);
        foreach ($levelDataProvider as $value) {
            $this->levelArr[$value->id] = $value->title;
        }

        if (isset($_GET['User'])) {
            $model->attributes = $_GET['User'];
            
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 將关注用户导入到我们自己的库
     */
    public function actionImport() {
        $nextopenid = $_GET['nextopenid'];
        if (empty($nextopenid)) {
            if ($this->downloadOpenId()) {
                Yii::app()->user->setFlash('success', '成功从微信服务器下载用户，如果用户的资料还未显示的话，请您耐心等候，程序正在处理中。');
            } else {
                Yii::app()->user->setFlash('error', '数据导入失败，请您检查公众号是否开启开发模式，appid和appsecret是否正确，如果以上都无误，请您退出网站在登录一次重试。');
            }
        }
        $this->redirect(array('user/admin'));
    }

    /*
     * 给用户设等级方法
     */

    public function actionLevel($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->save();
            echo @$model->levels->title;
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'level',
            ));
        }
    }

    /*
     * 给用户加标签方法
     */

    public function actionTag($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        $model->tag = array();
        $criteria = new CDbCriteria();
        $modelUserTagRelation = UserTagRelation::model()->findAll('user_id=:user_id', array(':user_id' => $id));
        if ($modelUserTagRelation !== null) {
            foreach ($modelUserTagRelation as $value) {
                $model->tag[] = $value->tag_id;
            }
        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            foreach ($_POST['User']['tag'] as $value) {
                $modelTag = UserTag::model()->findByPk($value);
                $modelTag->frequency += 1;
                $modelTag->save();
                $modelUserTagRelation = UserTagRelation::model()->deleteAll('user_id=:user_id', array(':user_id' => $id));
                if ($modelUserTagRelation) {
                    $modelUserTagRelation = new UserTagRelation();
                    $modelUserTagRelation->user_id = $id;
                    $modelUserTagRelation->tag_id = $modelTag->id;
                    $modelUserTagRelation->save();
                }
            }
        }
        $this->render('update', array(
            'model' => $model,
            'action' => 'tag',
        ));
    }

    /*
     * 给用户设积分方法
     */

    public function actionIntegral($id) {
        $this->layout = '//layouts/operation';
        $model = new UserIntegral();
        $modelUser = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['UserIntegral'])) {
            $model->attributes = $_POST['UserIntegral'];
            $model->user_id = $id;
            if ($model->save()) {
                $modelUser->integral += $model->value;
                $modelUser->save();
                echo $modelUser->integral;
            }
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'integral',
            ));
        }
    }

    /*
     * 给用户加备注方法
     */

    public function actionRemark($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            //查询 时候存在重复 并删除 -------开始
            $criteria = new CDbCriteria();
            $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
            $criteria->compare('isdelete', 0);
            $criteria->compare('openid', $model->openid);
            $alluser = User::model()->findAll($criteria);
            $userid = 0;
            if (count($alluser) > 1) {
                foreach ($alluser as $u) {
                    $userid = $u->id;
                }
                //修改 重复 isdelete 为1
                if (!empty($userid) && $userid > 0) {
                    User::model()->updateAll(array('isdelete' => '1', 'openid' => '1'), 'id = :id', array(':id' => $userid));
                }
            }
            //查询 时候存在重复 并删除 -------结束
            $model->remark = $_POST['User']['remark'];
            $model->save();
            $statusid = @Yii::app()->request->getParam('status');
            if (!empty($statusid)) {
                $this->redirect(array('admin'));
            }
            $this->redirect(array('view', 'id' => $id));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'remark',
            ));
        }
    }

    /*
     * 给用户备注手机号码方法
     */

    public function actionMobile($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->mobile = $_POST['User']['mobile'];
            $model->save();
            $this->redirect(array('view', 'id' => $id));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'mobile',
            ));
        }
    }

    /*
     * 给用户备注年龄方法
     */

    public function actionAge($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->age = $_POST['User']['age'];
            $model->save();
            //echo $model->age;
            $this->redirect(array('view', 'id' => $id));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'age',
            ));
        }
    }

    /*
     * 修改语言
     */

    public function actionlanguage($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->language = $_POST['User']['language'];
            $model->save();
            //echo $model->language;
            $this->redirect(array('view', 'id' => $id));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'language',
            ));
        }
    }

    /*
     * 给用户备注性别方法
     */

    public function actionSex($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->sex = $_POST['User']['sex'];
            $model->save();
            //echo Yii::app()->params->SEX[$model->sex];
            $this->redirect(array('view', 'id' => $id));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'sex',
            ));
        }
    }

    /*
     * 给用户备注性别方法
     */

    public function actionGroup($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['User'])) {
            $model->group_id = $_POST['User']['group_id'];
            $model->save();
            $statusid = @Yii::app()->request->getParam('status');
            if (!empty($statusid)) {
                $this->redirect(array('admin'));
            }
            $this->redirect(array('view', 'id' => $id));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'group',
            ));
        }
    }

    /*
     * 给用户加星标方法
     */

    public function actionStar($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $model->star = Yii::app()->request->getParam('accept');
        $model->save();
        $this->redirect(array('user/admin'));
    }

    /*
     * 给用户加星标方法
     */

    public function actionHeadimage($id) {
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        echo CHtml::image(substr($model->headimgurl, 0, -1) . "64");
    }

    /**
     * 更新用户的数据
     */
    public function actionRefresh($id) {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );

        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $model = $this->loadModel($id);
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$model->openid&lang=zh_CN";
        $result = WechatStaticMethod::https_request($url);
        $dataProvider = json_decode($result, true);
        $model->subscribe = $dataProvider['subscribe'];
        $model->openid = $dataProvider['openid'];
        $model->nickname = $dataProvider['nickname'];
        $model->sex = $dataProvider['sex'];
        $model->language = $dataProvider['language'];
        $model->city = $dataProvider['city'];
        $model->province = $dataProvider['province'];
        $model->country = $dataProvider['country'];
        $model->headimgurl = $dataProvider['headimgurl'];
        $model->subscribe_time = $dataProvider['subscribe_time'];
        $model->remark = $model->remark ? $model->remark : $dataProvider['remark'];

        $district = PublicStaticMethod::getDistrictDataProvider();
        $model->country = array_search($model->country, $district);
        $model->country = $model->country ? $model->country : 0;
        $model->province = array_search($model->province, $district);
        $model->province = $model->province ? $model->province : 0;
        $model->city = array_search($model->city, $district);
        $model->city = $model->city ? $model->city : 0;

        if (!$model->save()) {
            print_r($model->errors);
        }
        $this->redirect(array('user/admin'));
    }

    public function actionRefreshall($id,$publicid){

    }
    /*
     * 查询单图文 多图文
     */

    public function actionSourcefile() {

        $this->layout = '//layouts/operation';
        if (Yii::app()->request->getParam('multi')) {
            $model = new SourceFileGroup();
            $model->_select = 'id,title,time_created,description';
            if (isset($_GET['SourceFileGroup'])) {
                $model->attributes = $_GET['SourceFileGroup'];
            }
        } else {
            $model = new SourceFile();
            $model->_select = 'id,title,filename,ext,time_created,description,type';
            if (isset($_GET['SourceFile'])) {
                $model->attributes = $_GET['SourceFile'];
            }
            $model->type = Yii::app()->request->getParam('type');
        }
        $role_id = Yii::app()->user->getState('roles');
        if ($role_id == 4) {
            $public_id = '1';
        } else {
            $public_id = Yii::app()->user->getState('public_id');
        }
        $model->public_id = $public_id;
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 10;
        $dataProvider = $model->getData();
        $sourceFileGather = PublicStaticMethod::getSourceFileGather($public_id, Yii::app()->request->getParam('type'), Yii::app()->request->getParam('multi'));
        $this->render('//library/content', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /* ------------------------------------非Action部分------------------------------------------ */

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
            return $data->subscribe ? "<span class=\"subscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/subscribe.png", "关注中", array("class" => "sub_image")) . CHtml::image(substr($data->headimgurl, 0, -1) . "64") . "</span>" : "<span class=\"unsubscribe\">" . CHtml::image(Yii::app()->baseUrl . "/images/unsubscribe.png", "已取消关注", array("class" => "sub_image")) . CHtml::image(substr($data->headimgurl, 0, -1) . "64") . "</span>";
        }
    }

    /**
     * 得到省份的数组
     * @return object
     */
    protected function getProvinceArr() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name';
        $criteria->compare('parent_id', 1);
        $criteria->compare('isdelete', 0);
        return District::model()->findAll($criteria);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $model = User::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '对不起，没有这个用户。');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * 修改用户分组
     */
    public function actionUpdateusergroup() {
        $group_id = @$_POST['clientIdArr'];
        $ids = @$_POST['groupId'];
        $id = explode(',', $ids);
        if (count($id) == '1') {
            User::model()->updateAll(array('group_id' => $group_id), 'id=:id', array(':id' => $ids));
        } else {
            foreach ($id as $i) {
                User::model()->updateAll(array('group_id' => $group_id), 'id=:id', array(':id' => $i));
            }
        }
    }

    private function downloadOpenId(&$next_openid = '') {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);

        /* ---------------------第一次从微信服务器下载数据---------------------- */
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$next_openid";
        $dataProvider = WechatStaticMethod::https_request($url);
        $dataProvider = json_decode($dataProvider, true);
        if (isset($dataProvider['data']) && isset($dataProvider['data']['openid'])) {

            foreach ($dataProvider['data']['openid'] as $key => $value) {
                $model = new User();
                $model->public_id = Yii::app()->user->getState('public_id');
                $model->openid = $value;
                $model->save();
            }
        } else {
            return false;
        }
        if (isset($dataProvider['next_openid']) && !empty($dataProvider['next_openid'])) {
            //$this->downloadOpenId($dataProvider['next_openid']);
            echo $dataProvider['next_openid'];
            exit;
            //   return true;
        }
    }

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
        $dataProvider = array();
        if (is_array($sourceFile) && !empty($sourceFile)) {
            foreach ($sourceFile as $key => $value) {
                $dataProvider[$key]['title'] = urlencode($value['title']);
                $dataProvider[$key]['description'] = urlencode($value['description']);

                $dataProvider[$key]['url'] = Yii::app()->createAbsoluteUrl('site/view', array('id' => $value['id']));

                $fileSize = $key ? 'thumb' : 'medium'; //判断是否是封面
                $dataProvider[$key]['picurl'] = PublicStaticMethod::returnSourceFile($value['filename'], $value['ext'], 'image', $fileSize);
            }
            return $dataProvider;
        }
    }

}
