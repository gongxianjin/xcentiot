<?php

/**
 * This is the model class for table "{{goods}}".
 *
 * The followings are the available columns in table '{{goods}}':
 * @property integer $csc_id
 * @property string $csc_name
 * @property string $csc_desc
 * @property string $csc_img
 * @property string $csc_img_thumb
 * @property string $csc_img_thumb_min
 * @property double $csc_price
 * @property integer $csc_cate_id
 * @property integer $csc_sysuser_id
 * @property integer $csc_sort
 * @property integer $csc_recom_point
 * @property integer $csc_sale_num
 * @property integer $csc_gd
 * @property integer $csc_sj
 * @property integer $csc_school
 * @property integer $csc_term
 * @property string  $csc_note
 * @property string $csc_create
 * @property string $csc_update_date
 */
class Goods extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_name, csc_img,csc_gd,csc_sj', 'required' , 'message'=>'未填写完整，无法提交'),
//			array('csc_name' , 'unique' , 'message'=>'教师名称重复'),
			array('csc_id, csc_sysuser_id, csc_sort, csc_recom_point, csc_sale_num', 'numerical', 'integerOnly'=>true , 'message'=>'数量必须为整数'),
			array('csc_price', 'numerical' , 'message'=>'价格必须为数值'),
			array('csc_name', 'length', 'max'=>100 , 'message'=>'超出存储范围'),
			array('csc_img, csc_img_thumb, csc_img_thumb_min, csc_note', 'length', 'max'=>200 , 'message'=>'超出存储范围'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_desc, csc_img, csc_img_thumb, csc_img_thumb_min, csc_price,csc_cate_id, csc_sysuser_id, csc_sort, csc_recom_point, csc_sale_num, csc_note, csc_create, csc_update_date', 'safe', 'on'=>'search'),
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
			'user'=>array(self::HAS_ONE, 'Sysuser', array('csc_id'=>'csc_sysuser_id')),
			'cate_gd'=>array(self::HAS_ONE, 'Category', array('csc_id'=>'csc_gd')),
			'cate_sj'=>array(self::HAS_ONE, 'Category', array('csc_id'=>'csc_sj')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => '商品ID 主键',
			'csc_name' => '名称',
			'csc_desc' => '简介描述',
			'csc_img' => '图片(原图)',
			'csc_img_thumb' => '中等缩略图',
			'csc_img_thumb_min' => '最小缩略图',
			'csc_price' => '价格',
			'csc_cate_id' => '分类ID',
			'csc_sysuser_id' => '管理员编号',
			'csc_sort' => '排序数字',
			'csc_recom_point' => '推荐指数 最大5',
			'csc_sale_num' => '已售数量',
			'csc_gd' => '年级',
			'csc_sj' => '科目',
			'csc_school' => '校区',
			'csc_term' => '学期',
			'csc_note' => '备注',
			'csc_create' => '发布日期',
			'csc_update_date' => '商品修改时间',
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
		$criteria->compare('csc_desc',$this->csc_desc,true);
		$criteria->compare('csc_img',$this->csc_img,true);
		$criteria->compare('csc_img_thumb',$this->csc_img_thumb,true);
		$criteria->compare('csc_img_thumb_min',$this->csc_img_thumb_min,true);
		$criteria->compare('csc_price',$this->csc_price);
		$criteria->compare('csc_cate_id',$this->csc_cate_id,true);
		$criteria->compare('csc_sysuser_id',$this->csc_sysuser_id);
		$criteria->compare('csc_sort',$this->csc_sort);
		$criteria->compare('csc_recom_point',$this->csc_recom_point);
		$criteria->compare('csc_sale_num',$this->csc_sale_num);
		$criteria->compare('csc_gd',$this->csc_gd,true);
		$criteria->compare('csc_sj',$this->csc_sj,true);
		$criteria->compare('csc_school',$this->csc_school,true);
		$criteria->compare('csc_term',$this->csc_term,true);
		$criteria->compare('csc_note',$this->csc_note,true);
		$criteria->compare('csc_create',$this->csc_create,true);
		$criteria->compare('csc_update_date',$this->csc_update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goods the static model class
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
				$this->csc_sysuser_id = Yii::app()->session['sysuser_user'];
				$this->csc_update_date = $this->csc_create;
				return $this->insert($attributes);
			}else{
				$this->csc_update_date = date('Y-m-d H:i:s');
				return $this->update($attributes);
			}
		}else
			return false;
	}
}

