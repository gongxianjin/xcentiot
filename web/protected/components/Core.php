<?php
Yii::import('zii.widgets.CPortlet');
/**
* 核心问题首页组件
*/
class Core extends CPortlet
{
	/**
	* 渲染组件视图
	*/
	protected function renderContent()
	{
		$core = Category::model()->findAll('csc_parent_id=:id order by csc_sort ASC' , array(':id'=>10));
		foreach($core as $k=>$v){
			$models[$k] = Faq::model()->findAll('csc_cate_id=:id ORDER BY csc_sort ASC,csc_create DESC LIMIT 6' , array('id'=>$v['csc_id']));
		}
		$this->render('core' , array(
			'core' => $core,
			'models' => $models,
		));
	}
}