<?php

/**
 * 公用函数库
 *
 */

class BaseApi {
	/**
	 * 系统加密算法
	 *
	 * @param 加密原串 $var
	 * @return string
	 */
	static function system_md5($var)
	{
		$_md5 = md5($var);
		$b = array();
		for ($i=0 ; $i<32 ; $i+=2)
		{
			if (fmod($i,3)){
				$b[] = strrev(substr($_md5,$i,2));
			}else{
				$b[] = substr($_md5,$i,2);
			}
		}
		return md5(implode('',$b));
	}

	/**
	 * 获取唯一ID标识
	 * @param Mixed $type false_md5加密串    true 20位数字订单编号
	 * @return String
	 */
	static function guid($type = false){
		if($type===false){
			return md5(sha1(uniqid(date('YmdHis'), true)));
		}else{
			$s = date('YmdHis');
			$t = ceil(microtime()*100);
			$t = $t<10?'0'.$t:$t;
			$t = $t<100?'0'.$t:$t;
			return $s.$t;
		}
	}

	static function json_msg($code, $msg, $data='', $forwardUrl=''){
		$array = array(
			'code' => $code,
			'msg' => $msg,
		);
		if($data){
			$array['data'] = $data;
		}
		if($forwardUrl){
			$array['forward'] = $forwardUrl;
		}
		echo json_encode($array);exit;
	}

	/**
	 * 接口加密串检测
	 * @param Array $param
	 * @param String $sign
	 */
	static function check_sign($param, $sign, $debug=false){
		if(!is_array($param)) return false;

		$s = '';
		foreach ($param as $k=>$v){
			$s .= $k.md5($v);
		}
		if($debug){
			echo ($sign.'<br>'.md5($s));
			exit;
		}
		return $sign == md5($s);
	}
	
	/**
	 * 删除上传目录中的文件
	 * @param String $file 文件相对路径
	 */
	static function delFile($file){

		if(!$file) return ;

		$file = dirname(Yii::app()->params['img_upload_dir']). $file;

		if(file_exists($file)){
			unlink($file);
		}
	}
	
	/**
	 * 递归删除指定目录内的文件及目录
	 * @param String $dir
	 */
	static function delDirFile($dir, $step=0){
		if(!is_dir($dir)){
			if(file_exists($dir)){
				@unlink($dir);
			}
		}else{
			$dh = opendir($dir);
			while (false !== ($file=readdir($dh))){
				if($file == '.' || $file =='..') continue;
				
				$file = $dir.DIRECTORY_SEPARATOR.$file;
				if(is_dir($file)){
					self::delDirFile($file, $step+1);
				}else{
					@unlink($file);
				}
			}
			closedir($dh);
			if($step){
				@rmdir($dir);
			}
		}
	}
	
	/**
	 * 快速删除目录文件
	 * @param String $path 删除的目录
	 */
	static function delDirFileFast($path){
		if(file_exists($path)){
			$b_cmd = 'mkdir '.$path;
			if('linux' != strtolower(PHP_OS)){
				$cmd = 'rd /s /q "'.$path.'"';
			}else{
				$cmd = 'rm -rf "'.$path.'"';
			}
			system($cmd);
			system($b_cmd);
		}
	}

	static function createDir($path){
		if(!is_dir($path)){
			if(! @mkdir($path, 755) ){
				die('directory not writeable');
			}
		}
	}

