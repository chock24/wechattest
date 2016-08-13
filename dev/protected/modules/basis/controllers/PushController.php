<?php

class PushController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //  'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'view', 'create', 'selectuser', 'district', 'admin', 'delete', 'addmessages', 'sourcefile'),
                'roles' => array('1', '2'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /*
     * 单图文列表显示
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

    /*
     * 创建群发消息
     */

    public function actionAddmessages() {
        $this->render('addmessages');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $oldstatus = $model->status;
        if (isset($_POST['Push'])) {
            $model->attributes = $_POST['Push'];
            $success = @$_POST['Push']['success'];
            $remark = @$_POST['Push']['remark'];
            if ($model->preview == 1) { //如果是预览消息
                $model->setScenario('preview'); //场景验证 openid不为空
                $data = $model->type == 1 ? $model->content : $model->media_id;
                if ($model->openid) {
                    $dataProvider = $this->preview($model->type, $data, $model->openid); //提交预览数据
                    if (isset($dataProvider['errcode'])) {
                        if (!$dataProvider['errcode']) {
                            $pushReturnModel = new PushReturn();
                            $pushReturnModel->errcode = $dataProvider['errcode'];
                            $pushReturnModel->errmsg = $dataProvider['errmsg'];
                            $pushReturnModel->title = '预览群发消息';
                            $pushReturnModel->push_id = $model->id;
                            if ($pushReturnModel->save()) {
                                Yii::app()->user->setFlash('success', '预览已经发送成功了，您可以在预览手机微信客户端上查看发送数据。');
                                $this->refresh();
                            }
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('error', '用户openid必须填写正确才能发送。');
                    $this->refresh();
                }
            } else {
                if ($model->status == 1) {//审核操作
                    if ($success == 1) {//审核通过
                        $model->updateByPk($model->id, array("status" => '2'));
                        $this->redirect(array('index', 'status' => '2'));
                    } else {//审核失败
                        $model->updateByPk($model->id, array("status" => '3', 'remark' => $remark));
                        $this->redirect(array('index', 'status' => '3'));
                    }
                } elseif ($model->status == 2) {//提交到微信服务器
                    $data = $model->type == 1 ? $model->content : $model->media_id;
                    $dataProvider = $this->send($model->type, $data, $model->user); //提交消息数据
                    if (isset($dataProvider['errcode'])) {
                        if (!$dataProvider['errcode']) {
                            $pushReturnModel = new PushReturn();
                            $pushReturnModel->errcode = $dataProvider['errcode'];
                            $pushReturnModel->errmsg = $dataProvider['errmsg'];
                            $pushReturnModel->msg_id = $dataProvider['msg_id'];
                            $pushReturnModel->title = '提交群发消息到微信服务器';
                            $pushReturnModel->push_id = $model->id;
                            if ($pushReturnModel->save()) {
                                $model->msg_id = $pushReturnModel->msg_id;
                                if ($model->save()) {
                                    Yii::app()->user->setFlash('success', '群发请求已经提交，发送需要一段时间处理，请耐心等候');
                                    $this->refresh();
                                }
                            }
                        } else {
                            $model->updateByPk($model->id, array("status" => '4')); //修改 状态为发送成功
                            $this->redirect(array('index', "status" => 4));
                        }
                    }
                } elseif ($model->status == 3) {//撤销提交到微信服务器的群发信息
                    if ($model->msg_id) {
                        if ($oldstatus == 2) {
                            $dataProvider = $this->remove($model->msg_id);
                            if (isset($dataProvider['errcode'])) {
                                if (!$dataProvider['errcode']) {
                                    $pushReturnModel = new PushReturn();
                                    $pushReturnModel->errcode = $dataProvider['errcode'];
                                    $pushReturnModel->errmsg = $dataProvider['errmsg'];
                                    $pushReturnModel->title = '提交撤销请求到微信服务器';
                                    $pushReturnModel->push_id = $model->id;
                                    if ($pushReturnModel->save()) {
                                        if ($model->save()) {
                                            Yii::app()->user->setFlash('success', '已经提交撤销请求到微信服务器。');
                                            $this->refresh();
                                        }
                                    }
                                }
                            }
                        } else {
                            Yii::app()->user->setFlash('error', '只有已经提交(未完全发送)的信息才能撤销。');
                            $this->refresh();
                        }
                    }
                }
            }
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($genre = 1) {
        $model = new Push;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $sourceFileDataProvider = '';
        $modelDataProvider = array('selectedId' => 0);
        $groupDataProvider = '';

        if ($genre == 2) {
            Yii::import('application.modules.users.models.UserGroup');
            $criteria = new CDbCriteria();
            $criteria->select = 'id,name,time_created';
            $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
            $criteria->compare('isdelete', 0);
            $groupDataProvider = CHtml::listData(UserGroup::model()->findAll($criteria), 'id', 'name');
        }
        if ($genre == 3) {
            $model->userArr = Yii::app()->request->getParam('userarr');
        }
        if (Yii::app()->request->getParam('type') == 5) {

            if (Yii::app()->request->getParam('multi') == 1) {
                $criteria = new CDbCriteria();
                $criteria->select = 'id,title,description,time_created';
                $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                $criteria->compare('gather_id', Yii::app()->request->getParam('gather'));
                $criteria->compare('isdelete', 0);
                $sourceFileDataProvider = new CActiveDataProvider('SourceFileGroup', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 4,
                    ),
                    'sort' => array(
                        'defaultOrder' => '`time_created` DESC',
                    ),
                ));
            } else {
                $criteria = new CDbCriteria();
                $criteria->select = 'id,title,description,filename,ext,time_created';
                $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                $criteria->compare('gather_id', Yii::app()->request->getParam('gather'));
                $criteria->compare('type', 5);
                $criteria->compare('isdelete', 0);
                $sourceFileDataProvider = new CActiveDataProvider('SourceFile', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 15,
                    ),
                    'sort' => array(
                        'defaultOrder' => '`time_created` DESC',
                    ),
                ));
            }
        }


        /* --------------------------查询素材的集合---------------------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,name,multi';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('type', Yii::app()->request->getParam('type'));
        $criteria->compare('multi', Yii::app()->request->getParam('multi') ? Yii::app()->request->getParam('multi') : 0);
        $criteria->compare('isdelete', 0);
        $sourceFileGather = new CActiveDataProvider('SourceFileGather', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));

        /* --------------------------查询素材的集合---------------------------- */

        if (isset($_POST['Push'])) {
            $model->attributes = $_POST['Push'];
            $model->type = $_POST['Push']['type'] ? $_POST['Push']['type'] : 1;
            $model->genre = Yii::app()->request->getParam('genre') ? Yii::app()->request->getParam('genre') : 1;
            $model->multi = $_POST['Push']['multi'] ? $_POST['Push']['multi'] : 0;

            $dataProvider = $this->returnUserInfo($model->genre, $model->groupArr, $model->userArr); //得到用户数据

            if ($dataProvider) {
                $model->count = $dataProvider['count'];
                $model->user = json_encode($dataProvider['info']);
            }
            $wechatInfo = $this->returnWechatInfo($model->source_file_id, $model->multi); //返回微信端数据

            if (isset($wechatInfo['type'])) {
                $model->created_at = (int) $wechatInfo['created_at'];
                $model->media_id = $wechatInfo['media_id'];
            }
            if ($model->save()) {

                $this->redirect(array('index'));
            } else {
                var_dump($model->errors);
                exit;
                Yii::app()->user->setFlash('error', '创建不成功，可能是接口调用限制已满。');
                $this->refresh();
            }
        }
        $this->render('create', array(
            'model' => $model,
            'groupDataProvider' => $groupDataProvider,
            'modelDataProvider' => $modelDataProvider,
            'sourceFileDataProvider' => $sourceFileDataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->updateByPk($id, array('isdelete' => 1));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * 得到省份的数组
     * @return object
     */
    public function actionDistrict($parent_id = 1, $type = 0) {
        if ($parent_id) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,name';
            $criteria->compare('parent_id', $parent_id);
            $criteria->compare('isdelete', 0);
            if ($type) {
                echo json_encode(CHtml::listData(District::model()->findAll($criteria), 'id', 'name'));
            } else {
                return CHtml::listData(District::model()->findAll($criteria), 'id', 'name');
            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = new Push('search');
        $model->unsetAttributes();  // clear any default values
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->isdelete = 0;
        if (isset($_GET['Push']))
            $model->attributes = $_GET['Push'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 群发列表页
     */
    public function actionIndex() {
        $model = new Push;
        $status = Yii::app()->request->getParam('status');
        $criteria = new CDbCriteria();
        $criteria->select = 'id,created_at,genre,count,type,multi,content,source_file_id,remark,status,time_created';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        if (!empty($status)) {
            $criteria->compare('status', $status);
        }
        if (isset($_GET['Push'])) {
            if (!empty($_GET['Push']['time_start']) && !empty($_GET['Push']['time_end'])) {
                $criteria->addBetweenCondition('time_created', strtotime($_GET['Push']['time_start']), strtotime($_GET['Push']['time_end']) + 3600 * 24);
            }
        }
        $dataProvider = new CActiveDataProvider('Push', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    /**
     * 返回每个图文部分
     * @param int $id
     */
    private function returnPart($id = 0) {
        $dataProvider = array();
        $criteria = new CDbCriteria();
        $criteria->select = array(
            'id',
            'type',
            'author',
            'title',
            'description',
            'show_content',
            'content_source_url',
            'content',
            'filename',
            'ext',
        );
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $model = SourceFile::model()->findByPk($id, $criteria);


        $criteria = new CDbCriteria();
        $criteria->select = 'media_id,media_create_time';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('source_file_id', $id);
        $criteria->compare('multi', 0);
        $criteria->compare('type', 5);
        $criteria->compare('isdelete', 0);
        $criteria->order = '`time_created` DESC';
        $media = MediaId::model()->find($criteria);
        if ($model !== null) {//如果素材存在
            if ($media !== null && (time() - $media->media_create_time < 2.5 * 24 * 60 * 60)) {//如果media存在
                $dataProvider['thumb_media_id'] = $media->media_id;
                $dataProvider['author'] = $model->author;
                $dataProvider['title'] = $model->title;
                $dataProvider['description'] = $model->description;
                $dataProvider['content_source_url'] = $model->content_source_url;
                $dataProvider['content'] = $model->content;
                //读取txt 为内容
                $contnetname = $model->content;
                $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $contnetname;
                //读取文件 内容
                if (file_exists($textname)) {
                    $contents = file_get_contents($textname);
                    $dataProvider['content'] = @$contents;
                }
                $dataProvider['show_content'] = $model->show_content;
            } else {
                $publicArr = array(
                    'appid' => Yii::app()->user->getState('public_appid'),
                    'appsecret' => Yii::app()->user->getState('public_appsecret'),
                );
                $access_token = WechatStaticMethod::getAccessToken($publicArr);
                //上传临时素材
                $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=$access_token&type=thumb";
                $postArr = array();
                if (class_exists('\CURLFile', FALSE)) {
                    $postArr['media'] = new CURLFile(PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'image', 'thumb'));
                } else {
                    $postArr['media'] = '@' . PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'image', 'thumb');
                }
                $result = WechatStaticMethod::https_request($url, $postArr);
                $result = json_decode($result, true);
                if (isset($result['thumb_media_id'])) {
                    $media = new MediaId();
                    $media->type = $model->type;
                    $media->multi = 0;
                    $media->thumb = 1;
                    $media->source_file_id = $model->id;
                    $media->media_id = $result['thumb_media_id'];
                    $media->media_create_time = (int) $result['created_at'];
                    if ($media->save()) {
                        $dataProvider['thumb_media_id'] = $media->media_id;
                        $dataProvider['author'] = $model->author;
                        $dataProvider['title'] = $model->title;
                        $dataProvider['description'] = $model->description;
                        $dataProvider['content_source_url'] = $model->content_source_url;
                        $dataProvider['content'] = $model->content;
                        $contnetname = $model->content;
                        $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $contnetname;
                        //读取文件 内容
                        if (file_exists($textname)) {
                            $contents = file_get_contents($textname);
                            $dataProvider['content'] = @$contents;
                        }
                        $dataProvider['show_content'] = $model->show_content;
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

        return $dataProvider;
    }

    /**
     * 返回微信服务器数据
     * @param int $id
     * @param int $multi
     */
    private function returnWechatInfo($id = 0, $multi = 0) {
        if ($id) {
            $dataProvider = array();
            if ($multi == 1) {
                $criteria = new CDbCriteria();
                $criteria->select = 'file_id';
                $criteria->compare('group_id', $id);
                $criteria->compare('isdelete', 0);
                $sourceFileDetail = SourceFileDetail::model()->findAll($criteria);

                if (is_array($sourceFileDetail) && !empty($sourceFileDetail)) {
                    foreach ($sourceFileDetail as $value) {

                        $dataProvider[] = $this->returnPart($value->file_id);
                    }
                }
            } else {
                $dataProvider[] = $this->returnPart($id);
            }
            return $this->processNews($dataProvider);
        }
    }

    /**
     * 提交图文数据到微信数据库
     * @param array $dataProvider 图文数据
     * return 返回
      {
      "type":"news",
      "media_id":"CsEf3ldqkAYJAU6EJeIkStVDSvffUJ54vqbThMgplD-VJXXof6ctX5fI6-aYyUiQ",
      "created_at":1391857799
      }
     */
    private function processNews($dataProvider = array()) {
        if (is_array($dataProvider) && !empty($dataProvider)) {
            foreach ($dataProvider as &$item) {
                if (empty($item)) {
                    return false;
                }
                foreach ($item as $key => $value) {
                    //将""转化为单引号，转化为html实体后编码
                    if ($key == 'content') {
                        $item[$key] = urlencode(htmlspecialchars(str_replace("\"", "'", $value)));
                    } else {
                        $item[$key] = urlencode($value);
                    }
                }
            }
            $datas = '{"articles":[';
            foreach ($dataProvider as $key => $value) {
                $datas = $datas . '{';
                $datas = $datas . "\"thumb_media_id\":" . "\"" . $value['thumb_media_id'] . "\",";
                $datas = $datas . "\"author\":" . "\"" . $value['author'] . "\",";
                $datas = $datas . "\"title\":" . "\"" . $value['title'] . "\",";
                $datas = $datas . "\"content_source_url\":" . "\"" . $value['content_source_url'] . "\",";
                $datas = $datas . "\"content\":" . "\"" . $value['content'] . "\",";
                $datas = $datas . "\"digest\":" . "\"" . $value['description'] . "\",";
                $datas = $datas . "\"show_cover_pic\":" . "\"" . $value['show_content'] . "\"";
                $datas = $datas . '},';
            }
            $datas = trim($datas, ',');
            $datas = $datas . ']}';
            $datas = urldecode($datas);
            $datas = htmlspecialchars_decode($datas);
            $publicArr = array(
                'appid' => Yii::app()->user->getState('public_appid'),
                'appsecret' => Yii::app()->user->getState('public_appsecret'),
            );
            $access_token = WechatStaticMethod::getAccessToken($publicArr);

            $url = "https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=$access_token";
            $result = WechatStaticMethod::https_request($url, $datas);
            return json_decode($result, true);
        }
    }

    /**
     * 返回用户数据
     * @param int $genre
     * @param int $group_id
     * @param array $userIdArr
     */
    private function returnUserInfo($genre = 1, $groupIdArr = array(), $userIdArr = array()) {
        $dataProvider = array();
        switch ($genre):
            case 2 : //选择组发送
                if (is_array($groupIdArr) && !empty($groupIdArr)) {
                    $criteria = new CDbCriteria();
                    $criteria->select = 'id';
                    $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                    $criteria->compare('group_id', $groupIdArr);
                    $criteria->compare('subscribe', 1);
                    $criteria->compare('isdelete', 0);
                    Yii::import('application.modules.users.models.User');
                    $userCount = User::model()->count($criteria);
                    $dataProvider['count'] = $userCount; //用户数量
                    $dataProvider['info']['type'] = $genre; //选择类型
                    $dataProvider['info']['group'] = implode(',', $groupIdArr); //用户详情
                    $dataProvider['info']['condition'] = ''; //附加条件
                }
                break;
            case 3 : //选择用户发送
                if (!empty($userIdArr)) {
                    $criteria = new CDbCriteria();
                    $criteria->select = 'id';
                    $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                    $criteria->compare('id', explode(',', $userIdArr));
                    $criteria->compare('subscribe', 1);
                    $criteria->compare('isdelete', 0);
                    Yii::import('application.modules.users.models.User');
                    $userCount = User::model()->count($criteria);
                    $dataProvider['count'] = $userCount; //用户数量
                    $dataProvider['info']['type'] = $genre; //选择类型
                    $dataProvider['info']['user'] = $userIdArr; //用户详情
                    $dataProvider['info']['condition'] = ''; //附加条件
                }
                break;
            case 4 : //此公众号全部用户
                $criteria = new CDbCriteria();
                $criteria->select = 'COUNT(id)';
                $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                $criteria->compare('subscribe', 1);
                $criteria->compare('isdelete', 0);
                Yii::import('application.modules.users.models.User');
                $userCount = User::model()->count($criteria);
                $dataProvider['count'] = $userCount; //用户数量
                $dataProvider['info']['type'] = $genre; //选择类型
                $dataProvider['info']['user'] = 'all'; //用户详情
                $dataProvider['info']['condition'] = ''; //附加条件
                break;
            default : //默认选择全部
                //查询所有 托管的公众号ID
                $publicmodel = WcPublic::model()->findAll('trust = :trust', array(':trust' => '1'));
                if (!empty($publicmodel)) {
                    $publicids = array();
                    //查询托管的的公众号id 
                    foreach ($publicmodel as $key => $ad) {
                        $publicids[$key] = $ad->id;
                    }
                }
                $criteria = new CDbCriteria();
                $criteria->select = 'COUNT(id)';
                $criteria->addInCondition('public_id', $publicids);
                $criteria->compare('subscribe', 1);
                $criteria->compare('isdelete', 0);
                Yii::import('application.modules.users.models.User');
                $userCount = User::model()->count($criteria);
                $dataProvider['count'] = $userCount; //用户数量
                $dataProvider['info']['type'] = $genre; //选择类型
                $dataProvider['info']['user'] = 'all'; //用户详情
                $dataProvider['info']['condition'] = ''; //附加条件
                break;
        endswitch;
        return $dataProvider;
    }

    /**
     * 预览群发信息
     * @param int $type 发送类型
     * @param string $data 群发消息文本内容 or 群发消息media_id
     * @param string $openid 发送用户openid
     */
    private function preview($type = 0, $data = '', $openid = '') {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );

        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=$access_token";
        $postArr = array();
        $postArr['touser'] = $openid;
        if ($type == 1) {
            $postArr['text']['content'] = urlencode($data);
        } elseif ($type == 5) {
            $postArr['mpnews']['media_id'] = $data;
        }
        $postArr['msgtype'] = Yii::app()->params->PUSHTYPE[$type];
        //  var_dump($data);exit;
        $result = WechatStaticMethod::https_request($url, urldecode(json_encode($postArr)));
        return json_decode($result, true);
    }

    /**
     * 发送群发信息
     * @param int $type 发送类型
     * @param string $data 群发消息文本内容 or 群发消息media_id
     * @param string $openid 发送用户openid
     */
    private function send($type = 0, $data = '', $user = '') {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $postArr = array();
        $dataProvider = json_decode($user);

        if (is_object($dataProvider) && !empty($dataProvider)) {

            if ($dataProvider->type == 1) {
                $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=$access_token";
                $postArr['filter'] = array(
                    'is_to_all' => true,
                );
            } elseif ($dataProvider->type == 2) {
                $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$access_token";
                $criteria = new CDbCriteria();
                $criteria->select = 'openid';
                $userIdArr = explode(',', $dataProvider->group);
                $criteria->compare('group_id', $userIdArr);
                $criteria->compare('isdelete', 0);
                Yii::import('application.modules.users.models.User');
                $users = User::model()->findAll($criteria);
                $openidArr = array();
                if (is_array($users) && !empty($users)) {
                    foreach ($users as $value) {
                        $openidArr[] = $value->openid;
                    }
                }
                $postArr['touser'] = $openidArr;
            } else {
                $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$access_token";
                $criteria = new CDbCriteria();
                $criteria->select = 'openid';
                $userIdArr = explode(',', $dataProvider->user);
                $criteria->compare('id', $userIdArr);
                $criteria->compare('isdelete', 0);
                Yii::import('application.modules.users.models.User');
                $users = User::model()->findAll($criteria);
                $openidArr = array();
                if (is_array($users) && !empty($users)) {
                    foreach ($users as $value) {
                        $openidArr[] = $value->openid;
                    }
                }
                $postArr['touser'] = $openidArr;
            }
        }
        if ($type == 1) {
            $postArr['text']['content'] = $data;
        } elseif ($type == 5) {
            $postArr['mpnews']['media_id'] = $data;
        }
        $postArr['msgtype'] = Yii::app()->params->PUSHTYPE[$type];
        echo $url;
        var_dump($postArr);
        exit;
        $result = WechatStaticMethod::https_request($url, json_encode($postArr));
        return json_decode($result, true);
    }

    /**
     * 撤销群发信息
     * @param string $msg_id 信息id
     */
    private function remove($msg_id = '') {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=$access_token";
        $postArr = array();
        $postArr['msg_id'] = $msg_id;
        $result = WechatStaticMethod::https_request($url, json_encode($postArr));
        return json_decode($result, true);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Push the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Push::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Push $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'push-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
