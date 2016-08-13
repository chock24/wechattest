<?php

class UsergroupController extends Controller {

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
            array('allow',
                'actions' => array('index', 'view', 'create', 'update', 'import', 'admin', 'delete'),
                'roles' => array('1', '2', '3'),
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
        $this->layout = '//layouts/operation';
        $model = new UserGroup;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UserGroup'])) {
            $model->attributes = $_POST['UserGroup'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
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
        $this->layout = '//layouts/operation';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UserGroup'])) {
            $model->attributes = $_POST['UserGroup'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id));
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
        if (!empty($id)) {
            $this->loadModel($id)->updateByPk($id, array('isdelete' => 1));
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $criteria = new CDbCriteria();
        $criteria->compare('isdelete', 0);
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $dataProvider = new CActiveDataProvider('UserGroup', array(
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
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = new UserGroup('search');
        $model->unsetAttributes();  // clear any default values
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->isdelete = 0;
        if (isset($_GET['UserGroup']))
            $model->attributes = $_GET['UserGroup'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 將用户分组导入到我们自己的库
     */
    public function actionImport() {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $url = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=$access_token";
        $result = WechatStaticMethod::https_request($url);
        $result = json_decode($result, true);
        if (isset($result['groups'])) {
            foreach ($result['groups'] as $value) {
                $criteria = new CDbCriteria();
                $criteria->select = 'id,name,count';
                $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                $criteria->compare('group_id', $value['id']);
                $criteria->compare('isdelete', 0);
                $model = UserGroup::model()->find($criteria);
                if ($model === null) {
                    $model = new UserGroup();
                    $model->name = $value['name'];
                    $model->count = $value['count'];
                    $model->group_id = $value['id'];
                } else {
                    $model->name = $value['name'];
                    $model->count = $value['count'];
                }
                $model->save();
            }
            Yii::app()->user->setFlash('success', '成功从微信服务器下载用户组数据。');
        } else {
            Yii::app()->user->setFlash('error', '数据导入失败，请您检查公众号是否开启开发模式，appid和appsecret是否正确，如果以上都无误，请您退出网站在登录一次重试。');
        }
        $this->redirect(array('admin'));
    }

    /**
     * 返回用户组列表
     */
    public function actionGrouplist() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return UserGroup the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = UserGroup::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param UserGroup $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