	/**
	 * 复制文件到正式目录
	 * @param String $oldFile
	 * @param String $type    可自定义多级目录   dir1/dir2...
	 * @param String $newName 新文件名(无后缀)
	 * @return String 新文件路径(相对目录)
	 */
	static function copyTempFile($oldFile, $type, $newName = null){
		$r = array('status'=>0, 'msg'=>'', 'path'=>''); // 操作返回信息

		if(!$type || 'temp' == strtolower($type)){
			$r['msg'] = 'FILE TYPE FEILD';
			return $r;
		}
		
		if(!stristr($oldFile, '/temp/')){
			$r['status'] = 1;
			$r['path'] = trim($oldFile, '/');
			return $r;
		}
		
		$basepath = dirname(Yii::app()->basepath);
		$path = $basepath.$oldFile;

		if(!file_exists($path)){
			$r['msg'] = 'FILE NOT FOUND';
			return $r;
		}

		$type = explode('/', $type);

		// 创建新目录
		$dir = $basepath.'/uploads/';
		foreach ($type as $v){
			$dir .= $v;
			self::createDir($dir);
			$dir .= '/';
		}
		if(count($type)>0){
			$dir = rtrim($dir, '/');
		}

		$dir .= date('/Y-m-d');
		self::createDir($dir);
		
		$ext = pathinfo($oldFile, PATHINFO_EXTENSION);
		
		$newFile = $dir . '/' . ( $newName ? $newName : md5(uniqid()) ).'.'.$ext;

		if(! @copy($path, $newFile) ){
			$r['msg'] = 'FILE NOT WRITEABLE';
		}else{
			$r['status'] = 1;
			$r['path'] = str_replace(dirname(Yii::app()->params['img_upload_dir']), '', $newFile);
		}

		return $r;
	}
	
	/**
	 * 复制文件到新文件
	 * @param String $oldFile
	 * @param String $type    可自定义多级目录   dir1/dir2...
	 * @param String $newName 新文件名(无后缀)
	 * @return String 新文件路径(相对目录)
	 */
	static function copyFile($oldFile, $type, $newName = null){
		$r = array('status'=>0, 'msg'=>'', 'path'=>''); // 操作返回信息

		if(!$type || 'temp' == strtolower($type)){
			$r['msg'] = 'FILE TYPE FEILD';
			return $r;
		}
		
		$basepath = dirname(Yii::app()->basepath);
		$path = $basepath.$oldFile;

		if(!file_exists($path)){
			$r['msg'] = 'FILE NOT FOUND';
			return $r;
		}

		$type = explode('/', $type);

		// 创建新目录
		$dir = $basepath.'/uploads/';
		foreach ($type as $v){
			$dir .= $v;
			self::createDir($dir);
			$dir .= '/';
		}
		if(count($type)>0){
			$dir = rtrim($dir, '/');
		}

		$dir .= date('/Y-m-d');
		self::createDir($dir);
		
		$ext = pathinfo($oldFile, PATHINFO_EXTENSION);
		
		$newFile = $dir . '/' . ( $newName ? $newName : md5(uniqid()) ).'.'.$ext;

		if(! @copy($path, $newFile) ){
			$r['msg'] = 'FILE NOT WRITEABLE';
		}else{
			$r['status'] = 1;
			$r['path'] = str_replace(dirname(Yii::app()->params['img_upload_dir']), '', $newFile);
		}

		return $r;
	}
	
