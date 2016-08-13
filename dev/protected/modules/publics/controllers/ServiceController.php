<?php

class ServiceController extends Controller {

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'view', 'create', 'update', 'import', 'admin', 'delete'),
                'roles' => array('1', '2'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Service;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        /* $publicArr = array(
          'appid' => Yii::app()->user->getState('public_appid'),
          'appsecret' => Yii::app()->user->getState('public_appsecret'),
          );
          $dataProvider = array(
          'kf_account'=>$model->account,
          'nickname'=>urlencode($model->nickname),
          'password'=>$model->password,
          );
          $dataProvider = json_encode(array(
          'account' => 'test@gh_7be9798d63ba',
          'nickname' => 'test',
          'password' => 'd123asd4asd2as3d1sa3d21sa3d131as',
          ));

          $access_token = WechatStaticMethod::getAccessToken($publicArr);
          //print_r($access_token);exit;
          $url = "https://api.weixin.qq.com/customservice/kfaccount/add?access_token=$access_token";
          $result = WechatStaticMethod::https_request($url, $dataProvider);
          $result = json_decode($result, true);
          print_r($result);
          exit;
         */
        if (isset($_POST['Service'])) {
            $model->attributes = $_POST['Service'];
            $model->kf_headimg = CUploadedFile::getInstance($model, 'kf_headimg');
            if($model->validate()){
                if (is_object($model->kf_headimg) && get_class($model->kf_headimg) === 'CUploadedFile') {
                    $filename = PublicStaticMethod::generateFileName();
                    if ($model->kf_headimg->saveAs(Yii::getPathOfAlias('webroot') . '/upload/service/headimage/' . $filename . '.' . $model->kf_headimg->extensionName)) {
                        $model->setattribute('kf_headimg', $filename . '.' . $model->kf_headimg->extensionName);
                    }
                }
            }
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        } $this->render('create', array(
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

        if (isset($_POST['Service'])) {
            $model->attributes = $_POST['Service'];
            $model->kf_headimg = CUploadedFile::getInstance($model, 'kf_headimg');
            if($model->validate()){
                if (is_object($model->kf_headimg) && get_class($model->kf_headimg) === 'CUploadedFile') {
                    $filename = PublicStaticMethod::generateFileName();
                    if ($model->kf_headimg->saveAs(Yii::getPathOfAlias('webroot') . '/upload/service/headimage/' . $filename . '.' . $model->kf_headimg->extensionName)) {
                        $model->setattribute('kf_headimg', $filename . '.' . $model->kf_headimg->extensionName);
                    }
                }
            }
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Service');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Service('search');
        $model->unsetAttributes();  // clear any default values
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->isdelete = 0;
        if (isset($_GET['Service']))
            $model->attributes = $_GET['Service'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 將微信线上的客服数据导入到我们的数据库
     * 获取客服基本信息
     */
    public function actionImport() {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $url = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=$access_token";
        $result = WechatStaticMethod::https_request($url);
        $result = json_decode($result, true);
        print_r($result);
        exit;
    }

    /**
     * 获取在线客服接待信息
     * 开发者通过本接口，根据AppID获取公众号中当前在线的客服的接待信息，包括客服工号、客服登录账号、客服在线状态（手机在线、PC客户端在线、手机和PC客户端全都在线）、客服自动接入最大值、客服当前接待客户数。开发者利用本接口提供的信息，结合客服基本信息，可以开发例如“指定客服接待”等功能；结合会话记录，可以开发”在线客服实时服务质量监控“等功能
     */
    public function actionGetinfo() {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $url = "https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=$access_token";
        $result = WechatStaticMethod::https_request($url);
        $result = json_decode($result, true);
        print_r($result);
        exit;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Service the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Service::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Service $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
