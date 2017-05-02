<?php

class CurlApi {
	
	private static $header = array(
		'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0',
//		'User-Agent: baiduspider/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 baiduspider/15.0'
	);
	
	private static function _header($url) {
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_NOBODY, 1);
		curl_setopt($curl_handle, CURLOPT_ENCODING, ''); // 接受任意编码形式 gzip ...
		curl_setopt($curl_handle, CURLOPT_HEADER, 1);
		curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10); // 设置超时时间为10秒
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		
		$orders = curl_exec($curl_handle);
		curl_close($curl_handle);
		
		$pat = '/(.*)\s{2,}/SU';
		preg_match_all($pat, $orders, $matches);
		
		$matches = trim($matches[0][0]);
		$matches = explode(' ', $matches);
		
		return $matches[1];
	}
	
	static function get($url){
		$httpStatus = self::_header($url);
		
		if( $httpStatus == '404' ){
			return '';
		}
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_ENCODING, ''); // 接受任意编码形式 gzip ...
		curl_setopt($curl_handle, CURLOPT_HEADER, 0);
		curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10); // 设置超时时间为10秒
		
		curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);  //是否抓取跳转后的页面
		
		curl_setopt($curl_handle, CURLOPT_HTTPHEADER, self::$header);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		
		$orders = curl_exec($curl_handle);
		curl_close($curl_handle);
		
		return $orders;
	}
	
	static function post($url, $postdata, $header=0){
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_HEADER, 0);
		
		if(is_array($header)){
			$cookie = 'f://cookie.txt';
			curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl_handle, CURLOPT_COOKIEJAR, $cookie);
			//dump($header);
		}
		
		curl_setopt($curl_handle, CURLOPT_POST, 0);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		
		
		$orders = curl_exec($curl_handle);
		
		curl_close($curl_handle);
		
		return $orders;
	}
}