	/**
	 * 生成zip压缩文件
	 * @param Array $files 要压缩的文件  文件路径=>文件名
	 * @param String $destination 文件名
	 * @param Boolean $overwrite
	 */
	static function create_zip($files = array(),$destination = 'text.zip',$overwrite = false) {
		$file_dir = dirname(Yii::app()->params['img_upload_dir']);
		$destination = $file_dir.'/uploads/temp/file/'.getPrimaryKey().'.zip';
	    
	    //vars
	    $valid_files = array();
	    //if files were passed in...
	    if(is_array($files)) {
	    	
	        //cycle through each file
	        foreach($files as $path=>$file) {
	            //make sure the file exists
	            if(file_exists($file_dir.$path)) {
	                $valid_files[$file_dir.$path] = $file;
	            }
	        }
	    }
	    //if we have good files...
	    if(count($valid_files)) {
	        //create the archive
	        $zip = new ZipArchive();
	        if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
	            return false;
	        }
	        
	        foreach($valid_files as $path=>$file) {
	            $zip->addFile($path, $file);//去掉层级目录
	        }
	        //debug
	        //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
	
	        //close the zip -- done!
	        $zip->close();
	
	        //check to make sure the file exists
	        if(file_exists($destination)){
	        	return $destination;
	        }
	        
	    }else{
	        return false;
	    }
	}

	
	/**
	 * 根据宽高生成缩略图文件
	 * @param String $img 原始图片文件
	 * @param Int $w  缩略宽度
	 * @param Int $h  缩略高度
	 * @param String $thumbName  缩略图文件名
	 * @param Int $mode 图片质量
	 */
	static function createThumb($img, $w=120, $h=120, $thumbName=false, $mode=2 ){
		$r = array('status'=>0, 'msg'=>'', 'path'=>''); // 操作返回信息

		$root_path = dirname(Yii::app()->params['img_upload_dir']);
		
		$path = $root_path.$img;
		if(!file_exists($path)){
			$r['msg'] = 'FILE NOT FOUND';
			return $r;
		}
		
		$outImg = str_replace(strstr($path, '.'), '', $path);
//		exit($outImg);
		
		$thumb = Yii::app()->thumb;
		$thumb->image = $path;
		$thumb->directory = $outImg;
		$thumb->mode = $mode;
		$thumb->width = $w;
		$thumb->height = $h;
		$dn = $thumb->defaultName;
		$thumb->defaultName = $thumbName?$thumbName:$thumb->defaultName;
		$thumb->createThumb();
		$thumb->save();
		
		$outImg = $outImg.$thumb->defaultName.'.'.$thumb->srcExt;
		$outImg = str_replace($root_path, '', $outImg);
		$thumb->defaultName = $dn;
		$r['status'] = 1;
		$r['path'] = $outImg;
		
		return $r;
	}
		
	/**
	 * 获取内容中所有图片
	 * @param String $content
	 */
