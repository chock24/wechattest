<?php

class WcpublicController extends Controller {

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'create', 'update', 'delete', 'change', 'news', 'createnews', 'deletenews', 'updatenews', 'public_news'),
                'roles' => array('1', '2', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /*
     * 显示 系统公告 详情页
     */

    public function actionPublic_news($id = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,content,time_created';
        $criteria->compare('isdelete', 0);
        $model = News::model()->findByPk($id, $criteria);
        $this->render('public_news', array(
            'model' => $model,
        ));
    }

    /*
     * 删除 公众账号 常见问题
     */

    public function actiondeletenews($id) {
        if (!empty($id)) {
            News::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
        } $this->redirect(array('news'));
    }

    /**
     * 显示公众号列表 
     */
    public function actionIndex() {
        $this->layout = '//layouts/system';
        $criteria = new CDbCriteria();
        $criteria->compare('admin_id', Yii::app()->user->id);
        $criteria->compare('isdelete', 0);
        $dataProvider = new CActiveDataProvider('WcPublic', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $adminmodel = Admin::model()->findByPk(Yii::app()->user->id);
        $wcmmodel = WcPublic::model()->findAll('admin_id = :admin_id and isdelete = :isdelete', array(':admin_id' => Yii::app()->user->id, ':isdelete' => '0'));
        $this->render('index', array('dataProvider' => $dataProvider, 'wcmmodel' => $wcmmodel, 'adminmodel' => $adminmodel));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = '//layouts/system';
        $model = new WcPublic;
        $kefulist = array();
        //查询 客服列表
        $adminlist = Admin::model()->findAll('role_id = :role_id', array(':role_id' => '4'));
        if (!empty($adminlist)) {
            foreach ($adminlist as $key => $a) {
                $kefulist[$a->id] = $a->name;
            }
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['WcPublic'])) {
            $model->attributes = $_POST['WcPublic'];
            /* $model->headimage = CUploadedFile::getInstance($model, 'headimage');
              if($model->validate()){
              if (is_object($model->headimage) && get_class($model->headimage) === 'CUploadedFile') {
              $filename = PublicStaticMethod::generateFileName();
              if ($model->headimage->saveAs(Yii::getPathOfAlias('webroot') . '/upload/public/headimage/' . $filename . '.' . $model->headimage->extensionName)) {
              $model->setattribute('headimage', $filename . '.' . $model->headimage->extensionName);
              }
              }
              } */
            $admin_id = @$_POST['WcPublic']['all_kefu']; //得到管理员 账号
            if ($model->save()) {
                $adminpublic = new AdminPublic;
                if (!empty($admin_id)) {
                    $adminpublic->setattribute('admin_id', $admin_id);
                } else {
                    $adminpublic->setattribute('admin_id', 1);
                }
                $adminpublic->setattribute('public_id', $model->id);
                $adminpublic->save();
                if (!Yii::app()->user->getState('public_id')) {//如果当前没有公众号
                    Yii::app()->user->logout();
                    $this->redirect(Yii::app()->homeUrl);
                } else {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'kefulist' => @$kefulist,
            'adminlist' => $adminlist,
        ));
    }

    /*
     * 创建公众号常见问题
     */

    public function actionCreatenews() {

        $model = new News;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            //  $model->setAttribute('type','1');
            if ($model->save()) {
                if (!Yii::app()->user->getState('public_id')) {//如果当前没有公众号
                    Yii::app()->user->logout();
                    $this->redirect(Yii::app()->homeUrl);
                } else {
                    $this->redirect(array('news'));
                }
            }
        }
        $this->render('create_news', array(
            'model' => $model,
        ));
    }

    /*
     * 修改 公众号常见问题
     */

    public function actionUpdatenews($id) {
        if (!empty($id)) {
            $model = News::model()->findByPk($id);
        }
        //exit;
        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            if ($model->save()) {
                $this->redirect(array('news'));
            }
        }
        $this->render('update_news', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->layout = '//layouts/system';
        $model = $this->loadModel($id);
        $kefulist = array();
        //查询 客服列表
        $adminlist = Admin::model()->findAll('role_id = :role_id', array(':role_id' => '4'));
        if (!empty($adminlist)) {

            foreach ($adminlist as $key => $a) {
                $kefulist[$a->id] = $a->name;
            }
        }
        //查询 所属客服
        $adminpublic = AdminPublic::model()->find('public_id = :public_id', array(':public_id' => $id));
        //$model->all_kefu = array();
        //  foreach($adminpublic as $key=>$value){
        // $model->all_kefu[] = $value['admin_id'];
        // }
        $model->all_kefu = @$adminpublic->admin_id;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['WcPublic'])) {
            $model->attributes = $_POST['WcPublic'];
            //是否托管 公众号
            $model->setAttribute('trust', $_POST['WcPublic']['trust']);
            //得到客服 id
            if (!empty($_POST['WcPublic']['all_kefu'])) {
                $admin_id = $_POST['WcPublic']['all_kefu'];
                //修改关联表数据
                if (!empty($adminpublic)) {
                    AdminPublic::model()->updateAll(array('admin_id' => $admin_id), 'id=:id', array(':id' => $adminpublic->id));
                } else {
                    $adminpublic = new AdminPublic;
                    $adminpublic->setattribute('admin_id', $admin_id);
                    $adminpublic->setattribute('public_id', $id);
                    $adminpublic->save();
                }
            }
            $model->headimage = CUploadedFile::getInstance($model, 'headimage');
            if ($model->validate()) {
                if (is_object($model->headimage) && get_class($model->headimage) === 'CUploadedFile') {
                    $filename = PublicStaticMethod::generateFileName();
                    if ($model->headimage->saveAs(Yii::getPathOfAlias('webroot') . '/upload/public/headimage/' . $filename . '.' . $model->headimage->extensionName)) {
                        $model->setattribute('headimage', $filename . '.' . $model->headimage->extensionName);
                    }
                }
            }
            if ($model->save()) {
                if (Yii::app()->user->getState('public_id') == $model->id) {//如果修改当前登录的公众号
                    Yii::app()->user->logout();
                    $this->redirect(Yii::app()->homeUrl);
                } else {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'kefulist' => @$kefulist,
            'adminlist' => $adminlist,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        WcPublic::model()->updateByPk($id, array('isdelete' => 1));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * 切换当前公众号
     */
    public function actionChange($id) {
        if ($id == Yii::app()->user->getState('public_id')) {
            throw new CHttpException(405, '已经是当前公众号');
        } else {
            //获取公众号模型
            $model = $this->loadModel($id);
            if ($model === null) {
                throw new CHttpException(405, '公众号不存在');
            } else {
                //重新赋值session公众号信息
                Yii::app()->user->setState('public_id', $model->id);
                Yii::app()->user->setState('public_original', $model->original);
                Yii::app()->user->setState('public_wechat', $model->wechat);
                Yii::app()->user->setState('public_name', $model->title);
                Yii::app()->user->setState('public_appid', $model->appid);
                Yii::app()->user->setState('public_appsecret', $model->appsecret);
                Yii::app()->user->setState('public_watermark', $model->watermark);
                //$this->redirect(Yii::app()->request->urlReferrer);
                $this->redirect(Yii::app()->homeUrl);
            }
        }
    }

    /**
     * 公众号常见问题
     */
    public function actionNews() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,time_created';
        $criteria->compare('type', 1);
        $criteria->compare('isdelete', 0);
        $dataProvider = new CActiveDataProvider('News', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 15,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $this->render('news', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return WcPublic the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('admin_id', Yii::app()->user->id);
        $criteria->compare('isdelete', 0);
        $model = WcPublic::model()->findByPk($id, $criteria);
        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param WcPublic $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'wc-public-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
