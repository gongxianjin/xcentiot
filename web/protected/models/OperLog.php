<?php

/**
 * This is the model class for table "{{oper_log}}".
 *
 * The followings are the available columns in table '{{oper_log}}':
 * @property string $csc_id
 * @property string $csc_user_id
 * @property string $csc_username
 * @property string $csc_log
 * @property string $csc_guest_ip
 * @property string $csc_create
 */
class OperLog extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{oper_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_user_id, csc_username, csc_log, csc_guest_ip', 'required'),
			array('csc_id, csc_user_id', 'length', 'max'=>32),
			array('csc_username', 'length', 'max'=>50),
			array('csc_log', 'length', 'max'=>200),
			array('csc_guest_ip', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_user_id, csc_username, csc_log, csc_guest_ip, csc_create', 'safe', 'on'=>'search'),
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
			'csc_user_id' => 'Csc User',
			'csc_username' => 'Csc Username',
			'csc_log' => 'Csc Log',
			'csc_guest_ip' => 'Csc Guest Ip',
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

		$criteria->compare('csc_id',$this->csc_id,true);
		$criteria->compare('csc_user_id',$this->csc_user_id,true);
		$criteria->compare('csc_username',$this->csc_username,true);
		$criteria->compare('csc_log',$this->csc_log,true);
		$criteria->compare('csc_guest_ip',$this->csc_guest_ip,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OperLog the static model class
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
