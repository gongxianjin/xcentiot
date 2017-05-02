<?php
/**
 * 检测参数
 * 2010 by seiven Email: c.navy@qq.com
 */
class ParamApi
{
	/**
	 * 检测参数的合法性
	 *
	 * @param 参数字符串 $param
	 * @param 内置参数格式 $action
	 * @param 正则表达式 $ext
	 *
	 * @return boolen
	 */
	static function check($param,$action,$ext = '')
	{
		if (empty($param)) return false;
		switch ($action)
		{
			case 'username':
				return self::_username($param);
				break;
			case 'email':
				return self::_email($param);
				break;
			case 'url':
				return self::_url($param);
				break;
			case 'idcard':
				return self::_idcard($param);
				break;
			case 'ip':
				return self::_ip($param);
				break;
			case 'phone':
				return self::_phone($param);
				break;
			case 'mobile':
				return self::_mobile($param);
				break;
			case 'call':
				return self::_call($param);
				break;
			case 'number':
				return self::_number($param);
				break;
			case 'chinese':
				return self::_chinese($param);
				break;
			case 'safe':
				return self::_isSafe($param);
				break;
			default:
				return (preg_match($ext,$param))?true:false;
				break;
		}
		return false;
	}
	# 账户名
	static function _username($p,$min = 3, $max = 20)
	{
		$v = strtolower($p);
		$in = $min - 1;
		$ax = $max - 1;
		$r = '/^[^\d][a-z0-9_]{'.$in.','.$ax.'}$/i';
		return (preg_match($r,$v))?true:false;
	}
	# Email地址
	static function _email($p)
	{
		$r = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
		return (preg_match($r,$p))?true:false;
	}
	# Url地址
	static function _url($p)
	{
		$v = strtolower($p);
		$r = '/^http:\/\/[a-z0-9]+[a-z0-9\.\/]+/';
		return (preg_match($r,$v))?true:false;
	}
	# 身份证号码
	static function _idcard($p)
	{
		$user_code = strtoupper($p);
		if( strlen(	$user_code) == 15 ){
			$code_18 = self::idcard_15to18($user_code);
		}elseif ( strlen($user_code) == 18 ){
			$code_18 = $user_code;
		}else{
			# error
			return false;
		}
		return self::idcard_checksum18($code_18);
	}
	# ip
	static function _ip($p)
	{
		$r = '/^[\d]{1,3}.[\d]{1,3}.[\d]{1,3}.[\d]{1,3}$/';
		if(preg_match($r,$p)){
			$ip_array = explode('.',$p);
			foreach ($ip_array as $intval){
				if ($intval > 255) return false;
			}
			return true;
		}else{
			return false;
		}
	}
	# 座机电话
	static function _phone($p){
		$r = '/^([\d]{2,3}[\-]?)?([0]?[\d]{2,3}[\-]?)?[1-9][0-9]{6,7}(\-[\d]{1,4})?$/';
		return (preg_match($r,$p))?true:false;
	}
	# 手机号码
	static function _mobile($p)
	{
		//默认手机
		$r = '/^[0]?1[3456789]\d{9}$/';
		return (preg_match($r,$p))?true:false;
	}
	# 组合验证(电话号码.手机号码)
	static function _call($p)
	{
		if (self::_phone($p) || self::_mobile($p)) return true;
		return false;
	}
	static function _chinese($p)
	{
		//默认中文
		$r = "/^[\\x{4e00}-\\x{9fa5}]+$/u";
		return (preg_match($r,$p))?true:false;
	}
	# 数字验证
	static function _number($p,$min = null,$max = null)
	{
		if (empty($p)) return false;
		# 位数
		if (is_null($min) && is_null($max)){
			$r = '/^[0-9]*$/';
		}elseif (is_null($min) && !is_null($max)){
			$r = '/^[0-9]{0,'. $max .'}$/';
		}elseif (!is_null($min) && is_null($max)){
			$r = '/^[0-9]{'. $min .',}$/';
		}else {
			$r = '/^[0-9]{'. $min .','. $max .'}$/';
		}
		return (preg_match($r,$p))?true:false;
	}
	# 检查安全字符
	static function _isSafe($p)
	{
		$r = '/\'\%\#\&\~\*\;\"\>\<\/\(\)/';
		return  (preg_match($r,$p))?false:true;
	}
	# 计算身份证校验码，根据国家标准GB 11643-1999
	static function idcard_verify_number($idcard_base){
		if (strlen($idcard_base) != 17){ return false; }
		// 加权因子
		$factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
		// 校验码对应值
		$verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
		$checksum = 0;
		for ($i = 0; $i < strlen($idcard_base); $i++){
			$checksum += substr($idcard_base, $i, 1) * $factor[$i];
		}
		$mod = $checksum % 11;
		$verify_number = $verify_number_list[$mod];
		return $verify_number;
	}

	# 将15位身份证升级到18位
	static function idcard_15to18($idcard){
		if (strlen($idcard) != 15){
			return false;
		}else{
			// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
			if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
				$idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
			}else{
				$idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
			}
		}
		$idcard = $idcard . self::idcard_verify_number($idcard);
		return $idcard;
	}

	# 18位身份证校验码有效性检查
	static function idcard_checksum18($idcard){
		if (strlen($idcard) != 18){ return false; }
		$idcard_base = substr($idcard, 0, 17);
		if (self::idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
			return false;
		}else{
			return true;
		}
	}

	// 转义 mysql 岐义字符
	static function convert_unsafe_char($str){
		return mysql_escape_string(gbk_to_utf8($str));
	}
}