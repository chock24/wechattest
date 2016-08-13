<?php

class CouponController extends Controller {

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

    /*
     * 删除 
     */

    public function actionDelete($id) {
        if (!empty($id)) {
            Coupon::model()->updateAll(array('delete' => '1'), 'id=:id', array(':id' => $id));
        }
        $this->redirect(array('index'));
    }

    public function actionIndex() {
        $model = new Coupon('search');
        $model->unsetAttributes();  // clear any default values
        $status = Yii::app()->request->getParam('status');
        $criteria = new CDbCriteria;
        if (!empty($_GET['Coupon']['name'])) {
            $name = $_GET['Coupon']['name'];
            $criteria->addSearchCondition('name', $name);
        }if ($status === '0') {
            $criteria->addSearchCondition('status', $status);
        }if ($status === '1') {
            $criteria->addSearchCondition('status', $status);
        }
        $criteria->order = 'order_by DESC';
        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $this->render('index'
                , array('dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Coupon('search');
        // $model = Transmit::model()->findAll('status=:status', array(':status' => '0'));
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['Coupon']))
            $model->attributes = $_GET['Coupon'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * 新建 转发新闻 
     */

    public function actionCreate() {
        $model = new Coupon;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Coupon'])) {
            $model->attributes = $_POST['Coupon'];
            $model->public_id = Yii::app()->user->public_id;
            $model->time_start = strtotime(@$_POST['Coupon']['time_start']);
            $model->time_end = strtotime(@$_POST['Coupon']['time_end']);
            $model->time_created = time();
            //从图库选择的图片 赋值
            if (!empty($_POST['Coupon']['image_src'])) {
                $imgname = @$_POST['Coupon']['image_src'];
                $model->setAttribute('image_src', $imgname);
                if ($model->save()) {
                    $this->redirect(array('index'));
                } else {
                    print_r($model->errors);
                    exit;
                }
            }
            //上传图片
            else {
                $files = CUploadedFile::getInstance($model, 'files');
                if (@$files->size > 2097152) {
                    //超过2M  
                    Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
                } else {
                    $filename = PublicStaticMethod::generateFileName();
                    if (is_object($files) && get_class($files) === 'CUploadedFile') {
                        $filename = PublicStaticMethod::generateFileName();
                        if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
                            PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
                            $model->setAttribute('image_src', @$filename . '.' . $files->extensionName);
                            $extensionName = $files->extensionName;
                            if ($model->save()) {
                                $model = new SourceFile();
                                $model->attributes = $_POST['Coupon'];
                                $model->setattribute('type', '2');
                                $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                                $model->setattribute('filename', $filename);
                                $model->setattribute('ext', $files->extensionName);
                                PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                                if ($model->save()) {
                                    $this->redirect(array('index'));
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /*
     * 修改 
     */

    public function actionUpdate($id = 0) {
        //$id = Yii::app()->request->getParam('id');
        if (!empty($id)) {
            $model = $this->loadModel($id);
        } else {
            $model = new Coupon;
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Coupon'])) {
            $model->attributes = $_POST['Coupon'];
            $model->time_start = strtotime($_POST['Coupon']['time_start']);
            $model->time_end = strtotime($_POST['Coupon']['time_end']);
            //从图库选择的图片 赋值
            if (!empty($_POST['Coupon']['image_src'])) {
                $imgname = @$_POST['Coupon']['image_src'];
                $model->setAttribute('image_src', $imgname);
                //   $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
            }
            //上传图片
            $files = CUploadedFile::getInstance($model, 'files');
            if (@$files->size > 2097152) {
                //超过2M  
                Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
            } else {
                $filename = PublicStaticMethod::generateFileName();
                if (is_object($files) && get_class($files) === 'CUploadedFile') {
                    $filename = PublicStaticMethod::generateFileName();
                    if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
                        PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
                        $model->setAttribute('image_src', @$filename . '.' . $files->extensionName);
                        $extensionName = $files->extensionName;

                        if ($model->save()) {
                            $model = new SourceFile();
                            $model->attributes = $_POST['Coupon'];
                            $model->setattribute('type', '2');
                            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                            $model->setattribute('filename', $filename);
                            $model->setattribute('ext', $files->extensionName);
                            PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                            if ($model->save()) {
                                $this->redirect(array('index'));
                            }
                        }
                    }
                }
            }
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);

        $model = Coupon::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

}
