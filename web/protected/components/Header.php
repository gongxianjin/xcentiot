<?php
Yii::import('zii.widgets.CPortlet');
class Header extends CPortlet
{
	public $title = null;
	public $theme;

	protected function renderContent()
	{
		# 关于我们二级分类
		$solution_id = Category::model()->find('csc_name=:name' , array(':name'=>'解决方案与产品'))->csc_id;
		$solution = Category::model()->findAll('csc_parent_id=:pid' , array(':pid'=>$solution_id));

		$cid = Yii::app()->request->getParam('cid');

		$this->render($this->theme?$this->theme:'header', array(
			'solution'=>$solution,
			'cid'=>$cid,
		));

	}
}