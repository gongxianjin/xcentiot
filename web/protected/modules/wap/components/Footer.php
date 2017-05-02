<?php
Yii::import('zii.widgets.CPortlet');
class Footer extends CPortlet{

	public $title = null;

	protected function renderContent(){

		$this->render('footer', array(
		));
	}
}