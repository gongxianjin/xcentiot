<?php
/**
 * 自定义函数
 * Enter description here ...
 * @author Administrator
 *
 */
/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo=true, $label=null, $strict=true) {
	header('Content-Type:text/html; charset=utf-8');
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

/**
 * XML编码
 * @param mixed $data 数据
 * @param string $root 根节点名
 * @param string $item 数字索引的子节点名
 * @param string $attr 根节点属性
 * @param string $id   数字索引子节点key转换的属性名
 * @param string $encoding 数据编码
 * @return string
 */
function xml_encode($data, $root='think', $item='item', $attr='', $id='id', $encoding='utf-8') {
    if(is_array($attr)){
        $_attr = array();
        foreach ($attr as $key => $value) {
            $_attr[] = "{$key}=\"{$value}\"";
        }
        $attr = implode(' ', $_attr);
    }
    $attr   = trim($attr);
    $attr   = empty($attr) ? '' : " {$attr}";
    $xml    = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
    $xml   .= "<{$root}{$attr}>";
    $xml   .= data_to_xml($data, $item, $id);
    $xml   .= "</{$root}>";
    return $xml;
}

/**
 * 数据XML编码
 * @param mixed  $data 数据
 * @param string $item 数字索引时的节点名称
 * @param string $id   数字索引key转换为的属性名
 * @return string
 */
function data_to_xml($data, $item='item', $id='id') {
    $xml = $attr = '';
    foreach ($data as $key => $val) {
        if(is_numeric($key)){
            $id && $attr = " {$id}=\"{$key}\"";
            $key  = $item;
        }
        $xml    .=  "<{$key}{$attr}>";
        $xml    .=  (is_array($val) || is_object($val)) ? data_to_xml($val, $item, $id) : $val;
        $xml    .=  "</{$key}>";
    }
    return $xml;
}

/**
 * 生成UUID 单机使用
 * @access public
 * @return string
 */
function uuid() {
	$charid = md5(uniqid(mt_rand(), true));
	$hyphen = chr(45);// "-"
	$uuid = chr(123)// "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			.chr(125);// "}"
	return $uuid;
}

/**
 * 获取主键Key
 */
function getPrimaryKey($model=null, $type=false){
	if(!$model){
		return md5(uuid());
	}else if(!$type){
		// 查询最大记录ID
		$table_name = Yii::app()->db->tablePrefix.str_replace(array('{','}'), '', $model->tableName());
		$sql = 'select max(`csc_id`) as `num` from '.$table_name;

		$data = Yii::app()->db->createCommand($sql)->queryRow();
		$num = $data['num'];
		return $num ? $num+1 : 1;
	}else if($type==='coupon'){
		// 优惠券特征码
		$sn = str_pad(rand(1, 99999999), 8, '0', STR_PAD_LEFT);
		$table_name = Yii::app()->db->tablePrefix.str_replace(array('{','}'), '', $model->tableName());
		$sql = 'select count(1) as `num` from '.$table_name. ' where csc_cp_sn=\''.$sn.'\'';
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		
		if(!$data['num']){
			return $sn;
		}
		return getPrimaryKey($model, $type);
			
	}else if($type=='ordernumber'){
		// 生成订单号
		$mid = date('ymdHi');
		$table_name = Yii::app()->db->tablePrefix.str_replace(array('{','}'), '', $model->tableName());
		$sql = 'select count(1) as `num` from '.$table_name. ' where  datediff(csc_create, "'.date('Y-m-d').'")=0';
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		
		if(!$data['num']){
			return $mid.str_pad('1', 7, '0', STR_PAD_LEFT);
		}
		return $mid.str_pad(++$data['num'], 7, '0', STR_PAD_LEFT);
	}else{
		die('primarkey create fail');
	}
}

// 自动转换字符集 支持数组转换
function autoCharset($string, $from='gbk', $to='utf-8') {
	$from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
	$to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
	if (strtoupper($from) === strtoupper($to) || empty($string) || (is_scalar($string) && !is_string($string))) {
		//如果编码相同或者非字符串标量则不转换
		return $string;
	}
	if (is_string($string)) {
		if (function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($string, $to, $from);
		} elseif (function_exists('iconv')) {
			return iconv($from, $to, $string);
		} else {
			return $string;
		}
	} elseif (is_array($string)) {
		foreach ($string as $key => $val) {
			$_key = self::autoCharset($key, $from, $to);
			$string[$_key] = self::autoCharset($val, $from, $to);
			if ($key != $_key)
			unset($string[$key]);
		}
		return $string;
	}
	else {
		return $string;
	}
}

/**
 * 两个时间差的天数
 * @param begin_time 起始时间
 * @param end_time 结束时间
 * @return array
 */
function timediff($begin_time,$end_time)
{
      if($begin_time < $end_time){
         $starttime = $begin_time;
         $endtime = $end_time;
      }
      else{
         $starttime = $end_time;
         $endtime = $begin_time;
      }
      $timediff = $endtime-$starttime;
      $days = intval($timediff/86400);
      $remain = $timediff%86400;
      $hours = intval($remain/3600);
      $remain = $remain%3600;
      $mins = intval($remain/60);
      $secs = $remain%60;
      $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
      return $res;
}

function format_timediff($begin_time,$end_time)
{
	$res = timediff($begin_time,$end_time);
	return "{$res['day']}天{$res['hour']}时{$res['min']}分{$res['sec']}秒";
}

/**
 * 文本安全输出
 * @param String $str
 * @param Boolearn $filter_html
 */
function html($str, $html_encode=false){
	if($html_encode){
		$str = htmlentities($str);
	}
	return strip_tags($str);
}


function getBrowser(){
	$agent=$_SERVER["HTTP_USER_AGENT"];
	if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
	return "ie";
	else if(strpos($agent,'Firefox')!==false)
	return "firefox";
	else if(strpos($agent,'Chrome')!==false)
	return "chrome";
	else if(strpos($agent,'Opera')!==false)
	return 'opera';
	else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
	return 'safari';
	else
	return 'unknown';
}

function getBrowserVer(){
	if (empty($_SERVER['HTTP_USER_AGENT'])){    //当浏览器没有发送访问者的信息的时候
		return 'unknow';
	}
	$agent= $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/MSIE\s(\d+)\..*/i', $agent, $regs))
	return $regs[1];
	elseif (preg_match('/FireFox\/(\d+)\..*/i', $agent, $regs))
	return $regs[1];
	elseif (preg_match('/Opera[\s|\/](\d+)\..*/i', $agent, $regs))
	return $regs[1];
	elseif (preg_match('/Chrome\/(\d+)\..*/i', $agent, $regs))
	return $regs[1];
	elseif ((strpos($agent,'Chrome')==false)&&preg_match('/Safari\/(\d+)\..*$/i', $agent, $regs))
	return $regs[1];
	else
	return 'unknow';
}