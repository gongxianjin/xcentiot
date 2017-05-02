<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/20
 * Time: 11:50
 */
class StudyController extends Controller
{
    //url唯一
//	public function beforeAction($action)
//    {
//
//        if (Yii::app()->request->url != CHtml::normalizeUrl(array_merge(array($this->route), $_GET)))
//            $this->redirect(CHtml::normalizeUrl(array_merge(array($this->route), $_GET)), true, 301);
//           return parent::beforeAction($action);
//    }
	public function actionIndex(){
       // $this->title = '极客学';
		//添加SEO tkd
		$studys = Category::model()->find('csc_id=:cid',array('cid'=>'1'));
		//echo $studys->csc_seo_description;exit;//测试
		$this->title = $studys->csc_seo_title;
		$this->keywords = $studys->csc_seo_keywords;
		$this->description = $studys->csc_seo_description;
        #极客学.企业介绍
        $study = Faq::model()->find('csc_cate_id=:cid  AND csc_best=1',array('cid'=>'1'));
        #极客学.极客产品
        $comtxts = Faq::model()->findAll('csc_cate_id=:cid  AND csc_best=0',array('cid'=>'1'));
        $this->render('index',array(
            'study'=>$study,
            'articles'=>$comtxts,
        ));
    }

}