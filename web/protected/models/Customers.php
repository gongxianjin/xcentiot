<?php

/**
 * This is the model class for table "{{customers}}".
 *
 * The followings are the available columns in table '{{customers}}':
 * @property integer $csc_id
 * @property string $csc_guest_ip
 * @property string $csc_user_id
 * @property string $csc_tname
 * @property string $csc_phone
 * @property string $csc_identity
 * @property string $csc_lock
 * @property string $csc_create
 */
class Customers extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_guest_ip, csc_tname, csc_phone, csc_identity, csc_create', 'required'),
			array('csc_id', 'numerical', 'integerOnly'=>true),
			array('csc_guest_ip', 'length', 'max'=>32),
			array('csc_tname', 'length', 'max'=>20),
			array('csc_phone', 'length', 'max'=>13),
			array('csc_identity', 'length', 'max'=>100),
			array('csc_lock', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_guest_ip, csc_tname, csc_phone, csc_identity, csc_lock, csc_create', 'safe', 'on'=>'search'),
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
			'csc_guest_ip' => '用户ip',
			'csc_user_id'=>'用户id',
			'csc_tname' => '真实姓名',
			'csc_phone' => '电话',
			'csc_identity' => '身份证',
			'csc_lock' => '审核',
			'csc_create' => '创建时间',
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
		$criteria->compare('csc_guest_ip',$this->csc_guest_ip,true);
		$criteria->compare('csc_tname',$this->csc_tname,true);
		$criteria->compare('csc_phone',$this->csc_phone,true);
		$criteria->compare('csc_identity',$this->csc_identity,true);
		$criteria->compare('csc_lock',$this->csc_lock,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customers the static model class
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
				$this->csc_guest_ip = Yii::app()->request->userHostAddress;
				$this->csc_create = date('Y-m-d H:i:s');
				$this->csc_lock = 0;
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else{
			return false;
		}
	}
}
