<?php

/**
 * This is the model class for table "{{service}}".
 *
 * The followings are the available columns in table '{{service}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property string $account
 * @property string $nickname
 * @property string $password
 * @property integer $kf_id
 * @property string $kf_headimg
 * @property integer $auto_accept
 * @property integer $accepted_case
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Service extends CActiveRecord {

    public $_select = '*';
    public $repeat;
    public $time_start;
    public $time_end;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{service}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('admin_id, public_id, account, nickname, password, kf_id, kf_headimg, auto_accept, accepted_case, status, sort, ', 'required'),
            array('account,nickname,password,repeat','required','on'=>'insert'),
            array('account','unique'),//唯一
            array('repeat','compare','compareAttribute'=>'password','message'=>'两次输入密码不同'),
            array('admin_id, public_id, kf_id, auto_accept, accepted_case, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('account, password', 'length', 'max' => 55),
            array('nickname','length','max'=>12),
            array('kf_headimg', 'file', 'maxFiles'=>1, 'allowEmpty'=>true ,'maxSize'=>2*1024*1024, 'tooLarge'=>'文件超出规定尺寸', 'types'=>array('jpg','gif','png'), 'wrongType'=>'仅能上传jpg,png或者是gif的文件'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, admin_id, public_id, account, nickname, password, kf_id, kf_headimg, auto_accept, accepted_case, status, sort, isdelete, time_created, time_updated, time_start, time_end', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '客服帐号',
            'admin_id' => '管理员ID',
            'public_id' => '公众号ID',
            'account' => '账号',
            'nickname' => '客服昵称',
            'password' => '客服密码',
            'repeat' => '重复密码',
            'kf_id' => '客服工号',
            'kf_headimg' => '客服头像',
            'auto_accept' => '客服设置的最大自动接入数',
            'accepted_case' => '客服当前正在接待的会话数',
            'status' => '客服在线状态',
            'sort' => '排序',
            'isdelete' => 'Isdelete',
            'time_created' => '创建时间',
            'time_updated' => '更新时间',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = $this->_select;
        $criteria->compare('id', $this->id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('account', $this->account, true);
        $criteria->compare('nickname', $this->nickname, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('kf_id', $this->kf_id);
        $criteria->compare('kf_headimg', $this->kf_headimg, true);
        $criteria->compare('auto_accept', $this->auto_accept);
        $criteria->compare('accepted_case', $this->accepted_case);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        //$criteria->compare('time_created', $this->time_created);
        //$criteria->compare('time_updated', $this->time_updated);
        if (!empty($this->time_start) && !empty($this->time_end)) {
            $criteria->addBetweenCondition('time_created', strtotime($this->time_start), strtotime($this->time_end) + 3600 * 24);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize'=>20,
            ),
            'sort'=>array(
                'defaultOrder'=>'`time_created` DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Service the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * 在存入数据库前的操作
     */
    public function beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->admin_id = Yii::app()->user->id;
                $this->public_id = Yii::app()->user->getState('public_id');
                $this->password = md5($this->password);
            }
            return true;
        }else{
            return false;
        }
    }

    /*
     * 自动填充创建时间和更新时间
     */

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'time_created',
                'updateAttribute' => 'time_updated',
                'setUpdateOnCreate' => true,
            ),
        );
    }

}
