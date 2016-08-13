<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    protected function beforeAction($action) {
        if (parent::beforeAction($action)) {
            if (Yii::app()->user->id) {//如果已经登录
                if (!Yii::app()->user->getState('public_id')) {
                    $route = Yii::app()->controller->id . '/' . $action->id;
                    $allowPage = array(
                        'site/error',
                        'site/login',
                        'site/logout',
                        'wcpublic/index',
                        'wcpublic/create',
                        'wcpublic/update',
                        'wcpublic/change',
                        'system/index',
                        'admin/index',
                        'admin/create',
                        'admin/update',
                        'system/logaccess',
                        'system/logerror',
                        'message/index',
                        'user/view',
                        'user/sourcefile',
                        'message/sourcefile',
                    );

                    if (!in_array($route, $allowPage)) {
                        Yii::app()->user->setFlash('error', '您必须选择公众号，才能进行后续操作。');
                        $this->redirect(array('/publics/wcpublic/index'));
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public static function post($url, $param) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param, '&'));
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /* protected function beforeAction($action) {
      if (parent::beforeAction($action)) {
      $route = Yii::app()->controller->id . '/' . $action->id;
      if (!$this->allowIp(Yii::app()->request->userHostAddress) && $route !== 'site/error' && $route !== 'site/login') {
      throw new CHttpException(403, "你未被允许访问.");
      }
      return true;
      } else
      return false;
      } */

    /**
     * Checks to see if the user IP is allowed by {@link ipFilters}.
     * @param string $ip the user IP
     * @return boolean whether the user IP is allowed by {@link ipFilters}.
     */
    /* protected function allowIp($ip) {
      Yii::import("application.modules.settings.models.*");
      //查询 白名单，黑名单
      $model = System::model();
      $model->_select = 'id,safe,white_ip,black_ip';
      $limitIp = $model->find();
      if (!empty($limitIp['black_ip'])) {
      $ipList = explode(',', $limitIp['black_ip']);

      if (count($ipList) > 1) {
      $bool = 1;
      foreach ($ipList as $filter) {
      if ($filter === '*' || trim($filter) === trim($ip) || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
      $bool = 0;
      } else {
      if ($bool == 0) {
      $bool = 0;
      } else {
      $bool = 1;
      }
      }
      }
      if ($bool == 0) {
      return false;
      } else {
      return true;
      }
      } else {
      if ($ipList[0] === '*' || $ipList[0] === $ip || (($pos = strpos($ipList[0], '*')) !== false && !strncmp($ip, $ipList[0], $pos))) {
      return false;
      } else {
      return true;
      }
      }
      } else {
      return true;
      }
      } */
}
