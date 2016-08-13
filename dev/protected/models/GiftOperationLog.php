<?php

/**
 * This is the model class for table "{{gift_operation_log}}".
 *
 * The followings are the available columns in table '{{gift_operation_log}}':
 * @property integer $id
 * @property integer $gift_id
 * @property integer $admin_id
 * @property integer $genre
 * @property integer $score
 * @property string $remark
 * @property integer $isdelete
 * @property integer $time_created
 */
class GiftOperationLog extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{gift_operation_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('genre, score', 'required'),
            array('gift_id, admin_id, genre, score, isdelete, time_created', 'numerical', 'integerOnly' => true),
            array('remark', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, gift_id, admin_id, genre, score, remark, isdelete, time_created', 'safe', 'on' => 'search'),
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
            'gift_id' => 'Gift',
            'admin_id' => 'Admin',
            'genre' => 'Genre',
            'score' => 'Score',
            'remark' => 'Remark',
            'isdelete' => 'Isdelete',
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
        $criteria->compare('gift_id', $this->gift_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('genre', $this->genre);
        $criteria->compare('score', $this->score);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('isdelete', $this->isdelete);
        $criteria->compare('time_created', $this->time_created);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftOperationLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
