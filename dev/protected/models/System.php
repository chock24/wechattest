<?php

/**
 * This is the model class for table "{{system}}".
 *
 * The followings are the available columns in table '{{system}}':
 * @property integer $id
 * @property string $title
 * @property string $keyword
 * @property string $description
 * @property integer $safe
 * @property string $white_ip
 * @property string $black_ip
 * @property integer $update_id
 * @property integer $time_created
 * @property integer $time_updated
 */
class System extends CActiveRecord {

    public $_select;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{system}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, keyword, description', 'required'),
            array('safe, update_id, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('title, keyword, description', 'length', 'max' => 255),
            array('white_ip, black_ip', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, keyword, description, safe, white_ip, black_ip, update_id, time_created, time_updated', 'safe', 'on' => 'search'),
            
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
            'title' => '网站标题',
            'keyword' => '网站关键字',
            'description' => '网站描述',
            'safe' => '安全模式',
            'white_ip' => '白名单IP',
            'black_ip' => '黑名单IP',
            'update_id' => '最后一次更新人',
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
        $criteria->select = $this->_select;
        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('safe', $this->safe);
        $criteria->compare('white_ip', $this->white_ip, true);
        $criteria->compare('black_ip', $this->black_ip, true);
        $criteria->compare('update_id', $this->update_id);
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
     * @return System the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * 保存入数据库前操作
     */

    public function beforeSave() {
        if (parent::beforeSave()) {
            $this->update_id = Yii::app()->user->id;
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

    public function limitIp() {
        return $resutl = Yii::app()->db->createCommand()
                ->select('open_saveip,saveip')
                ->from($this->tableName())
                ->queryRow();
    }

}
