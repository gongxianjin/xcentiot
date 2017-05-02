<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/11
 * Time: 16:56
 */
class TeacherController extends Controller
{
    //url唯一
	public function beforeAction($action)  
    {
        if (Yii::app()->request->url != CHtml::normalizeUrl(array_merge(array($this->route), $_GET)))  
            $this->redirect(CHtml::normalizeUrl(array_merge(array($this->route), $_GET)), true, 301);  
           return parent::beforeAction($action);  
    }  
	public function actionIndex(){
       // $this->title = '极客师';
	   //seo tdk
		$studys = Category::model()->find('csc_id=:cid',array('cid'=>'2'));
		//echo $studys->csc_seo_description;exit;//测试
		$this->title = $studys->csc_seo_title;
		$this->keywords = $studys->csc_seo_keywords;
		$this->description = $studys->csc_seo_description;
        $model = Goods::model();
        $gd_id = Yii::app()->request->getParam('gd');

        if(in_array($gd_id,array('gd','sj','kw'))){
            $gd_id = '';
        }

        $sj_id = Yii::app()->request->getParam('sj');

        if(in_array($sj_id,array('gd','sj','kw'))){
            $sj_id = '';
        }

        $params = array('kw'=>'','gd'=>'','sj'=>'');

        $critera = new CDbCriteria();

        if(Yii::app()->request->isPostRequest){
            $tname = Yii::app()->request->getParam('tname');
        }else{
            $tname = Yii::app()->request->getParam('kw');
        }
        /*搜索*/
        if($tname){
            $critera->addCondition('locate(:tname,csc_name)');
            $critera->params['tname'] = $tname;
            $params['kw'] = $tname;
        }
        
        if($sj_id){
            $critera->addCondition('locate(:sj,csc_sj)');
            $critera->params['sj'] = $sj_id;
            $params['sj'] = $sj_id;
        }

        if($gd_id){
            $critera->addCondition('locate(:gd,csc_gd)');
            $critera->params['gd'] = $gd_id;
            $params['gd'] = $gd_id;
        }

        /*排序*/
        $critera->order = 'csc_sort ASC';

        /*分页*/
        $count = $model->count($critera);
        $pager = new CPagination($count);
        $pager->pageSize = 10;
        $pager->applyLimit($critera);
        $teacher = $model->findAll($critera);
//	dump($critera);
        /*年级*/
        $gd = Yii::app()->getDb()->createCommand()
            ->select('csc_gd')
            ->order('csc_gd ASC')
            ->from('csc_goods')
            ->group('csc_gd')->queryAll();

        /*学科*/
        $sj = Yii::app()->getDb()->createCommand()
            ->select('csc_sj')
            ->order('csc_sj ASC')
            ->from('csc_goods')
            ->group('csc_sj')->queryAll();

        /*所有分类*/
        $cate = Category::model()->findAll(); 
        $this->render('index',array(
            'pages' => $pager,
            'teacher'=> $teacher,
            'sj'=>$sj,
            'gd'=>$gd,
            'cate'=>$cate,
            'params'=>$params,
        ));

    }

}