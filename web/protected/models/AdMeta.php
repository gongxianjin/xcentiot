<?php

/**
 * This is the model class for table "{{ad_meta}}".
 *
 * The followings are the available columns in table '{{ad_meta}}':
 * @property string $csc_id
 * @property string $csc_name
 * @property string $csc_type
 * @property string $csc_pos_id
 * @property string $csc_begin_time
 * @property string $csc_end_time
 * @property string $csc_url
 * @property string $csc_show
 * @property integer $csc_sort
 * @property string $csc_img
 * @property string $csc_img_url
 * @property string $csc_flash
 * @property string $csc_flash_url
 * @property string $csc_code
 * @property string $csc_text
 * @property string $csc_contactor
 * @property string $csc_email
 * @property string $csc_phone
 * @property string $csc_create
 */
class AdMeta extends SubCActiveRecord
{
	public $pos_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{ad_meta}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_name, csc_type, csc_pos_id, csc_begin_time, csc_url, csc_show', 'required'),
			array('csc_sort', 'numerical', 'integerOnly'=>true),
			array('csc_id', 'length', 'max'=>32),
			array('csc_name', 'length', 'max'=>100),
			array('csc_type, csc_show', 'length', 'max'=>1),
			array('csc_url, csc_img, csc_flash, csc_email', 'length', 'max'=>200),
			array('csc_img_url, csc_flash_url', 'length', 'max'=>1024),
			array('csc_code, csc_text', 'length', 'max'=>500),
			array('csc_contactor', 'length', 'max'=>20),
			array('csc_phone', 'length', 'max'=>13),
			//array('csc_end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_type, csc_pos_id, csc_begin_time, csc_end_time, csc_url, csc_show, csc_sort, csc_img, csc_img_url, csc_flash, csc_flash_url, csc_code, csc_text, csc_contactor, csc_email, csc_phone, csc_create', 'safe', 'on'=>'search'),
			array('csc_begin_time', 'checktime', 'on'=>'add,edit'),
		);
	}
	
	//验证时间
	public function checktime(){
		if(!$this->hasErrors()){
			if($this->csc_end_time && $this->csc_end_time<=$this->csc_begin_time){
				$this->addError('csc_end_time', '投放时间有误');
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
			'pos'=>array(self::HAS_ONE, 'Adposition', array('csc_id'=>'csc_pos_id')),
			/*站点*/
			'pca'=>array(self::HAS_ONE, 'PCA', array('csc_id'=>'csc_site_id')),
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
			'csc_type' => 'Csc Type',
			'csc_pos_id' => 'Csc Pos',
			'csc_begin_time' => 'Csc Begin Time',
			'csc_end_time' => 'Csc End Time',
			'csc_url' => 'Csc Url',
			'csc_show' => 'Csc Show',
			'csc_sort' => 'Csc Sort',
			'csc_img' => 'Csc Img',
			'csc_img_url' => 'Csc Img Url',
			'csc_flash' => 'Csc Flash',
			'csc_flash_url' => 'Csc Flash Url',
			'csc_code' => 'Csc Code',
			'csc_text' => 'Csc Text',
			'csc_contactor' => 'Csc Contactor',
			'csc_email' => 'Csc Email',
			'csc_phone' => 'Csc Phone',
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
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_type',$this->csc_type,true);
		$criteria->compare('csc_pos_id',$this->csc_pos_id,true);
		$criteria->compare('csc_begin_time',$this->csc_begin_time,true);
		$criteria->compare('csc_end_time',$this->csc_end_time,true);
		$criteria->compare('csc_url',$this->csc_url,true);
		$criteria->compare('csc_show',$this->csc_show,true);
		$criteria->compare('csc_sort',$this->csc_sort);
		$criteria->compare('csc_img',$this->csc_img,true);
		$criteria->compare('csc_img_url',$this->csc_img_url,true);
		$criteria->compare('csc_flash',$this->csc_flash,true);
		$criteria->compare('csc_flash_url',$this->csc_flash_url,true);
		$criteria->compare('csc_code',$this->csc_code,true);
		$criteria->compare('csc_text',$this->csc_text,true);
		$criteria->compare('csc_contactor',$this->csc_contactor,true);
		$criteria->compare('csc_email',$this->csc_email,true);
		$criteria->compare('csc_phone',$this->csc_phone,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdMeta the static model class
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
