<?php

class MenuController extends Controller {

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // 登录后才能进行的操作
                'actions' => array('index', 'view', 'create', 'update', 'delete', 'sourcefile', 'remove', 'generate','tokentest'),
                'roles' => array('1', '2'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    /**
     * 检查access_token是否有效
     * @author 陈永杰 2016年7月4日15:26:51
     */
    public function actionTokentest(){
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $flag = WechatStaticMethod::checkAccessToken($access_token);
        if (flag){
            echo "OK,<br/> $access_token";
        }else{
            echo "not OK,<br/> $access_token";
        }
    }
    
    

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->layout = '//layouts/operation';
        $this->performAjaxValidation($model);
        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->save())
                $this->redirect(array('index'));
        }
        $this->render('view', array(
            'model' => $model,
            'action' => 'view',
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = 0) {
        $model = new Menu;
        $this->layout = '//layouts/operation';
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        $criteria = new CDbCriteria();
        $criteria->select = 'COUNT(id)';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('parent_id', $id);
        $criteria->compare('isdelete', 0);
        $count = Menu::model()->count($criteria); //有效菜单数
        $limit = $id ? 5 : 3; //限制数量

        if ($count >= $limit) {
            Yii::app()->user->setFlash('notify', '抱歉，该菜单数已达限额');
        }
        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            $model->parent_id = $id;
            if ($model->save()) {
                $model->updateByPk($model->id, array('key' => $model->id));
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'action' => 'create',
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->layout = '//layouts/operation';
        $this->performAjaxValidation($model);

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '保存菜单项设置成功');
                $this->redirect(array('index', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', '保存菜单项设置失败');
            }
        }

        $this->render('update', array(
            'model' => $model,
            'action' => 'update',
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->updateByPk($id, array('isdelete' => 1));
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionIndex($id = 0, $type = 0) {
        $sourcefileid = array();
        $public_id = Yii::app()->user->getState('public_id');
        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,status,public_id';
        $criteria->compare('public_id', $public_id);
        $criteria->compare('parent_id', 0);
        $criteria->compare('isdelete', 0);
        $dataProvider = new CActiveDataProvider('Menu', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => '`sort` ASC',
            ),
        ));

        //没有自定义菜单
        if ($dataProvider->itemCount == 0) {
            //查询 一级菜单
            $main_meun = Menu::model()->findAll(array(
                'select' => array('id', 'admin_id', 'type', 'multi', 'title', 'category', 'description', 'source_file_id', 'url', 'status'),
                'order' => 'id ASC',
                'condition' => 'public_id=:public_id and template=:template and isdelete = :isdelete and parent_id =:parent_id',
                'params' => array(':public_id' => '1', ':template' => '1', ':isdelete' => '0', ':parent_id' => '0'),
            ));
            //循环一级菜单
            foreach ($main_meun as $key => $mm) {
                $menumodel = new Menu;
                $menumodel->attributes = $mm->attributes;
                $menumodel->unsetAttributes(array('id'));
                $menumodel->setAttribute('public_id', $public_id);
                $menumodel->setAttribute('template', 0);
                $menumodel->setAttribute('parent_id', '0');
                if ($menumodel->save()) {
                    $menumodel->updateByPk($menumodel->id, array('key' => $menumodel->id));
                    //查询 对应的二级菜单
                    $child_meun = Menu::model()->findAll(array(
                        'select' => array('admin_id', 'type', 'multi', 'title', 'category', 'description', 'source_file_id', 'url', 'status'),
                        'order' => 'id ASC',
                        'condition' => 'public_id=:public_id AND template=:template AND isdelete = :isdelete and parent_id =:parent_id',
                        'params' => array(':public_id' => '1', ':template' => '1', ':isdelete' => '0', ':parent_id' => $mm->id),
                    ));
                    //循环增加二级菜单
                    foreach ($child_meun as $key => $child) {
                        $childmodel = new Menu;
                        //  $childmodel->setAttributes($child);
                        $childmodel->setAttribute('admin_id', $child->id);
                        $childmodel->setAttribute('public_id', $public_id);
                        $childmodel->setAttribute('type', $child->type);
                        $childmodel->setAttribute('template', 0);
                        $childmodel->setAttribute('title', $child->title);
                        $childmodel->setAttribute('multi', $child->multi);
                        $childmodel->setAttribute('parent_id', $menumodel->id);
                        $childmodel->setAttribute('category', $child->category);
                        $childmodel->setAttribute('description', $child->description);
                        $childmodel->setAttribute('source_file_id', $child->source_file_id);
                        $childmodel->setAttribute('url', $child->url);
                        $childmodel->setAttribute('status', $child->status);
                        if ($childmodel->save()) {
                            $childmodel->updateByPk($childmodel->id, array('key' => $childmodel->id));
                            //复制单图文 
                            if ($child->multi == 0 && $child->source_file_id > 0) {
                                $result = array_search($child->source_file_id, $sourcefileid);
                                if ($result > 0) {
                                    
                                } else {
                                    //如果图文不存在 则新建  并加入数组
                                    $sourcefileid[$child->source_file_id] = $child->source_file_id;
                                    $sourcemodel = SourceFile::model()->findByPk($child->source_file_id);
                                    $smodel = new SourceFile;
                                    $smodel->attributes = $sourcemodel->attributes;
                                    $smodel->unsetAttributes(array('id'));
                                    $smodel->setAttribute('public_id', $public_id);
                                    if ($smodel->save()) {
                                        
                                    } else {
                                        var_dump($smodel->errors());
                                    }
                                }
                            } //复制   多图文
                            elseif ($child->multi > 0 && $child->source_file_id > 0) {
                                $sourcefielgroupmodel = SourceFileGroup::model()->findByPk($child->source_file_id);
                                if (!empty($sourcefielgroupmodel)) {
                                    $groupmodel = new SourceFileGroup;
                                    $groupmodel->attributes = $sourcefielgroupmodel->attributes;
                                    $groupmodel->unsetAttributes(array('id'));
                                    $groupmodel->setAttribute('public_id', $public_id);
                                    if ($groupmodel->save()) {
                                        $sourcefiledetaillist = SourceFileDetail::model()->findAll('group_id = :group_id and isdelete = :isdelete', array(':group_id' => $child->source_file_id, ':isdelete' => '0'));
                                        if (!empty($sourcefiledetaillist)) {
                                            //分组详情 复制数据
                                            foreach ($sourcefiledetaillist as $key => $fl) {
                                                $sourcefiledetail = new SourceFileDetail;
                                                $sourcefiledetail->setAttribute('group_id', $groupmodel->id);
                                                $sourcefiledetail->setAttribute('file_id', $fl->file_id);
                                                $sourcefiledetail->setAttribute('sort', $fl->sort);
                                                if ($sourcefiledetail->save()) {
                                                    
                                                } else {
                                                    var_dump($sourcefiledetail->errors());
                                                }
                                            }
                                        }
                                    } else {
                                        var_dump($groupmodel->errors());
                                    }
                                }
                            }
                        }
                    }
                } else {
                    var_dump($menumodel->errors);
                    exit;
                }
            }

            $this->redirect(array('index'));
        };
        $model = $this->loadModel($id);
        if ($id == 0) {
            $model = Menu::model()->find('public_id=:public_id', array(':public_id' => $public_id));
        }
        $status = Yii::app()->request->getParam('status');
        if (isset($status)) {
            $parent_id = $model->parent_id;
            //自身的 锁定或解锁
            $model->updateByPk($id, array('status' => $status));
            if ($parent_id > 0) {
                //锁定  父级  操作 
                if ($status > 0) {//解锁 时判断子类是否有 锁定
                    $model->updateByPk($parent_id, array('status' => $status));
                } else {
                    //连同父类 一起锁定 或者解锁
                    $fmodel = $model->findAll('parent_id=:parent_id and status = :status', array(':parent_id' => $parent_id, ':status' => 1));
                    if (count($fmodel) > 0) {//子项 有锁定的菜单
                        //父级菜单不做处理
                    } else {
                        //解锁父级 菜单
                        $model->updateByPk($parent_id, array('status' => $status));
                    }
                }
            }

            $this->redirect(array('index'));
        }
        $template = Yii::app()->request->getParam('template');
        if (isset($template)) {
            Menu::model()->updateAll(array('template' => $template), 'public_id=:public_id', array(':public_id' => $public_id));
            //  $this->redirect(array('index'));
        }
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /*
     * 删除菜单（在线上）
     */

    public function actionRemove() {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$access_token";
        $result = WechatStaticMethod::https_request($url);
        Yii::app()->user->setFlash('success', '删除成功');
        $this->redirect(array('index'));
//var_dump($result);
    }
    
 
    /**
     * 生成菜单（在线上）
     */
    public function actionGenerate() {
        $publicArr = array(
            'appid' => Yii::app()->user->getState('public_appid'),
            'appsecret' => Yii::app()->user->getState('public_appsecret'),
        );
        $access_token = WechatStaticMethod::getAccessToken($publicArr);
        //将长url转换为短URL的微信开放API
        $url_long2short = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=".$access_token;
        //找出所有属于当前公众号的自定义菜单
        $criteria = new CDbCriteria();
        $criteria->select = '`id`,`parent_id`,`type`,`multi`,`title`,`category`,`description`,`source_file_id`,`key`,`url`';
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        $criteria->compare('isdelete', 0);
        $criteria->order = '`sort` ASC';
        $result = Menu::model()->findAll($criteria);
    
        $dataProvider['button'] = array();
        $index = 0;
        foreach ($result as $key => $value) {
            if ($value->parent_id == 0 && $index < 3) {
                //只允许3个一级菜单
                $dataProvider['button'][$index]['type'] = @Yii::app()->params->MENUTYPE[$value->type];
                $dataProvider['button'][$index]['name'] = urlencode($value->title);
                //                 $dataProvider['button'][$index]['name'] = $value->title;
                $dataProvider['button'][$index]['key'] = $value->key;
                $dataProvider['button'][$index]['id'] = $value->id;
                $index ++;
            }
        }
        /**
         * @author 陈永杰 修改于2016年6月29日15:44:15
         * 修复菜单数组的BUG
         * 修复原因:原来传值的数组结构有错误.
         */
        if (is_array($dataProvider['button'])) {
            foreach ($dataProvider['button'] as $key => $value) {
                //判断没有子菜单
                if ($value['type'] == null){
                    //有子菜单
                    $i = 0;
                    foreach ($result as $key_result => $value_result){
                        if ($value_result->parent_id == $value['id'] && $i < 5){
                            $dataProvider['button'][$key]['sub_button'][$i]['name'] = urlencode($value_result->title);
                            $dataProvider['button'][$key]['sub_button'][$i]['type'] = @Yii::app()->params->MENUTYPE[$value_result->type];
                            if ($value_result->type == 1) {
                                $dataProvider['button'][$key]['sub_button'][$i]['key'] = $value_result->key;
                            } elseif ($value_result->type == 2) {
                                $dataProvider['button'][$key]['sub_button'][$i]['url'] = $value_result->url;
                            }
                            unset($dataProvider['button'][$key]['type']);
                            unset($dataProvider['button'][$key]['key']);
                            unset($dataProvider['button'][$key]['id']);
                            $i++;
                        }
                    }
                }elseif($value['type'] != null){
                    //没有子菜单
                    foreach ($result as $key_result => $value_result) {
                        if ($value_result->id == $dataProvider['button'][$key]['id']) {
                            $dataProvider['button'][$key]['name'] = urlencode($value_result->title);
                            $dataProvider['button'][$key]['type'] = @Yii::app()->params->MENUTYPE[$value_result->type];
                            if ($value_result->type == 1) {
                                $dataProvider['button'][$key]['key'] = $value_result->key;
                                unset($dataProvider['button'][$key]['url']);
                            } elseif ($value_result->type == 2) {
                                $dataProvider['button'][$key]['url'] = $value_result->url;
                                unset($dataProvider['button'][$key]['key']);
                            }
                            unset($dataProvider['button'][$key]['id']);
                        }
                    }
                }
            }
        }
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        $data_json = json_encode($dataProvider);
        $result_final = WechatStaticMethod::https_request($url, urldecode($data_json));
        /**
         * @author 陈永杰 修改于2016年6月29日9:41:01
         * 返回正确的信息到前台
         */
        $result_final = json_decode($result_final);
        if($result_final->errcode != 0){
            Yii::app()->user->setFlash('error', '操作失败:'.$result_final->errmsg);
        }else{
            Yii::app()->user->setFlash('success', '上传成功');
        }
        $this->redirect(array('index'));
    }
    

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
            $model->type = Yii::app()->request->getParam('category');
        }

        $model->public_id = Yii::app()->user->getState('public_id');
        $model->isdelete = 0;
        $model->gather_id = Yii::app()->request->getParam('gather_id');
        $model->_limit = 10;
        $dataProvider = $model->getData();

        $sourceFileGather = PublicStaticMethod::getSourceFileGather(Yii::app()->user->getState('public_id'), Yii::app()->request->getParam('category'), Yii::app()->request->getParam('multi'));

        $this->render('//library/content', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sourceFileGather' => $sourceFileGather,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Menu the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $criteria = new CDbCriteria();
        $criteria->select = 'id,type,multi,title,category,description,source_file_id,url,status,parent_id,template';
        $criteria->compare('isdelete', 0);
        $criteria->compare('public_id', Yii::app()->user->getState('public_id'));
        return Menu::model()->findByPk($id, $criteria);
    }

    /**
     * Performs the AJAX validation.
     * @param Menu $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
