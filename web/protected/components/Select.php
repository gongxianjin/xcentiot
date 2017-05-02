<?php
Yii::import('zii.widgets.CPortlet');
/**
* 相关文章组件
*/
class Select extends CPortlet
{
	public $cate_name; #分类名称
	/**
	* 渲染视图
	*/
	protected function renderContent()
	{
		$cid = Category::model()->find('csc_name=:name' , array(':name'=>$this->cate_name))->csc_id;
        $father = Category::model()->findAll('csc_parent_id=:cid' , array(':cid'=>$cid));
        foreach($father as $k=>$v){
            $son[] = Category::model()->findAll('csc_parent_id=:cid' , array(':cid'=>$v->csc_id));
        }
		$this->render('select', array(
			'father' => $father,
            'son' => $son,
            'cate_name' => $this->cate_name,
		));
	}
}