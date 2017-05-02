<?php

class IndexController extends Controller
{
	public function actionIndex()
	{
		$act_address = Yii::app()->params['site']['act_address'];
		if(empty($act_address)){
			$act_address = array();
		}
		$this->render('index',array(
			'act_address'=>$act_address,
		));
	}

	/**
	 *    生成抽奖号
	 *
	 *    @author    Garbin
	 *    @return    string
	 */
	public function _gen_award_sn($begin, $end)
	{
		if(empty($begin) || empty($end)){
			return false;
		}
		/* 选择一个随机的方案 */
		mt_srand((double) microtime() * 1000000);


//		$timestamp = time();
//		$y = date('y', $timestamp);
//		$z = date('z', $timestamp);
//		$award_sn = $y . str_pad($z, 3, '0', STR_PAD_LEFT) . str_pad(mt_rand($begin, $end), 5, '0', STR_PAD_LEFT);

		$award_sn = mt_rand($begin, $end);

		//查找已有的抽奖表中是否存在该抽奖号？
		$awards = Special::model()->find('csc_award=:id',array(':id'=>$award_sn));

		if (empty($awards))
		{
			/* 否则就使用这个订单号 */
			return $award_sn;
		}

		/* 如果有重复的，则重新生成 */
		return $this->_gen_award_sn($begin,$end);
	}

	public function actionAward(){
		$amode = Award::model();
		$setting = $amode->find();
		if(empty($setting)){
			$this->jsonMsg(501, '活动未开始', '');
		}else{
			if($setting->amax < $setting->amin){
				$this->jsonMsg(502, '活动未开始','');
			}
		}
		if(Yii::app()->request->IsPostRequest){
			//header("Content-type: text/html; charset=utf-8");
			$name = Yii::app()->request->getParam('name');
			$tel = Yii::app()->request->getParam('tel');
			$type = Yii::app()->request->getParam('type');
			if(empty($name)){
				$this->jsonMsg(503,  mb_convert_encoding('请您输入姓名', 'utf-8', 'gbk'),'');
			}
			$str = mb_convert_encoding('--请选择--', 'utf-8', 'gbk');
			if($type == $str){
				$this->jsonMsg(503, mb_convert_encoding('请您选择地点', 'utf-8', 'gbk'),'');
			}
			if(!preg_match("/^1[34578]{1}\d{9}$/", $tel)){
				$this->jsonMsg(503, mb_convert_encoding('请输入正确的手机号', 'utf-8', 'gbk'),'');
			}
			if(!empty($tel)){
				$user = Special::model()->find('csc_phone=:tel',array('tel'=>$tel));
			 	$str = '感谢您参加活动,您的抽奖码是'.$user->csc_award;
				if(!empty($user)){
					$this->jsonMsg(504, mb_convert_encoding($str, 'utf-8', 'gbk'),'');
				}
			}
			$award_sn = $this->_gen_award_sn($setting->amin,$setting->amax);
			$transaction= Yii::app()->db->beginTransaction();
			$user = new Special();
			$user->csc_id = getPrimaryKey($user);
			$user->csc_name = $name;
			$user->csc_phone = $tel;
			$user->csc_type = $type;
			$user->csc_award = $award_sn;
			$user->csc_create = date('Y-m-d H:i:s');
			if(!$user->save()){
				$error = implode('', current($user->getErrors()));
				$this->jsonMsg(502, mb_convert_encoding('添加失败', 'utf-8', 'gbk').$error, '', '', $transaction);
			}
			$url = $this->createUrl('index/award',array('id'=>$user->csc_id));
			$transaction->commit();
			$this->jsonMsg(200, mb_convert_encoding('加入成功', 'utf-8', 'gbk'),'', $url);
		}else{
			$id = Yii::app()->request->getParam('id');
			$info = Special::model()->findByPk($id);
		}
		$this->render('award',array(
			'infos'=>$info,
		));
	}

}