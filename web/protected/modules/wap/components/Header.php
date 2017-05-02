<?php
Yii::import('zii.widgets.CPortlet');
class Header extends CPortlet{
	
	public $title = null;
	public $theme;
	
	protected function renderContent(){
		$cmodel = Category::model();
		//显示的栏目
		$nav = $cmodel->findAll('csc_parent_id = \'0\' order by csc_sort');
		//子栏目
		$nav_data =  array();
		foreach($nav as $v){
			$nav_data[$v->csc_id] = $cmodel->findAll('csc_parent_id = \''.$v->csc_id.'\' order by csc_sort');
		}
		$id = Yii::app()->session['user_id'];
		$user = Member::model()->findByPk($id);

		$this->render('header', array(
			'nav'=>$nav,
			'nav_data'=>$nav_data,
			'user'=>$user,
		));
	}
}