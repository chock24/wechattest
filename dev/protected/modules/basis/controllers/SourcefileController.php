<?php

class SourcefileController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //   'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array(
                    'selonemsg',
                    'addmoremsg',
                    'index',
                    'view',
                    'appmsgmore',
                    'playvideo',
                    'create',
                    'update',
                    'voice',
                    'video',
                    'image',
                    'appmsg',
                    'moremsg',
                    'onlymsg',
                    'imggroup',
                    'imageupload',
                    'onlineimage',
                    'admin',
                    'delete',
                    'appmsgclass',
                    'news',
                    'morenews',
                    'sourcefile',
                    'createback',
                    'download',
                    'updatemsg',
                ),
                'roles' => array('1', '2'),
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
     * 下载 音频文件
     * @param int $id 二维码ID
     */
    public function actionDownload($id) {
        header("Content-Type: application/force-download");
        $model = SourceFile::model()->findByPk($id);
        if ($model == null) {
            throw new CHttpException('500', '对不起，您所下载的文件不存在');
        } else {
            if ($model->filename) {
                $this->downloadFile($model->filename);
                //Yii::app()->request->sendFile($model->filename.'.'.$model->ext, file_get_contents('/upload/sourcefile/voice/'.$model->filename.'.'.$model->ext));
            } else {
                throw new CHttpException('500', '对不起，您所下载的文件不存在');
            }
        }
    }

    /*
     * 视频播放页面 
     */

    public function actionPlayvideo() {
        $this->render('playvideo');
    }

    /*
     * 多图文页面
     */

    public function actionAppmsgmore() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $sourcefilegroup = SourceFileGroup::model();
        $sourcefilegroup->_select = 'gather_id,id,admin_id,sort,public_id,title,description,time_created';
        $sourcefilegroup->public_id = Yii::app()->user->getState('public_id');
        $dataProvider = $sourcefilegroup->search();
        $multi = '1';
        /* --------------------------查询素材的集合---------------------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,name,multi';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('type', 5);
        $criteria->compare('multi', 1);
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
        $this->render('appmsgmore', array(
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
            'multi' => $multi,
                )
        );
    }

    public function actionCreate() {
        $type = Yii::app()->request->getParam('type');
        $sourceFileGather = '';
        $public_id = Yii::app()->user->getState('public_id');
        if ($type == '2') {
            $model = new SourceFile('images');
        } elseif ($type == '3') {
            $model = new SourceFile('voice');
        } elseif ($type == '4') {
            $model = new SourceFile('video');
        }
        $sourceFileGather = $this->getSourceFlieGather($type, $public_id, 0);
        if (isset($_POST['SourceFile'])) {
            $model->attributes = $_POST['SourceFile'];
            $model->type = $type;
            $model->filename = CUploadedFile::getInstance($model, 'filename');
            $files = CUploadedFile::getInstance($model, 'filename');
            $title = $_POST['SourceFile']['title'];
            if ($type == '2') {
                if ($model->validate()) {
                    if (is_object($model->filename) && get_class($model->filename) === 'CUploadedFile') {
                        $filename = PublicStaticMethod::generateFileName();
                        $extensionName = $model->filename->extensionName;
                        $size = $model->filename->size;
                        if ($model->filename->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $extensionName)) {
                            $model->setattribute('filename', $filename);
                            $model->setattribute('ext', $extensionName);
                            $model->setattribute('size', $size);
                            PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                        }
                    }
                    if ($model->save()) {
                        if (!Yii::app()->user->getState('public_id')) {//如果当前没有公众号
                            Yii::app()->user->logout();
                            $this->redirect(Yii::app()->homeUrl);
                        } else {
                            $wechatInfo = $this->returnPart($model->id, $type);
                            $this->redirect(array('image', 'type' => $type));
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('error', '图片不符合规则，请您重新选择');
                }
            } else if ($type == '3') {//音频文件
                $length = $_POST['SourceFile']['length'];
                $extarray[] = 'mp3,wma,wav,amr';
                if (@$files->size > 5242880) {
                    //超过5M
                    Yii::app()->user->setFlash('alert', '文件已超过5M，请重新选择其他文件。');
                } else if (in_array($files->extensionName, $extarray)) {
                    Yii::app()->user->setFlash('alert', '文件类型错误，请重新选择其他文件。' . $files->extensionName);
                } else {
                    if (is_object($files) && get_class($files) === 'CUploadedFile') {
                        $filename = PublicStaticMethod::generateFileName();
                        if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/voice/' . $filename . '.' . $files->extensionName)) {
                            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                            $model->setattribute('type', $type);
                            $model->setattribute('title', @$title);
                            $model->setattribute('length', @$length);
                            $model->setattribute('size', $files->size);
                            $model->setattribute('filename', $filename);
                            $model->setattribute('ext', $files->extensionName);
                            //保存数据
                            if ($model->save()) {
                                //上传到微信端数据
                                $wechatInfo = $this->returnPart($model->id, $type);
                                $this->redirect(array('voice', 'type' => $type));
                            }
                        }
                    }
                }
            } else if ($type == "4") {
//视频文件
                $length = $_POST['SourceFile']['length'];
                //视频简介
                $extarray[] = 'mp4,flv,f4v,webm,3gp,3g2,m4v,rm,rmvb,avi,asf,wmv,mov';
                $description = $_POST['SourceFile']['description'];

                if (@$files->size > 20971520) {
                    //超过20M
                    Yii::app()->user->setFlash('alert', '文件已超过20M，请重新选择其他文件。');
                } else if (in_array($files->extensionName, $extarray)) {
                    Yii::app()->user->setFlash('alert', '文件类型错误，请重新选择其他文件。' . $files->extensionName);
                } else {
                    if (is_object($files) && get_class($files) === 'CUploadedFile') {
                        $filename = PublicStaticMethod::generateFileName();
                        if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/video/' . $filename . '.' . $files->extensionName)) {
                            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                            $model->setattribute('type', $type);
                            $model->setattribute('title', @$title);
                            $model->setattribute('length', @$length);
                            $model->setattribute('size', $files->size);
                            $model->setattribute('description', @$description);
                            $model->setattribute('filename', $filename);
                            $model->setattribute('ext', $files->extensionName);
                            if ($model->save()) {
                                $wechatInfo = $this->returnPart($model->id, $type);
                                $this->redirect(array('video', 'type' => $type));
                            } else {
                                var_dump($model->errors);
                                exit;
                            }
                        }
                    }
                }
            }
        }
        $this->render('create', array(
            'model' => $model,
            'type' => $type,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

//得到音频、视频 分组名称
    private function getSourceFlieGather($type = 0, $public_id = 0, $multi = 0) {
        $model = new SourceFileGather;
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,name,multi';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('type', $type);
        $criteria->compare('multi', $multi);
        $criteria->compare('isdelete', 0);
        return $model->findAll($criteria);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     *
     */
    public function actionUpdate($id) {
        $this->layout = '//layouts/operation';
        $model = $this->loadModel($id);
        $sourceFileGather = '';
        $type = Yii::app()->request->getParam('type');
        $public_id = Yii::app()->user->getstate('public_id');
        if ($type == 3 || $type == 4 || $type == 2) {
            $sourceFileGather = $this->getSourceFlieGather($type, $public_id, 0);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $this->performAjaxValidation($model);
        if (isset($_POST['SourceFile'])) {
            $model->attributes = $_POST['SourceFile'];
            if ($model->save()) {
                if ($type == '3') {
                    $this->redirect(array('voice', 'type' => $type));
                }
                $this->redirect(array('view', 'id' => $model->id, 'sourceFileGather' => $sourceFileGather));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'type' => $type,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    //单图文  修改
    public function actionUpdatemsg($id) {
        $layout = Yii::app()->request->getParam('layout');
        if (!empty($layout)) {
            $this->layout = '//layouts/column2';
        }
        //文件地址
        $model = $this->loadModel($id);
        $contnetname = $model->content;
        $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $contnetname;
        //读取文件 内容
        if (is_file($textname)) {
            $contents = file_get_contents($textname);
            $model->content = @$contents;
        }
        $groupid = Yii::app()->request->getParam('groupid');
        $type = Yii::app()->request->getParam('type');
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
        $dataProvider = SourceFile::model()->search('5'); //单图文 内容
        if (isset($_POST['SourceFile'])) {
            $post_public_id = @$_POST['SourceFile']['public_id'];
            $public_id = Yii::app()->user->getstate('public_id');
            if ($post_public_id != $public_id) {
                $model = new SourceFile;
            }
            $model->attributes = $_POST['SourceFile'];
            //content 赋值

            if (is_file($textname)) {
                file_put_contents($textname, @$_POST['SourceFile']['content']);
                $model->setattribute('content', $contnetname); //文件名不变
            } else {
                $content = $_POST['SourceFile']['content'];
                $textname = time() . ".txt";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $textname;
                if (file_put_contents($filepath, $content)) {
                    $model->setAttribute('content', $textname);
                }
            }
            $model->setAttribute('type', '5');
            if (isset($_POST['SourceFile']['template'])) {
                $model->setAttribute('template', $_POST['SourceFile']['template']);
            } else {
                $model->setAttribute('template', 0);
                $model->setAttribute('public_id', Yii::app()->user->getstate('public_id'));
            }
            if (!empty($_POST['SourceFile']['filename'])) {
                $names = explode('.', $_POST['SourceFile']['filename']);
                $model->setAttribute('filename', $names[0]);
                if (!empty($names[1])) {
                    $model->setAttribute('ext', $names[1]);
                }
            }
            $files = CUploadedFile::getInstance($model, 'files');
            if (is_object($files) && get_class($files) === 'CUploadedFile') {
                $filename = PublicStaticMethod::generateFileName();
                if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
                    PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
                    $model->setattribute('size', $files->size);
                    $model->setattribute('filename', $filename);
                    $model->setattribute('ext', $files->extensionName);
                    if ($model->save()) {
                        $this->redirect(array('news'));
                    }
                }
            }
            if ($model->save()) {
                if (!empty($groupid)) {
                    $this->redirect(array('moremsg', 'id' => $groupid));
                }
                $this->redirect(array('news'));
            } else {
                print-r($model->errors);
                exit;
            }
        }

        $this->render('onlymsg', array(
            'model' => $model,
            'type' => $type,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * 删除 和批量删除 修改isdelete 为1
     */
    public function actionDelete($id = 0) {

        //$this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!empty($id)) {
            SourceFile::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => @$id));
        }
        $type = Yii::app()->request->getParam('type');
        $gatherid = Yii::app()->request->getParam('gatherid');
        $ids = @$_POST['queryString'];
        $gatherids = @$_POST['gatherid'];

        if ($type == 'sourcefilegroup') {
            SourceFileGroup::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
            $this->redirect(array('appmsgmore'));
        }

        if (!empty($ids)) {
            $moreids = explode(',', $ids);
            if (count($moreids) > 1) {
                foreach ($moreids as $i) {
                    SourceFile::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => @$i));
                }
            } else {
                SourceFile::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => @$ids));
            }
            echo 'success';
            exit;
        }

        //if(!isset($_GET['ajax'])){

        if ($type == '3') {
            $this->redirect(array('voice', 'type' => $type));
        } else if ($type == '4') {
            $this->redirect(array('video', 'type' => $type));
        } else if ($type == '2') {
            $this->redirect(array('image', 'type' => '2', 'gather' => $gatherid));
        } else if ($type == '5') {
            $this->redirect(array('appmsg'));
        }
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('news'));
        //}
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $type = Yii::app()->request->getParam('type');
        $action = Yii::app()->request->getParam('action');
        $name = Yii::app()->request->getParam('name');
        $dataProvider = SourceFile::model()->search($type);
        $model = SourceFile::model()->findAll();

        $pictureurl = ''; // 'http://mmbiz.qpic.cn/mmbiz/k9Fic85iavYTLn9urJM48cobqbUmtJO6V1nTbPtk0Jic1c5xzzFSp6ibEo6TrjdVucgDeEn67vQDOMAX1sn2eNVekg/0';
        $inval = 'mmbiz.qpic.cn/mmbiz';
        //内容中包含 微信服务器图片 
        if (!empty($pictureurl)) {
            $success = explode($pictureurl, $inval);
            if (count($success) > 0) {
                $image = file_get_contents($pictureurl);
                $imagename = date("Ymdhis") . ".jpg";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/message/' . $imagename;
                file_put_contents($filepath, $image);
                echo '成功';
                exit;
            }
        }


        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'type' => $type,
            'action' => $action,
            'name' => $name,
        ));
    }

    /*
     * 音频页面 加载
     */

    public function actionVoice() {
        $model = new SourceFile();

        $model->_select = 'id,title,filename,ext,time_created';
        if (isset($_GET['SourceFile'])) {
            $model->attributes = $_GET['SourceFile'];
        }
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->type = 3;
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 20;

        $dataProvider = $model->getData();
        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), 3, 0);

        $this->render('voice', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /*
     * 视频页面 加载
     */

    public function actionVideo() {
        $model = new SourceFile();
        $model->_select = 'id,title,filename,ext,time_created';
        if (isset($_GET['SourceFile'])) {
            $model->attributes = $_GET['SourceFile'];
        }
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->type = 4;
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 20;
        $dataProvider = $model->getData();

        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), 4, 0);

        $this->render('video', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /*
     * 图片页面 加载 
     */

    public function actionImage() {
        $model = new SourceFile();
        $type = @$_GET['type'];
        if (@$type == 1) {
            $this->layout = '//layouts/operation';
        }
        $model->_select = 'id,title,filename,ext,time_created';
        if (isset($_GET['SourceFile'])) {
            $model->attributes = $_GET['SourceFile'];
        }
        $model->public_id = Yii::app()->user->getState('public_id');
        $model->type = 2;
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 20;
        $dataProvider = $model->getData();

        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), 2, 0);

        $this->render('image', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /*
     * 图文消息页面 加载
     */

    public function actionAppmsg() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = SourceFile::model();
        $model->public_id = Yii::app()->user->getState('public_id');
        $dataProvider = $model->search(5);

        /* --------------------------查询素材的集合---------------------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,name';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('type', 5);
        $criteria->compare('multi', 0);

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
        $this->render('appmsg', array(
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
                )
        );
    }

    /*
     * 单图文消息页面 加载
     */

    public function actionOnlymsg() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model = new SourceFile();
        if (isset($_POST['SourceFile'])) {
            $model->attributes = $_POST['SourceFile'];
            $model->setAttribute('template', @$_POST['SourceFile']['template']);
            $dataProvider = SourceFile::model()->search('5');
            //将href 替换
            if (!empty($_POST['SourceFile']['content'])) {
                $content = $_POST['SourceFile']['content'];
                $textname = time() . ".txt";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $textname;
                if (file_put_contents($filepath, $content)) {
                    $model->setAttribute('content', $textname);
                }
            }

            //从图库选择的图片 赋值
            if (!empty($_POST['SourceFile']['filename'])) {
                $imgname = explode('.', @$_POST['SourceFile']['filename']);
                $model->setAttribute('filename', @$imgname[0]);
                $model->setAttribute('ext', @$imgname[1]);
                $model->setAttribute('type', '5');
                $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
                if ($model->save()) {
                    $this->redirect(array('news'));
                } else {
                    print_r($model->error);
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
                            $model->setAttribute('type', '5');
                            $model->setattribute('ext', $files->extensionName);
                            $model->setAttribute('filename', @$filename);
                            $extensionName = $files->extensionName;
                            if ($model->save()) {
                                $model = new SourceFile();
                                $model->attributes = $_POST['SourceFile'];
                                $model->setattribute('type', '2');
                                $model->setAttribute('content', $textname);
                                $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                                $model->setattribute('filename', $filename);
                                $model->setattribute('ext', $files->extensionName);
                                PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                                if ($model->save()) {
                                    $this->redirect(array('news'));
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->render('onlymsg', array('model' => $model));
    }

//多图文
    public function actionmoremsg() {
        $imgpath = '';
        $model = new SourceFile();
        $id = Yii::app()->request->getParam('id');
        $sourcefiledetail = new SourceFileDetail();
        if (!empty($id)) {
            $sourcegroup = SourceFileGroup::model();
            $sourcegroup->_select = 'id,admin_id,public_id,title,description,time_created,author';
            $detailmodel = SourceFileDetail::model()->find('group_id=:group_id', array(":group_id" => $id));
            if (!empty($detailmodel)) {
                $file_id = $detailmodel->file_id;
                $model = SourceFile::model()->findByPk($file_id);
                $contnetname = $model->content;
                $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $contnetname;
                //读取文件 内容
                if (is_file($textname)) {
                    $contents = file_get_contents($textname);
                    $model->content = @$contents;
                }
            }

            $detailmodel = SourceFileDetail::model();
            $detailmodel->_select = 'id,group_id,file_id';
            $sourcefiledetail = $detailmodel->findAll('group_id = :group_id and isdelete = :isdelete ', array(':group_id' => $id, ':isdelete' => '0'));
        }
        $path = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/';
        $extArr = array("jpg", "png", "gif");
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $_FILES['photoimg']['name'];
            $size = $_FILES['photoimg']['size'];
            if (empty($name)) {
                echo '请选择要上传的图片';
                exit;
            }
            $extend = pathinfo($name);
            $ext = strtolower($extend["extension"]);
            if (!in_array($ext, $extArr)) {
                echo '图片格式错误！';
                exit;
            }
            if ($size > (1000 * 1024)) {
                echo '图片大小不能超过100KB';
                exit;
            }
            $image_name = time() . rand(100, 999) . "." . $ext;
            $tmp = $_FILES['photoimg']['tmp_name'];
            if (move_uploaded_file($tmp, $path . $image_name)) {
                $imgpath = $path . $image_name;
                Yii::app()->user->setFlash('imgpath', $imgpath);
                $imagename = explode('.', $image_name);
                $filename = $imagename[0];
                $ext = $imagename[1];
                PublicStaticMethod::photoShop($filename, $ext, Yii::app()->user->getState('public_watermark'));
                echo '<div class="preview-con-img"><img id = "imgcover" name = "' . $image_name . '" src="' . Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $image_name . '"  class="preview-img"></div>';
                //echo $imgpath;
            } else {
                echo '上传出错了！';
            }
            exit;
        }

        $this->render('onlymsg2', array('model' => $model, 'sourcefiledetail' => $sourcefiledetail));
    }

    /*
     * ajax 增加多图文
     */

    public function actionAddmoremsg() {
        //非空 表示修改
        if (!empty($_POST['btnall'])) {
            if (!empty($_POST['ids'])) {
                $ids = explode(",", $_POST['ids']);
                //id不为空 表示为修改
                if (!empty($_POST['id'])) {
                    $id = @$_POST['id'];
                    $model = SourceFileGroup::model()->findByPk($id);
                }
                //新增
                else {
                    $model = new SourceFileGroup();
                }
                $model->setAttribute('template', @$_POST['template']);
                $model->setAttribute('admin_id', Yii::app()->user->id);
                $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
                //多图文 分组 增加成功
                if ($model->save()) {
                    $groupid = $model->attributes['id'];
                    SourceFileDetail::model()->updateAll(array('isdelete' => '1'), 'group_id=:group_id', array(':group_id' => $groupid));
                    foreach ($ids as $key => $i) {
                        $sourcefiledetail = new SourceFileDetail();
                        $sourcefiledetail->setAttribute('group_id', @$groupid);
                        $sourcefiledetail->setAttribute('file_id', @$i);
                        $sourcefiledetail->setAttribute('sort', @$key);
                        //SourceFileDetail::model()->updateAll(array('isdelete'=>'0'),'id=:id',array(':id'=>$groupid));
                        if (@$i > 0) {
                            //查询存在 的关联数据
                            $detailmodel = SourceFileDetail::model()->find('group_id = :group_id and file_id =:file_id', array(':group_id' => @$groupid, ':file_id' => $i));
                            if (!empty($detailmodel)) {
                                SourceFileDetail::model()->updateAll(array('isdelete' => '0'), 'id=:id', array(':id' => $detailmodel->id));
                            } else {
                                $sourcefiledetail->save();
                            }
                        }
                    }
                    echo 'ok';
                    exit;
                } else {
                    echo 'error';
                    exit;
                }
            }
        }
        if (!empty($_POST['imageurl'])) {
            $upload = @$_POST['upload']; //是否为1上传 图片0从图库选择
            $imageurl = $_POST['imageurl'];
            $imagename = explode('.', $imageurl);
            $filename = $imagename[0];
            $fileExt = $imagename[1];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $public_name = $_POST['public_name'];
            $public_url = $_POST['public_url'];
            $show_content = $_POST['show_content'];
            $description = $_POST['description'];
            $content = @$_POST['content'];
            $content_source_url = $_POST['content_source_url'];
            $template = $_POST['template'];
            //表示上传
            if ($upload == '1') {
                //新增图片 
                $model = new SourceFile();
                $model->setAttribute('type', '2');
                $model->setattribute('title', $title);
                $model->setattribute('author', $author);
                $model->setattribute('public_name', $public_name);
                $model->setattribute('public_url', $public_url);
                $model->setattribute('show_content', $show_content);
                $model->setattribute('description', $description);

//content  赋值 文件名
                if (!empty($content)) {
                    $textname = time() . ".txt";
                    $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $textname;
                    if (file_put_contents($filepath, $content)) {
                        $model->setAttribute('content', $textname);
                    }
                }

                $model->setattribute('content_source_url', $content_source_url);
                $model->setattribute('template', $template);
                $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                $model->setattribute('filename', $filename); //图片名称
                $model->setattribute('ext', $fileExt); //后缀
                $model->save();
            }
            //从图库中选择
            else if ($upload == '0') {
                
            }
            if (!empty($_POST['id'])) {
                $id = $_POST['id'];
                $model = $this->loadModel($id);
            } else {
                $model = new SourceFile();
            }
            $model->setattribute('title', $title);
            $model->setattribute('author', $author);
            $model->setattribute('public_name', $public_name);
            $model->setattribute('public_url', $public_url);
            $model->setattribute('show_content', $show_content);
            $model->setattribute('description', $description);
            //content  赋值 文件名
            if (!empty($content)) {
                $textname = time() . ".txt";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $textname;
                if (file_put_contents($filepath, $content)) {
                    $model->setAttribute('content', $textname);
                }
            }
            $model->setattribute('content_source_url', $content_source_url);
            $model->setattribute('template', $template);
            $model->setattribute('type', '5');
            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setattribute('filename', $filename); //图片名称
            $model->setattribute('ext', $fileExt); //后缀
            //首先增加为单图文
            if ($model->save()) {

                $result = array('id' => $model->id, 'title' => $title, 'author' => $author, 'public_name' => $public_name, 'public_url' => $public_url, 'show_content' => $show_content,
                    'description' => $description, 'content' => $content, 'content_source_url' => $content_source_url, 'template' => $template, 'imageurl' => $imageurl);
                echo json_encode($result);
            } else {
                print_r($model->errors);
            }
        }
    }

    /*
     * ajax根据 id 查询 单图文内容
     */

    public function actionSelonemsg() {
        $id = @$_POST['id'];
        if (!empty($id)) {
            $model = SourceFile::model()->findByPk($id);
            $contents = $model->content;
            $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . @$contents;
            //读取文件 内容
            if (is_file($textname)) {
                $contents = file_get_contents($textname);
            } else {
                $content = $_POST['SourceFile']['content'];
                $textname = time() . ".txt";
                $filepath = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $textname;
                if (file_put_contents($filepath, $content)) {
                    $contents = $textname;
                }
            }

            if (!empty($model)) {
                $result = array('id' => $model->id, 'title' => $model->title, 'author' => $model->author, 'public_name' => $model->public_name, 'public_url' => $model->public_url, 'show_content' => $model->show_content,
                    'description' => $model->description, 'content' => @$contents, 'content_source_url' => $model->content_source_url, 'template' => $model->template, 'filename' => $model->filename, 'ext' => $model->ext);
                echo json_encode($result);
            }
        }
    }

    /*
     * 多图文消息页面 加载
     */

    public function actionMoremsgold() {
        if (Yii::app()->user->getState('public_id') === 0) {
            throw new CHttpException('500', '对不起，您需要先创建公众号。');
        }
        $model2 = SourceFile::model();
        $model2->_select = '*';
        $model2->public_id = Yii::app()->user->getState('public_id');
        $dataProvider = $model2->search('5');
        $model = new SourceFileGroup();
        $sourcefiledetail = new SourceFileDetail();
        $id = Yii::app()->request->getParam('id');
        if (isset($_POST['SourceFileGroup'])) {
            $groupid = ($_POST['SourceFileGroup']['id']);
            if (!empty($_POST['SourceFileGroup']['ids'])) {
                $ids = explode(",", $_POST['SourceFileGroup']['ids']);
                //	如果groupid 不空 则为 修改
                if (!empty($groupid)) {
                    $model = SourceFileGroup::model()->findBypk($groupid);
                    $post_public_id = $model->public_id;
                    $public_id = Yii::app()->user->getstate('public_id');
                    //判断修改的是否是模板
                    if ($post_public_id != $public_id) {
                        $model = new SourceFileGroup;
                    }
                    $model->attributes = $_POST['SourceFileGroup'];
                    $model->setAttribute('type', '5');
                    if (isset($_POST['SourceFileGroup']['template'])) {
                        $model->setAttribute('template', $_POST['SourceFileGroup']['template']);
                    } else {
                        $model->setAttribute('template', 0);
                        $model->setAttribute('public_id', Yii::app()->user->getstate('public_id'));
                    }
                    $model->attributes = $_POST['SourceFileGroup'];
                    //多图文 分组 修改成功 
                    if ($model->save()) {
                        $groupid = $model->attributes['id'];
                        SourceFileDetail::model()->updateAll(array('isdelete' => '1'), 'group_id=:group_id', array(':group_id' => $groupid));
                        foreach ($ids as $key => $i) {
                            $sourcefiledetail = new SourceFileDetail();
                            $sourcefiledetail->setAttribute('group_id', @$groupid);
                            $sourcefiledetail->setAttribute('file_id', @$i);
                            $sourcefiledetail->setAttribute('sort', @$key);
                            $sourcefiledetailmodel = SourceFileDetail::model()->find('group_id=:group_id AND file_id =:file_id ', array(':group_id' => @$groupid, ':file_id' => @$i));
                            if (!empty($sourcefiledetailmodel)) {
                                SourceFileDetail::model()->updateAll(array('isdelete' => '0', 'sort' => @$key), 'id=:id', array(':id' => $sourcefiledetailmodel->id));
                            } else {
                                if ($sourcefiledetail->save()) {
                                    
                                } else {
                                    print_r($sourcefiledetail->errors);
                                }
                            }
                        }
                        $dataProvider = SourceFile::model()->search('5');
                        $this->redirect(array('morenews'));
                    }
                }
                //空的话 为新增 
                else {
                    if (!empty($_POST['SourceFileGroup']['title'])) {
                        $title = $_POST['SourceFileGroup']['title'];
                    }
                    if (!empty($_POST['SourceFileGroup']['description'])) {
                        $description = $_POST['SourceFileGroup']['description'];
                    }
                    $model->setAttribute('template', $_POST['SourceFileGroup']['template']);
                    $model->setAttribute('title', @$title);
                    $model->setAttribute('admin_id', Yii::app()->user->id);
                    $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
                    $model->setAttribute('description', @$description);
                    //多图文 分组 增加成功
                    if ($model->save()) {
                        $groupid = $model->attributes['id'];
                        foreach ($ids as $key => $i) {
                            $sourcefiledetail = new SourceFileDetail();
                            $sourcefiledetail->setAttribute('group_id', @$groupid);
                            $sourcefiledetail->setAttribute('file_id', @$i);
                            $sourcefiledetail->setAttribute('sort', @$key);
                            $sourcefiledetail->save();
                        }
                        $dataProvider = SourceFile::model()->search('5');
                        $this->redirect(array('morenews'));
                    }
                }
            }
        }
        if (!empty($id)) {
            $sourcegroup = SourceFileGroup::model();
            $sourcegroup->_select = 'id,admin_id,public_id,title,description,time_created';
            $model = $sourcegroup->find('id=:id', array(':id' => $id));
            $detailmodel = SourceFileDetail::model();
            $detailmodel->_select = 'id,group_id,file_id';
            $sourcefiledetail = $detailmodel->findAll('group_id = :group_id and isdelete = :isdelete ORDER BY sort  ASC', array(':group_id' => $id, ':isdelete' => '0'));
        }
        /* --------------------------查询素材的集合---------------------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,name';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('type', 5);
        $criteria->compare('multi', 0);
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
        $this->render('moremsg', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'sourcefiledetail' => $sourcefiledetail,
            'sourceFileGather' => $sourceFileGather,
                )
        );
    }

    /*
     * 
     */

    public function actionAppmsgclass() {
        $this->layout = '//layouts/operation';
        $dataProvider = SourceFile::model()->search('5');
        $this->render('appmsgclass', array(
            'dataProvider' => $dataProvider,
                )
        );
    }

    /*
     * 图片 分组显示
     */

    public function actionImggroup() {
        $this->layout = '//layouts/operation';
        $type = Yii::app()->request->getParam('type');
        $dataProvider = SourceFile::model()->search($type);
        //查询分组
        $sourcefilegather = SourceFileGather::model()->findAll('isdelete=:isdelete and type=:type', array(':isdelete' => '0', ':type' => $type));
        $model = new SourceFile();
        $model->setScenario('image'); //验证场景
        //$this->performAjaxValidation($model);
        $this->render('imggroup', array('dataProvider' => $dataProvider,
            'model' => $model,
            'type' => $type,
            'sourcefilegather' => $sourcefilegather,)
        );
    }

    /*
     * 单图文列表 显示
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

    /* -------------------后期重构方法------------------ */

    /**
     * 单图文列表页
     * @throws CHttpException
     */
    public function actionNews() {
        $model = new SourceFile();
        $model->_select = 'id,title,filename,ext,time_created,description';
        if (isset($_GET['SourceFile'])) {
            $model->attributes = $_GET['SourceFile'];
        }
        $public_id = Yii::app()->user->getState('public_id');
        $model->public_id = $public_id;
        $model->type = 5;
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 21;
        $dataProvider = $model->getData();
        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), 5, 0);
        $publicmodel = WcPublic::model()->findByPk($public_id);
        $this->render('news', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
            'publicmodel' => $publicmodel,
        ));
    }

    /**
     * 多图文列表页
     * @throws CHttpException
     */
    public function actionMorenews() {
        $model = new SourceFileGroup();
        $model->_select = 'id,title,time_created,description';
        if (isset($_GET['SourceFileGroup'])) {
            $model->attributes = $_GET['SourceFileGroup'];
        }
        $public_id = Yii::app()->user->getState('public_id');
        $model->public_id = $public_id;
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 9;
        $dataProvider = $model->getData();

        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), 5, 1);
        $publicmodel = WcPublic::model()->findByPk($public_id);
        $this->render('morenews', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
            'publicmodel' => $publicmodel,
        ));
    }

    /**
     * 编辑器
     * 图片上传
     */
    public function actionImageupload() {
        $config = array(
            "uploadPath" => "upload/sourcefile/image/source/", //保存路径
            "fileType" => array(".gif", ".png", ".jpg", ".jpeg", ".bmp"), //文件允许格式
            "fileSize" => 2000 //文件大小限制，单位KB
        );
        //原始文件名，表单名固定，不可配置
        $oriName = htmlspecialchars($_POST['fileName'], ENT_QUOTES);
        //上传图片框中的描述表单名称，
        $title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
        //文件句柄
        $file = $_FILES["upfile"];
        //文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
        $state = "SUCCESS";
        //重命名后的文件名
        $fileName = '';

        //保存路径
        $path = $config['uploadPath'];

        if (!file_exists($path)) {
            mkdir("$path", 0777);
        }
        //格式验证
        $current_type = strtolower(strrchr($file["name"], '.'));
        if (!in_array($current_type, $config['fileType']) || false == getimagesize($file["tmp_name"])) {
            $state = "不允许的图片格式";
        }
        //大小验证
        $file_size = 1024 * $config['fileSize'];
        if ($file["size"] > $file_size) {
            $state = "图片大小超出限制";
        }
        //保存图片
        if ($state == "SUCCESS") {
            $tmp_file = $file["name"];
            $ext = pathinfo($tmp_file, PATHINFO_EXTENSION);
            $fileName = PublicStaticMethod::generateFileName();
            $result = move_uploaded_file($file["tmp_name"], $path . $fileName . '.' . $ext);
            if (!$result) {
                $state = "未知错误";
            } else {
                PublicStaticMethod::photoShop($fileName, $ext, Yii::app()->user->getState('public_watermark'));
                $model = new SourceFile;
                $model->setattribute('type', 2);
                $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
                $model->setattribute('title', $title);
                $model->setattribute('size', $file["size"]);
                $model->setattribute('filename', $fileName);
                $model->setattribute('ext', $ext);
                if ($model->save()) {
                    $fileName = PublicStaticMethod::returnSourceFile($model->filename, $model->ext, 'image', 'source');
                }
            }
        }
        echo "{'url':'" . $fileName . "','title':'" . $title . "','original':'" . $oriName . "','state':'" . $state . "'}";
    }

    /**
     * 返回图片 信息部分
     * @param int $id
     */
    private function returnPart($id = 0, $type = 0) {
        $dataProvider = array();
        $criteria = new CDbCriteria();
        $criteria->select = array(
            'id',
            'type',
            'title',
            'filename',
            'ext',
            'description',
        );
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $model = SourceFile::model()->findByPk($id, $criteria);
        $criteria = new CDbCriteria();
        $criteria->select = 'media_id';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('source_file_id', $id);
        $criteria->compare('type', $type);
        $criteria->compare('isdelete', 0);
        $criteria->order = '`time_created` DESC';
        $media = MediaId::model()->find($criteria);
        if ($model !== null) {//如果素材存在
            if ($media !== null) {//如果media存在
                $dataProvider['media_id'] = $media->media_id;
                $dataProvider['title'] = $model->title;
            } else {
                $publicArr = array(
                    'appid' => Yii::app()->user->getState('public_appid'),
                    'appsecret' => Yii::app()->user->getState('public_appsecret'),
                );
                $access_token = WechatStaticMethod::getAccessToken($publicArr);
                if (!empty($type)) {
                    //上传图片 永久素材
                    if ($type == 2) {
                        //上传图片 永久素材
                        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=" . $access_token;
                        //上传 为临时图片
                        // $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $access_token . "&type=image";
                        $postArr = array();
                        if (class_exists('\CURLFile', FALSE)) {
                            $postArr['media'] = new CURLFile(PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'image', 'source'));
                        } else {
                            $postArr['media'] = '@' . PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'image', 'source');
                        }
                    } else {
                        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=" . $access_token;
                        $postArr = array();
                        $video_info = array();
                        if ($type == 3) {
                            //上传音频 永久素材
                            if (class_exists('\CURLFile', FALSE)) {
                                $postArr['media'] = new CURLFile(PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'voice', 'voice'));
                            } else {
                                $postArr['media'] = '@' . PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'voice', 'voice');
                            }
                        } else if ($type == 4) {
                            //上传视频 永久素材
                            if (class_exists('\CURLFile', FALSE)) {
                                $postArr['media'] = new CURLFile(PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'video', 'video'));
                            } else {
                                $postArr['media'] = '@' . PublicStaticMethod::returnFilePath('sourcefile', $model->filename, $model->ext, 'video', 'video');
                            }
                            $video_info['title'] = $model->filename . '.' . $model->ext;
                            $video_info['introduction'] = $model->description;
                            $postArr['description'] = json_encode($video_info);
                        }
                    }
                }
                $result = WechatStaticMethod::https_request($url, $postArr);
                $result = json_decode($result, true);
                if (isset($result['media_id'])) {
                    $media = new MediaId();
                    $media->type = $model->type;
                    $media->source_file_id = intval($model->id);
                    $media->media_id = $result['media_id'];
                    $media->media_create_time = time();
                    //返回url 未保存$result['url'];
                    if ($media->save()) {
                        $dataProvider['media_id'] = $media->media_id;
                        $dataProvider['title'] = $model->title;
                    }
                } else {
                    if ($result['errcode'] == '40006') {
                        echo '不合法的文件大小';
                        exit;
                    }
                    return false;
                }
            }
        }

        return $dataProvider;
    }

    /**
     * 上传永久素材(认证后的订阅号可用)
     * 新增的永久素材也可以在公众平台官网素材管理模块中看到
     * 注意：上传大文件时可能需要先调用 set_time_limit(0) 避免超时
     * 注意：数组的键值任意，但文件名前必须加@，使用单引号以避免本地路径斜杠被转义
     * @param array $data {"media":'@Path\filename.jpg'}
     * @param type 类型：图片:image 语音:voice 视频:video 缩略图:thumb
     * @param boolean $is_video 是否为视频文件，默认为否
     * @param array $video_info 视频信息数组，非视频素材不需要提供 array('title'=>'视频标题','introduction'=>'描述')
     * @return boolean|array
     */
    public function uploadForeverMedia($data, $type, $is_video = false, $video_info = array()) {
        if (!$this->access_token && !$this->checkAuth())
            return false;
        //#TODO 暂不确定此接口是否需要让视频文件走http协议
        //如果要获取的素材是视频文件时，不能使用https协议，必须更换成http协议
        //$url_prefix = $is_video?str_replace('https','http',self::API_URL_PREFIX):self::API_URL_PREFIX;
        //当上传视频文件时，附加视频文件信息
        if ($is_video)
            $data['description'] = self::json_encode($video_info);
        $result = $this->http_post(self::API_URL_PREFIX . self::MEDIA_FOREVER_UPLOAD_URL . 'access_token=' . $this->access_token . '&type=' . $type, $data, true);
        if ($result) {
            $json = json_decode($result, true);
            if (!$json || !empty($json['errcode'])) {
                $this->errCode = $json['errcode'];
                $this->errMsg = $json['errmsg'];
                return false;
            }
            return $json;
        }
        return false;
    }

    /**
     * 编辑器在线图片管理
     */
    public function actionOnlineimage() {
        $criteria = new CDbCriteria();
        $criteria->select = 'filename,ext';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('type', 2);
        $criteria->compare('isdelete', 0);
        $criteria->order = '`time_created` DESC';
        $dataProvider = SourceFile::model()->findAll($criteria);
        $data = array();
        if ($dataProvider) {
            foreach ($dataProvider as $key => $value) {
                $data[$key]['icon'] = PublicStaticMethod::returnSourceFile($value['filename'], $value['ext'], 'image', 'icon');
                $data[$key]['source'] = PublicStaticMethod::returnSourceFile($value['filename'], $value['ext'], 'image', 'watermark');
            }
        }
        $dataString = '';
        foreach ($data as $value) {
            $dataString .= $value['icon'] . 'self_separate_self' . $value['source'] . 'ue_separate_ue';
        }
        echo $dataString;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SourceFile the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SourceFile::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SourceFile $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'source-file-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
