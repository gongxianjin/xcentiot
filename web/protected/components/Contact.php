<?php
Yii::import('zii.widgets.CPortlet');
/**
* 联系方式组件
*/
class Contact extends CPortlet
{
	/**
	* 渲染视图
	*/
	protected function renderContent()
	{
		$tel = Yii::app()->params['site']['tel'];
		$phone = Yii::app()->params['site']['phone'];
		$qq = Yii::app()->params['site']['qq'];
		$this->render('contact' , array(
			'tel' => $tel,
			'phone' => $phone,
			'qq' => $qq,
		));
	}
}