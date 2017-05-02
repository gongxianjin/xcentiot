<?php
Yii::import('zii.widgets.CPortlet');
/**
* 会所套餐首页组件
*/
class Club extends CPortlet
{
	/**
	* 渲染组件视图
	*/
	protected function renderContent()
	{
		$club = Category::model()->findAll('csc_parent_id=:cid order by csc_sort ASC' , array(':cid'=>2));
		$this->render('club' , array(
			'club' => $club,
		));
	}
}