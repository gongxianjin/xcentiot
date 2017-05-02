<?php

/**
 * This is the model class for table "{{goods_info}}".
 *
 * The followings are the available columns in table '{{goods_info}}':
 * @property integer $csc_id
 * @property integer $csc_goods_id
 * @property string $csc_name
 * @property string $csc_name_en
 * @property string $csc_content
 * @property integer $csc_sort
 * @property string $csc_create
 * @property string $csc_update
 */
class GoodsInfo extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_goods_id, csc_name, csc_content, csc_sort', 'required' , 'message'=>'未填写完整，无法提交'),
			array('csc_id, csc_goods_id, csc_sort', 'numerical', 'integerOnly'=>true , 'message'=>'数量必须为整数'),
			array('csc_name, csc_name_en', 'length', 'max'=>50 , 'message'=>'超出存储范围'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_goods_id, csc_name, csc_name_en, csc_content, csc_sort, csc_create, csc_update', 'safe', 'on'=>'search'),
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
			'info'=>array(self::BELONGS_TO , 'Goods' , array('csc_goods_id'=>'csc_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => '主键ID',
			'csc_goods_id' => '案例编号',
			'csc_name' => '扩展信息名称',
			'csc_name_en' => '扩展信息英文名',
			'csc_content' => '内容',
			'csc_sort' => '排序数字',
			'csc_create' => '发布日期',
			'csc_update' => '更新日期',
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
		$criteria->compare('csc_goods_id',$this->csc_goods_id);
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_name_en',$this->csc_name_en,true);
		$criteria->compare('csc_content',$this->csc_content,true);
		$criteria->compare('csc_sort',$this->csc_sort);
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
	 * @return GoodsInfo the static model class
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
				$this->csc_id = getPrimaryKey($this);
				$this->csc_update = $this->csc_create;
				return $this->insert($attributes);
			}else{
				$this->csc_update = date('Y-m-d H:i:s');
				return $this->update($attributes);
			}
		}else
			return false;
	}
}
