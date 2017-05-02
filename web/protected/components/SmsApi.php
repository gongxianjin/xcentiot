<?php

class SmsApi {
	private static $smsUrl = 'http://sdk.entinfo.cn:8061/webservice.asmx?WSDL';
	private static $smsSdk;
	private static $sdkPwd;
	private static $sign;
	private static $smsStatus = array(
		'-2' => '帐号/密码不正确',
		'-4' => '余额不足不支持本次发送',
		'-5' => '数据格式错误',
		'-6' => '参数有误',
		'-7' => '权限受限',
		'-8' => '流量控制错误',
		'-9' => '扩展码权限错误',
		'-10' => '内容长度长',
		'-11' => '内部数据库错误',
		'-12' => '序列号状态错误',
		'-14' => '服务器写文件失败',
		'-17' => '没有权限',
		'-19' => '禁止同时使用多个接口地址',
		'-20' => '相同手机号，相同内容重复提交',
		'-22' => 'Ip鉴权失败',
		'-23' => '缓存无此序列号信息',
		'-601' => '序列号为空，参数错误',
		'-602' => '序列号格式错误，参数错误',
		'-603' => '密码为空，参数错误',
		'-604' => '手机号码为空，参数错误',
		'-605' => '内容为空，参数错误',
		'-606' => 'ext长度大于9，参数错误',
		'-607' => '参数错误 扩展码非数字 ',
		'-608' => '参数错误 定时时间非日期格式',
		'-609' => 'rrid长度大于18,参数错误 ',
		'-610' => '参数错误 rrid非数字',
		'-611' => '参数错误 内容编码不符合规范',
		'-623' => '手机个数与内容个数不匹配',
		'-624' => '扩展个数与手机个数数',
		'-644' => 'Rrid个数与手机号个数不一致',
	);

	static protected function init(){
		$sms_config = Yii::app()->params['md_sms'];

		self::$smsSdk = isset($sms_config['sdk'])?$sms_config['sdk']:'';
		self::$sdkPwd = isset($sms_config['pwd'])?$sms_config['pwd']:'';
		self::$sign = isset($sms_config['sign'])?$sms_config['sign']:'';

		if(!self::$smsSdk || !self::$sdkPwd || !self::$sign){
			die('sms param missing');
		}
	}

	/**
	 * 漫道短信发送
	 * @param String $mobile 手机号码 多个以逗号隔开
	 * @param String $body 发送内容
	 */
	static function send($moblie, $body, $type=''){
	
		if(!$body || $body == ''){
			$msg = '短信内容为空';
			Yii::log("\n{$msg}:\n", CLogger::LEVEL_WARNING);
			return $msg;
		}
		
		self::init();

		// 传入参数
		$argv = array(
	        'sn'=>self::$smsSdk, //替换成您自己的序列号
			'pwd'=>strtoupper(md5(self::$smsSdk.self::$sdkPwd)), //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
			'mobile'=>$moblie, //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
			'content'=>$body.self::$sign,
			'ext'=>'',
			'stime'=>'', //定时时间 格式为2011-6-29 11:09:21
			'msgfmt'=>'',
			'rrid'=>'', //默认空 如果空返回系统生成的标识串 如果传值保证值唯一 成功则返回传入的值
		);

		$q = $argv;
		unset($q['sn'], $q['pwd']);
		
		try{
			ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
			$soap = new SoapClient(self::$smsUrl, array('trace' => 1));
			
			Yii::log("\n短信发送内容_{$type}:\n".var_export($q, true)."\n", CLogger::LEVEL_WARNING);
			
			$rs = $soap->mdsmssend($argv);
			$rs->customMsg = isset(self::$smsStatus[$rs->mdsmssendResult])?self::$smsStatus[$rs->mdsmssendResult]:'';
				
			unset($soap);
			Yii::log("\n短信发送返回内容_{$type}:\n".var_export($rs, true)."\n", CLogger::LEVEL_WARNING);
				
		}catch (Exception $e){
			$msg = '短信通道错误：'.$e->getMessage();
			Yii::log("\n{$msg}:\n", CLogger::LEVEL_WARNING);
			return $msg;
		}
		
		return isset(self::$smsStatus[$rs->mdsmssendResult])?self::$smsStatus[$rs->mdsmssendResult]:true;

	}

}