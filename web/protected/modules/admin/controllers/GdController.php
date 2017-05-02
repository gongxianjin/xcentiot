<?php
class GdController extends Controller {
	
	private $os;
	
	function __construct($id, $module=null){
		
		parent::__construct($id, $module);
		
		$session_id = Yii::app()->request->getParam('sessionid');
		if($session_id){
			UserIdentity::autologinBySessionID($session_id);
		}
		
		$this->os = strtolower(PHP_OS);
	}
	
	protected function keditorMsg($status, $msg='', $url='', $name='', $size=0){
		$data = array('error'=>$status?1:0, 'message'=>$msg, 'url'=>$url, 'name'=>$name, 'size'=>$size);
		
		exit(json_encode($data));
	}

	protected function cmp_func($a, $b) {
		global $order;
		if ($a['is_dir'] && !$b['is_dir']) {
			return -1;
		} else if (!$a['is_dir'] && $b['is_dir']) {
			return 1;
		} else {
			if ($order == 'size') {
				if ($a['filesize'] > $b['filesize']) {
					return 1;
				} else if ($a['filesize'] < $b['filesize']) {
					return -1;
				} else {
					return 0;
				}
			} else if ($order == 'type') {
				return strcmp($a['filetype'], $b['filetype']);
			} else {
				return strcmp($a['filename'], $b['filename']);
			}
		}
	}

	/**
	 * 图片文件上传
	 */
	public function actionUpload(){
		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2', 'pdf'),
		);
		$dir_name = Yii::app()->request->getParam('dir');
		$dir_name = $dir_name ? $dir_name : 'image';
		
		if (empty($ext_arr[$dir_name])) {
			$this->keditorMsg(1, '目录名不正确。');
		}
		
		$attach = CUploadedFile::getInstanceByName('imgFile');
		
		if($attach->size > 3145728){
			$this->keditorMsg(1, '提示：文件大小不能超过3M');
		}
		
		$ext = strtolower(pathinfo($attach->getName(), PATHINFO_EXTENSION));
		if(!in_array($ext, $ext_arr[$dir_name])){
			$this->keditorMsg(1, '非法上传文件');
		}
		
		
		$upload_path = Yii::app()->params['img_upload_dir'];
		$save_path = $upload_path.'/temp';
		//检测目录是否存在
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
		$save_path .= '/'.$dir_name;
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
		$save_path .= '/'.date('Y-m');
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
		$save_path .= '/'.date('d');
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
		$save_path .= '/'.md5(time().rand(1, 1000)).'.'.$ext;
		
		if(!$attach->saveAs($save_path)){
			$this->keditorMsg(1, $attach->getError());
		}
		
		$file_path = str_replace($upload_path, '/uploads', $save_path);
		
		$this->keditorMsg(0, '', $file_path, $attach->getName(), $attach->getSize());
	}

	/**
	 * 图片文件管理
	 */
	public function actionFilemanager(){
		$php_path = Yii::app()->params['img_upload_dir'];
		$php_url = $this->createAbsoluteUrl('/').'/uploads';
		
		//根目录路径，可以指定绝对路径，比如 /var/www/attached/
		$root_path = $php_path . '/temp/';
		if (!file_exists($root_path)) {
			mkdir($root_path);
		}

		//根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
		$root_url = $php_url . '/temp/';
		//图片扩展名
		$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

		//目录名
		$dir = Yii::app()->request->getParam('dir');
		$path = Yii::app()->request->getParam('path');
		$order = Yii::app()->request->getParam('order');
		
		$dir_name = $this->os != 'linux' ? autoCharset($dir, 'utf8', 'gbk') : $dir;
		if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
			exit('Invalid Directory name.');
		}
		if ($dir_name !== '') {
			$root_path .= $dir_name . "/";
			$root_url .= $dir_name . "/";
				
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
		}

		//根据path参数，设置各路径和URL
		if (!$path) {
			$current_path = realpath($root_path) . '/';
			$current_url = $root_url;
			$current_dir_path = '';
			$moveup_dir_path = '';
		} else {
			$path = $this->os != 'linux' ? autoCharset($path, 'utf8', 'gbk') : $path;
			
			$current_path = realpath($root_path) . '/' . $path;
			$current_url = $root_url . $path;
			$current_dir_path = $path;
			$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
		}
		//echo realpath($root_path);
		//排序形式，name or size or type
		$order = !$order ? 'name' : strtolower($order);

		//不允许使用..移动到上一级目录
		if (preg_match('/\.\./', $current_path)) {
			echo 'Access is not allowed.';
			exit;
		}
		//最后一个字符不是/
		if (!preg_match('/\/$/', $current_path)) {
			echo 'Parameter is not valid.';
			exit;
		}
		//目录不存在或不是目录
		if (!file_exists($current_path) || !is_dir($current_path)) {
			echo 'Directory does not exist.';
			exit;
		}

		//遍历目录取得文件信息
		$file_list = array();
		if ($handle = opendir($current_path)) {
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;

				$file = $current_path . $filename;
				if (is_dir($file)) {
					$file_list[$i]['is_dir'] = true; //是否文件夹
					$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$file_list[$i]['filesize'] = 0; //文件大小
					$file_list[$i]['is_photo'] = false; //是否图片
					$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$file_list[$i]['is_dir'] = false;
					$file_list[$i]['has_file'] = false;
					$file_list[$i]['filesize'] = filesize($file);
					$file_list[$i]['dir_path'] = '';
					$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
					$file_list[$i]['filetype'] = $file_ext;
				}
				$file_list[$i]['filename'] = $this->os != 'linux' ? autoCharset($filename) : $filename; //文件名，包含扩展名
				$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				$i++;
			}
			closedir($handle);
		}

		usort($file_list, array(__CLASS__, 'cmp_func'));

		$result = array();
		//相对于根目录的上一级目录
		$result['moveup_dir_path'] = $this->os != 'linux' ? autoCharset($moveup_dir_path) : $moveup_dir_path;
		//相对于根目录的当前目录
		$result['current_dir_path'] = $this->os != 'linux' ? autoCharset($current_dir_path) : $current_dir_path;
		//当前目录的URL
		$result['current_url'] = $this->os != 'linux' ? autoCharset($current_url) : $current_url;
		//文件数
		$result['total_count'] = count($file_list);
		//文件列表数组
		$result['file_list'] = $file_list;

		//输出JSON字符串
		$this->ajaxReturn($result);
	}

	/**
	 * 图片管理文件删除
	 */
	public function actionFiledel(){
		$del_file = Yii::app()->request->getParam('url');
		$php_path = Yii::app()->params['img_upload_dir'];

		//根目录路径，可以指定绝对路径，比如 /var/www/attached/
		$root_path = $php_path . 'temp/';

		//根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
		$root_url = basename($php_path).'/temp/';

		if(!strstr($del_file, $root_url)){
			$this->ajaxReturn(array('status'=>100, 'msg'=>'非法删除文件'));
		}
		
		$root_path = dirname(Yii::app()->basePath);
		$del_file = $this->os != 'linux' ? autoCharset($del_file, 'utf8', 'gbk') : $del_file;
		if(!file_exists($root_path.$del_file)){
			$this->ajaxReturn(array('status'=>101, 'msg'=>'文件不存在'.$del_file));
		}

		if(!@unlink($root_path.$del_file)){
			$this->ajaxReturn(array('status'=>102, 'msg'=>'文件无法删除，请检查文件权限'));
		}
		$this->ajaxReturn(array('status'=>200, 'msg'=>'删除文件成功'));

	}
}