<?php

class SystemController extends Controller {

    private $adminArr = array();

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'logaccess', 'logerror'),
                'roles' => array('1'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 显示系统设置
     */
    public function actionIndex() {
        $this->layout = '//layouts/system';
        $model = $this->loadModel(1);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['System'])) {
            $model->attributes = $_POST['System'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存系统设置成功');
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', '保存系统设置失败');
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionLogerror() {
        $this->layout = '//layouts/system';
        $model = new LogError('search');
        $model->unsetAttributes();  // clear any default values
        $model->_select = 'id,admin_id,ip,error_code,content,error_url,from_url,time_created';
        $model->isdelete = 0;
        $this->getAdminDataProvider();
        if (isset($_GET['LogError']))
            $model->attributes = $_GET['LogError'];

        $this->render('logerror', array(
            'model' => $model,
        ));
    }

    /**
     * 显示所有系统用户登录记录
     */
    public function actionLogaccess() {
        $this->layout = '//layouts/system';
        $model = new LogAccess('search');
        $model->unsetAttributes();  // clear any default values
        $model->_select = 'id,admin_id,ip,time_created';
        $this->getAdminDataProvider();
        if (isset($_GET['LogAccess']))
            $model->attributes = $_GET['LogAccess'];

        $this->render('logaccess', array(
            'model' => $model,
        ));
    }

    /**
     * 页面调用出管理员名字
     * @param object $data
     * @param int $row
     * @return string
     */
    protected function admin($data, $row) {
        if ($this->adminArr) {
            foreach ($this->adminArr as $key => $value) {
                if ($key == $data->admin_id) {
                    return $value;
                }
            }
        }
    }

    /**
     * 返回管理员数组
     */
    private function getAdminDataProvider() {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,name';
        $criteria->compare('isdelete', 0);
        $adminDataProvider = Admin::model()->findAll($criteria);
        if ($adminDataProvider) {
            foreach ($adminDataProvider as $value) {
                $this->adminArr[$value['id']] = $value['name'];
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return System the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = System::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param System $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'system-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
