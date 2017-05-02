<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/12
 * Time: 12:12
 */
class SchoolController extends Controller
{
    //url唯一
	public function beforeAction($action)  
    {
        if (Yii::app()->request->url != CHtml::normalizeUrl(array_merge(array($this->route), $_GET)))  
            $this->redirect(CHtml::normalizeUrl(array_merge(array($this->route), $_GET)), true, 301);  
           return parent::beforeAction($action);  
    }  
	public function actionIndex(){
       // $this->title = '极客堂';
        /*极客堂分类*/
        $cid = Yii::app()->request->getParam('cid');
        if(!$cid){
            $cid = 3;
        }
        /*分页*/
		//seo tdk
	    $studys = Category::model()->find('csc_id=:cid',array('cid'=>$cid));
		$this->title = $studys->csc_seo_title;
		$this->keywords = $studys->csc_seo_keywords;
		$this->description = $studys->csc_seo_description;
        $model = Category::model();
        $critera = new CDbCriteria();
        $critera->condition = 'csc_parent_id=:cid AND csc_show = 1';
        $critera->order = 'csc_sort';
        $critera->params = array('cid'=>$cid);
        $count = $model->count($critera);
        $pager  = new CPagination($count);
        $pager->pageSize = 4;
        $pager->applyLimit($critera);
        $comtxt = $model->findAll($critera);
        $this->render('index',array(
            'pages'=>$pager,
            'cates'=>$comtxt,
        ));
    }

    public function actionCate(){
      //  $this->title = '极客堂';
        /*校区分类*/
        $cmodel = Category::model();
        $fmodel = Faq::model();
        $cid = Yii::app()->request->getParam('cid');
		//seo tdk 校区
	    $studys = Category::model()->find('csc_id=:cid',array('cid'=>$cid));
		$this->title = $studys->csc_seo_title;
		$this->keywords = $studys->csc_seo_keywords;
		$this->description = $studys->csc_seo_description;
        $cate = $cmodel->find('csc_id=:cid',array('cid'=>$cid));
        $subcates = $cmodel->findAll('csc_parent_id=:pid order by csc_sort',array('pid'=>$cate->csc_id));
        $comtxts = array();
        foreach($subcates as $key=>$item){
            if($key==0){
                $comtxts[$key] = $fmodel->findAll('csc_cate_id=:cid order by csc_sort limit 4',array('cid'=>$item->csc_id));
            }else{
                $comtxts[$key] = $fmodel->findAll('csc_cate_id=:cid order by csc_sort',array('cid'=>$item->csc_id));
            }
            if($key>3)continue;
        } 
        $this->render('cate',array(
            'cate'=>$cate,
            'article'=>$comtxts,
        ));
    }

    public function actionDetail(){
        $id = Yii::app()->request->getParam('id');
        if(!$id) exit;
        $comtxt = Faq::model()->findByPk($id);
        $this->title = $comtxt->csc_seo_title;
		$this->keywords =$comtxt->csc_seo_keywords;
        $this->description = $comtxt->csc_seo_description;
        $this->render('detail',array(
            'article'=>$comtxt,
        ));
    }

}