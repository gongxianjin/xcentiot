<?php

/**
 * This is the model class for table "{{special}}".
 *
 * The followings are the available columns in table '{{special}}':
 * @property integer $csc_id
 * @property string $csc_name
 * @property string $csc_phone
 * @property string $csc_type
 * @property integer $csc_award
 * @property string $csc_create
 * @property string $csc_update
 */
class Special extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{special}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_name, csc_phone, csc_type, csc_create', 'required'),
			array('csc_id, csc_award', 'numerical', 'integerOnly'=>true),
			array('csc_name', 'length', 'max'=>100),
			array('csc_phone', 'length', 'max'=>20),
			array('csc_type', 'length', 'max'=>200),
			array('csc_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_phone, csc_type, csc_award, csc_create, csc_update', 'safe', 'on'=>'search'),
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
			'csc_name' => 'Csc Name',
			'csc_phone' => 'Csc Phone',
			'csc_type' => 'Csc Type',
			'csc_award' => 'Csc Award',
			'csc_create' => 'Csc Create',
			'csc_update' => 'Csc Update',
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

		$criteria->compare('csc_id',$this->csc_id);
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_phone',$this->csc_phone,true);
		$criteria->compare('csc_type',$this->csc_type,true);
		$criteria->compare('csc_award',$this->csc_award);
		$criteria->compare('csc_create',$this->csc_create,true);
		$criteria->compare('csc_update',$this->csc_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Special the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
