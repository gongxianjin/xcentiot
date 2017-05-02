<?php
include_once dirname(dirname(__FILE__)).'/components/SetupApi.php';

$ini = SetupApi::getInfo('site_setup');
$admin_custom = is_array($ini) ? $ini : array();

$df_custom = array(
	'confuse' => 'awefFWGR@#(^*(#JLFHEW*&TFIEF',
	'cookie'=>array(
		'path' => '/',
		'domain' => '',
		'secure' => false,   // 是否是安全链接：https
		'httpOnly' => false, // 允许JS脚本获取COOKIE信息
	),
	'title' => '欢迎使用先讯CMS管理平台',
	'mb_nav_first' => '先讯 管理中心',
	// 网站前台页面默认信息配置
	'site'=>array(
		'title' => '', //标题
		'keyword' => '', //关键字
		'description' => '', //描述
        'record' => '', //备案
		'copy' => '', //版权
        'address' => '成都', //地址
        'school' => '', //学校
		'vision' => '', //愿景
		'mission' => '', //使命
		'motto' => '', //校训
		'values' => '', //价值
		'slogan' => '', //口号
		'email' => '', //邮编
		'wechat' => '', //微信
		'crate'=>'',//连续续班率
        'phone' => '400-008-2811', //咨询热线
        'client_phone' => '', //客服热线，多个逗号隔开
		'client_mail' => '', //客服邮箱，多个逗号隔开
		'gd_type'=>array(''),// 年级种类
		'act_address'=>array(''),//活动地点
	),
	
	'default_master' => array(
		'user' => 'admin', // 默认管理员帐户名
		'tname' => '默认管理员', // 默认管理员名字
		'passwd' => 'admin',// 默认管理员密码
	),
	'default_store' => array(
		'enabled'=>true, // 配置是否启用超级店铺店铺
		'user' => 'admin', // 超级店铺帐户名
		'tname' => '超级店铺', // 超级店铺名字
		'passwd' => '123456',// 超级店铺密码
		'phone' => '15828619356', // 超级店铺电话
	),
	
	'default_site_id' => '267',//默认站点在成都267 南充277

    // 状态
    'enabled' => array('关闭', '启用'),

	'lock'=>array('未锁定', '已锁定'),
	
	// 文件上传根目录    Yii::app()->basepath
	'img_upload_dir' => dirname(dirname(dirname(__FILE__))).'/uploads',
	
	'user_type' => array('0'=>'普通会员', '1'=>'商家'),
	// 会员性别
	'user_sex' => array('0'=>'未知', 'F'=>'男', 'M'=>'女'),
	// 会员状态
	'locked' => array('0'=>'未锁定', '1'=>'锁定'),
	// 广告类型
	'ad_type' => array('图片', 'FLash', '代码', '文字'),
	// 分类节点类型
	'category_type' => array(
		'1'=>'解决方案',
		'2'=>'产品展示',
		'3'=>'关于我们',
	    '4'=>'联系我们',
    ),
    // 分类推荐位
	'cate_column' => array('home_notice'=>'首页网站公告', 'page_footer'=>'页面底部'),
    
	'category_show' => array('1'=>'显示', '0'=>'不显示'),

	'category_recom' => array('0'=>'不推荐', '1'=>'推荐'),

	//多站点
	'master_site' => array('0'=>'站点1', '1'=>'站点2'),
	
	//导航设置配置
	'nav_location' =>array('0'=>'顶部','1'=>'主导航','2'=>'底部'),
	//后台数据默认分页数量
	'pages'=>20,
    
    //手机端二次加载分页数量
    'wap_pages' => 5,
	// 商品状态
	'goods_status'=>array('-1'=>'禁售', '0'=>'下架', '1'=>'上架'),
	//包邮
	'goods_free_maill'=>array('0'=>'否', '1'=>'是'),
	//热销
	'goods_hot'=>array('0'=>'否', '1'=>'是'),
	//精品
	'goods_fine'=>array('0'=>'否', '1'=>'是'),
	//新品
	'goods_new'=>array('0'=>'否', '1'=>'是'),
	//特价
	'goods_special'=>array('0'=>'否', '1'=>'是'),
    //满赠
	'full_gift'=>array('0'=>'否', '1'=>'是'),
	//促销类型
	'di_type' => array('0'=>'打折', '1'=>'满减'),
	//关联分区编号
	'asscate' => array('1'=>1, '2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6, '7'=>7, '8'=>8, '9'=>9, '10'=>10),
	// 图片缩略图配置
	'img_thumb'=>array(
		// 套餐图片大小
		'goods' => array(
			'small' => array('width'=>100, 'height'=>100),
			'thumb' => array('width'=>230, 'height'=>230),
		),
		// 文章图片
		'article' => array(
			'small' => array('width'=>100, 'height'=>100),
			'thumb' => array('width'=>500, 'height'=>500),
		),
		// 用户头像
		'user_header'=>array(
			'normal'=> array('width'=>200, 'height'=>200),
		),

	),
	'csc_type'=>array('goods'=>'商品收藏','store'=>'店铺收藏'),
	
	// 提现转帐方式
	'cash_type'=>array(1=>'银行转帐',2=>'支付宝转帐'),
	
	// 支付种类
	'pay_type'=>array(
		'cash_delivery'=>'货到付款', 'alipay'=>'支付宝-即时到帐', 'alipay_bank'=>'支付宝-网银', 'unionpay'=>'银联在线', 'wxpay'=>'微信支付',
	),
	

	// 邮件配置
	'mailer' => array(
		'smtpHost' => 'smtp.qq.com',
		'smtpPort' => 25,
		'delimiter' => '{}',	//分隔符 smtpUser mailFormEmail
		'smtpUser' => 'geek@jiuaoedu.com',
		'smtpPass' => 'Jk123123123',
		'mailFormEmail' => 'geek@jiuaoedu.com',
		'mailFormName' => '极客数学',
	),
	
	/* 短信接口配置 */
    'md_sms' => array(
    	'sdk'=>'',
    	'pwd'=>'',
    	'sign'=>'【先讯】',// 短信签名
	),
	
	'QQloging' => array(
		'appid'=>'101239232',
		'appkey'=>'28d725d6d53d4e25967b32d825dd47d3',
		'state'=>'2343dk390d*(KJSdikdfl9823d',// 防CSRF攻击串
	),
	// 短信发送内容配置模版
	'sms_tpl'=>array(
		'member_reg'=>'您的注册验证码是：{NUM}',
		'member_reg_success'=>'您已成功注册为本站会员，帐号：{USER} 密码:{PWD},请及时登陆帐号并修改密码。本条短信请勿转发',
		'order_fh' => '您的订单({ORDER_ID})商家已成功发货，{LOGISTICS_NAME}：{LOGISTICS_NUM}。本条短信请勿转发',
		'member_phone' => '{USER},你好!你的短信验证码是:{CODE}。本条短信请勿转发',
		'reg_tip'=>'用户{USER}已完成注册，手机号：{PHONE}，请及时联系客户。',
		'editinfo'=>'你好，修改资料验证码为：{CODE}。本条短信请勿转发。',
	),
	
	//快递公司
	'Express_name' => array(
		'yuantong' => '圆通速递',
		'shunfeng' => '顺丰快递',
		'yunda' => '韵达快运',
	),

);


return array_merge($df_custom, $admin_custom);