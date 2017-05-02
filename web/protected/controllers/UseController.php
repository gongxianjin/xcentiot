<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/13
 * Time: 10:03
 */
class UseController extends Controller
{
    //url唯一
	public function beforeAction($action)  
    {  
   
        if (Yii::app()->request->url != CHtml::normalizeUrl(array_merge(array($this->route), $_GET)))  
            $this->redirect(CHtml::normalizeUrl(array_merge(array($this->route), $_GET)), true, 301);  
           return parent::beforeAction($action);  
    }  
	public function  actionIndex(){
        // $this->title = '极客致';
	   //seo tdk
		 $studys = Category::model()->find('csc_id=:cid',array('cid'=>'4'));
		//echo $studys->csc_seo_description;exit;//测试
		$this->title = $studys->csc_seo_title;
		$this->keywords = $studys->csc_seo_keywords;
		$this->description = $studys->csc_seo_description;
         $cid = Yii::app()->request->getParam('cid');
         if(!$cid){
             $cid = 4;
         }

         $usetext = Faq::model()->findAll('csc_cate_id=:cid',array('cid'=>$cid));

         $policytext = Faq::model()->findAll('csc_cate_id=:cid  order by csc_create,csc_sort DESC limit 4',array('cid'=>'40'));

         $strategytext = Faq::model()->findAll('csc_cate_id=:cid  order by csc_create,csc_sort DESC limit 4',array('cid'=>'41'));

         $experiencetext = Faq::model()->findAll('csc_cate_id=:cid  order by csc_create,csc_sort DESC limit 4',array('cid'=>'42'));

         $this->render('index', array(
            'usetext'=>$usetext,
             'gtext'=>$policytext,
             'stext'=>$strategytext,
             'etext'=>$experiencetext,
         ));
    }

    public function actionMore(){

        $cid = Yii::app()->request->getParam('cid');
        $cate = Category::model()->findByPk($cid);
        /*分页*/
        $critera = new CDbCriteria();
        $critera->addCondition('csc_cate_id=:cid');
        $critera->params = array('cid'=>$cid);
        $critera->order = 'csc_create DESC';
        $count = Faq::model()->count($critera);
        $pager = new CPagination($count);
        $pager->pageSize = 10;
        $pager->applyLimit($critera);
        $comtxt = Faq::model()->findAll($critera);
        $this->render('more',array(
            'cate'=>$cate,
            'articles'=>$comtxt,
            'pages'=>$pager,
        ));
    }

    public function actionDetail(){
        $id = Yii::app()->request->getParam('id');
        $comtxt = Faq::model()->findByPk($id);

        //限制上下页
        $nextarticle = Faq::model()->find(array(
            'condition'=>'csc_id>:csc_id',
            'params'=>array(
                ':csc_id'=>$id),
            'order'=>'csc_id ASC',
        ));
        if($nextarticle->csc_cate_id != 40&&$nextarticle->csc_cate_id != 41&&$nextarticle->csc_cate_id != 42){
            $nextarticle = '';
        }
        $prevarticle = Faq::model()->find(array(
            'condition'=>'csc_id<:csc_id',
            'params'=>array(
                ':csc_id'=>$id),
            'order'=>'csc_id DESC',
        ));

        if($prevarticle->csc_cate_id != 40&&$prevarticle->csc_cate_id != 41&&$prevarticle->csc_cate_id != 42){
            $prevarticle = '';
        }

        $this->render('detail',array(
            'article'=>$comtxt,
            'prev' => $prevarticle,
            'next' => $nextarticle,
        ));
    }

}