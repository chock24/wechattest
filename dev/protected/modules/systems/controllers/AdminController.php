<?php

class AdminController extends Controller {

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
                'actions' => array('update'),
                'roles' => array('1','2','3'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index','view', 'create', 'admin', 'delete'),
                'roles' => array('1'),
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
        $this->layout = '//layouts/system';
        $model = new Admin;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->save())
                $this->redirect(array('admin'));
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
    public function actionUpdate() {
        $this->layout = '//layouts/system';
        $id = Yii::app()->request->getParam('id')?Yii::app()->request->getParam('id'):Yii::app()->user->id;        
        $model = $this->loadModel($id);
        $model->old_password = $model->password;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            if ($model->save())
                $this->redirect(array('admin'));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
    /**
     * Manages all models.
     */
    public function actionIndex() {
        $this->layout = '//layouts/system';
        $model = new Admin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Admin']))
            $model->attributes = $_GET['Admin'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Admin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Admin']))
            $model->attributes = $_GET['Admin'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Admin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('isdelete', 0);
        if(Yii::app()->user->getState('roles')!=1 && Yii::app()->user->id!=$id){
            throw new CHttpException(404, '对不起，您只能修改自己的资料。');
        }
        
        $model = Admin::model()->findByPk($id,$criteria);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Admin $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
