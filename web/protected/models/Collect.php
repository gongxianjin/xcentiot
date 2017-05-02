<?php
/**
 * 商品收藏表模型
 */
class Collect extends SubCActiveRecord{

	//两个方法
	public function tableName(){
		return '{{collect}}';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('csc_id, csc_user_id, csc_item_id, csc_create', 'required'),
		array('csc_id, csc_user_id, csc_item_id', 'length', 'max'=>32),
		array('csc_is_push', 'length', 'max'=>10),
		array('csc_is_push', 'safe'),
		);
	}
	
	public function relations(){
		return array(
			'good'=>array(self::HAS_ONE, 'Goods', array('csc_id'=>'csc_item_id')),
		);
	}

}