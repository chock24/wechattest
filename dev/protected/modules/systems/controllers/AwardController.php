<?php

class AwardController extends Controller {

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
                'actions' => array('list', 'createaward', 'index', 'admin', 'view', 'update', 'create', 'delete'),
                'roles' => array('1', '2', '3'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        
        $this->render('index');
    }

    public function actionDelete() {
        $id = @$_POST['id'];
        if (!empty($id)) {
            Award::model()->updateAll(array('isdelete' => '1'), 'id=:id', array(':id' => $id));
        }
    }

    /*
     * 中奖名单 列表
     */

    public function actionList() {
        $transmit_id = $_GET['transmit_id'];
        $public_id = Yii::app()->user->getState('public_id');
        $model = new Award('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
        $criteria->select = 'id,admin_id,public_id,gift_id,transmit_id,user_id,nickname,gift_name';
        $criteria->compare('public_id', $public_id);
        if (!empty($transmit_id)) {
            $criteria->compare('transmit_id', $transmit_id);
        }
        $criteria->compare('isdelete', 0);
        $criteria->order = 'time_created DESC';
        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $this->render('list', array('dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    /*
     * 新建 转发新闻 
     */

    public function actionCreate() {
        $model = new Award;
        $giftmodel = $this->returnGift();
        $transmit_id = @$_GET['transmit_id'];
        $tramsmit = new Transmit;
        if (!empty($transmit_id)) {
            $tramsmit = Transmit::model()->findByPk($transmit_id);
        } else if (isset($_GET['Transmit']['id'])) {
            $tramsmit = Transmit::model()->findByPk($_GET['Transmit']['id']);
        }
        $user = new User('search');
        $user->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
        $criteria->select = 'id,star,subscribe,headimgurl,nickname,group_id,level,integral,mobile,subscribe_time,province,city';
        if (!empty($_GET['User']['nickname'])) {
            $nickname = $_GET['User']['nickname'];
            $criteria->addSearchCondition('nickname', $nickname);
        }
        $criteria->compare('isdelete', 0);
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $dataProvider = new CActiveDataProvider($user, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));

// Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $this->render('create', array(
            'model' => $model,
            'tramsmit' => $tramsmit,
            'user' => $user,
            'dataProvider' => $dataProvider,
            'giftmodel' => $giftmodel,
        ));
    }

    /*
     * 查询用户分组
     * id 分组ID
     */

    public function groupname($id = 0) {
        Yii::import('application.modules.users.models.UserGroup');
        if ($id > 0) {
            $user_group = UserGroup::model()->findByPk($id);
            if (!empty($user_group)) {
                return $user_group->name;
            }
        }
    }

    /*
     * 新增中奖名单
     */

    public function actionCreateaward() {
        Yii::import('application.modules.users.models.User');
        $gift_id = @$_POST['gift_id'];
        $transmit_id = $_POST['transmit_id'];
        $user_id = $_POST['user_id'];
        $public_id = Yii::app()->user->getState('public_id');
        $admin_id = Yii::app()->user->id;
        if (!empty($gift_id) && !empty($transmit_id) && !empty($user_id) && !empty($public_id)) {
            $user_model = User::model()->findByPk($user_id);
            $gift_model = Gift::model()->findByPk($gift_id);
            $criteria = new CDbCriteria();
            $criteria->select = 'id';
            $criteria->compare('public_id', $public_id);
            $criteria->compare('gift_id', $gift_id);
            $criteria->compare('transmit_id', $transmit_id);
            $criteria->compare('user_id', $user_id);
            $criteria->compare('isdelete', 0);
            $awardmodel = Award::model()->find($criteria);

            if (count($awardmodel) > 0) {
                
            } else {
                $award = new Award;
                if (isset($user_model)) {
                    $nickname = $user_model->nickname;
                    $award->setAttribute('nickname', $nickname);
                }if (isset($gift_model)) {
                    $gift_name = $gift_model->name;
                    $award->setAttribute('gift_name', $gift_name);
                }
                $award->setAttribute('public_id', $public_id);
                $award->setAttribute('admin_id', $admin_id);
                $award->setAttribute('user_id', $user_id);
                $award->setAttribute('transmit_id', $transmit_id);
                $award->setAttribute('gift_id', $gift_id);
                $award->setAttribute('isdelete', 0);
                if ($award->save()) {
                    
                } else {
                    var_dump($award->errors);
                    exit;
                }
            }
            $criteria = new CDbCriteria();
            $criteria->select = 'id,admin_id,public_id,gift_id,transmit_id,user_id,gift_name';
            $criteria->compare('transmit_id', $transmit_id);
            $criteria->compare('public_id', $public_id);
            $criteria->compare('isdelete', 0);
            $award_model = Award::model()->findAll($criteria);
            $awards = array();
            if (!empty($award_model)) {
                foreach ($award_model as $c) {
                    $awards[] = array("id" => $c->id, "nickname" => $c->users->nickname, "mobile" => $c->users->mobile, 'gift_name' => $c->gift_name);
                }
                echo json_encode($awards);
            }
        }
    }

    /*
     * 得到礼品
     */

    public function returnGift() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name';
        $criteria->compare('status', 1);
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $giftmodel = Gift::model()->findAll($criteria);
        $gmodel = array();
        if (!empty($giftmodel)) {
            foreach ($giftmodel as $g) {
                $gmodel[$g->id] = $g->name;
            }
            return $gmodel;
        }
    }

}
