<?php

class TransmitUserController extends Controller {

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
     * 积分记录 列表 （后台）
     */

    public function actionIndex() {
        $model = new TransmitUser('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
        $type_id = @$_GET['type_id'];
        if (!empty($type_id)) {
           // $criteria->compare('type_id', $type_id);
        }
        $criteria->compare('status', 0);

        $dataProvider = new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => '`time_created` DESC',
            ),
        ));
        $this->render('index', array('dataProvider' => $dataProvider));
    }

}
