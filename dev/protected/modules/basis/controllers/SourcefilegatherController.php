<?php

class SourcefilegatherController extends Controller {

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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'group'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
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
     * 创建分组
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = '//layouts/operation';
        $model = new SourceFileGather;
        $type = Yii::app()->request->getParam('type');
        $multi = Yii::app()->request->getParam('multi');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['SourceFileGather'])) {
            $model->attributes = $_POST['SourceFileGather'];
            $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('type', @$type);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $this->render('create', array(
            'model' => $model,
            'multi' => $multi,
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
        $multi = Yii::app()->request->getParam('multi');
//        if (empty($multi)) {
//            $multi = '0';
//        }
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['SourceFileGather'])) {
            // $model->attributes = $_POST['SourceFileGather'];
            $model->setAttribute('name', $_POST['SourceFileGather']['name']);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));

        //		$model = SourceFileGather::model()->findBypk($id);
        //		$type=Yii::app()->request->getParam('type');
        //		if(isset($_POST['SourceFileGather']))
        //		{
        //			$model->attributes=$_POST['SourceFileGather'];
        //			if($model->save())
        //			$this->redirect(array('view','id'=>$model->id));
        //		}
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id)->updateByPk($id, array('isdelete' => 1));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->request->urlReferrer);
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->layout = '//layouts/operation';
        $dataProvider = new CActiveDataProvider('SourceFileGather');
        //$this->performAjaxValidation($dataProvider);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * 分组列表显示 没有被删除的
     */
    public function actionGroup() {

        $this->layout = '//layouts/operation';
        $gatherid = Yii::app()->request->getParam('gather_id'); //得到gather_id
        $id = Yii::app()->request->getParam('id'); //得到 id
        $ids = Yii::app()->request->getParam('ids'); //得到 ids
        

        $multi = Yii::app()->request->getParam('multi'); //得到 multi
        if (empty($multi)) {
            $multi = 0;
        }
        $type = Yii::app()->request->getParam('type'); //得到 type //类别
        $dataProvider = SourceFileGather::model()->findAll('isdelete=:isdelete and type=:type and multi = :multi', array(':isdelete' => '0', ':type' => $type, ':multi' => $multi));
        $model = new SourceFileGather();
        $this->performAjaxValidation($model);

        if (isset($_POST['SourceFileGather'])) {
            if (@$_POST['SourceFileGather']['id'] == '0' || $_POST['SourceFileGather']['id'] == '') {
                Yii::app()->user->setFlash('errors', '请选择分类');
                return false;
            } else {
                if (isset($_POST['SourceFileGather']['ids'])) {//批量移动   图片
                    $sourceids = explode(',', $_POST['SourceFileGather']['ids']);
                    if (count($sourceids) > 1) {
                        foreach ($sourceids as $i) {
                            SourceFile::model()->updateAll(array('gather_id' => $_POST['SourceFileGather']['id']), 'id=:id', array(':id' => $i));
                        }
                    } else {
                        SourceFile::model()->updateAll(array('gather_id' => $_POST['SourceFileGather']['id']), 'id=:id', array(':id' => @$_POST['SourceFileGather']['ids']));
                    }
                } else {
                    if (!empty($multi) && $multi == '1') {
                        SourceFileGroup::model()->updateAll(array('gather_id' => $_POST['SourceFileGather']['id']), 'id=:id', array(':id' => $id));
                        $gather_id=$_POST['SourceFileGather']['id'];
                        $this->redirect(Yii::app()->createUrl('basis/sourcefile/morenews/', array('type' => $type, 'gather_id' => $gather_id)));
                    }
                    SourceFile::model()->updateAll(array('gather_id' => $_POST['SourceFileGather']['id']), 'id=:id', array(':id' => $id));
                }

                $gatherid = $_POST['SourceFileGather']['id'];
                if ($type == '2') {
                    $this->redirect(Yii::app()->createUrl('basis/sourcefile/image/', array('type' => $type, 'gather_id' => $gatherid)));
                } elseif ($type == '3') {
                    $this->redirect(Yii::app()->createUrl('basis/sourcefile/voice/', array('type' => $type, 'gather_id' => $gatherid)));
                } elseif ($type == '4') {
                    $this->redirect(Yii::app()->createUrl('basis/sourcefile/video/', array('type' => $type, 'gather_id' => $gatherid)));
                } elseif ($type == '5') {
                    
                    $this->redirect(Yii::app()->createUrl('basis/sourcefile/news/', array('type' => $type, 'gather_id' => $gatherid)));
                }
            }
        }
        $this->render('group', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'gatherid' => $gatherid,
            'ids' => $ids,
            'type' => $type,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SourceFileGather('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SourceFileGather']))
            $model->attributes = $_GET['SourceFileGather'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SourceFileGather the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SourceFileGather::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SourceFileGather $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'source-file-gather-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
