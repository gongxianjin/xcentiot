<?php
/**
 * 公用函数库
 *
 */
include_once dirname(__FILE__).'/mailer/class.phpmailer.php';
include_once dirname(__FILE__).'/mailer/class.smtp.php';
class Mailer {
	/**
	 * 发送邮件
	 *
	 * @param 目标地址	$to  array('邮件地址'=>'名称')
	 * @param 邮件标题	$title
	 * @param 邮件正文	$body
	 * @return boolean
	 */
	static function sendmail($to, $title, $body, $html=true)
	{
		$mail_config = Yii::app()->params['mailer'];
		
		$delimiter = $mail_config['delimiter']?$mail_config['delimiter']:' ';
		$mail_config['smtpUser'] = explode($delimiter, $mail_config['smtpUser']);
		
		$s_c = count($mail_config['smtpUser']);
		
		if(1==$s_c){
			$mail_config['smtpUser'] = $mail_config['smtpUser'][0];
		}else{
			$i = floor(rand(0, count($mail_config['smtpUser'])-1));
			$mail_config['smtpUser'] = $mail_config['smtpUser'][$i];
			
			if(strstr($mail_config['smtpPass'], $delimiter)){
				$mail_config['smtpPass'] = explode($delimiter, $mail_config['smtpPass']);
				if($s_c!=count($mail_config['smtpPass'])){
					return 'Password is inconsistent with the number of users';
				}
				$mail_config['smtpPass'] = $mail_config['smtpPass'][$i];
			}
			
			if(strstr($mail_config['mailFormEmail'], $delimiter)){
				$mail_config['mailFormEmail'] = explode($delimiter, $mail_config['mailFormEmail']);
				if($s_c!=count($mail_config['mailFormEmail'])){
					return 'FormEmail is inconsistent with the number of users';
				}
				$mail_config['mailFormEmail'] = $mail_config['mailFormEmail'][$i];
			}
		}
		
		$mail	= new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;               // enable SMTP authentication
		$mail->SMTPSecure = "";                 // sets the prefix to the servier
		$mail->Host       = $mail_config['smtpHost'];      // sets GMAIL as the SMTP server
		$mail->Port       = $mail_config['smtpPort'];               // set the SMTP port
		
		$mail->Username   = $mail_config['smtpUser']; // GMAIL username
		$mail->Password   = $mail_config['smtpPass']; // GMAIL password
		
		$mail->From       = $mail_config['mailFormEmail'];
		$mail->FromName   = $mail_config['mailFormName'];
		$mail->Subject    = $title;
		#$mail->AltBody    = "我也不知道"; //Text Body
		$mail->WordWrap   = 50; // set word wrap
		
		$mail->CharSet = 'UTF-8';
		$mail->Encoding = 'base64';
		
		$mail->MsgHTML($body);
		# 抄送
		# $mail->AddReplyTo("382903026@qq.com","Jacen");
		# 附件
		# $mail->AddAttachment("/path/to/file.zip");             // attachment
		# 收件人
		foreach ($to as $k=>$v){
			$mail->AddAddress($k,$v);
		}
		$mail->IsHTML($html); // send as HTML
		
		if(!$mail->Send()) {
			return $mail->ErrorInfo;
		} else {
			return true;
		}
	}
	
	
	static function getMailTpl($type, $param=false){
	    if(!$type){
	        return array(400, '参数有误');
	    }
	    
	    if($type == 'forget_verify'){
	        return self::forget_verify($param);
	    }
	    
	    return array(500, '未知邮件内容信息');
	}
	
	/**
	 * 组合招标信息内容模版
	 * @param Array $param
	 */
	protected static function forget_verify($code){
	    if(!$code) return array(410, 'param is losted');
	    
	    $body = @file_get_contents(dirname(Yii::app()->basePath).'/assets/mail_tpl/forget_verify.html');
	    
	    if(!$body){
	        return array(401, '邮件内容模版不存在或未上传');
	    }
	    
	    $body = str_replace(array('{VERIFY}'), $code, $body);
	    
	    return array(200, $body);
	}
}
