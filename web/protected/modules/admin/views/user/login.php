<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>先讯网站后台管理</title>
<link href="<?php echo yii::app()->request->baseurl?>/assets/static/favicon.ico" rel="shortcut icon"/>
<link href="<?php echo yii::app()->request->baseurl?>/assets/admin/css/public.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php echo $this->createUrl('user/login')?>" class="loginform">
<div id="login">
  <div class="dologo"></div>
  <ul>
   <li class="tips">请下载安装并使用<a href="http://download.firefox.com.cn/releases/stub/official/zh-CN/Firefox-latest.exe" target="_blank">火狐浏览器</a>以确保功能使用稳定流畅</li>
   <li class="inpLi"><b>用户名：</b><input type="text" name="username" class="inpLogin"></li>
   <li class="inpLi"><b>密码：</b><input type="password" name="password" class="inpLogin"></li>
<!--   <li class="vcodePic">-->
<!--     <div class="inpLi"><b>验证码：</b><input type="text" name="captcha" class="vcode"/></div>-->
<!--     <img id="captcha" src="--><?php //echo $this->createUrl('user/captcha', array('v'=>rand(1, 1000)))?><!--" alt="验证码" border="1" onClick="refreshimage()" title=""/>-->
<!--   </li>-->
   <li><input type="submit" name="submit" class="btn ajax-post" value="登录" target-form="loginform" callback="logState"/>&nbsp;&nbsp;&nbsp;&nbsp;<span class="error"></span></li> 
  </ul>
</div>
</form>

<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/admin/js/global.js"></script>
<script type="text/javascript">
function logState(rs){
	if(!rs){
		refreshimage();
	}else{
		window.location.href = rs.forward;
	}
}
</script>
</body>
</html>