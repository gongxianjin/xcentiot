<?php

/**
 * This is the model class for table "{{adposition}}".
 *
 * The followings are the available columns in table '{{adposition}}':
 * @property string $csc_id
 * @property string $csc_name
 * @property integer $csc_width
 * @property integer $csc_height
 * @property string $csc_desc
 * @property string $csc_create
 */
class Adposition extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{adposition}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_name, csc_width, csc_height', 'required' , 'message'=>'未填写完整，无法提交'),
			array('csc_width, csc_height', 'numerical', 'integerOnly'=>true , 'message'=>'宽度、高度值必须为整数'),
			array('csc_id' , 'unique' , 'message'=>'ID值已存在，请重新输入'),
			array('csc_id', 'length', 'max'=>32 , 'message'=>'超出存储范围'),
			array('csc_name', 'length', 'max'=>50 , 'message'=>'超出存储范围'),
			array('csc_desc', 'length', 'max'=>200 , 'message'=>'超出存储范围'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_width, csc_height, csc_desc, csc_create', 'safe', 'on'=>'search'),
			array('csc_name','checkname','on'=>'add,edit'),
		);
	}
	
	
	public function checkname(){
		if(!$this->hasErrors()){
			$res = $this->find("csc_name=:name",array(':name'=>$this->csc_name));
			if($res){
				$this->addError('csc_name', '广告位名称已存在');
			}
		}
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
			'csc_id' => '主键',
			'csc_name' => '广告位名称',
			'csc_width' => '广告位宽度',
			'csc_height' => '广告位高度',
			'csc_desc' => '广告位描述',
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

		$criteria->compare('csc_id',$this->csc_id,true);
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_width',$this->csc_width);
		$criteria->compare('csc_height',$this->csc_height);
		$criteria->compare('csc_desc',$this->csc_desc,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adposition the static model class
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
