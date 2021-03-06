<?php

/**
 * This is the model class for table "{{user_level}}".
 *
 * The followings are the available columns in table '{{user_level}}':
 * @property integer $id
 * @property integer public_id
 * @property string $title
 * @property integer $value
 * @property string $rebate
 * @property integer $gabalnara
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class UserLevel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_level}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, value, rebate, gabalnara, status, sort, isdelete, time_created, time_updated', 'required'),
            array('public_id, value, gabalnara, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 55),
            array('rebate', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, title, value, rebate, gabalnara, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
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
            'id' => '等级ID',
            'public_id' => '所属公众号',
            'title' => '等级名',
            'value' => '等级值',
            'rebate' => '折扣',
            'gabalnara' => '是否包邮',
            'status' => 'Status',
            'sort' => 'Sort',
            'isdelete' => 'Isdelete',
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
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('value', $this->value);
        $criteria->compare('rebate', $this->rebate, true);
        $criteria->compare('gabalnara', $this->gabalnara);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
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
     * @return UserLevel the static model class
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
