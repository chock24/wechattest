<?php

/**
 * This is the model class for table "{{user_address}}".
 *
 * The followings are the available columns in table '{{user_address}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $admin_id
 * @property string $name
 * @property integer $address_sheng
 * @property integer $address_shi
 * @property integer $address_qu
 * @property string $address_other
 * @property integer $postcode
 * @property integer $mobile
 * @property integer $isdefault
 * @property integer $tel
 * @property integer $time_created
 * @property integer $time_updated
 */
class UserAddress extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_address}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, admin_id, address_sheng, address_shi, address_qu, postcode, mobile, isdefault, tel, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('name, address_other', 'length', 'max' => 255),
            array('postcode', 'length', 'message' => '正确填写邮编', 'max' => 6),
            array('tel', 'length', 'message' => '正确填写手机号', 'max' => 11),
            // array('tel', 'match', 'pattern' => '/(^((13[0-9])|(15[^4,\\D])|(18[0,5-9]))\\d{8}$)/', 'message' => '手机号码格式错误，请您重新输入。'),
            //array('postcode', 'match', 'pattern' => '/(^[1-9][0-9]{5}$)/', 'message' => '邮编不正确，请您重新输入。'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, admin_id, name, address_sheng, address_shi, address_qu, address_other, postcode, mobile, isdefault, tel, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sheng' => array(self::BELONGS_TO, 'District', 'address_sheng', 'condition' => 'status=:status', 'params' => array(':status' => 0)),
            'shi' => array(self::BELONGS_TO, 'District', 'address_shi', 'condition' => 'status=:status', 'params' => array(':status' => 0)),
            'qu' => array(self::BELONGS_TO, 'District', 'address_qu', 'condition' => 'status=:status', 'params' => array(':status' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'admin_id' => 'Admin',
            'name' => 'Name',
            'address_sheng' => 'Address Sheng',
            'address_shi' => 'Address Shi',
            'address_qu' => 'Address Qu',
            'address_other' => 'Address Other',
            'postcode' => 'Postcode',
            'mobile' => 'Mobile',
            'isdefault' => 'Isdefault',
            'tel' => 'Tel',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address_sheng', $this->address_sheng);
        $criteria->compare('address_shi', $this->address_shi);
        $criteria->compare('address_qu', $this->address_qu);
        $criteria->compare('address_other', $this->address_other, true);
        $criteria->compare('postcode', $this->postcode);
        $criteria->compare('mobile', $this->mobile);
        $criteria->compare('isdefault', $this->isdefault);
        $criteria->compare('tel', $this->tel);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserAddress the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
