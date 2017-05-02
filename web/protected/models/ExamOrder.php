<?php

/**
 * This is the model class for table "{{exam_order}}".
 *
 * The followings are the available columns in table '{{exam_order}}':
 * @property integer $csc_id
 * @property integer $csc_grade
 * @property integer $csc_school
 * @property string $csc_name
 * @property string $csc_tel
 * @property string $csc_mail
 * @property string $csc_create
 */
class ExamOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_grade, csc_school, csc_name, csc_tel', 'required'),
			array('csc_id, csc_grade, csc_school', 'numerical', 'integerOnly'=>true),
			array('csc_name', 'length', 'max'=>20),
			array('csc_tel, csc_mail', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_grade, csc_school, csc_name, csc_tel, csc_mail', 'safe', 'on'=>'search'),
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
			'cate'=>array(self::HAS_ONE, 'Category', array('csc_id'=>'csc_school')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => 'Csc',
			'csc_grade' => 'Csc Grade',
			'csc_school' => 'Csc School',
			'csc_name' => 'Csc Name',
			'csc_tel' => 'Csc Tel',
			'csc_mail' => 'Csc Mail',
			'csc_create' => 'csc create',
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
		$criteria->compare('csc_grade',$this->csc_grade);
		$criteria->compare('csc_school',$this->csc_school);
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_tel',$this->csc_tel,true);
		$criteria->compare('csc_mail',$this->csc_mail,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 
	 * @see CActiveRecord::save()
	 */
	public function save($runValidation=true,$attributes=null){
		if(!$runValidation || $this->validate($attributes)){
			if($this->getIsNewRecord()){
				$this->csc_id = getPrimaryKey($this);
				$this->csc_create = date('Y-m-d H:i:s');
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else
			return false;
	}

}
