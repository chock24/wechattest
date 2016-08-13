<?php

/**
 * This is the model class for table "{{public}}".
 *
 * The followings are the available columns in table '{{public}}':
 * @property integer $id
 * @property integer admin_id
 * @property integer $type
 * @property string $title
 * @property string $original
 * @property string $headimage
 * @property string $wechat
 * @property string $appid
 * @property string $appsecret
 * @property string $watermark
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class WcPublic extends CActiveRecord {

    public $time_start;
    public $time_end;
    public $all_kefu;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{public}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, title, original, wechat, appid, appsecret', 'required'),
            //array('headimage', 'file', 'maxFiles'=>1, 'allowEmpty'=>true ,'maxSize'=>2*1024*1024, 'tooLarge'=>'文件超出规定尺寸', 'types'=>array('jpg','gif','png'), 'wrongType'=>'仅能上传jpg,png或者是gif的文件'),
            array('admin_id, type, change, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('watermark', 'length', 'max' => 20),
          //  array('original', 'authenticate'),
            array('title, original, wechat, appid, appsecret', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type, title, original, headimage, wechat, appid, appsecret, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Authenticates the original.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $criteria = new CDbCriteria();
            $criteria->select = 'id';
            $criteria->compare('isdelete', 0);
            $criteria->compare('original', $this->original);
            $model = $this->find($criteria);
            if ($model !== null)
                $this->addError('original', '公众号已经存在。');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
         'adminpublic' => array(self::HAS_MANY, 'Adminpublic', array( 'public_id' => 'id'), 'on' => 'isdelete=:isdelete', 'params' => array(':isdelete' => 0), 'order' => '`sort` ASC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'admin_id' => '所属管理员',
            'type' => '公众号类型',
            'title' => '公众号名称',
            'original' => '原始ID',
            'headimage' => '头像',
            'wechat' => '微信号',
            'appid' => 'Appid',
            'appsecret' => 'Appsecret',
            'change' => '是否转接消息到多客服',
            'watermark' => '水印文字',
            'status' => 'Status',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
            'time_created' => '创建时间',
            'time_updated' => 'Time Updated',
            'trust'=>'是否托管公众号'
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

        $criteria->compare('id', $this->id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('original', $this->original, true);
        $criteria->compare('headimage', $this->headimage, true);
        $criteria->compare('wechat', $this->wechat, true);
        $criteria->compare('appid', $this->appid, true);
        $criteria->compare('appsecret', $this->appsecret, true);
        $criteria->compare('change', $this->change);
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
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WcPublic the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->admin_id = Yii::app()->user->id;
            }
            return true;
        } else {
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
