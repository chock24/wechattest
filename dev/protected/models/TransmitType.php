<?php

/**
 * This is the model class for table "{{transmit_type}}".
 *
 * The followings are the available columns in table '{{transmit_type}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $parent_id
 * @property string $name
 * @property integer $status
 * @property integer $time_created
 * @property integer $time_updated
 */
class TransmitType extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transmit_type}}';
    }

    

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
    array('parent_id, name', 'required'),
    array('admin_id, parent_id, status, time_created, time_updated', 'numerical', 'integerOnly' => true),
    array('name', 'length', 'max' => 50),
    // The following rule is used by search().
    // @todo Please remove those attributes that should not be searched.
    array('id, admin_id, parent_id, name, status, time_created, time_updated', 'safe', 'on' => 'search'),
    );
}

/**
 * @return array relational rules.
 */
public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
         'childrens' => array(self::HAS_MANY, 'TransmitType', array('parent_id' => 'id'), 'select' => 'id,admin_id,name,parent_id,status', 'on' => 'status=:status', 'params' => array(':status' => 0)),
    );
}

/**
 * @return array customized attribute labels (name=>label)
 */
public function attributeLabels() {
    return array(
        'id' => 'ID',
        'admin_id' => 'Admin',
        'parent_id' => '父级ID',
        'name' => '分类名称',
        'status' => '状态',
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
    $criteria->compare('admin_id', $this->admin_id);
    $criteria->compare('parent_id', $this->parent_id);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('status', $this->status);
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
 * @return TransmitType the static model class
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
