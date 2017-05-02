<?php

/**
 * This is the model class for table "{{order_log}}".
 *
 * The followings are the available columns in table '{{order_log}}':
 * @property string $csc_id
 * @property string $csc_order_id
 * @property string $csc_oper_name
 * @property string $csc_store_name
 * @property string $csc_order_status
 * @property string $csc_change_status
 * @property string $csc_remark
 * @property string $csc_create
 */
class OrderLog extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_order_id, csc_oper_name, csc_store_name, csc_order_status, csc_change_status, csc_create', 'required'),
			array('csc_id, csc_order_id', 'length', 'max'=>32),
			array('csc_oper_name', 'length', 'max'=>15),
			array('csc_store_name, csc_remark', 'length', 'max'=>50),
			array('csc_order_status, csc_change_status', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_order_id, csc_oper_name, csc_store_name, csc_order_status, csc_change_status, csc_remark, csc_create', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => 'Csc',
			'csc_order_id' => 'Csc Order',
			'csc_oper_name' => 'Csc Oper Name',
			'csc_store_name' => 'Csc Store Name',
			'csc_order_status' => 'Csc Order Status',
			'csc_change_status' => 'Csc Change Status',
			'csc_remark' => 'Csc Remark',
			'csc_create' => 'Csc Create',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('csc_id',$this->csc_id,true);
		$criteria->compare('csc_order_id',$this->csc_order_id,true);
		$criteria->compare('csc_oper_name',$this->csc_oper_name,true);
		$criteria->compare('csc_store_name',$this->csc_store_name,true);
		$criteria->compare('csc_order_status',$this->csc_order_status,true);
		$criteria->compare('csc_change_status',$this->csc_change_status,true);
		$criteria->compare('csc_remark',$this->csc_remark,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
