<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $username = strtolower($this->username);
        $admin = Admin::model()->find('LOWER(username)=?', array($username));
        if ($admin === null){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }elseif (!$admin->validationPassword($this->password)){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }elseif ($admin->isdelete){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else {
            $this->_id = $admin->id;
            $this->username = $admin->username;
            /*--------------------查询公众号，赋值到session----------------------*/
            /*$criteria = new CDbCriteria();
            $criteria->select = 'id,original,wechat,title,appid,appsecret,watermark';
            $criteria->compare('admin_id', $admin->id);
            $criteria->compare('isdelete', 0);
            $public = WcPublic::model()->find($criteria);*/
            $this->setState('roles', $admin->role_id);
            /*$this->setState('public_id', isset($public->id)?$public->id:0);
            $this->setState('public_original', isset($public->original)?$public->original:'');
            $this->setState('public_wechat', isset($public->wechat)?$public->wechat:'');
            $this->setState('public_name', isset($public->title)?$public->title:'');
            $this->setState('public_appid', isset($public->appid)?$public->appid:'');
            $this->setState('public_appsecret', isset($public->appsecret)?$public->appsecret:'');
            $this->setState('public_watermark', isset($public->watermark)?$public->watermark:'');*/
            
            /*--------------------保存登录记录----------------------*/
            $logAccess = new LogAccess();
            $logAccess->setAttribute('admin_id', $admin->id);
            $logAccess->setAttribute('session', md5(time()));//记录md5时间戳，以防以后需要做单位登录（不重复登录）
            $logAccess->setAttribute('ip', Yii::app()->request->userHostAddress);
            if($logAccess->save()){
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}
