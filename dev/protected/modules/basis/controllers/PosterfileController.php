<?php
class PosterfileController extends Controller {

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
                    'index',
                    'Posterfile',
                ),
                'roles' => array('1', '2'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionPosterfile() {

            $this->layout = '//layouts/operation';
            $model = new Poster;
            $dataProvider = $model->getData();
            $postertype=Yii::app()->request->getParam('type');
            $this->render('//library/content', array(
                'poster' => $postertype,
                'dataProvider' => $dataProvider,
        ));
    }
}