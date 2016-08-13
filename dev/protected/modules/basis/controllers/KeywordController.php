<?php

class KeywordController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'roles' => array('1', '2', '3'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

/**
     * 创建关键字
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate() {
        $this->layout = '//layouts/operation';
        $model = new Keyword;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Keyword'])) {
            $model->attributes = $_POST['Keyword'];
            $rule_id = Yii::app()->request->getParam('id');
            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('admin_id', Yii::app()->user->id);
            $model->setAttribute('isdelete', '0');
            $model->setAttribute('rule_id', @$rule_id);
            if ($model->save())
                $this->redirect(array('/basis/rule/index', 'id' => $rule_id, 'rule_id' => $rule_id));
        }
        $this->render('create', array('model' => $model,));
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

        if (isset($_POST['Keyword'])) {
            $model->attributes = $_POST['Keyword'];
            if ($model->save())
                $this->redirect(array('/basis/rule/index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Keyword::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->updateByPk($id, array('isdelete' => '1'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(array('/basis/rule/index', 'id' => $model->rule_id, 'rule_id' => $model->rule_id));
    }

}
