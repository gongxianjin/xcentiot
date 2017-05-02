<?php

class SetupApi{ 
	
	private static $c; // 设置参数文件
	
	private static $f; // 参数文件目录
	
	
	private static function createDir($path){
		if(!file_exists($path) && !is_dir($path)){
			mkdir($path);
		}
	}
	
	/**
	 * 初始化并返回配置文件
	 */
	private static function _init(){
		if(!self::$f){
			//self::$f = Yii::app()->Params['img_upload_dir'].'/setup';
			self::$f = dirname(dirname(dirname(__FILE__))).'/assets';
			self::createDir(self::$f);
			
			self::$f .= '/setup.ini';
			
			if(!file_exists(self::$f)){
				// 写入空字符串
				file_put_contents(self::$f, '');
			}
		}
		
		if(!self::$c){
			self::$c = file_get_contents(self::$f);
			if(self::$c){
				self::$c = json_decode(self::$c, true);
			}
		}
	}
	
	/**
	 * 获取客户端配置文件内容
	 * @param String $key
	 */
	static function getInfo($key){
		if(!$key) return '';
		
		self::_init();
		
		$key = explode('-', $key);
		
		$arr = false;
		foreach ($key as $k){
			if($arr===false){
				$arr = isset(self::$c[$k])?self::$c[$k]:'';
			}else{
				$arr = isset($arr[$k])?$arr[$k]:'';
			}
		}
		
		return $arr;
	}
	
	/**
	 * 设置客户端配置文件内容
	 * @param String $key
	 * @param Mixed $value
	 */
	static function setInfo($key, $value){
		if(!$key) return false;
		
		self::_init();
		$key = explode('-', $key);
		$wData = false;
		foreach ($key as $k){
			if($wData===false){
				$wData = &self::$c[$k];
			}else{
				$wData = &self::$c[$k];
			}
		}
		
		if($wData===false){
			return false;
		}
		$wData = $value;
		
		file_put_contents(self::$f, json_encode(self::$c));
		
		return true;
	}
	
	
}