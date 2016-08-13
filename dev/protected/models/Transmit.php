<?php

/**
 * This is the model class for table "{{transmit}}".
 *
 * The followings are the available columns in table '{{transmit}}':
 * @property integer $id
 * @property integer $type_id
 * @property integer $admin_id
 * @property integer $public_id
 * @property string $title
 * @property integer $time_start
 * @property integer $time_end
 * @property string $description
 * @property string $content
 * @property integer $number
 * @property integer $integral
 * @property integer $status
 * @property integer $order_by
 * @property integer $time_created
 * @property integer $time_updated
 */
class Transmit extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transmit}}';
    }

    public $files;
    public $child_type_id;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('star,title, description', 'required'),
            array('type_id, admin_id, public_id, time_start, time_end, number, integral, status, order_by, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('description', 'length', 'max' => 255),
            array('content', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type_id, admin_id, public_id, title, time_start, time_end, description, content, number, integral, status, order_by, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transmit_type' => array(self::BELONGS_TO, 'TransmitType', 'type_id', 'select' => 'id,name,parent_id', 'on' => 'status=:status', 'params' => array(':status' => 0)),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'star' => '活动星级',
            'type_id' => '转发类型',
            'admin_id' => 'Admin',
            'public_id' => 'Public',
            'title' => '标题',
            'time_start' => '开始时间',
            'time_end' => '结束时间',
            'description' => '描述',
            'content' => '内容',
            'image_src' => '图片名称',
            'show_cover_pic' => '封面图片显示在正文中',
            'number' => '转发人数',
            'content_source_url' => '查看原文链接',
            'integral' => '积分',
            'status' => '状态',
            'order_by' => '排序',
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
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('time_start', $this->time_start);
        $criteria->compare('time_end', $this->time_end);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('number', $this->number);
        $criteria->compare('integral', $this->integral);
        $criteria->compare('status', $this->status);
        $criteria->compare('order_by', $this->order_by);
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
     * @return Transmit the static model class
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
