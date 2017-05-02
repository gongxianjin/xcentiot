<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/13
 * Time: 14:36
 */
class ContractController extends Controller
{
    public function actionIndex(){
        #联系我们
        $product = Category::model()->find('csc_name='."'联系我们'");
        $this->title = $product->csc_seo_title;
        $this->keywords = $product->csc_seo_keywords;
        $this->description = $product->csc_seo_description;
        $theme = 'index';
        $this->render($theme,array(
        ));
    }


    public function actionSubmit(){

        if (Yii::app()->request->isPostRequest){
            //获取数据
            $username = trim(Yii::app()->request->getParam('username'));
            $phone = trim(Yii::app()->request->getParam('phone'));
            $subject = trim(Yii::app()->request->getParam('subject'));
            $message = trim(Yii::app()->request->getParam('message'));
            if(!$username) $this->jsonMsg(45,'请填写姓名');
            if(!preg_match('/^[\x{4E00}-\x{9FA5}]+$/u',$username)) $this->jsonMsg(21,'请输入正确姓名');
            $strReplaceArr = array('～','！','@','#','（','）','——','+','【','】','『','』','；','：','‘','“','’','”','、','《','》','？','。','，');
            foreach($strReplaceArr as $val){
                $rs = strstr($username,$val);
                $nrs = strstr($username,$val);
                if($rs)  $this->jsonMsg(22,'姓名须输入中文');
                if($nrs) $this->jsonMsg(22,'请填入正确的姓名');
            }
            if(!$phone) $this->jsonMsg(46,'请填写手机号');
            if(!preg_match("/^1[34578]\d{9}$/", $phone)){
                $this->jsonMsg(23,'请填入正确的手机号');
            }
            //判断游客生成游客
            $_user = Member::model()->find('csc_phone=:phone',array(':phone'=>$phone));
            if(empty($_user)){
                $transaction= Yii::app()->db->beginTransaction();
                $user = new Member();
                $user->csc_id = getPrimaryKey($user);
                $user->csc_username = $username;
                $user->csc_phone = $phone;
                $user->csc_pwd = md5('123456');
                $user->csc_type = 2;
                $user->save();
                $transaction->commit();
                $uid = $user->csc_id;
            }else{
                $uid = $_user->csc_id;
            }
            if(!$subject) $this->jsonMsg(47,'请填写主题');
            if(!$message) $this->jsonMsg(48,'请填写留言内容');
            //生成留言
            $model = new Feedback('add');
            $model->csc_id = getPrimaryKey($model);
            $model->csc_user_id = $uid;
            $model->csc_subject = $subject;
            $model->csc_content = $message;
            //开启事务
            $transaction = Yii::app()->db->beginTransaction();
            //写入数据
            if(!$model->save()){
                $error = implode('', current($model->getErrors()));
                $this->jsonMsg(502, '添加失败'.$error, '', $transaction);
            }
            //提交事务
            $transaction->commit();
            $this->jsonMsg(200, '留言成功', '', $this->createUrl('contract/index'));
        }
    }

}