<?php

class ReplyController extends Controller {

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
            array('allow', // 登录后才能进行的操作
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'welcome', 'auto', 'sourcefile'),
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
        $model = new Reply;
        $rule_id = Yii::app()->request->getParam('id');

        if (isset($_POST['Reply'])) {
            $model->attributes = $_POST['Reply'];
            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('admin_id', Yii::app()->user->id);
            $model->setAttribute('isdelete', '0');
            $model->setAttribute('rule_id', @$rule_id);
            if ($model->save())
                $this->redirect(array('/basis/rule/index/', 'id' => $rule_id));
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
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Reply'])) {
            $model->attributes = $_POST['Reply'];
            if ($model->save())
            // 'id' => $model->id,
                $this->redirect(array('rule/index', 'rule_id' => $model->rule_id));
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
        $model = $this->loadModel($id);
        $model->updateByPk($id, array('isdelete' => 1));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(array('/basis/rule/index', 'id' => $model->rule_id, 'rule_id' => $model->rule_id));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->layout = '//layouts/operation';
        $type = Yii::app()->request->getParam('type');
        $rule_id = Yii::app()->request->getParam('id');

        $dataProvider = array();
        $sourceFileGather = array();
        $modelDataProvider = array('selectedId' => 0);
        $model = new Reply;
        $id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            $model = $this->loadModel($id);
        }

        /* --------------------------查询素材的数据---------------------------- */
        if (Yii::app()->request->getParam('type') > 1) {
            if (Yii::app()->request->getParam('multi') == 1) {
                $criteria = new CDbCriteria();
                $criteria->select = 'id,title,description,time_created';
                $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                $criteria->compare('gather_id', Yii::app()->request->getParam('gather'));
                $criteria->compare('isdelete', 0);
                $dataProvider = new CActiveDataProvider('SourceFileGroup', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'sort' => array(
                        'defaultOrder' => '`time_created` DESC',
                    ),
                ));
            } else {
                $criteria = new CDbCriteria();
                $criteria->select = 'id,title,filename,ext,time_created,description';
                $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
                $criteria->compare('type', Yii::app()->request->getParam('type'));
                $criteria->compare('gather_id', Yii::app()->request->getParam('gather'));
                $criteria->compare('isdelete', 0);
                if ($model->source_file_id) {
                    $order = '`id`="' . $model->source_file_id . '"';
                    $criteria->order = $order . 'DESC';
                }

                $dataProvider = new CActiveDataProvider('SourceFile', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                    'sort' => array(
                        'defaultOrder' => '`time_created` DESC',
                    ),
                ));
            }
            /* --------------------------查询素材的数据---------------------------- */
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
        }

        if (isset($_POST['Reply'])) {
            $model->attributes = $_POST['Reply'];
            $model->multi = $_POST['Reply']['multi'] ? $_POST['Reply']['multi'] : 0;
            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('admin_id', Yii::app()->user->id);
            if (empty($_POST['Reply']['source_file_id'])) {
                $model->setAttribute('source_file_id', '0');
            }
            if (empty($_POST['Reply']['content'])) {
                $model->setAttribute('content', '0');
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存回复内容成功。');
                //   $this->refresh();
                $rule_id = $model->rule_id;
                $this->redirect(array('/basis/rule/index', 'id' => $rule_id, 'rule_id' => $rule_id));
            } else {
                print_r($model->errors);
                exit;
                Yii::app()->user->setFlash('error', '保存回复内容失败，请您检查一下输入的是否正确。');
            }
        }


        $this->performAjaxValidation($model);

        $this->render('index', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Reply('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Reply']))
            $model->attributes = $_GET['Reply'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 关注欢迎语
     */
    public function actionWelcome() {
        $model = Welcome::model()->find('public_id=:public_id AND isdelete=:isdelete', array(':public_id' => Yii::app()->user->getState('public_id'), ':isdelete' => 0));
        if ($model === null) {
            $model = new Welcome;
        } else {
            $_GET['type'] = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : $model->type;
        }
        if (isset($_POST['Welcome'])) {
            $model->attributes = $_POST['Welcome'];
            $model->type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : 1;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存欢迎语成功。');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', '保存欢迎语失败，请您检查一下输入的是否正确。');
            }
        }

        $this->render('welcome', array(
            'model' => $model,
        ));
    }

    /**
     * 自动回复
     */
    public function actionAuto() {
        $model = Auto::model()->find('public_id=:public_id AND isdelete=:isdelete', array(':public_id' => Yii::app()->user->getState('public_id'), ':isdelete' => 0));
        if ($model === null) {
            $model = new Auto;
        }

        if (isset($_POST['Auto'])) {
            $model->attributes = $_POST['Auto'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存自动回复成功。');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', '保存自动回复失败，请您检查一下输入的是否正确。');
            }
        }

        $this->render('auto', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Reply the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Reply::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

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

    /**
     * Performs the AJAX validation.
     * @param Reply $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'reply-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
