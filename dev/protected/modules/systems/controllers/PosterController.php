<?php

class PosterController extends Controller {

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
        $model = new Poster();
        $criteria = new CDbCriteria;
        $criteria->select='`id`,`time_created`,`typename`';
        $criteria->compare('is_delete', 0);
        $criteria->group='typeid';

        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 5,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        //var_dump($dataProvider);exit;
        $this->render('index',
                 array('dataProvider' => $dataProvider,
               // 'model' => $model,
        ));
    }

    /*
     * 新建
     */

    public function actionCreate() {
        $model = new Poster();
        $postertype=$this->getPostertype();
        $postername='';//定义海报名称
           if(!empty($_POST['Poster']['typeid'])){
             $postername= $this -> getPostername($_POST['Poster']['typeid']);
           }

        if (isset($_POST['submityes']) && isset($_POST['Poster'])) {

                $filesone = CUploadedFile::getInstance($model,'files_one');
                $filestwo = CUploadedFile::getInstance($model,'files_two');
                $filesthree = CUploadedFile::getInstance($model,'files_three');
                $susess=0;

            if(empty($_POST['Poster']['imgsrc_one'])){
                if(!empty($filesone)){
                    $Amodel = new Poster();
                    //$postertype=$this->getPostertype();
                    $Amodel->typeid = $_POST['Poster'][typeid];
                    $filename=self::Uploadimg($model,'files_one');
                    $Amodel->img_url=$filename;
                    $Amodel->typename=$postername;
                    $Amodel->url=$_POST['Poster']['url_one'];
                    if($Amodel->save()){
                        $susess=1;
                    };
                }
            }else{
                $Amodel = new Poster();
                $criteria = new CDbCriteria;
                $criteria->select='`id`,`img_url`';
                $criteria->compare('is_delete',0);
                $criteria->compare('id',$_POST['Poster']['imgsrc_one']);
                $Amodel->typeid = $_POST['Poster'][typeid];
                $Amodel->typename=$postername;
                $Amodel->url=$_POST['Poster']['url_one'];
                if($Amodel->save()){
                    $susess=1;
                };
            }
            if(empty($_POST['Poster']['imgsrc_two'])){
                if(!empty($filestwo)){
                    $tmodel = new Poster();
                    $tmodel->typeid = $_POST['Poster'][typeid];
                    $filename=self::Uploadimg($tmodel,'files_two');
                    $tmodel->img_url=$filename;
                    $tmodel->typename=$postername;
                    $tmodel->url=$_POST['Poster']['url_two'];
                    $tmodel->save();
                    if($tmodel->save()){
                        $susess=1;
                    };
                }
            } else{
                    $tmode = new Poster();
                    $criteria = new CDbCriteria;
                    $criteria->select='`id`,`img_url`';
                    $criteria->compare('is_delete',0);
                    $criteria->compare('id',$_POST['Poster']['imgsrc_two']);
                    $tmode->typeid = $_POST['Poster'][typeid];
                    $tmode->typename=$postername;
                    $tmode->url=$_POST['Poster']['url_one'];
                    if($tmode->save()){
                        $susess=1;
                    };
            }
            if(empty($_POST['Poster']['imgsrc_two'])) {
                if (!empty($filesthree)) {
                    $pmodel = new Poster();
                    $pmodel->typeid = $_POST['Poster'][typeid];
                    $filename = self::Uploadimg($pmodel, 'files_three');
                    $pmodel->img_url = $filename;
                    $pmodel->url = $_POST['Poster']['url_three'];
                    $pmodel->typename=$postername;
                    $pmodel->save();
                    if ($pmodel->save()) {
                        $susess = 1;
                    };
                }
            }else{
                $pmodel = new Poster();
                $criteria = new CDbCriteria;
                $criteria->select='`id`,`img_url`';
                $criteria->compare('is_delete',0);
                $criteria->compare('id',$_POST['Poster']['imgsrc_three']);
                $pmodel->typeid = $_POST['Poster'][typeid];
                $pmodel->url=$_POST['Poster']['url_one'];
                $pmodel->typename=$postername;
                if($pmodel->save()){
                    $susess=1;
                };
            }
        }
        if(empty($postertype)){
            $this->redirect(array('/systems/PosterType/index'));
        }
        $this->render('create', array(
            'model' => $model,
            'postertype' => $postertype,
        ));
    }

    /**
     * 上传图片
     * @param $model
     * @param $filesname
     * @return string
     */
    public function Uploadimg($model,$filesname){
        $files = CUploadedFile::getInstance($model,$filesname);
        if (@$files->size > 2097152) {
                   //超过2M
                   Yii::app()->user->setFlash('alert', '图片已超过2M，请重新选择其他文件。');
                }else{
                    if (is_object($files) && get_class($files) === 'CUploadedFile') {
                          $filename = PublicStaticMethod::generateFileName();
                           if ($files->saveAs(Yii::getPathOfAlias('webroot') . '/upload/sourcefile/image/poster/' . $filename . '.' . $files->extensionName)) {
                                    return $filename.'.'.$files->extensionName;
                              }
                }
        }
    }

    /*
     * 修改 
     */

    public function actionUpdate($id = 0) {
       // var_dump($_POST['Poster']);exit;

        $model = new Poster();
        $criteria = new CDbCriteria;
        $criteria->select='`typeid`,`typename`';
        $criteria->compare('id',$id);
        $type=$model->find($criteria);
        $tid='';
        $postername='';
        if(!empty($type)) {
            $tid = $type->typeid;
            $postername = $type->typename;
        }
        $filesone = CUploadedFile::getInstance($model,'files_one');
        $filestwo = CUploadedFile::getInstance($model,'files_two');
        $filesthree = CUploadedFile::getInstance($model,'files_three');
        $typeid=empty($_POST['Poster']['typeid'])?$tid:$_POST['Poster']['typeid'];


        if(!empty($filesone) && !empty($_POST['Poster']['lid_one'])){
            //更新
            $tmodel = new Poster();
            $lid=$_POST['Poster']['lid_one'];
            $url=$_POST['Poster']['url_one'];
            $filename=self::Uploadimg($tmodel,'files_one');
            $this->changeDate($lid,$typeid,$filename,$url,$postername);
        }

        if(!empty($_POST['Poster']['imgsrc_one']) && !empty($_POST['Poster']['lid_one'])){
            //更新
            $imgname=$_POST['Poster']['imgsrc_one'];
            $lid=$_POST['Poster']['lid_one'];
            $url=$_POST['Poster']['url_one'];
            $this->changeDate($lid,$typeid,$imgname,$url,$postername);
        }
        if(!empty($filestwo) && !empty($_POST['Poster']['lid_two'])){

            //更新
            $tmodel = new Poster();
            $lid=$_POST['Poster']['lid_two'];
            $url=$_POST['Poster']['url_two'];
            $filename=self::Uploadimg($tmodel,'files_two');
            $this->changeDate($lid,$typeid,$filename,$url,$postername);
        }

        if(!empty($_POST['Poster']['imgsrc_two']) && !empty($_POST['Poster']['lid_two'])){
            //更新
            $imgname=$_POST['Poster']['imgsrc_two'];
            $lid=$_POST['Poster']['lid_two'];
            $url=$_POST['Poster']['url_two'];
            $this->changeDate($lid,$typeid,$imgname,$url,$postername);
        }
        if(!empty($filesthree) && !empty($_POST['Poster']['lid_three'])){
            //更新
            $tmodel = new Poster();
            $lid=$_POST['Poster']['lid_three'];
            $url=$_POST['Poster']['url_three'];
            $filename=self::Uploadimg($tmodel,'files_three');
            $this->changeDate($lid,$typeid,$filename,$url,$postername);
        }
        if(!empty($_POST['Poster']['imgsrc_three'])  && !empty($_POST['Poster']['lid_three'])){
            //更新
            $imgname=$_POST['Poster']['imgsrc_three'];
            $lid=$_POST['Poster']['lid_three'];
            $url=$_POST['Poster']['url_three'];
            $this->changeDate($lid,$typeid,$imgname,$url,$postername);
        }

        //创建

        if(!empty($filestwo) && empty($_POST['Poster']['lid_two'])){
            $tmodel = new Poster();
            $tmodel->typeid = $typeid;
            $tmodel->typename =$postername;
            $filename=self::Uploadimg($tmodel,'files_two');
            $tmodel->img_url=$filename;
            $tmodel->url=$_POST['Poster']['url_two'];
            $tmodel->save();
        }
        if(!empty($_POST['Poster']['imgsrc_two'])  && empty($_POST['Poster']['lid_two'])){

            $Amodel = new Poster();
            $Amodel->typeid = $typeid;
            $Amodel->typename =$postername;
            $filename=$_POST['Poster']['imgsrc_two'];
            $Amodel->img_url=$filename;
            $Amodel->url=$_POST['Poster']['url_two'];
            $Amodel->save();
        }

        if(!empty($filesthree) && empty($_POST['Poster']['lid_three'])){
            $bmodel = new Poster();
            $bmodel->typeid = $typeid;
            $bmodel->typename =$postername;
            $filename=self::Uploadimg($bmodel,'files_three');
            $bmodel->img_url=$filename;
            $bmodel->url=$_POST['Poster']['url_three'];
            $bmodel->save();
        }
        if(!empty($_POST['Poster']['imgsrc_three'])  && empty($_POST['Poster']['lid_three'])){
            $cmodel = new Poster();
            $cmodel->typeid = $typeid;
            $cmodel->typename =$postername;
            $filename=$_POST['Poster']['imgsrc_three'];
            $cmodel->img_url=$filename;
            $cmodel->url=$_POST['Poster']['url_three'];
            $cmodel->save();
        }

        //当只有位置id时
        //var_dump($_POST['Poster']);exit;
        if(isset($_POST['Poster']['lid_one']) && !empty($_POST['Poster']['lid_one'])){
            $lid=$_POST['Poster']['lid_one'];
            $imgurl=$this->getImgurl($lid);
            $url=$_POST['Poster']['url_one'];
            $this->changeDate($lid,$typeid,$imgurl,$url,$postername);
        }
        if(isset($_POST['Poster']['lid_two']) && !empty($_POST['Poster']['lid_two'])){
            //echo 111111;exit;
            $lid=$_POST['Poster']['lid_two'];
            $url=$_POST['Poster']['url_two'];
            $imgurl=$this->getImgurl($lid);

            $this->changeDate($lid,$typeid,$imgurl,$url,$postername);
        }
        if(isset($_POST['Poster']['lid_three']) && !empty($_POST['Poster']['lid_three'])){
            $lid=$_POST['Poster']['lid_three'];
            $url=$_POST['Poster']['url_three'];
            $imgurl=$this->getImgurl($lid);
            $this->changeDate($lid,$typeid,$imgurl,$url,$postername);
        }

        /**
         * 删除
         */
        if(!empty($_POST['Poster']['delimg_two'])){
            $id=$_POST['Poster']['delimg_two'];
            $this->deleteByid($id);
        }

        if(!empty($_POST['Poster']['delimg_three'])){
            $id=$_POST['Poster']['delimg_three'];
            $this->deleteByid($id);
        }


        $model = new Poster();
        $criteria = new CDbCriteria();
        $criteria->select='`typeid`';
        $criteria->compare('is_delete',0);
        $criteria->compare('id',$id);
        $data=Poster::model()->find($criteria);
        $res=array();
        if(!empty($data)) {
            $cri = new CDbCriteria();
            $cri->select = '`id`,`img_url`,`url`';
            $cri->compare('typeid', $data->typeid);
            $cri->limit=3;
            $cri->order='time_created DESC';
            $result=$model->findAll($cri);
            foreach($result as $key=>$v){
                $res[$key]['id']=$v->id;
                $res[$key]['img_url']=$v->img_url;
                $res[$key]['url'] =$v->url;
            }
        }

        $this->render('update', array(
            'model' => $model,
            'dataprovider'=>$res,
            'postername'  =>$postername,
        ));
    }

    /*
     * 删除 
     */

    public function actionDelete($id) {
        if (!empty($id)) {
            $model =new Poster();
            $criteria = new CDbCriteria();
            $criteria->select='`typeid`';
            $criteria->compare('id',$id);
            $data=$model->find($criteria);
            if(!empty($data)) {
                $model->updateAll(array('is_delete' => '1'), 'typeid=:typeid', array(':typeid' => $data->typeid));
                $this->redirect(array('index'));
            }
        }

    }

    public function deleteByid($id){
        if (!empty($id)) {
            $model =new Poster();
            $criteria = new CDbCriteria();
            $criteria->compare('id',$id);
            $data=$model->find($criteria);
            if(!empty($data)) {
                $model->updateByPk($id,array('img_url'=>''));
            }
        }
    }
    /*
     * 得到海报分类
     */

    public function getPostertype() {
        $criteria = new CDbCriteria();
        $criteria->select='`id`,`col_name`';
        $criteria->compare('is_delete', 0);
        $model = PosterType::model()->findAll($criteria);
        $postertype = array();
        if (!empty($model)) {
            foreach ($model as $v) {
                $postertype[$v->id] = $v->col_name;
            }
            return $postertype;
        }
    }

    /*
     *根据id获得到海报名称
     */

    public function getPostername($id) {
        $criteria = new CDbCriteria();
        $criteria->select='`col_name`';
        $criteria->compare('is_delete', 0);
        $criteria->compare('id',$id);
        $model = PosterType::model()->find($criteria);
        $postername ='';
           if(!empty($model)){
                $postername=$model->col_name;
           }
            return $postername;
        }

    /**
     * 更新数据
     */
    public function changeDate($lid,$typeid,$imgurl='',$url='',$typename){
        $model=new Poster();
        $count=$model->updateByPk($lid,array(
                'typeid'=>$typeid,
                'url' =>$url,
                'img_url'=>$imgurl,
                'typename'=>$typename,
                'time_updated'=>time()
            ));
        if($count>0){
            return true;
        }
    }
    public function getImgurl($id){
        $model = new Poster();
        $criteria = new CDbCriteria;
        $criteria->select='`img_url`';
        $criteria->compare('id',$id);
        $data=$model->find($criteria);
        $imgurl='';
        if(!empty($data)){
            $imgurl=$data->img_url;
        }
        return $imgurl;
    }
}
