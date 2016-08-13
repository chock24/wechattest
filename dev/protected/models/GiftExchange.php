<?php

/**
 * This is the model class for table "{{gift_exchange}}".
 *
 * The followings are the available columns in table '{{gift_exchange}}':
 * @property integer $id
 * @property integer $public_id
 * @property integer $user_id
 * @property string $gift_name
 * @property integer $gift_id
 * @property integer $address_id
 * @property integer $address_sheng
 * @property integer $address_shi
 * @property integer $address_qu
 * @property string $address_other
 * @property integer $postcode
 * @property integer $mobile
 * @property integer $tel
 * @property integer $score
 * @property integer $time_created
 */
class GiftExchange extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gift_exchange}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' public_id, user_id, gift_name, gift_id,  address_sheng, address_shi, address_qu, score, time_created', 'required'),
            array(' public_id, user_id, gift_id, address_id, address_sheng, address_shi, address_qu, postcode, mobile, tel, score, time_created', 'numerical', 'integerOnly' => true),
            array('gift_name, address_other', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('status,id, public_id, user_id, gift_name, gift_id, address_id, address_sheng, address_shi, address_qu, address_other, postcode, mobile, tel, score, time_created', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id', 'condition' => 'status=:status', 'params' => array(':status' => 1)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'public_id' => 'Public',
            'user_id' => 'User',
            'gift_name' => 'Gift Name',
            'gift_id' => 'Gift',
            'address_id' => 'Address',
            'address_sheng' => 'Address Sheng',
            'address_shi' => 'Address Shi',
            'address_qu' => 'Address Qu',
            'address_other' => 'Address Other',
            'postcode' => 'Postcode',
            'mobile' => 'Mobile',
            'tel' => 'Tel',
            'score' => 'Score',
            'time_created' => 'Time Created',
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
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('gift_name', $this->gift_name, true);
        $criteria->compare('gift_id', $this->gift_id);
        $criteria->compare('address_id', $this->address_id);
        $criteria->compare('address_sheng', $this->address_sheng);
        $criteria->compare('address_shi', $this->address_shi);
        $criteria->compare('address_qu', $this->address_qu);
        $criteria->compare('address_other', $this->address_other, true);
        $criteria->compare('postcode', $this->postcode);
        $criteria->compare('mobile', $this->mobile);
        $criteria->compare('tel', $this->tel);

        $criteria->compare('score', $this->score);
        $criteria->compare('time_created', $this->time_created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftExchange the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'time_created',
                'updateAttribute' => 'time_updated',
                'setUpdateOnCreate' => true,
            )
        );
    }

}
