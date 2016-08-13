<?php

class GiftExchangeController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //    'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('ajaxUpdate', 'index', 'admin', 'view', 'update', 'create', 'delete'),
                'roles' => array('1', '2', '3', '4'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        Yii::import('application.modules.users.models.User');
        $model = new GiftExchange('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria;
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

    public function actionUpdate() {
        $id = Yii::app()->request->getParam('id');
        $model = $this->loadModel($id);
        $districtmodel = District::model()->findAll('status=:status', array(':status' => '0'));
        $trantype = array();
        if (!empty($districtmodel)) {
            foreach ($districtmodel as $t) {
                $trantype[$t->id] = $t->name;
            }
        }
        if (isset($_POST['GiftExchange'])) {
            $model->attributes = $_POST['GiftExchange'];
            $model->remark = @$_POST['GiftExchange']['remark'];
            $model->status = @$_POST['GiftExchange']['status'];
            $model->time_updated = time();
            if ($model->save()) {
                $this->redirect(array('index'));
            } else {
                var_dump($model->errors);
            }
        }

        $this->render('update', array(
            'model' => $model,
            'trantype' => $trantype,
        ));
    }

    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id);
        $model = GiftExchange::model()->findByPk($id, $criteria);

        if ($model === null)
            throw new CHttpException(404, '请求的页面不存在。');
        return $model;
    }

    //index 页面ajax 修改内容 GIFT
    public function actionAjaxUpdate() {
        $id = $_POST['id'];
        $status = $_POST['value'];
        if ($id) {
            GiftExchange::model()->updateAll(array('status' => $status), 'id=:id', array(':id' => $id));
            echo 'success';
        }
    }

}
