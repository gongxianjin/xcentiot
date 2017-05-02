<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/13
 * Time: 14:36
 */
class AboutController extends Controller
{
   //url唯一性
//    public function beforeAction($action)
//    {
//
//        if (Yii::app()->request->url != CHtml::normalizeUrl(array_merge(array($this->route), $_GET)))
//            $this->redirect(CHtml::normalizeUrl(array_merge(array($this->route), $_GET)), true, 301);
//           return parent::beforeAction($action);
//    }
    public function actionIndex(){

        #关于我们
        $product = Category::model()->find('csc_name='."'关于我们'");
        $this->title = $product->csc_seo_title;
        $this->keywords = $product->csc_seo_keywords;
        $this->description = $product->csc_seo_description;
        $theme = 'index';
        $this->render($theme,array());

    }


}