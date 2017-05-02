<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/14
 * Time: 14:23
 */
class TestController extends Controller
{
    public function actionIndex(){
        /*选择的测试科目*/
        $sid = Yii::app()->request->getParam('sid');
        /*所有测试科目*/
        $allexam = Exam::model()->findAll();
        if(!$sid){
            $sid = $allexam[0]->csc_id;
        }
        $examinfo = ExamInfo::model()->findAll('csc_exam_id=:sid order by csc_sort',array('sid'=>$sid));
        $this->render('index',array(
            'sid'=>$sid,
            'subject'=>$allexam,
            'examinfo'=>$examinfo,
        ));
    }
    public function actionAjaxdo(){
        if(Yii::app()->request->isPostRequest){
            $name = Yii::app()->request->getParam('name');
            $class = Yii::app()->request->getParam('class');
            $contact = Yii::app()->request->getParam('contact');

//            if(empty($name)){
//                $this->jsonMsg(10,'请填写姓名');
//            }
//            if(empty($class)){
//                $this->jsonMsg(11,'请填写年级');
//            }
//            if(empty($contact)){
//                $this->jsonMsg(12,'请填写联系方式');
//            }
//            if(!preg_match("/^1([0-9]{9})/",$contact)){
//                $this->jsonMsg(13,'请填写正确的联系方式');
//            }
            $exam_id = Yii::app()->request->getParam('csc_exam_id');
            $examinfoid = Yii::app()->request->getParam('examinfoid');
            $key = Yii::app()->request->getParam('key');
            $answer = Yii::app()->request->getParam('answer');

            /*记录正确数*/
            $count = 0;
            $record = '';
            foreach($examinfoid as $k=>$item){
                if(strpos($key[$k],$answer[$k]) || strpos($key[$k],strtolower($answer[$k]))){
                    $count++;
                }
                $record .= $item.'-'.$key[$k].'-'.$answer[$k].'|';
            }
            dump($count);exit;
            $transaction= Yii::app()->db->beginTransaction();
            $examlog = new ExamLog();
            $examlog->csc_id = getPrimaryKey($examlog);
            $examlog->csc_name = $name;
            $examlog->csc_class = $class;
            $examlog->csc_contact = $contact;
            $examlog->csc_exam_id = $exam_id;
            $examlog->csc_record = $record;
            $examlog->csc_grade = $count;
            if(!$examlog->save()){
                $error = implode('', current($examlog->getErrors()));
                $this->jsonMsg(502, '添加失败'.$error, '', '', $transaction);
            }
            $transaction->commit();
            // send mail
            $mail_body = $name.'&nbsp;&nbsp;'.$contact.'&nbsp;&nbsp;'.$class;
            $mail_body = '<p>在线测试</p><p>'.$mail_body.'</p>';
            Mailer::sendmail(array('617699485@qq.com'=>'QQ邮箱地址'), '邮箱通知', $mail_body);
            $this->jsonMsg(200, '提交成功', '', $this->createUrl('test/answer',array('sid'=>$exam_id,'id'=>$examlog->csc_id)));
        }
    }

    public function actionAnswer(){
        $sid = Yii::app()->request->getParam('sid');
        $examinfo = ExamInfo::model()->findAll('csc_exam_id=:sid order by csc_sort',array('sid'=>$sid));
        $id = Yii::app()->request->getParam('id');
        $examlog = ExamLog::model()->findByPk($id);
        $this->render('answer',array(
            'examinfo'=>$examinfo,
            'examlog'=>$examlog,
        ));
    }

    public function actionOrder(){
        if(Yii::app()->request->isPostRequest){
            $gd = Yii::app()->request->getParam('gd');
            $school = Yii::app()->request->getParam('school');
            if($gd == '-1'){
                $this->jsonMsg(10,'请选择年级');
            }
            if($school == '-1'){
                $this->jsonMsg(11,'请选择校区');
            }
            $name = Yii::app()->request->getParam('name');
            $tel = Yii::app()->request->getParam('tel');
            $email = Yii::app()->request->getParam('email');
            if(empty($name)){
                $this->jsonMsg(12,'请填写姓名');
            }
            if(empty($tel)){
                $this->jsonMsg(13,'请填写电话');
            }
            if(empty($email)){
                $email = '';
            }
            $transaction= Yii::app()->db->beginTransaction();
            $examorder = new ExamOrder();
            $examorder->csc_id = getPrimaryKey($examorder);
            $examorder->csc_grade = $gd;
            $examorder->csc_school = $school;
            $examorder->csc_name = $name;
            $examorder->csc_tel = $tel;
            $examorder->csc_mail = $email;
            if(!$examorder->save()){
                $error = implode('', current($examorder->getErrors()));
                $this->jsonMsg(502, '预约失败'.$error, '', '', $transaction);
            }
            $transaction->commit();

            // send mail
            $mail_body = $name.'&nbsp;&nbsp;'.$tel.'&nbsp;&nbsp;'.Yii::app()->params['site']['gd_type'][$gd];
            $mail_body = '<p>在线预约</p><p>'.$mail_body.'</p>';
            Mailer::sendmail(array('617699485@qq.com'=>'QQ邮箱地址'), '邮箱通知', $mail_body);
            $this->jsonMsg(200, '预约成功', '', $this->createUrl('/site'));

        }
    }


}