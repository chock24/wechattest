<?php

/**
 * This is the model class for table "{{rule}}".
 *
 * The followings are the available columns in table '{{rule}}':
 * @property integer $id
 * @property integer $admin_id
 * @property integer $public_id
 * @property integer $entire
 * @property string $title
 * @property integer $status
 * @property integer $sort
 * @property integer $isdelete
 * @property integer $time_created
 * @property integer $time_updated
 */
class Rule extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{rule}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('admin_id, public_id, entire, title, ', 'required'),
            array('admin_id, public_id, entire, status, sort, isdelete, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 60),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, admin_id, public_id, entire, title, status, sort, isdelete, time_created, time_updated', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'keyword' => array(self::HAS_MANY, 'Keyword', 'rule_id', 'select' => 'type,title,rule_id', 'on' => 'isdelete=:isdelete', 'params' => array('isdelete' => 0)),
            'replyCount' => array(self::STAT, 'Reply', 'rule_id'),
            'reply' => array(self::HAS_MANY, 'Reply', 'rule_id', 'select' => 'type,content,multi,source_file_id,rule_id,first', 'on' => 'isdelete=:isdelete ', 'params' => array('isdelete' => 0), 'order' => 'sort DESC',),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'admin_id' => '管理员ID',
            'public_id' => '公众号ID',
            'entire' => '是否发送全部',
            'title' => '规则名',
            'status' => '数据状态',
            'sort' => '排序',
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
        $id = Yii::app()->request->getParam("id");
        if (!empty($id)) {

            $criteria->compare('id', $id);
        }

        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('public_id', $this->public_id);
        $criteria->compare('entire', $this->entire);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('isdelete', $this->isdelete);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);
        $criteria->order = 'sort DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rule the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 在存入数据库前的操作
     */
    public function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->admin_id = Yii::app()->user->id;
                $this->public_id = Yii::app()->user->getState('public_id');
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
