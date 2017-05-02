<?php
Yii::import('zii.widgets.CPortlet');
class Pageright extends CPortlet{
    public $title = null;
    protected function renderContent(){
        if(Yii::app()->controller->id == 'depart'){
            $cid = Yii::app()->request->getParam('cid');
            if($cid){
                $comtxts = Faq::model()->findAll(
                     'locate(:cid,csc_cate_path) AND csc_cate_id != :cid limit 3',array('cid'=>$cid)
                );
            }
            $cate = Category::model()->find('csc_parent_id=:cid AND locate(:cname,csc_name)',array('cid'=>$cid,'cname'=>'老师'));
            $teacher = Faq::model()->findAll(
                'csc_cate_id=:cid ORDER BY csc_create DESC limit 2',array('cid'=>$cate->csc_id)
            );
        }else{
            $comtxts = Faq::model()->findAll(
                'locate(:cname,csc_name) order by csc_sort DESC limit 3',array('cname'=>'专业')
            );
            $cate = Category::model()->find('locate(:cname,csc_name) order by csc_sort',array('cname'=>'老师'));
            $cid = $cate->csc_parent_id;
            $teacher = Faq::model()->findAll(
                'csc_cate_id=:cid ORDER BY csc_sort DESC limit 4',array('cid'=>$cate->csc_id)
            );
        }
        $this->render('pageright',array(
            'article'=>$comtxts,
            'cid'=>$cid,
            'teacher'=>$teacher,
        ));
    }
}