<?php

/**
 * This is the model class for table "{{user_module}}".
 *
 * The followings are the available columns in table '{{user_module}}':
 * @property integer $id
 * @property integer $public_id
 * @property string $title
 * @property string $bg_img
 * @property string $url
 * @property integer $order_by
 * @property integer $time_created
 * @property integer $time_updated
 */
class UserModule extends CActiveRecord {

    public $files;
    public $type_id;
    public $child_type_id;
    public $three_type_id;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_module}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' title,  order_by', 'required'),
            array(' public_id, order_by, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 50),
            array('bg_img, url', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id,isdelete, title, bg_img, url, order_by, time_created, time_updated', 'safe', 'on' => 'search'),
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
            'title' => '标题',
            'bg_img' => '背景图',
            'url' => '链接地址',
            'order_by' => '排序',
            'isdelete' => 'isdelete',
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
        $criteria->compare('bg_img', $this->bg_img, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('isdelete', $this->isdelete, true);
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
     * @return UserModule the static model class
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
