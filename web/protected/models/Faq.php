<?php

/**
 * This is the model class for table "{{faq}}".
 *
 * The followings are the available columns in table '{{faq}}':
 * @property integer $csc_id
 * @property string $csc_name
 * @property string $csc_subtitle
 * @property string $csc_link
 * @property string $csc_cate_id
 * @property string $csc_cate_path
 * @property string $csc_img
 * @property string $csc_img_thumb
 * @property string $csc_img_thumb_min
 * @property string $csc_desc
 * @property string $csc_content
 * @property string $csc_video
 * @property string $csc_seo_title
 * @property string $csc_seo_keywords
 * @property string $csc_seo_description
 * @property integer $csc_sort
 * @property integer $csc_best
 * @property integer $csc_show
 * @property string $csc_create
 * @property string $csc_update
 * @property string $csc_time
 */
class Faq extends SubCActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{faq}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('csc_name, csc_cate_id, csc_cate_path', 'required'),
			array('csc_id, csc_best ,csc_show', 'numerical', 'integerOnly'=>true),
			array('csc_id, csc_sort', 'numerical', 'integerOnly'=>true),
			array('csc_name', 'length', 'max'=>100),
			array('csc_link', 'length', 'max'=>1000),
			array('csc_cate_id', 'length', 'max'=>32),
			array('csc_cate_path, csc_img, csc_img_thumb, csc_img_thumb_min', 'length', 'max'=>200),
			array('csc_video', 'length', 'max'=>500),
			array('csc_desc, csc_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('csc_id, csc_name, csc_link, csc_cate_id, csc_cate_path, csc_img, csc_img_thumb, csc_img_thumb_min, csc_desc, csc_content, csc_video, csc_seo_title, csc_seo_keywords, csc_seo_description, csc_sort, csc_create, csc_update,csc_time', 'safe', 'on'=>'search'),
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
            'pca' => array(self::BELONGS_TO, 'PCA',array('csc_pca_id'=>'csc_id')),
            'cate' => array(self::BELONGS_TO, 'Category', 'csc_cate_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'csc_id' => '主键',
			'csc_name' => '标题',
			'csc_link' => '外部链接',
			'csc_cate_id' => '分类ID',
			'csc_cate_path' => '分类路径',
			'csc_img' => '图片(原图)',
			'csc_img_thumb' => '中等缩略图',
			'csc_img_thumb_min' => '最小缩略图',
			'csc_desc' => '简介描述',
			'csc_content' => '信息内容',
			'csc_video' => '视频播放源 采用视频网站分享的站外播放代码',
			'csc_seo_title' => 'SEO标题',
			'csc_seo_keywords' => 'SEO关键字',
			'csc_seo_description' => 'SEO描述内容',
			'csc_sort' => '排序数字 默认0',
			'csc_create' => '发布日期',
			'csc_update' => '修改日期',
			'csc_time' => '日期',
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
		$criteria->compare('csc_link',$this->csc_link,true);
		$criteria->compare('csc_cate_id',$this->csc_cate_id,true);
		$criteria->compare('csc_cate_path',$this->csc_cate_path,true);
		$criteria->compare('csc_img',$this->csc_img,true);
		$criteria->compare('csc_img_thumb',$this->csc_img_thumb,true);
		$criteria->compare('csc_img_thumb_min',$this->csc_img_thumb_min,true);
		$criteria->compare('csc_desc',$this->csc_desc,true);
		$criteria->compare('csc_content',$this->csc_content,true);
		$criteria->compare('csc_video',$this->csc_video,true);
		$criteria->compare('csc_seo_title',$this->csc_seo_title,true);
		$criteria->compare('csc_seo_keywords',$this->csc_seo_keywords,true);
		$criteria->compare('csc_seo_description',$this->csc_seo_description,true);
		$criteria->compare('csc_sort',$this->csc_sort);
		$criteria->compare('csc_best',$this->csc_best);
		$criteria->compare('csc_show',$this->csc_show);
		$criteria->compare('csc_create',$this->csc_create,true);
		$criteria->compare('csc_update',$this->csc_update,true);
		$criteria->compare('csc_time',$this->csc_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Faq the static model class
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
