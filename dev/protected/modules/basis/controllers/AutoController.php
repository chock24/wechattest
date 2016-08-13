<?php

class AutoController extends Controller {

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
                'roles' => array('1', '2', '3', '4'),
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
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $dataProvider = array();
        $sourceFileGather = array();
        $modelDataProvider = array('selectedId' => 0);
        $model = Auto::model()->find('public_id=:public_id AND isdelete=:isdelete', array(':public_id' => Yii::app()->user->getState('public_id'), ':isdelete' => 0));
        //该公众号 没有 自动回复
        //设定模板 取消模板
        $id = Yii::app()->request->getParam('id');
        $template = Yii::app()->request->getParam('template');
        if (!empty($id)) {
            if ($template == 0) {
                $model->updateByPk($id, array('template' => '0'));
                $this->redirect(array('auto/index'));
            } elseif ($template == 1) {
                $model->updateByPk($id, array('template' => '1'));
                $this->redirect(array('auto/index'));
            }
        }
        if ($model === null) {
            $model = new Auto;
            $automodel = Auto::model()->find('public_id = :public_id and isdelete=:isdelete and template=:template', array(':public_id' => '1', ':isdelete' => '0', ":template" => '1'));
            //存在模板
            if (!empty($automodel)) {
                $model = $automodel;
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
                $groupDataProvider = SourceFileGroup::model()->findAll($criteria);
                if ($model->source_file_id) {
                    $order = '`id`="' . $model->source_file_id . '"';
                    $criteria->order = $order . 'DESC';
                }
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
        if (isset($_POST['Auto'])) {

            $model->attributes = $_POST['Auto'];
            $model->type = Yii::app()->request->getParam('type') ? Yii::app()->request->getParam('type') : 1;
            $model->multi = Yii::app()->request->getParam('multi') ? Yii::app()->request->getParam('multi') : 0;
            $timePicker = explode('-', $model->time_start);
            if ($timePicker) {
                foreach ($timePicker as $key => $value) {
                    if (!$key) {
                        $model->time_start = strtotime($value);
                    } else {
                        $model->time_end = strtotime($value);
                    }
                }
            }
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存自动回复成功。');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', '保存自动回复失败，请您检查一下输入的是否正确。');
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
        $public_id = Yii::app()->user->getstate('public_id');
        if (!empty($id)) {
            $model = $this->loadModel($id);
        } else {
            $model = new Auto('insert');
        }
        $this->layout = 'operation';
        if (isset($_POST['Auto'])) {
            if ($model->public_id == $public_id) {
                $model->attributes = $_POST['Auto'];
            } else {
                $model = new Auto;
                $model->attributes = $_POST['Auto'];
                $model->setAttribute('public_id', $public_id);
            }
            if ($model->type == 5) {
                $model->content = '';
            }
            //保存开始 结束 时间
            if (!empty($_POST['Auto']['time_start'])) {
                $totime = explode("-", $_POST['Auto']['time_start']);
                $model->time_start = strtotime($totime[0]);
                $model->time_end = strtotime($totime[1]);
            }
            if ($model->save()) {//
                Yii::app()->user->setFlash('success', '保存自动回复设置成功');
                $this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error', '保存自动回复设置失败');
            }
        }

        $this->render('update', array(
            'model' => $model,
            'action' => 'update',
        ));
    }

    /*
     * 单图文列表显示
     */

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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Auto the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Auto::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Auto $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'auto-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
