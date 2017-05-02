<?php

/**
 * This is the model class for table "{{p_c_a}}".
 *
 * The followings are the available columns in table '{{p_c_a}}':
 * @property integer $csc_id
 * @property string $csc_name
 * @property string $csc_pinyin
 * @property string $csc_type
 * @property integer $csc_parent_id
 * @property integer $csc_code
 */
class PCA extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{p_c_a}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_name, csc_pinyin, csc_type, csc_code', 'required'),
			array('csc_id, csc_parent_id, csc_code', 'numerical', 'integerOnly'=>true),
			array('csc_name', 'length', 'max'=>20),
			array('csc_pinyin', 'length', 'max'=>100),
			array('csc_type', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_pinyin, csc_type, csc_parent_id, csc_code', 'safe', 'on'=>'search'),
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
			'parent' => array(self::HAS_ONE, 'PCA', array('csc_id'=>'csc_parent_id')),
			'son' => array(self::HAS_MANY, 'PCA', array('csc_parent_id'=>'csc_id')),
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
			'csc_pinyin' => 'Csc Pinyin',
			'csc_type' => 'Csc Type',
			'csc_parent_id' => 'Csc Parent',
			'csc_code' => 'Csc Code',
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
		$criteria->compare('csc_pinyin',$this->csc_pinyin,true);
		$criteria->compare('csc_type',$this->csc_type,true);
		$criteria->compare('csc_parent_id',$this->csc_parent_id);
		$criteria->compare('csc_code',$this->csc_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PCA the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
