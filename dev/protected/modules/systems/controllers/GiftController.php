<?php

class GiftController extends Controller {

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
                'actions' => array('giftimg', 'ajaxupdate', 'index', 'admin', 'view', 'update', 'create', 'delete'),
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
            Gift::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
        }
        $this->redirect(array('index'));
    }

    public function actionIndex() {
        $model = new Gift('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
        if (!empty($_GET['Gift']['name'])) {
            $name = $_GET['Gift']['name'];
            $criteria->addSearchCondition('name', $name);
        }
        $criteria->compare('public_id', @Yii::app()->user->public_id);
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

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Gift('search');
        // $model = Transmit::model()->findAll('status=:status', array(':status' => '0'));
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['Gift']))
            $model->attributes = $_GET['Gift'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /*
     * 新增 图片
     */

    public function actionGiftimg() {
        $imgpath = '';
        $model = new Gift();
        $id = Yii::app()->request->getParam('id');
        $sourcefiledetail = new SourceFileDetail();
        if (!empty($id)) {
            $sourcegroup = SourceFileGroup::model();
            $sourcegroup->_select = 'id,admin_id,public_id,title,description,time_created,author';
            $detailmodel = SourceFileDetail::model()->find('group_id=:group_id', array(":group_id" => $id));
            if (!empty($detailmodel)) {
                $file_id = $detailmodel->file_id;
                $model = SourceFile::model()->findByPk($file_id);
            }

            $detailmodel = SourceFileDetail::model();
            $detailmodel->_select = 'id,group_id,file_id';
            $sourcefiledetail = $detailmodel->findAll('group_id = :group_id and isdelete = :isdelete ', array(':group_id' => $id, ':isdelete' => '0'));
        }
        $path = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/';
        $extArr = array("jpg", "png", "jpeg");
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

        $this->render('create', array('model' => $model, 'sourcefiledetail' => $sourcefiledetail));
    }

    /*
     * 新建 转发新闻 
     */

    public function actionCreate() {
        $model = new Gift;
        $gifttype = $this->returnGiftType();

       // var_dump($_POST['Gift']);exit;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['submityes']) && isset($_POST['Gift'])) {
          //  var_dump($_POST['Gift']);exit;
            $model->attributes = $_POST['Gift'];
            $model->integral = $_POST['Gift']['integral'];
            $model->image_arr = $_POST['Gift']['image_arr'];
            $model->prizevalue= $_POST['Gift']['prizevalue'];
            $model->public_id = Yii::app()->user->public_id;
            $genre = $_POST['Gift']['genre']; //操作类型 增加或者减少
            $score = $_POST['Gift']['score']; //数值
            $giftlogmodel = new GiftOperationLog;
            $giftlogmodel->genre = $genre;
            $giftlogmodel->score = $score;
            $giftlogmodel->admin_id = Yii::app()->user->id;
            $giftlogmodel->time_created = time();

            //var_dump($_POST['Gift']);exit;

            //从图库选择的图片 赋值
            if (!empty($_POST['Gift']['image_src'])) {

                $imgname = @$_POST['Gift']['image_src'];
                $model->setAttribute('image_src', $imgname);
                if ($model->save()) {
                    $giftlogmodel->gift_id = $model->id;
                    $giftlogmodel->save();
                    exit;
                } else {
                    print_r($model->error);
                }

            }
            //上传图片
            else {
                  if($model->save()){
                      $img_one='files';
                      $img_two='filestwo';
                      $img_three='filesthree';
                      self::Uploadimage($model,$giftlogmodel,$img_one,$model->id);
                      self::Uploadimage($model,$giftlogmodel,$img_two,$model->id);
                      self::Uploadimage($model,$giftlogmodel,$img_three,$model->id);

                      $this->redirect('index');
                  }

//                $files = CUploadedFile::getInstance($model, 'files');
//                $filestwo=CUploadedFile::getInstance($model, 'filestwo');
//                var_dump($files);
//                var_dump($filestwo);
//                //var_dump($files);exit;
//                if (@$files->size > 2097152) {
//                    //超过2M
//                    Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
//                } else {
//                    $filename = PublicStaticMethod::generateFileName();
//                    if (is_object($files) && get_class($files) === 'CUploadedFile') {
//                        $filename = PublicStaticMethod::generateFileName();
//                        if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
//                            PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
//                            $model->setAttribute('image_src', @$filename . '.' . $files->extensionName);
//                            $extensionName = $files->extensionName;
//                            if ($model->save()) {
//                                $giftlogmodel->gift_id = $model->id;
//                                $giftlogmodel->save();
//                                $model = new SourceFile();
//                                $model->attributes = $_POST['Gift'];
//                                $model->setattribute('type', '2');
//                                $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
//                                $model->setattribute('filename', $filename);
//                                $model->setattribute('ext', $files->extensionName);
//                                PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
//                                if ($model->save()) {
//                                    exit;
//                                }
//                            }
//                        }
//                    }
//                }
            }
        }
        if (isset($_POST['Gift']) && empty($_POST['submityes'])) {

            $path = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/';
            $extArr = array("jpg", "png", "jpeg");
            $name = $_FILES['photoimg']['name'];
            if (!empty($name)) {
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
                    //echo  $image_name;
                    //echo '<div><img data-img= "' . $image_name . '" name = "' . $image_name . '" src="' . Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $image_name . '" ></div>';
                } else {
                    echo '上传出错了！';exit;
                }
            }
        }


        $this->render('create', array(
            'model' => $model,
            'gifttype' => $gifttype,
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
            $model = new Gift;
        }
        $gifttype = @$this->returnGiftType();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['submityes']) && isset($_POST['Gift'])) {

           // var_dump($_POST['Gift']);exit;

            $model->attributes = $_POST['Gift'];
            $model->integral = $_POST['Gift']['integral'];
            $model->image_arr = $_POST['Gift']['image_arr'];

            $model->prizevalue= $_POST['Gift']['prizevalue'];

            $genre = $_POST['Gift']['genre']; //操作类型 增加或者减少
            $score = $_POST['Gift']['score']; //数值
            if (!empty($genre)) {
                $giftlogmodel = new GiftOperationLog;
                $giftlogmodel->genre = $genre;
                $giftlogmodel->score = $score;
                $giftlogmodel->admin_id = Yii::app()->user->id;
                $giftlogmodel->time_created = time();
                $giftlogmodel->gift_id = $id;
                if ($giftlogmodel->save()) {
                    
                } else {
                    var_dump($model->errors);
                    exit;
                }
            }

            //从图库选择的图片 赋值
            if (!empty($_POST['Gift']['image_src'])) {
                $imgname = @$_POST['Gift']['image_src'];
                $model->setAttribute('image_src', $imgname);
                //   $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
            }

            ////////////////////

            $model->save();//保存数据

            $imgid=0;
            $img_one='files';
            $image = CUploadedFile::getInstance($model,$img_one);
            if(!empty($image)){
                $imgid=1;
                self::Uploadimage($model,$giftlogmodel,$img_one,$model->id,$imgid);
            }

            $img_two='filestwo';
            $image = CUploadedFile::getInstance($model,$img_two);
            if(!empty($image)){
                $imgid=2;
                self::Uploadimage($model,$giftlogmodel,$img_two,$model->id,$imgid);
            }

            $img_three='filesthree';
            $image = CUploadedFile::getInstance($model,$img_three);
            if(!empty($image)){
                $imgid=3;
                self::Uploadimage($model,$giftlogmodel,$img_three,$model->id,$imgid);
            }

            //删除图片
            //$delimg=$_POST['Gift']['delimgtwo'];
            if(isset($_POST['Gift']['delimgtwo'])&&!empty($_POST['Gift']['delimgtwo'])){
                $delimg=$_POST['Gift']['delimgtwo'];
            }

            if(isset($_POST['Gift']['delimgthree'])&&!empty($_POST['Gift']['delimgthree'])){
                $del=$_POST['Gift']['delimgthree'];
            }

            if(!empty($delimg)&&!empty($del)){
                $imgarr=array($delimg,$del);
            }elseif(!empty($delimg)&&empty($del)){
                $imgarr=array($delimg);
            }elseif(empty($delimg)&&!empty($del)){
                $imgarr=array($del);
            }else{
                $imgarr=array();
            }
           $res= self::delImage($imgarr,$model->id);
            if($res){
                $this->redirect(array('index'));
            }
//            $files = CUploadedFile::getInstance($model, 'files');
//            if (@$files->size > 2097152) {
//                //超过2M
//                Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
//            } else {
//               // $filename = PublicStaticMethod::generateFileName();
//                if (is_object($files) && get_class($files) === 'CUploadedFile') {
//                    $filename = PublicStaticMethod::generateFileName();
//                    if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
//                        PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));
//                        $model->setAttribute('image_src', @$filename . '.' . $files->extensionName);
//                        $extensionName = $files->extensionName;
//                        if ($model->save()) {
//                            $model = new SourceFile();
//                            $model->attributes = $_POST['Gift'];
//                            $model->setattribute('type', '2');
//                            $model->setattribute('public_id', Yii::app()->user->getState('public_id'));
//                            $model->setattribute('filename', $filename);
//                            $model->setattribute('ext', $files->extensionName);
//                            PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
//                            if ($model->save()) {
//                                $this->redirect(array('index'));
//                            } else {
//                                var_dump($model->errors);
//                                exit;
//                            }
//                        } else {
//                            var_dump($model->errors);
//                            exit;
//                        }
//                    }
//                }
//            }
//            if ($model->save()) {
//                $this->redirect(array('index'));
//            }
        }
        if (isset($_POST['Gift'])) {
            $path = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/';
            $extArr = array("jpg", "png", "jpeg");
            $name = $_FILES['photoimg']['name'];
            if (!empty($name)) {
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
                    //echo  $image_name;
                    echo '<div><img data-img= "' . $image_name . '" name = "' . $image_name . '" src="' . Yii::app()->baseurl . '/upload/sourcefile/image/source/' . $image_name . '" ></div>';
                } else {
                    echo '上传出错了！';
                }
                exit;
            }
        }
        $this->render('update', array(
            'model' => $model,
            'gifttype' => $gifttype,
        ));
    }

    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);

        $model = Gift::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

    /*
     * 得到礼品分类
     */

    public function returnGiftType() {
        $criteria = new CDbCriteria();
        $criteria->compare('status', 0);
        $gtypemodel = GiftType::model()->findAll($criteria);
        $gifttype = array();
        if (!empty($gtypemodel)) {
            foreach ($gtypemodel as $g) {
                $gifttype[$g->id] = $g->name;
            }
            return $gifttype;
        }
    }

    //index 页面ajax 修改内容 GIFT
    public function actionAjaxUpdate() {
        $id = $_POST['id'];
        $data_name = $_POST['data_name'];
        $value = $_POST['value'];

        if ($id && $data_name) {
            if ($data_name == 'data-name') {
                $data['name'] = $value;
            } else if ($data_name == 'data-number') {
                $data['number'] = $value;
            } else if ($data_name == 'data-integral') {
                $data['integral'] = $value;
            } else if ($data_name == 'data-status') {
                $data['status'] = $value;
            }
            Gift::model()->updateAll($data, 'id=:id', array(':id' => $id));
            echo 'success';
        }
    }
    /**
     * 上传图片并把数据写入数据库
     */
    public function Uploadimage($cmodel,$giftlogmodel,$filesname,$id,$imgid=''){

        $files = CUploadedFile::getInstance($cmodel, $filesname);
        if (@$files->size > 2097152) {
            //超过2M
            Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
        } else {
            $filename = PublicStaticMethod::generateFileName();
            if (is_object($files) && get_class($files) === 'CUploadedFile') {
                $filename = PublicStaticMethod::generateFileName();
                if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/' . $filename . '.' . $files->extensionName)) {
                    PublicStaticMethod::photoShop($filename, $files->extensionName, Yii::app()->user->getState('public_watermark'));

                    $criteria = new CDbCriteria;
                    $criteria->select='`image_src`';
                    $criteria->condition="id=".$id;
                    $result=$cmodel->find($criteria);

                    if(!empty($imgid)) {
                        $imgsrc = explode(',', $result->image_src);
                        $imgsrc[($imgid - 1)] = @$filename. '.' . $files->extensionName;
                        $img = implode(',', $imgsrc);
                        $imagesrc = $img;
                    }else{
                        $imagesrc= $result->image_src.@$filename . '.' . $files->extensionName.',';//拼接图片
                    }
                    $count =$cmodel->updateByPk($id,array('image_src'=>$imagesrc));//更新路径
                    $extensionName = $files->extensionName;
                   // var_dump($cmodel->id);exit;
                    if ($count>0) {

                        if(!empty($giftlogmodel)){
                          $giftlogmodel->gift_id = $cmodel->id;
                          $giftlogmodel->save();
                        }
                        PublicStaticMethod::photoShop($filename, $extensionName, Yii::app()->user->getState('public_watermark'));
                    }
                    else{
                        echo '<i>Update data failed</i>';
                    }

                }
            }
        }
    }

    /**
     * 删除图片
     */
    public function delImage($imgid,$id){
        if(!empty($imgid)){
           // var_dump(count($imgid));exit;
            for($i=0;$i<count($imgid);$i++){
            $model =new Gift;
            $criteria = new CDbCriteria;
            $criteria->select='`image_src`,`id`';
            $criteria->condition="id=".$id;
            $result=$model->find($criteria);
            if(!empty($result)){
                $imgarr=explode(',',$result->image_src);
                $icon=Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/icon/'.$imgarr[($imgid[$i]-1)];
                $medium=Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/medium/'.$imgarr[($imgid[$i]-1)];
                $source=Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/source/'.$imgarr[($imgid[$i]-1)];
                $thumb =Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/thumb/'.$imgarr[($imgid[$i]-1)];
                $watermark=Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/watermark/'.$imgarr[($imgid[$i]-1)];
                if(file_exists($icon)){
                    unlink($icon);
                }
                if(file_exists($medium)){
                    unlink($medium);
                }
                if(file_exists($source)){
                    unlink($source);
                }
                if(file_exists($thumb)){
                    unlink($thumb);
                }
                if(file_exists($watermark)){
                    unlink($watermark);
                }

                unset($imgarr[($imgid[$i]-1)]);
                $img=implode(',',$imgarr);
                $count=$model->updateByPk($id,array('image_src'=>$img));//更新路径
            }
        }
            if($count>0){
                return $susess=1;
            }
    }
    }
}
