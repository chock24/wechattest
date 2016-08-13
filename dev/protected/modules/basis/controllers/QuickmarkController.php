<?php

class QuickmarkController extends Controller {

    public $userGroupArr = array();

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                // 'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('updateuserqm', 'view', 'update', 'admin', 'delete', 'download'),
                'roles' => array('1', '2', '3'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'index'),
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
    public function actionView($id) {

        if (!empty($id)) {
            $model = $this->loadModel($id);
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * 创建二维码
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $user_id = 0;
        $public_id = Yii::app()->user->getState('public_id');
        $model = new Quickmark;
        $appId = Yii::app()->user->getState('public_appid'); //需要换为 真是的appid
        $secret = Yii::app()->user->getState('public_appsecret'); //换为------真实的
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        if (isset($_POST['Quickmark'])) {
            $model->attributes = $_POST['Quickmark'];
            $model->description = @$_POST['Quickmark']['description'];
            $model->type = $_POST['Quickmark']['type'];
            $model->multi = $_POST['Quickmark']['multi'];
            $publicArr = array(
                'appid' => Yii::app()->user->getState('public_appid'),
                'appsecret' => Yii::app()->user->getState('public_appsecret'),
            );
            $publicid = Yii::app()->user->getState('public_id');
            $wcpublic = WcPublic::model()->findByPk($publicid);
            $scene_id = 0;
            if (!empty($wcpublic)) {
                $scene_id = intval($wcpublic->quickmark_scene_id);
            }

            $access_token = WechatStaticMethod::getAccessToken($publicArr);
            $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;

            if ($model->action_name == 'QR_SCENE') {//临时二维码
                $model->expire_seconds = $model->expire_seconds <= 1800 ? $model->expire_seconds : 1800; //判断输入的临时时间是否大于1800秒
                $model->action_info = '{"expire_seconds": ' . $model->expire_seconds . ', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
            } else {
                $model->action_info = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
            }//永久二维码
            $result = WechatStaticMethod::https_request($url, $model->action_info);
            //token 错误
            $fanhui =explode(',',$result);
            if($fanhui[0]){
                $returnview =  mb_substr($fanhui[0],11,5);
            }
            if (@$returnview > 0&&$returnview=='40001') {
                $access_token = WechatStaticMethod::getAccessToken($publicArr, 1);
                $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $access_token;
                $result = WechatStaticMethod::https_request($url, $model->action_info);
            }
            $jsoninfo = json_decode($result, true);
            $model->ticket = $jsoninfo['ticket'];
            $model->url = $jsoninfo['url'];
            $model->scene_id = $scene_id;
            $model->public_id = $publicid;
            $model->action_info = serialize($model->action_info);
            $model->path = ($model->action_name == 'QR_SCENE' ? 'upload/quickmark/temp/' : 'upload/quickmark/eternal/') . time() . '.jpg';
            $photoPath = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($model->ticket);
            // echo $photoPath;exit;
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




                //更新 二维码场景id 值
                if ($wcpublic->quickmark_scene_id < 99999) {
                    $wcpublic->updateByPk($publicid, array('quickmark_scene_id' => $wcpublic->quickmark_scene_id + 1));
                }
                //   $model->updateByPk($model->id, array('scene_id' => $model->id));
                $this->redirect(array('index'));
            }
        }


        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Quickmark'])) {
            $model->attributes = $_POST['Quickmark'];
            $model->description = @$_POST['Quickmark']['description'];
            $model->type = $_POST['Quickmark']['type'];
            $model->multi = $_POST['Quickmark']['multi'];
            if ($model->save())
            //$this->redirect(array('view', 'id' => $model->id));
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Quickmark('search');
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model->unsetAttributes();  // clear any default values
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->isdelete = 0;
        if (isset($_GET['Quickmark'])) {
            $model->attributes = $_GET['Quickmark'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * 修改所有用户自定动生成 二维码 分组
     */

    public function actionUpdateuserqm() {
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = new Quickmark;
        $criteria = new CDbCriteria();
        $criteria->select = 'id,group_id,title,path,time_created';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('admin_id', 0);
        $criteria->compare('isdelete', 0);
        $model = Quickmark::model()->find($criteria);
        if (isset($_POST['Quickmark'])) {
            $group_id = $_POST['Quickmark']['group_id'];
            Quickmark::model()->updateAll(array('group_id' => $group_id), 'admin_id=:admin_id', array(':admin_id' => '0'));
            Yii::app()->user->setFlash('success', '修改成功');
            $this->redirect(array('updateuserqm'));
        }
        $this->render('updateuserqm', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,group_id,title,path,time_created';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('admin_id', Yii::app()->user->id);
        $criteria->compare('isdelete', 0);
        $dataProvider = new CActiveDataProvider('Quickmark', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 12,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * 下载二维码
     * @param int $id 二维码ID
     */
    public function actionDownload($id) {
        $model = Quickmark::model()->findByPk($id);
        if ($model == null) {
            throw new CHttpException('500', '对不起，您所下载的文件不存在');
        } else {
            if (file_exists($model->path)) {
                Yii::app()->request->sendFile(PublicStaticMethod::generateFileName() . '.jpg', file_get_contents($model->path));
            } else {
                throw new CHttpException('500', '对不起，您所下载的文件不存在');
            }
        }
    }

    /**
     * 返回用户组表
     */
    public function userGroup() {
        Yii::import('application.modules.users.models.UserGroup');
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        return CHtml::listData(UserGroup::model()->findAll($criteria), 'id', 'name');
    }

    /**
     * 自动匹配用户组ID
     */
    public function userGroupItem($data, $row) {
        $this->userGroupArr = $this->userGroup();
        return isset($this->userGroupArr[$data->group_id]) ? $this->userGroupArr[$data->group_id] : '';
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Quickmark the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Quickmark::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Quickmark $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'quickmark-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
