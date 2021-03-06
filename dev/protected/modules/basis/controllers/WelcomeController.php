<?php

class WelcomeController extends Controller {

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
            array('allow',
                'actions' => array('index', 'update', 'sourcefile'),
                'roles' => array('1', '2'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $public_id = Yii::app()->user->getstate('public_id');
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $dataProvider = array();
        $sourceFileGather = array();
        $modelDataProvider = array('selectedId' => 0);
        $model = Welcome::model()->find('public_id=:public_id AND isdelete=:isdelete', array(':public_id' => Yii::app()->user->getState('public_id'), ':isdelete' => 0));
        //此公众号 没有 欢迎语
        if ($model === null) {
            $model = new Welcome;
            //查询主公众号 是否存在模板
            $templatemodel = Welcome::model()->find('public_id=:public_id AND isdelete=:isdelete and template = :template', array(':public_id' => '1', ':isdelete' => 0, ':template' => '1'));
            if (!empty($templatemodel)) {
                //存在模板
//                $model->attributes = $templatemodel->attributes;
//                $model->unsetAttributes(array('id'));
//                $model->setAttribute('public_id', $public_id);
//                $model->setAttribute('template', $templatemodel->template);
//                //复制模板内容
//                if ($model->save()) {
//                    
//                } else {
//                    var_dump($model->errors());
//                }
                $model = $templatemodel;
            }
        } else {
            $modelDataProvider['selectedId'] = $model->source_file_id;
            if (Yii::app()->request->getParam('multi') == '') {
                $_GET['multi'] = $model->multi;
            } elseif (Yii::app()->request->getParam('multi') === 0) {
                $_GET['multi'] = Yii::app()->request->getParam('multi') == '0' ? 0 : Yii::app()->request->getParam('multi');
            }
            $_GET['type'] = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : $model->type;
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

        if (isset($_POST['Welcome'])) {
            $model->attributes = $_POST['Welcome'];
            $model->type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : 1;
            $model->multi = Yii::app()->request->getParam('multi') ? Yii::app()->request->getParam('multi') : 0;

            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存欢迎语成功。');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', '保存欢迎语失败，请您检查一下输入的是否正确。');
            }
        }
        $this->performAjaxValidation($model);
        //设定模板 取消模板
        $id = Yii::app()->request->getParam('id');
        $template = Yii::app()->request->getParam('template');
        if (!empty($id)) {
            if ($template == 0) {
                $model->updateByPk($id, array('template' => '0'));
                $this->redirect(array('welcome/index'));
            } elseif ($template == 1) {
                $model->updateByPk($id, array('template' => '1'));
                $this->redirect(array('welcome/index'));
            }
        }
        $this->render('index', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $public_id = Yii::app()->user->getstate('public_id');
        if ($model === null) {
            $model = new Welcome('insert');
        }
        $this->layout = '//layouts/operation';

        if (isset($_POST['Welcome'])) {

            if ($model->public_id == $public_id) {

                $model->attributes = $_POST['Welcome'];
            } else {
                $model = new Welcome;
                $model->attributes = $_POST['Welcome'];
                $model->setAttribute('public_id', $public_id);
            }
            if ($model->type == 5) {
                $model->content = '';
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存欢迎语设置成功');
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error', '保存欢迎语设置失败');
            }
        }

        $this->render('update', array(
            'model' => $model,
            'action' => 'update',
        ));
    }

    public function actionSourcefile() {

        $this->layout = '//layouts/operation';
        if (Yii::app()->request->getParam('multi')) {
            $model = new SourceFileGroup();
            $model->_select = 'id,title,time_created,description';
            if (isset($_GET['SourceFileGroup'])) {
                $model->attributes = $_GET['SourceFileGroup'];
            }
            //
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Welcome the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Welcome::model()->findByPk($id);
        //if ($model === null)
        //throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Welcome $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'welcome-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
