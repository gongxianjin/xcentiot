<?php

/**
 * This is the model class for table "{{exam_info}}".
 *
 * The followings are the available columns in table '{{exam_info}}':
 * @property integer $csc_id
 * @property integer $csc_exam_id
 * @property string $csc_name
 * @property string $csc_content
 * @property string $csc_answer
 * @property integer $csc_sort
 * @property string $csc_create
 */
class ExamInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{exam_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_exam_id, csc_name, csc_content, csc_answer', 'required'),
			array('csc_id, csc_exam_id, csc_sort', 'numerical', 'integerOnly'=>true),
//			array('csc_name', 'length', 'max'=>200),
			array('csc_answer', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_exam_id, csc_name, csc_content, csc_answer, csc_sort, csc_create', 'safe', 'on'=>'search'),
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
			'csc_exam_id' => 'Csc Exam',
			'csc_name' => 'Csc Name',
			'csc_content' => 'Csc Content',
			'csc_answer' => 'Csc Answer',
			'csc_sort' => 'Csc Sort',
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

		$criteria->compare('csc_id',$this->csc_id);
		$criteria->compare('csc_exam_id',$this->csc_exam_id);
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_content',$this->csc_content,true);
		$criteria->compare('csc_answer',$this->csc_answer,true);
		$criteria->compare('csc_sort',$this->csc_sort);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ExamInfo the static model class
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
				$this->csc_create = date('Y-m-d H:i:s');
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else
			return false;
	}
}
