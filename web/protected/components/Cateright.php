<?php
Yii::import('zii.widgets.CPortlet');
class Cateright extends CPortlet{
    public $title = null;
    public $id;//分类id

    protected function renderContent(){
        $cid = Yii::app()->request->getParam('cid');
        # 教学系部二级分类
        $depart_id = Category::model()->find('csc_name=:name' , array(':name'=>'教学系部'))->csc_id;
        $depart = Category::model()->findAll('csc_parent_id=:pid' , array(':pid'=>$depart_id));
        $this->render('cateright',array(
            'cid'=>$cid,
            'depart'=>$depart,
        ));
    }
}