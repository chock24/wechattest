<?php

class TransmitController extends Controller {

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
                'actions' => array('ajaxupdate', 'index', 'admin', 'view', 'update', 'create', 'delete', 'childtransmitType'),
                'roles' => array('1', '2', '3'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $model = new Transmit('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
        if (!empty($_GET['Transmit']['title'])) {
            $title = $_GET['Transmit']['title'];
            $criteria->addSearchCondition('title', $title);
        }
        $criteria->compare('isdelete', 0);
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

    /*
     * 新建 转发新闻 
     */

    public function actionCreate() {
        $model = new Transmit;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $transmitmodel = TransmitType::model()->findAll('parent_id=:parent_id and status=:status', array(':parent_id' => '0', ':status' => '0'));
        $trantype = array();
        if (!empty($transmitmodel)) {
            foreach ($transmitmodel as $t) {
                $trantype[$t->id] = $t->name;
            }
        }
        if (isset($_POST['Transmit'])) {
            $model->attributes = $_POST['Transmit'];
            $model->show_cover_pic = $_POST['Transmit']['show_cover_pic'];
            $model->admin_id = Yii::app()->user->id;
            $model->public_id = Yii::app()->user->public_id;
            $model->content_source_url = $_POST['Transmit']['content_source_url'];
            $model->time_start = strtotime($_POST['Transmit']['time_start']);
            $model->time_end = strtotime($_POST['Transmit']['time_end']);
            if ($_POST['Transmit']['number'] == 0) {
                $model->number = rand(200, 600);
            }
            $type_id = @$_POST['Transmit']['child_type_id'];
            //内容增加到对应文档
            if (!empty($_POST['Transmit']['content'])) {
                $content = $_POST['Transmit']['content'];
                $textname = time() . ".txt";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/transmit/' . $textname;
                if (file_put_contents($filepath, $content)) {
                    $model->setAttribute('content', $textname);
                }
            }

            if ($type_id > 0) {
                $model->type_id = $type_id;
            }
            //从图库选择的图片 赋值
            if (!empty($_POST['Transmit']['image_src'])) {
                $imgname = @$_POST['Transmit']['image_src'];
                $model->setAttribute('image_src', $imgname);
                //   $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
                if ($model->save()) {
                    $this->redirect(array('index'));
                } else {
                    print_r($model->error);
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
                                $model->attributes = $_POST['Transmit'];
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
            'trantype' => $trantype,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Transmit('search');
        // $model = Transmit::model()->findAll('status=:status', array(':status' => '0'));
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['Transmit']))
            $model->attributes = $_GET['Transmit'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * 修改 
     */

    public function actionUpdate($id = 0) {

        $model = $this->loadModel($id);
        $contnetname = $model->content;
        $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/transmit/' . $contnetname;
        //读取文件 内容
        if (is_file($textname)) {
            $contents = file_get_contents($textname);
            $model->content = @$contents;
        }

        $transmitmodel = TransmitType::model()->findAll('parent_id=:parent_id and status=:status', array(':parent_id' => '0', ':status' => '0'));
        //一级分类
        $trantype = array();
        if (!empty($transmitmodel)) {
            foreach ($transmitmodel as $t) {
                $trantype[$t->id] = $t->name;
            }
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Transmit'])) {
            $model->attributes = $_POST['Transmit'];
            $type_id = @$_POST['Transmit']['child_type_id'];
            $model->content_source_url = $_POST['Transmit']['content_source_url'];
            $model->show_cover_pic = $_POST['Transmit']['show_cover_pic']; //是否显示封面图
            $model->time_start = strtotime($_POST['Transmit']['time_start']);
            $model->time_end = strtotime($_POST['Transmit']['time_end']);
            //content 赋值

            if (is_file($textname)) {
                file_put_contents($textname, @$_POST['Transmit']['content']);
                $model->setattribute('content', $contnetname); //文件名不变
            } else {
                $content = $_POST['Transmit']['content'];
                $textname = time() . ".txt";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/transmit/' . $textname;
                if (file_put_contents($filepath, $content)) {
                    $model->setAttribute('content', $textname);
                }
            }
            if ($type_id > 0) {
                $model->type_id = $type_id;
            }
            //从图库选择的图片 赋值
            if (!empty($_POST['Transmit']['image_src'])) {
                $imgname = @$_POST['Transmit']['image_src'];
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
                            $model->attributes = $_POST['Transmit'];
                            $model->setattribute('type', '2');
                            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                            $model->setattribute('filename', $filename);
                            $model->setattribute('ext', $files->extensionName);
                            PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                            if ($model->save()) {
                                $this->redirect(array('index'));
                            } else {
                                var_dump($model->errors);
                                exit;
                            }
                        }else {
                                var_dump($model->errors);
                                exit;
                            }
                    }
                }
            }


            // $model->type_id = ;
            if ($model->save()){
                $this->redirect(array('index'));
            }else {
                var_dump($model->errors);exit;
            }
        }
        $this->render('update', array(
            'model' => $model,
            'trantype' => $trantype,
        ));
    }

    /*
     * 根据id 查询二级分类
     */

    public function actionChildtransmitType() {
        $id = @$_POST['id'];
        if (empty($id)) {
            $id = $_GET['id'];
        }
        if (!empty($id)) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id,name,status';
            $criteria->compare('parent_id', $id);
            $criteria->compare('status', 0);
            $childtype = TransmitType::model()->findAll($criteria);
            $childtypearr = array();
            // echo json_encode(CHtml::listData(TransmitType::model()->findAll($criteria), 'id', 'name'));
            if (!empty($childtype)) {
                foreach ($childtype as $c) {
                    // $childtypearr[$c->id] =$c->name;
                    $childtypearr[] = array("id" => $c->id, "name" => $c->name);
                }
            }

            echo json_encode($childtypearr);
        }
    }

    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);
        $criteria->compare('isdelete', 0);
        $model = Transmit::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

    /*
     * 删除 
     */

    public function actionDelete($id) {
        if (!empty($id)) {
            Transmit::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
        }
        $this->redirect(array('index'));
    }

    //index 页面ajax 修改内容
    public function actionAjaxUpdate() {
        $id = $_POST['id'];
        $data_name = $_POST['data_name'];
        $value = $_POST['value'];
        if ($id && $data_name) {
            if ($data_name == 'data-title') {
                $data['title'] = $value;
            } else if ($data_name == 'data-by') {
                $data['order_by'] = $value;
            } else if ($data_name = 'data-status') {
                $data['status'] = $value;
            }
            Transmit::model()->updateAll($data, 'id=:id', array(':id' => $id));
            echo 'success';
        }
    }

}
