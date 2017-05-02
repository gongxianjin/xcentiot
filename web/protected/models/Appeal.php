<?php

/**
 * This is the model class for table "{{appeal}}".
 *
 * The followings are the available columns in table '{{appeal}}':
 * @property integer $csc_id
 * @property integer $csc_user_id
 * @property integer $csc_guest_ip
 * @property string $csc_name
 * @property string $csc_content
 * @property string $csc_create
 * @property string $csc_appeal_table
 * @property string $csc_appeal_link
 * @property string $csc_lock
 */
class Appeal extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{appeal}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_user_id, csc_name, csc_content, csc_create', 'required'),
			array('csc_id, csc_user_id', 'numerical', 'integerOnly'=>true),
			array('csc_name', 'length', 'max'=>100),
			array('csc_lock', 'length', 'max'=>1),
			array('csc_appeal_table, csc_appeal_link', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_user_id, csc_name, csc_content, csc_create, csc_appeal_table, csc_appeal_link, csc_lock', 'safe', 'on'=>'search'),
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
			'user'=>array(self::HAS_ONE , 'User' , array('csc_id'=>'csc_user_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => '主键',
			'csc_user_id' => '用户id',
			'csc_name' => '项目名',
			'csc_content' => '项目内容',
			'csc_create' => '创建时间',
			'csc_appeal_table' => '申请表',
			'csc_appeal_link' => '申请表链接',
			'csc_lock' => '审核',
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
		$criteria->compare('csc_user_id',$this->csc_user_id);
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_content',$this->csc_content,true);
		$criteria->compare('csc_create',$this->csc_create,true);
		$criteria->compare('csc_appeal_table',$this->csc_appeal_table,true);
		$criteria->compare('csc_appeal_link',$this->csc_appeal_link,true);
		$criteria->compare('csc_lock',$this->csc_lock,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Appeal the static model class
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
				$this->csc_user_id = Yii::app()->session['user_id'];
				$this->csc_guest_ip = Yii::app()->request->userHostAddress;
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else{
			return false;
		}
	}
}
