<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $csc_id
 * @property string $csc_name
 * @property string $csc_logo
 * @property string $csc_pinyin
 * @property string $csc_link
 * @property string $csc_show
 * @property integer $csc_recom
 * @property string $csc_parent_id
 * @property string $csc_cate_path
 * @property integer $csc_special_id
 * @property integer $csc_sort
 * @property string $csc_seo_title
 * @property string $csc_seo_keywords
 * @property string $csc_seo_description
 * @property string $csc_create
 */
class Category extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_id, csc_name, csc_parent_id, csc_cate_path', 'required'),
			array('csc_id, csc_recom, csc_special_id, csc_sort', 'numerical', 'integerOnly'=>true),
			array('csc_name', 'length', 'max'=>50),
			array('csc_logo, csc_link, csc_cate_path, csc_seo_title', 'length', 'max'=>200),
			array('csc_pinyin', 'length', 'max'=>150),
			array('csc_show', 'length', 'max'=>1),
			array('csc_parent_id', 'length', 'max'=>32),
			array('csc_seo_keywords, csc_seo_description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_logo, csc_pinyin, csc_link, csc_show, csc_recom, csc_parent_id, csc_cate_path, csc_special_id, csc_sort, csc_seo_title, csc_seo_keywords, csc_seo_description, csc_create', 'safe', 'on'=>'search'),
			array('csc_name','checkname','on'=>'add'),
			array('csc_parent_id','chkParentID','on'=>'edit'),
		);
	}
	/**
	 * 检测重名
	 */
	public function checkname(){
		if(!$this->hasErrors()){
			switch ($this->getScenario()){
				case 'add':
					$res = $this->findByAttributes(array('csc_name'=>$this->csc_name, 'csc_parent_id'=>$this->csc_parent_id));
					break;
				case 'edit':
					$cond = new CDbCriteria();
					$cond->addCondition('csc_id!=:id and csc_name=:name and csc_parent_id=:pid');
					$cond->params['id'] = $this->csc_id;
					$cond->params['name'] = $this->csc_name;
					$cond->params['pid'] = $this->csc_parent_id;
					$res = $this->find($cond);
					break;
				default: $res = false;break;
			}

			if($res){
				$this->addError('csc_name', '分类名称已存在');
			}
		}
	}
	/**
	 * 检测父类ID
	 */
	public function chkParentID(){
		if(!$this->hasErrors()){
			$cond = new CDbCriteria();
			$cond->addCondition('csc_id=\''.$this->csc_parent_id.'\'');
			$cond->addCondition('locate(\''.$this->csc_id.'\', csc_cate_path)');

			$res = $this->find($cond);
			if($res){
				$this->addError('csc_parent_id', '选择分类为当前分类子节点');
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
			'parent'=>array(self::HAS_ONE, 'Category', array('csc_id'=>'csc_parent_id')),
			'son' => array(self::HAS_MANY, 'Category', array('csc_parent_id'=>'csc_id')),
            'special' => array(self::BELONGS_TO, 'Special',array('csc_special_id'=>'csc_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => '主键',
			'csc_name' => '名称',
			'csc_logo' => '分类logo',
			'csc_pinyin' => '英文描述',
			'csc_link' => '绑定链接',
			'csc_show' => '是否显示 默认为1 0 不显示 1显示',
			'csc_recom' => '是否推荐 默认0',
			'csc_parent_id' => '父级分类ID 顶级分类为 0',
			'csc_cate_path' => '分类路径',
			'csc_special_id' => '专题页面编号',
			'csc_sort' => '排序数字 默认为1',
			'csc_seo_title' => 'SEO标题',
			'csc_seo_keywords' => 'SEO关键字',
			'csc_seo_description' => 'SEO描述内容',
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
		$criteria->compare('csc_name',$this->csc_name,true);
		$criteria->compare('csc_logo',$this->csc_logo,true);
		$criteria->compare('csc_pinyin',$this->csc_pinyin,true);
		$criteria->compare('csc_link',$this->csc_link,true);
		$criteria->compare('csc_show',$this->csc_show,true);
		$criteria->compare('csc_recom',$this->csc_recom);
		$criteria->compare('csc_parent_id',$this->csc_parent_id,true);
		$criteria->compare('csc_cate_path',$this->csc_cate_path,true);
		$criteria->compare('csc_special_id',$this->csc_special_id);
		$criteria->compare('csc_sort',$this->csc_sort);
		$criteria->compare('csc_seo_title',$this->csc_seo_title,true);
		$criteria->compare('csc_seo_keywords',$this->csc_seo_keywords,true);
		$criteria->compare('csc_seo_description',$this->csc_seo_description,true);
		$criteria->compare('csc_create',$this->csc_create,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Category the static model class
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
				//$this->csc_id = getPrimaryKey($this);
				if($this->csc_sort<=1){
					// 统计当前节点排序数字最大值
					$cond = new CDbCriteria();
					$cond->select = 'max(csc_sort) as csc_sort';
					$cond->addCondition('csc_parent_id=:pid');
					$cond->params[':pid'] = $this->csc_parent_id ? $this->csc_parent_id : 0;
					$max = self::model()->find($cond);
					$this->csc_sort = ++$max->csc_sort;
				}
				return $this->insert($attributes);
			}else{
				return $this->update($attributes);
			}
		}else
			return false;
	}
}
