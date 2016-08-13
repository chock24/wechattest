<?php

/**
 * This is the model class for table "{{coupon}}".
 *
 * The followings are the available columns in table '{{coupon}}':
 * @property integer $id
 * @property integer $public_id
 * @property integer $number
 * @property string $title
 * @property string $description
 * @property integer $integral
 * @property integer $price
 * @property integer $time_start
 * @property integer $time_end
 * @property integer $status
 * @property integer $order_by
 * @property integer $tme_created
 */
class Coupon extends CActiveRecord {

    public $files;
 
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{coupon}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' public_id, title', 'required'),
            array(' public_id,  integral, price, time_start, time_end, status, order_by, time_created', 'numerical', 'integerOnly' => true),
            array('title, description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, number, title, description, integral, price, time_start, time_end, status, order_by, time_created', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'public_id' => 'Public',
            'number' => '优惠券号',
            'title' => '标题',
            'description' => '描述',
            'integral' => '所需积分',
            'price' => '价值',
            'time_start' => '开始时间',
            'time_end' => '结束时间',
            'status' => '状态',
            'order_by' => '排序',
            'time_created' => '创建时间',
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
        $criteria->compare('number', $this->number);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('integral', $this->integral);
        $criteria->compare('price', $this->price);
        $criteria->compare('time_start', $this->time_start);
        $criteria->compare('time_end', $this->time_end);
        $criteria->compare('status', $this->status);
        $criteria->compare('order_by', $this->order_by);
        $criteria->compare('time_created', $this->tme_created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coupon the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
