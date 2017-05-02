<?php

class PinyinApi{

	private static $pyObj; // 获取拼音对象

	private static function init(){
		if(!self::$pyObj || is_null(self::$pyObj)){
			include_once dirname(__FILE__).'/pinyin/ChinesePinyin.class.php';
			self::$pyObj = new \ChinesePinyin();
		}
	}

	/**
	 * 获取拼音首字母
	 * @param String $words
	 * @param String $delimiter
	 */
	static function getfirstchar($words, $delimiter=''){
		self::init();
		return self::$pyObj->TransformUcwords($words, $delimiter);
	}

	/**
	 * 获取拼音
	 * @param String $words
	 * @param String $delimiter
	 */
	static function getpinyin($words, $delimiter=''){
		self::init();
		return self::$pyObj->TransformWithoutTone($words, $delimiter);
	}

	/**
	 * 获取拼音带声调
	 * @param String $words
	 * @param String $delimiter
	 */
	static function getpinyinandvoice($words, $delimiter=''){
		self::init();
		return self::$pyObj->TransformWithTone($words, $delimiter);
	}
}