<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'SCaptchaAction',
                'backColor' => 0xEBEBCB,
                'minLength' => 4,
                'maxLength' => 4,
                'height' => 25,
                'width' => 80,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'captcha', 'view', 'transmit'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('index', 'contact', 'page', 'logout', 'error', 'news', 'createnews', 'updatenews', 'deletenews'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /*
     * 创建 系统公告 新闻
     */

    public function actionCreatenews() {

        $model = new News;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            if ($model->save()) {
                if (!Yii::app()->user->getState('public_id')) {//如果当前没有公众号 
                    Yii::app()->user->logout();
                    $this->redirect(Yii::app()->homeUrl);
                } else {
                    $this->redirect(array('index'));
                }
            }
        }
        $this->render('create_news', array(
            'model' => $model,
        ));
    }

    /*
     * 修改 系统公告 新闻
     */

    public function actionUpdatenews($id) {
        if (!empty($id)) {
            $model = News::model()->findByPk($id);
        }
        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('update_news', array(
            'model' => $model,
        ));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        Yii::import('application.modules.users.models.User');

        /* --------------今日关注--------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(*)';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $criteria->compare('subscribe', 1);
        $criteria->addBetweenCondition('subscribe_time', strtotime(date('Y-m-d')), strtotime(date('Y-m-d')) + 60 * 60 * 24, 'AND');
        $userTodayCount = User::model()->count($criteria);

        /* --------------总关注--------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(*)';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $criteria->compare('subscribe', 1);
        $userCount = User::model()->count($criteria);

        /* --------------取消关注--------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(*)';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $criteria->compare('subscribe', 0);
        $userCancelCount = User::model()->count($criteria);
        /* ----------------未读信息--------------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(*)';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $criteria->compare('status', 1); //未读信息
        $messageUnreadCount = Message::model()->count($criteria);
        /* --------------微信公众平台新闻--------------- */
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,time_created';
        $criteria->compare('type', 0);
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

        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'userTodayCount' => $userTodayCount,
            'userCount' => $userCount,
            'userCancelCount' => $userCancelCount,
            'messageUnreadCount' => $messageUnreadCount,
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        $this->layout = '//layouts/system';
        if ($error = Yii::app()->errorHandler->error) {
            $logError = new LogError;
            $logError->setAttribute('error_code', $error['code']);
            $logError->setAttribute('content', $error['message']);
            if ($logError->save()) {
                if (Yii::app()->request->isAjaxRequest) {
                    echo $error['message'];
                } else {
                    $this->render('error', $error);
                }
            }
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'login';
        $model = new LoginForm;
        // if it is ajax validation request

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {

            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid

            if ($model->validate() && $model->login()) {
                $role_id = Yii::app()->user->getState('roles');
                //判断权限 是否是
                if ($role_id == 4) {
                    $this->redirect(array('/users/message'));
                } else {
                    $this->redirect(array('/publics/wcpublic'));
                }
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * 图文详情页
     * @param int $id 图文id
     */
    public function actionView($id = 0) {
        $this->layout = '//layout/operation';
        $criteria = new CDbCriteria();
        $criteria->select = 'id,public_id,public_name,public_url,path,title,filename,author,description,show_content,content,content_source_url,ext,time_created';
        $criteria->compare('type', 5);
        $criteria->compare('isdelete', 0);
        $model = SourceFile::model()->findByPk($id, $criteria);
        $contnetname = $model->content;
        $textname = Yii::getPathOfAlias('webroot') . '/upload/sourcefile/filecontent/' . $contnetname;
        if (Yii::app()->user->getState('public_id')) {//如果当前没有公众号 
            $public_id = Yii::app()->user->getState('public_id');
            $publicmodel = WcPublic::model()->findByPk($public_id);
        }

        //读取文件 内容
        if (file_exists($textname)) {
            $contents = file_get_contents($textname);
            $model->content = @$contents;
        }
        $this->render('view', array(
            'model' => $model,
            'publicmodel' => $publicmodel,
        ));
    }

    /*
     * 显示 系统公告 详情页
     */

    public function actionNews($id = 0) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,content,time_created';
        $criteria->compare('isdelete', 0);
        $model = News::model()->findByPk($id, $criteria);
        $this->render('news', array(
            'model' => $model,
        ));
    }

    /*
     * 删除 系统公告新闻
     */

    public function actionDeletenews($id) {
        if (!empty($id)) {
            News::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
        } $this->redirect(array('index'));
    }

}
