<?php

class TransmitTypeController extends Controller {

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
                'actions' => array('index', 'admin', 'view', 'update', 'create', 'delete'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionCreate() {
        $model = new TransmitType;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $parent_id = Yii::app()->request->getParam('parent_id');
        if (empty($parent_id)) {
            $parent_id = 0;
        }
        if (isset($_POST['TransmitType'])) {
            $model->attributes = $_POST['TransmitType'];
            $model->admin_id = Yii::app()->user->id;
            if ($model->save()) {
                $this->redirect(array('admin'));
            } else {
                var_dump($model->errors);
            }
        }
        $this->render('create', array(
            'model' => $model,
            'parent_id' => $parent_id,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        //$model = new TransmitType('search');
        $model = TransmitType::model()->findAll('status=:status',array(':status'=>'0'));
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransmitType']))
            $model->attributes = $_GET['TransmitType'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionUpdate() {
        $id = Yii::app()->request->getParam('id');
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['TransmitType'])) {
            $model->attributes = $_POST['TransmitType'];
            if ($model->save())
                $this->redirect(array('admin'));
        }
        $this->render('update', array(
            'model' => $model,
            'parent_id' => $model->parent_id,
        ));
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /*
     * 删除 分类
     */

    public function actionDelete($id) {
        if (!empty($id)) {
            TransmitType::model()->updateAll(array('status' => '1'), 'id=:id', array(':id' => $id));
        }
        $this->redirect(array('admin'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return WcPublic the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);
        $criteria->compare('status', 0);
        $model = TransmitType::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

}
