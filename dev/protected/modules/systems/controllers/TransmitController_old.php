<?php

class TransmitController extends Controller {

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'sourcefile', 'create', 'view', 'update', 'addtransmit_user', 'sample', 'transmitmsg'),
                'roles' => array('1', '2'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Updates a particular model.
     *  修改转发 信息
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        $this->layout = '//layouts/operation';
        $id = Yii::app()->request->getParam('id') ? Yii::app()->request->getParam('id') : Yii::app()->user->id;
        $model = Transmit::model()->findByPk($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Transmit'])) {
            $model->attributes = $_POST['Transmit'];
            if ($model->save()) {
                $this->redirect(array('index'));
            } else {
                var_dump($model->error);
                exit;
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /*
     * 首页显示
     */

    public function actionIndex() {
        $model = new Transmit;
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,time_start,time_end,description,keyword,source_file_id,integral';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('status', 3); //只查询 状态为3的
        $criteria->compare('isdelete', 0);
        $transmit = new CActiveDataProvider('Transmit', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        if (isset($_POST['Transmit'])) {
            $model->attributes = $_POST['Transmit'];
            $model->setAttribute('admin_id', Yii::app()->user->id);
            $model->setAttribute('time_start', strtotime($_POST['Transmit']['time_start']));
            $model->setAttribute('time_end', strtotime($_POST['Transmit']['time_end']));
            $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('status', '1');
            if ($model->save()) {
                
            } else {
                var_dump($model->errors);
                exit;
            }
        }
        $this->render('index', array(
            'model' => $model,
            'transmit' => $transmit,
        ));
    }

    /*
     * 创建 转发内容
     */

    public function actionCreate() {
        $model = new Transmit;
        if (isset($_POST['Transmit'])) {
            if (!empty($_POST['Transmit']['id'])) {
                $id = $_POST['Transmit']['id'];
                $keyword = @$_POST['Transmit']['keyword'];
                $multi = @$_POST['Transmit']['multi'];
                $sourcefileid = @$_POST['Transmit']['source_file_id'];
                Transmit::model()->updateAll(array('status' => '3', 'keyword' => $keyword, 'source_file_id' => $sourcefileid, 'multi' => $multi), 'id=:id', array(':id' => @$id));
                $this->redirect(array('create', 'status' => '3'));
            }
            $model->attributes = $_POST['Transmit'];
            $status = Yii::app()->request->getParam('status');
            $model->setAttribute('admin_id', Yii::app()->user->id);
            $model->setAttribute('time_start', strtotime($_POST['Transmit']['time_start']));
            $model->setAttribute('time_end', strtotime($_POST['Transmit']['time_end']));
            $model->setAttribute('public_id', Yii::app()->user->getState('public_id'));
            $model->setAttribute('status', $status);

            if ($model->save()) {
                //  Yii::app()->user->setFlash('id', $model->id);
                $this->redirect(array('create', 'status' => '2', 'id' => $model->id));
            } else {
                var_dump($model->errors);
                exit;
            }
        }
        $this->render('create', array(
            'model' => $model,
                //  'transmit'=> $transmit,
        ));
    }

    /*
     * 单图文 多图文 调用
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

    /*
     * 详细列表页面 
     * 
     */

    function getRandChar($length) {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str.=$strPol[rand(0, $max)];
        }

        return $str;
    }

    public function actionView($id) {
        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $usermodel = new User;
        $appId = 0;
        $appSecret = 0;
        $openid = @Yii::app()->cache->get('openid'); //得到openid
        $usermodel = User::model()->find('openid=:openid', array(':openid' => @$openid));
        if ($usermodel) {
            $public_id = $usermodel->public_id;
            $publicmodel = WcPublic::model()->findByPk($public_id);
            if ($publicmodel) {
                $appId = $publicmodel->appid;
                $appSecret = $publicmodel->appsecret;
            }
        }
        $model = Transmit::model()->findByPk($id);
        $TransmitUser = new TransmitUser; //转发用户列表
        $criteria = new CDbCriteria();
        $criteria->compare('transmit_id', @$id);
        $criteria->compare('isdelete', 0);
        $TransmitUserList = new CActiveDataProvider('TransmitUser', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 9,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $sourcemodel = SourceFile::model()->findByPk(@$model->source_file_id);

        $this->render('view', array(
            'appId' => $appId,
            'appSecret' => $appSecret,
            'model' => $model,
            'sourcemodel' => $sourcemodel,
            'usermodel' => $usermodel,
            'TransmitUser' => $TransmitUser,
            'TransmitUserList' => $TransmitUserList,
        ));
    }

    /*
     * 分享好友  添加数据库 
     */

    public function actionTransmitmsg() {

        Yii::import('application.modules.users.models.User');
        Yii::import('application.modules.users.models.UserIntegral');
        $public_id = Yii::app()->user->getState('public_id');
        $type = '2'; //转发  type 为2
        $openid = @$_POST['openid'];
        $transmit_id = $_POST['transmit_id'];
        if (!empty($openid) && !empty($transmit_id)) {
            $usermodel = User::model()->find('openid = :openid ', array(':openid' => $openid));
            if (!empty($usermodel->mobile)) {// 绑定 手机
                $user_id = $usermodel->id;
                $TransmitUser = TransmitUser::model()->find('transmit_id = :transmit_id and user_id =:user_id and isdelete = :isdelete', array(':transmit_id' => $transmit_id, ':user_id' => $user_id, ':isdelete' => '0'));
                // if (empty($TransmitUser)) {
                $TransmitUser = new TransmitUser; //转发用户列表
                $TransmitUser->setAttribute('transmit_id', $transmit_id);
                $TransmitUser->setAttribute('user_id', $user_id);
                $TransmitUser->setAttribute('remark', '转发信息');
                if ($TransmitUser->save()) {//增加转发记录 
                    $intearalModel = new UserIntegral;
                    $intearalModel->setAttribute('public_id', $public_id);
                    $intearalModel->setAttribute('user_id', @$user_id);
                    $intearalModel->setAttribute('type', $type);
                    $attendanceModel = Attendance::model()->find('type= :type and public_id = :public_id', array(":type" => $type, ':public_id' => $public_id));
                    if (!empty($attendanceModel)) {
                        $integral = @$attendanceModel->integral; //积分   需要从签到规则attendance表中 得到 积分数
                    } else {
                        $integral = 1;
                    }
                    $intearalModel->setAttribute('value', $integral); //积分  
                    if ($intearalModel->save()) {//增加积分记录表  一条记录
                        //更新 用户积分
                        $usermodel->updateByPk($user_id, array('integral' => $usermodel->integral + $integral));
                        // echo json_encode(array('success' => 'success'));
                        echo '转发成功！';
                    } else {
                        var_dump($intearalModel->error);
                        echo 'error1';
                    }
                } else {
                    print_r($TransmitUser->error);
                    echo "error2";
                }
//                } else {
//                    echo "已转发，不要重复转发";
//                }
            } else {
                echo "未绑手机";
            }
        } else {
            echo 'openid或transmit_id为空';
        }
        // echo json_encode(array('id' => $openid));
    }

    /*
     * 分享 测试页面
     */

    public function actionSample() {
        $this->renderPartial('sample', array(
            'appId' => 'wxcdf4e48a30470336',
            'appSecret' => 'f42bcf909cdecade715ecc919873bc98',
        ));
    }

}
