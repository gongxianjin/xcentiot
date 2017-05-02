<?php
Yii::import('zii.widgets.CPortlet');
/**
* 相关文章组件
*/
class Relative extends CPortlet
{
	/**
	* 渲染视图
	*/
	protected function renderContent()
	{
		$cid = Category::model()->find('csc_name=:name' , array(':name'=>'相关文章'))->csc_id;
		$models = Faq::model()->findAll('csc_cate_id=:cid' , array(':cid'=>$cid));
		$this->render('relative', array(
			'models' => $models,
		));
	}
}