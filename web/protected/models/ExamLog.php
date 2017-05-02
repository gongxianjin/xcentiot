<?php

/**
 * This is the model class for table "{{exam_log}}".
 *
 * The followings are the available columns in table '{{exam_log}}':
 * @property integer $csc_id
 * @property string $csc_name
 * @property string $csc_class
 * @property string $csc_contact
 * @property integer $csc_exam_id
 * @property string $csc_record
 * @property string $csc_grade
 * @property string $csc_create
 */
class ExamLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_name, csc_class, csc_contact, csc_exam_id, csc_record, csc_grade', 'required'),
			array('csc_id, csc_exam_id', 'numerical', 'integerOnly'=>true),
			array('csc_name, csc_contact, csc_grade', 'length', 'max'=>20),
			array('csc_class', 'length', 'max'=>100),
			array('csc_record', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_class, csc_contact, csc_exam_id, csc_record, csc_grade', 'safe', 'on'=>'search'),
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
			'info'=>array(self::BELONGS_TO , 'Exam' , array('csc_exam_id'=>'csc_id')),
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
			'csc_class' => 'Csc Class',
			'csc_contact' => 'Csc Contact',
			'csc_exam_id' => 'Csc Exam',
			'csc_record' => 'Csc Record',
			'csc_grade' => 'Csc Grade',
			'csc_create' => '发布日期',
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
		$criteria->compare('csc_class',$this->csc_class,true);
		$criteria->compare('csc_contact',$this->csc_contact,true);
		$criteria->compare('csc_exam_id',$this->csc_exam_id);
		$criteria->compare('csc_record',$this->csc_record,true);
		$criteria->compare('csc_grade',$this->csc_grade,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 默认填充数据
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