//	static function getContentImg($content){
//		$arr = array();
//		$tps = basename(Yii::app()->params['img_upload_dir']);
//
//		$content = str_replace(array('&quot;', '&lt;', '&gt;'), array('"', '<', '>'), $content);
//		$pat = '/<img.+src=[\'\"]?.+[\'\"]?.*>/SU';
//		preg_match_all($pat, $content, $matches);
//
//		if( isset($matches[0]) && is_array($matches[0]) ){
//
//			$pat = '/src=[\'\"](.*)[\'\"]/SiU';
//			foreach ($matches[0] as $v){
//				preg_match($pat, $v, $src);
//				$src = trim($src[1]);
//
//				if(strstr($src, '/'.$tps.'/')){
//					$arr[] = $src;
//				}
//			}
//		}
//		return $arr;
//	}

	/**
	 * 获取内容中所有图片
	 * @param String $content
	 */
	static function getContentImg(&$content, $filter=false){
		$arr = array();
		$tps = basename(Yii::app()->params['img_upload_dir']);

		$content = str_replace(array('&quot;', '&lt;', '&gt;'), array('"', '<', '>'), $content);
		$pat = '/<img.+src=[\'\"]?.+[\'\"]?.*>/SU';

		preg_match_all($pat, $content, $matches);

		if( isset($matches[0]) && is_array($matches[0]) ){

			$pat = '/src=[\'\"](.*)[\'\"]/SiU';
			$imgs = array();
			foreach ($matches[0] as $v){
				preg_match($pat, $v, $src);
				$src = trim($src[1]);
				$imgs[] = $src;
				if(stristr($src, 'data:image')){
					$ls = strpos($src, '/')+1;
					$le = strpos($src, ';base64') - $ls;
					$ext = substr($src, $ls, $le);
					$tmpfile = $tps.'/temp/'.date('Y-m-d');
					self::createDir($tmpfile);
					$tmpfile .= '/'.getPrimaryKey().'.'.$ext;

					$fc = base64_decode(trim(strstr($src, ','), ','));
					file_put_contents($tmpfile, $fc);
					$src = '/'.$tmpfile;
				}
				if($filter){
					$arr[] = $src;
				}else if(strstr($src, '/'.$tps.'/')){
					$arr[] = $src;
				}
			}
			$content = self::updateContentImg($content, $imgs, $arr);
		}
		return $arr;
	}

	/**
	 * 更新图文容图片
	 * @param String $content
	 * @param Array/String $oldImg
	 * @param Array/String $newImg
	 * @return String
	 */
	static function updateContentImg($content, $oldImg, $newImg){
		$content = str_replace(array('&quot;', '&lt;', '&gt;'), array('"', '<', '>'), $content);
		
		return str_replace($oldImg, $newImg, $content);
	}

	static function buildImg($imgs){
		$tps = basename(Yii::app()->params['img_upload_dir']);
		if(is_string($imgs)){
			if(!strstr($imgs, $tps)){
				$imgs = $tps.'/'.$imgs;
			}
		}else if(is_array($imgs)){
			foreach ($imgs as $k=>$v){
				$imgs[$k] = self::buildImg($v);
			}
		}
		return $imgs;
	}
	
	static function createCateUrl($cate, $ext_id=null, $aid=null){
		if(!$cate || !is_object($cate)){
			
			return '';
		}elseif($cate->csc_link){
			
			return $cate->csc_link;
		}
		
		if($cate->csc_pinyin){
			
			$param = array('en'=>$cate->csc_pinyin);
		}elseif($cate->csc_cate_path){
			
			$path = trim($cate->csc_cate_path, '0,');
			$path = trim($path, ',');
			$path = str_replace(',', '-', $path);
			
			$param = array('path'=>$path);
		}else{
			$param = array('cid'=>$item->csc_id);
		}
		
		if($ext_id){
			$param['sid'] = $ext_id;
		}
		if($aid){
			$param['aid'] = $aid;
		}
		return Yii::app()->createUrl('cate/index', $param);
	}
	
	/**
	 * 获取摘要内容
	 * @param String $content
	 */
	static function getSummary($content, $length=200, $encode='utf-8'){
		return mb_substr(strip_tags($content), 0, $length, $encode);
	}

	/**
	 * 过滤内容图片
	 * @param String $content
	 */
	static function delContentImg($content, $delImg=false){
		$arr = array();
		$tps = basename(Yii::app()->params['img_upload_dir']);

		$content = str_replace(array('&quot;', '&lt;', '&gt;'), array('"', '<', '>'), $content);
		$pat = '/<img.+src=[\'\"]?.+[\'\"]?.*>/SU';
		preg_match_all($pat, $content, $matches);

		if( isset($matches[0]) && is_array($matches[0]) ){
			$old_c = $matches[0];
			foreach ($matches[0] as $key=>$v){
				if(!$delImg && !$key){
					$matches[0][$key] = '';
					break;
				}elseif($delImg && stristr($v, $delImg)){
					$matches[0][$key] = '';
					break;
				}
			}
			$content = str_replace($old_c, $matches[0], $content);
		}
		return $content;
	}

	/**
	 * 过滤所有内容图片
	 * @param String $content
	 */
	static function delContentImgAll($content){
		while(self::getContentImg($content) != null){
			$content = self::delContentImg($content);
		}
		return $content;
	}
	
	/**
	 * 生成默认用户名
	 * @param String $phone
	 */
	static function getDefaultUser($phone=null){
		$s = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    				'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    	);
    	
    	$rand = array_rand($s, 4);
    	$c = 'csx_';
    	foreach ($rand as $v){
    		$c .= $s[$v];
    	}
    	
    	if($phone){
    		$phone = substr($phone, -5);
    		$c .= '_'.$phone;
    	}
    	return $c;
	}
	
	/**
	 * 在线解压缩文件 .zip
	 * @param String $filename zip压缩包路径
	 * @param String $path 解压目录
	 * @return Array array('code'=>状态码, 'msg'=>状态描述, 'ignore_file'=>解压失败文件列表)
	 */
	static function unzip($filename, $path) {

		$os = strtolower(PHP_OS);

		//先判断待解压的文件是否存在
		if(!file_exists($filename)){
			return array('code'=>100, 'msg'=>"文件 $filename 不存在！");
		}
		$starttime = explode(' ',microtime()); //解压开始的时间

		if($os == 'winnt'){
			//将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到
			$filename = autoCharset($filename, 'utf-8', 'gbk');
			$path = autoCharset($path, 'utf-8', 'gbk');
		}
		
		$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if($file_ext!='zip'){
			return array('code'=>101, 'msg'=>'压缩包文件类型必须为.zip'.$file_ext);
		}

		//打开压缩包
		$resource = zip_open($filename);
		
		$ignore_file = array();

		//遍历读取压缩包里面的一个个文件
		while ($dir_resource = zip_read($resource)) {
			//如果能打开则继续
			if (zip_entry_open($resource, $dir_resource)) {
				//获取当前项目的名称,即压缩包里面当前对应的文件名
				$file_name = $path.zip_entry_name($dir_resource);

				//以最后一个“/”分割,再用字符串截取出路径部分
				$file_path = substr($file_name,0,strrpos($file_name, "/"));
				//如果路径不存在，则创建一个目录，true表示可以创建多级目录
				if(!is_dir($file_path)){
					mkdir($file_path,0777,true);
				}
				//如果不是目录，则写入文件
				if(!is_dir($file_name)){
					//读取这个文件
					$file_size = zip_entry_filesize($dir_resource);
					//最大读取6M，如果文件过大，跳过解压，继续下一个
					if($file_size > 1024*1024*6){
						// 文件过大
						$ignore_file[] = $file_path.$file_name;
					}else{
						$file_content = zip_entry_read($dir_resource, $file_size);
						file_put_contents($file_name, $file_content);
					}
				}
				//关闭当前
				zip_entry_close($dir_resource);
			}
		}
		//关闭压缩包
		zip_close($resource);
		//$endtime = explode(' ',microtime()); //解压结束的时间
		//$thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
		//$thistime = round($thistime,3); //保留3为小数

		return array('code'=>200, 'msg'=>'解压完成，'.count($ignore_file).'个文件解压失败', 'ignore_file'=>$ignore_file);
	}

	/**
	 * 专题内容包自动解压并归档
	 * @param Int $id 专题编号
	 * @param String $zip_path 专题包文件路径
	 * @return Array
	 */
	static function special($id, $zip_path){
		if(!$id || !$zip_path){
			return array('code'=>400, 'msg'=>'参数错误');
		}
		$root_path = dirname(Yii::app()->basepath);
		$path = $root_path.'/uploads/special/'.$id;
		
		if(!is_dir($path) && !file_exists($path)){
			// 专题目录不存在，则先创建目录
			@mkdir($path, 755, true);
		}else{
			// 专题目录存在则删除
			self::delDirFile($path);
		}
		
		$unzip = self::unzip($zip_path, $path.'/');
		
		if($unzip['code']!=200) return $unzip;
		
		$unzip['zip_path'] = str_replace($root_path, '', $path);
		
		return $unzip;
	}
	
	/**
	 * 删除专题归档内容
	 * @param Int $id 专题编号
	 */
	static function specialDel($id){
		if(!$id){
			return array('code'=>400, 'msg'=>'参数错误');
		}
		
		$root_path = dirname(Yii::app()->basepath);
		$path = $root_path.'/uploads/special/'.$id;
		
		self::delDirFile($path);
	}
	/**
	* 获取所有图片文件
	* @param String $path 文件路径
	*/
	static function getImgs($path){
		$imgs = array();
		$content = file_get_contents($path);
		preg_match_all("/<img.*src\s*=\s*[\"|\']?\s*([^>\"\'\s]*)/i", $content, $matches);
		return $content;
	}
	/**
	* 遍历文件夹和文件
	*/
	static function read_all_dir ( $dir )
    {
        $result = array();
        $handle = opendir($dir);
        if ( $handle )
        {
            while ( ( $file = readdir ( $handle ) ) !== false )
            {
                if ( $file != '.' && $file != '..')
                {
                    $cur_path = $dir . DIRECTORY_SEPARATOR . $file;
                    if ( is_dir ( $cur_path ) )
                    {
                        $result['dir'][$cur_path] = self::read_all_dir ( $cur_path );
                    }
                    else
                    {
                        $result['file'][] = $cur_path;
                        $result['img'][] = self::getImgs($cur_path);
                    }
                }
            }
            closedir($handle);
        }
        return $result;
    }
}