<?php

class MessageController extends Controller {

    public $userArr = array();

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /* 查询素材方法 */

    public function actionSourcefile() {

        $this->layout = '//layouts/operation';
        if (Yii::app()->request->getParam('multi')) {
            $model = new SourceFileGroup();
            $model->_select = 'id,title,time_created,description';
            if (isset($_GET['SourceFileGroup'])) {
                $model->attributes = $_GET['SourceFileGroup'];
            }
            //
        } else {
            $model = new SourceFile();
            $model->_select = 'id,title,filename,ext,time_created,description';
            if (isset($_GET['SourceFile'])) {
                $model->attributes = $_GET['SourceFile'];
            }
            $model->type = Yii::app()->request->getParam('type');
        }

        $model->public_id = Yii::app()->user->getState('public_id');
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 10;
        $dataProvider = $model->getData();

        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), Yii::app()->request->getParam('type'), Yii::app()->request->getParam('multi'));

        $this->render('//library/content', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('index', 'admin', 'remark', 'star', 'create', 'sourcefile'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $admin_id = Yii::app()->user->id;
        $public_id = Yii::app()->user->getState('public_id');

        $time_start=$_GET['Message']['time_start'];
        $time_end  =$_GET['Message']['time_end'];

        //将 未读信息 改为已读
        Message::model()->updateAll(array('status' => '0'), 'public_id = :public_id and status = :status', array(':public_id' => $public_id, ':status' => 1));
       // $model = new Message('search');
        $model = new Message();
       // $model->unsetAttributes();  // clear any default values
        /*if (isset($_GET['Message'])) {
            $model->attributes = $_GET['Message'];
        }*/
        $adminmodel = Admin::model()->findByPk($admin_id);
        //查询 id集合 -------------开始
        $ids = array();
        $date_num = 0;
        //var_dump($_GET['date']);exit;
        $db = Yii::app()->db;
    if(empty($_GET['Message'])){
        if (!empty($_GET['date'])) {
            $date_num = $_GET['date'];
            if ($date_num == 1) {  //30天内
                $date_time = strtotime("last month");
            } else if ($date_num == 2) {//5天内
                $date_time = strtotime("-5 day");
            } else if ($date_num == 3) {//今天
                $date_time = strtotime(date('Y-m-d', time()));
            } else if ($date_num == 4) {//昨天
                $date_time = strtotime(date('Y-m-d', time())) - 24 * 3600;
            } else if ($date_num == 5) {//前天至今
                $date_time = strtotime(date('Y-m-d', time())) - 2 * 24 * 3600;
            } else if ($date_num == 6) {
                $date_time = strtotime("last month");
            }
        }

        $now_date = $date_time;
        $today_date = $now_date + (24 * 3600);
        $sql = "select MAX(id) as id,user_id,fromusername from wc_message WHERE isdelete=0  AND receive=1 AND time_created ";

            if ($date_num == '6') {
                $sql = $sql . " < " . $date_time;
            } else if ($date_num == '1' || $date_num == '2') {
                $sql = $sql . " > " . $date_time;
            } else if ($date_num >= '3' && $date_num <= '5') {
                $sql = $sql . " > " . $now_date . ' AND time_created < ' . $today_date;
            } else {//默认查询今天
                $sql = $sql . " > " . strtotime(date('Y-m-d', time()));
            }
        }else {

        $sql = "select MAX(id) as id,user_id,fromusername from wc_message WHERE isdelete=0  AND receive=1 AND time_created ";
        if (!empty($time_start) && !empty($time_end)) {
            $start = strtotime($time_start);
            $end = strtotime($time_end) + 3600 * 24;
            $sql = $sql . " > " . $start . ' AND time_created <' . $end;
        }

    }
        $sql = $sql . " AND  public_id =:public_id GROUP BY user_id";

        $results = $db->createCommand($sql)->query(array(
            ':public_id' => $public_id,
        ));
        foreach ($results as $kye => $r) {
            //user存在 该用户
            $ids[$kye] = $r['id'];
            if ($r['user_id'] != '0') {
                $ids[$kye] = $r['id'];
            } else {//user  不存在
              //  var_dump($r['id']);
                $model = new Message();
                $criteria = new CDbCriteria;
                $criteria->select='`fromusername`';
                $criteria->compare('id',$r['id']);
                $message_null= $model->findByPk($r['id']);
               // var_dump($data);exit;
               // $message_null = Message::model()->findByPk($r['id']);
               // var_dump($data['fromusername']);exit;
                if (!empty($message_null['fromusername'])) {
                    $fromuser = User::model()->find('openid=:openid', array(':openid' => $message_null['fromusername']));
                    //查询 存在
                    if (!empty($fromuser)) {
                        $user_id = $fromuser->id;
                    } else {
                        $user_add = new User();
                        $user_add->nickname = '昵称加载中';
                        $user_add->openid = $message_null['fromusername'];
                        $user_add->public_id = $message_null['public_id'];
                        if ($user_add->save()) {
                            $user_id = $user_add->id;
                        }
                    }
                    if (!empty($user_id)) {
                        Message::model()->updateAll(array('user_id' => $user_id), 'fromusername=:fromusername ', array(':fromusername' => $message_null['fromusername']));
                        Message::model()->updateAll(array('user_id' => $user_id), 'tousername=:tousername ', array(':tousername' => $message_null['fromusername']));
                        $ids[$kye] = $user_id;
                    }
                } else {
                    echo '没有 openid';
                }
            }
        }

//查询 id集合 -------------结束

        $criteria = new CDbCriteria;
        $criteria->select = 'id,star,format,user_id,createtime,remark,type,picurl,title,description,url,content,menukey,menutype';
        if (!empty($adminmodel)) {
//得到 权限级别
            $role_id = $adminmodel->role_id;
//表示为客服
            if ($role_id == 4) {
                $publicids = array();
//查询关联的公众号id
                $adminpublicmodel = AdminPublic::model()->findAll('admin_id =:admin_id', array(':admin_id' => $adminmodel->id));
                foreach ($adminpublicmodel as $key => $ad) {
                    $publicids[$key] = $ad->public_id;
                }
                $criteria->addInCondition('public_id', $publicids);
            } elseif ($role_id == 1) {
                $criteria->compare('public_id', $public_id);
            }
        }
        $criteria->compare('receive', 1);
//  $criteria->compare('menutype', 0);
        $star = Yii::app()->request->getParam('star');
        if (!empty($star)) {
            $criteria->compare('star', $star);
        } else {
            $criteria->compare('star', $model->star);
        }
//根据内容 搜索
        if (!empty($model->content)) {
            $criteria->compare('content', $model->content, true);
        } else {
//正常加载
          $criteria->addInCondition('id', $ids); //代表where id IN (1,2,3,4,5,);
        }

        $criteria->compare('isdelete', 0);

        if (!empty($time_start) && !empty($time_end)) {
            $criteria->addBetweenCondition('createtime', strtotime($time_start), strtotime($time_end) + 3600 * 24);
        }
        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`createtime` DESC',
            ),
        ));
        if (isset($dataProvider->data)) {
            $userIdArr = array();
            foreach ($dataProvider->data as $key => $value) {
                if (!in_array($value->user_id, $userIdArr)) {
                    $userIdArr[] = $value->user_id;
                }
            }
            $this->returnUserArr($userIdArr);
        }
        /* -------------------------回复信息-------------------------- */
        if (isset($_POST['Message'])) {
            $messageModel = new Message();
            $usermodel = User::model()->findByPk($_POST['Message']['user_id']);
            if (!empty($usermodel)) {

                $messageModel->setAttribute('tousername', $usermodel->openid);
                $messageModel->setAttribute('source_file_id', $_POST['Message']['source_file_id'] ? $_POST['Message']['source_file_id'] : '0');
                $messageModel->setAttribute('multi', $_POST['Message']['multi'] ? $_POST['Message']['multi'] : 0);
                $messageModel->setAttribute('fromusername', Yii::app()->user->getState('public_original'));
                $messageModel->setAttribute('user_id', $usermodel->id);
                $messageModel->setAttribute('public_id', Yii::app()->user->getState('public_id'));
                $messageModel->setAttribute('receive', 2); //发出
                $messageModel->setAttribute('auto', 2); //手动
                $messageModel->setAttribute('type', $_POST['Message']['type'] ? $_POST['Message']['type'] : 1); //信息类型
                $messageModel->setAttribute('createtime', time());
                $messageModel->setAttribute('content', $_POST['Message']['content']);
                if ($messageModel->save()) {
                    $publicArr = array(
                        'appid' => Yii::app()->user->getState('public_appid'),
                        'appsecret' => Yii::app()->user->getState('public_appsecret'),
                    );
                    $access_token = WechatStaticMethod::getAccessToken($publicArr);
                    $dataProvider = array(
                        'touser' => $usermodel->openid,
                        'msgtype' => 'text',
                        'text' => array(
                            'content' => urlencode($messageModel->content),
                        ),
                    );
                    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
                    $result = WechatStaticMethod::https_request($url, urldecode(json_encode($dataProvider)));
                    $this->refresh();
                }
            }
        }

        /* -------------------------回复信息-------------------------- */
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = new Message('search');
        $model->unsetAttributes();  // clear any default values
        $model->_select = 'id,star,user_id,MAX(createtime) AS lasttime';
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->receive = 1; //只显示接收的信息
        $this->getUserDataProvider($model->public_id);
        if (isset($_GET['Message']))
            $model->attributes = $_GET['Message'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * 给用户加星标方法
     */

    public function actionStar($id) {
        $model = $this->loadModel($id);
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $model->star = Yii::app()->request->getParam('accept');
        $view_id = @Yii::app()->request->getParam('view_id');
        if ($model->save()) {
            if (!empty($view_id)) {
                $this->redirect(array('user/view', 'id' => Yii::app()->request->getParam('view_id')));
            }
            $this->redirect(array('index'));
        } else {
            var_dump($model->$error);
            exit;
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
        if (isset($_POST['Message'])) {
            $model->remark = $_POST['Message']['remark'];
            $model->save();
//echo $model->remark;
            if (!empty($_POST['Message']['view_id'])) {
                $this->redirect(array('user/view', 'id' => $_POST['Message']['view_id']));
            }
            $this->redirect(array('index'));
        } else {
            $this->render('update', array(
                'model' => $model,
                'action' => 'remark',
            ));
        }
    }

    /**
     * 给用户发消息
     * @param int $id 用户ID
     */
    public function actionCreate($id = 0) {
        $this->layout = '//layouts/operation';
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $criteria = new CDbCriteria();
        $criteria->select = 'id,openid';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('subscribe', 1);
        $criteria->compare('isdelete', 0);
        $user = User::model()->findByPk($id, $criteria);
        if ($user === null) {
//throw new CHttpException('500', '对不起，用户不存在或者已经取消关注。');
            echo '对不起，用户不存在或者已经取消关注。';
        }
        $model = new Message();
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $dataProvider = array();
        $sourceFileGather = array();
        if (Yii::app()->request->getParam('type') > 1) {
            $dataProvider = PublicStaticMethod::getSourceFile(Yii::app()->user->getState('public_id'), Yii::app()->request->getParam('type'), Yii::app()->request->getParam('multi'), Yii::app()->request->getParam('gather'));
            $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), Yii::app()->request->getParam('type'), Yii::app()->request->getParam('multi'));
        }
        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            $model->public_id = Yii::app()->user->getState('public_id');
            $model->user_id = $user->id;
            $model->fromusername = Yii::app()->user->getState('public_original');
            $model->tousername = $user->openid;
            $model->receive = 2;
            $model->auto = 2;
            $model->type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : 1;
            $model->multi = Yii::app()->request->getParam('multi');
            $model->createtime = time();
            $model->status = 0;
            if ($model->save()) {
                $this->sentMessage($model->tousername, $model->type, $model->multi, $model->content, $model->source_file_id);
                $this->redirect(array('/users/user/view', 'id' => $id));
            }
        }

        $this->render('//library/content', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /* ------------------------------------非Action部分------------------------------------------ */

    /**
     * 页面调用出用户名字
     * @param object $data
     * @param int $row
     * @return string
     */
    protected function user($data, $row) {
        if ($this->userArr) {
            foreach ($this->userArr as $key => $value) {
                if ($key == $data->user_id) {
                    if (!empty($value['remark'])) {
                        echo CHtml::link($value['nickname'] . ' (' . $value['remark'] . ')', 'javascript:;', array('class' => 'show-headimage', 'data-id' => $data->user_id, 'title' => '点击获取用户头像'));
                    } else {
                        echo CHtml::link($value['nickname'], 'javascript:;', array('class' => 'show-headimage', 'data-id' => $data->user_id, 'title' => '点击获取用户头像'));
                    }
                }
            }
        }
    }

    /**
     * 返回用户数组
     */
    private function getUserDataProvider($public_id = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,nickname,remark';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('isdelete', 0);
        $adminDataProvider = User::model()->findAll($criteria);
        if ($adminDataProvider) {
            foreach ($adminDataProvider as $value) {
                $this->userArr[$value['id']]['nickname'] = $value['nickname'];
                $this->userArr[$value['id']]['remark'] = $value['remark'];
            }
        }
    }

    /**
     * 匹配用户名字，备注及头像
     * @param type $id
     * @param type $type
     */
    protected function matchUser($id = 0, $type = 'nickname') {
        if (is_array($this->userArr) && !empty($this->userArr)) {
            foreach ($this->userArr as $key => $value) {
                if ($key == $id) {
                    return $value[$type];
                }
            }
        }
    }

    /**
     * 返回精确用户数组
     */
    private function returnUserArr($userIdArr = array()) {
        if (is_array($userIdArr) && !empty($userIdArr)) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,nickname,headimgurl,remark';
            $criteria->compare('id', $userIdArr);
            $criteria->compare('isdelete', 0);
            $dataProvider = User::model()->findAll($criteria);
            if ($dataProvider) {
                foreach ($dataProvider as $value) {
                    $this->userArr[$value['id']]['nickname'] = $value['nickname'];
                    $this->userArr[$value['id']]['headimgurl'] = substr($value['headimgurl'], 0, - 1) . "64";
                    $this->userArr[$value['id']]['remark'] = $value['remark'];
                }
            }
        }
    }

    private function sentMessage($openid = '', $type = 0, $multi = 0, $content = '', $source_file_id = 0) {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $dataProvider = array();
        if ($type == 1) {
            $dataProvider['touser'] = $openid;
            $dataProvider['msgtype'] = 'text';
            $dataProvider['text'] = array(
                'content' => urlencode($content),
            );
        } else {
            $dataProvider['touser'] = $openid;
            $dataProvider['msgtype'] = 'news';
            $dataProvider['news'] = array(
                'articles' => $this->searchSourceFile($source_file_id, $multi),
            );
        }
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        return WechatStaticMethod::https_request($url, urldecode(json_encode($dataProvider)));
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Message the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Message::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Message $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
