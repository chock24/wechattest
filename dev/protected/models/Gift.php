<?php

/**
 * This is the model class for table "{{gift}}".
 *
 * The followings are the available columns in table '{{gift}}':
 * @property integer $id
 * @property integer $public_id
 * @property string $name
 * @property integer $type_id
 * @property string $number
 * @property integer $integral
 * @property string $content
 * @property string $image_src
 * @property string $remark
 * @property integer $count_stock
 * @property integer $order_by
 * @property integer $status
 * @property integer $time_created
 * @property integer $time_updated
 */
class Gift extends CActiveRecord {

    public $files;
    public $score; //库存  数值
    public $genre; //操作类型 1增加 2减少

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return '{{gift}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('public_id, type_id,number', 'required'),
            array('public_id, type_id,  count_stock, order_by, status, time_created, time_updated', 'numerical', 'integerOnly' => true),
            array('name, image_src, remark', 'length', 'max' => 255),
            array('number', 'length', 'max' => 200),
            array('content,public_id, type_id,  count_stock, order_by, status, time_created, time_updated,image_src,image_arr', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, public_id, name, type_id, number, integral, content, image_src, remark, count_stock, order_by, status, time_created, time_updated , prizevalue', 'safe', 'on' => 'search'),
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
            'name' => '名称',
            'type_id' => '类型',
            'number' => '商品编号',
            'integral' => '积分',
            'content' => '商品详情',
            'image_src' => '图片名称',
            'image_arr' => '图片集',
            'remark' => '商品参数',
            'count_stock' => '库存数',
            'order_by' => '排序',
            'status' => '状态',
            'time_created' => 'Time Created',
            'time_updated' => 'Time Updated',
            'prizevalue'   =>'商品原价',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('integral', $this->integral);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('image_src', $this->image_src, true);
        $criteria->compare('image_arr', $this->image_arr, true);
        $criteria->compare('remark', $this->remark, true);
        $criteria->compare('count_stock', $this->count_stock);
        $criteria->compare('order_by', $this->order_by);
        $criteria->compare('status', $this->status);
        $criteria->compare('time_created', $this->time_created);
        $criteria->compare('time_updated', $this->time_updated);
        $criteria->compare('prizevalue', $this->prizevalue);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Gift the static model class
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
