<?php

class GiftOperationLogController extends Controller {

    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('index', 'admin', 'view', 'update', 'create', 'delete'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //    'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /*
     * 删除 
     */

    public function actionDelete($id) {
        if (!empty($id)) {
            GiftOperationLog::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
        }
        $this->redirect(array('index'));
    }

    public function actionCreate() {
        $model = new GiftOperationLog;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['GiftOperationLog'])) {
            $model->attributes = $_POST['GiftOperationLog'];
            $model->admin_id = Yii::app()->user->id;
            $model->time_created = time();
            if ($model->save()) {
                $this->redirect(array('index'));
            } else {
                var_dump($model->errors);
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionIndex() {
        $criteria = new CDbCriteria;
        $criteria->compare('isdelete', 0);
        $model = GiftOperationLog::model()->findAll($criteria);
        $this->render('index'
                , array('model' => $model,
        ));
    }

    public function actionUpdate() {
        $id = Yii::app()->request->getParam('id');
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['GiftOperationLog'])) {
            $model->attributes = $_POST['GiftOperationLog'];
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new GiftOperationLog('search');
        // $model = Transmit::model()->findAll('status=:status', array(':status' => '0'));
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['GiftOperationLog']))
            $model->attributes = $_GET['GiftOperationLog'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);
        $criteria->compare('isdelete', 0);
        $model = GiftOperationLog::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

}
