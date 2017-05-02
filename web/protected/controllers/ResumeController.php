<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/13
 * Time: 11:41
 */
class ResumeController extends  Controller
{

    //url唯一
	public function beforeAction($action)  
    {  
   
        if (Yii::app()->request->url != CHtml::normalizeUrl(array_merge(array($this->route), $_GET)))  
            $this->redirect(CHtml::normalizeUrl(array_merge(array($this->route), $_GET)), true, 301);  
           return parent::beforeAction($action);  
    }  
	public function actionIndex(){
       // $this->title = '极客募';
	   //seo tdk
		$studys = Category::model()->find('csc_id=:cid',array('cid'=>'5'));
		//echo $studys->csc_seo_description;exit;//测试
		$this->title = $studys->csc_seo_title;
		$this->keywords = $studys->csc_seo_keywords;
		$this->description = $studys->csc_seo_description;
        $cid = Yii::app()->request->getParam('cid');
        $rcate = Category::model()->findByPk($cid);
        $socialcate = Category::model()->findByPk('50');
        $schoolcate = Category::model()->findByPk('51');
        $studycate = Category::model()->findByPk('52');
        $this->render('index',array(
            'rcat'=>$rcate,
            'socialcate'=>$socialcate,
            'schoolcate'=>$schoolcate,
            'studycate'=>$studycate,
        ));
    }

    public function actionSocial(){
     //   $this->title = '极客募';
        $cid = Yii::app()->request->getParam('cid');
		//seo tdk
		$studys = Category::model()->findByPk($cid);
		$this->title = $studys->csc_seo_title;
		$this->description = $studys->csc_seo_description;
		$this->keywords = $studys->csc_seo_keywords;
        /*主页banner文字*/
        $rcate = Category::model()->findByPk('5');
        $comtxts = Faq::model()->findAll('csc_cate_id=:cid',array('cid'=>$cid));
        $this->render('social',array(
            'rcat'=>$rcate,
            'articles'=>$comtxts,
        ));
    }

    public function actionSchool(){
      //  $this->title = '极客募';
        $cid = Yii::app()->request->getParam('cid');
		//seo tdk
		$studys = Category::model()->findByPk($cid);
		$this->title = $studys->csc_seo_title;
		$this->description = $studys->csc_seo_description;
		$this->keywords = $studys->csc_seo_keywords;
        /*主页banner文字*/
        $rcate = Category::model()->findByPk('5');
        $comtxts = Faq::model()->findAll('csc_cate_id=:cid',array('cid'=>$cid));
        $this->render('school',array(
            'rcat'=>$rcate,
            'articles'=>$comtxts,
            'cid'=>$cid,
        ));
    }

}