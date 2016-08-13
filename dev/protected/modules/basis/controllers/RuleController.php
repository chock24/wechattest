<?php

class RuleController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     * 
     */
    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'updatereply'),
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
        $this->layout = '//layouts/operation';
        $model = Rule::model()->find(array(
            'order' => 'sort asc',
            'condition' => 'id=:id',
            'params' => array(':id' => $id),
        ));
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * 创建规则
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = '//layouts/operation';
        $model = new Rule;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rule'])) {
            $model->attributes = $_POST['Rule'];
            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('admin_id', Yii::app()->user->id);
            $model->setAttribute('isdelete', '0');
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rule'])) {
            $model->attributes = $_POST['Rule'];
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
        $this->loadModel($id)->updateByPk($id, array('isdelete' => '1'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $public_id = Yii::app()->user->getstate('public_id');
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,entire,template';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $dataProvider = new CActiveDataProvider('Rule', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));

        if ($dataProvider->itemCount == 0) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,title,entire,template';
            $criteria->compare('public_id', 1);
            $criteria->compare('isdelete', 0);
            $criteria->compare('template', 1);
            $dataProvider = new CActiveDataProvider('Rule', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => 10,
                ),
                'sort' => array(
                    'defaultOrder' => '`time_created` DESC',
                ),
            ));
        }
        if (isset($_POST['Rule'])) {
            $id = $_POST['Rule']['id'];
            $model = $this->loadModel($id);
            if ($model->public_id == $public_id) {
                $model->attributes = $_POST['Rule'];
            } else {
                $model = new Rule;
                $model->attributes = $_POST['Rule'];
                $model->setAttribute('public_id', $public_id);
            }
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id, 'rule_id' => $model->id));
        }
        //设定模板 取消模板
        $id = Yii::app()->request->getParam('id');
        $template = Yii::app()->request->getParam('template');

        if (!empty($id)) {
            $model = $this->loadModel($id);
            if ($template == 0) {
                $model->updateByPk($id, array('template' => '0'));
                $this->redirect(array('rule/index'));
            } elseif ($template == 1) {
                $model->updateByPk($id, array('template' => '1'));
                $this->redirect(array('rule/index'));
            }
        }
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Rule('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rule']))
            $model->attributes = $_GET['Rule'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionUpdatereply($id, $rule_id) {
        //echo $id.$rule_id;

        if (!empty($id) && !empty($rule_id)) {
            Reply::model()->updateAll(array('first' => '0'), 'rule_id = :rule_id', array(':rule_id' => $rule_id));
            Reply::model()->updateByPk($id, array('first' => '1'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rule the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {


        $model = Rule::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rule $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rule-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
