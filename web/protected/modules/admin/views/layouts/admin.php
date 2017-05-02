<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php echo Yii::app()->params['title']?></title>
<link href="<?php echo yii::app()->request->baseurl?>/assets/static/favicon.ico" rel="shortcut icon"/>
<link href="<?php echo yii::app()->request->baseurl?>/assets/admin/css/public.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<style>
	#menu li em span{padding: 5px;background: red;float:right;border-radius: 50%; display: inline-block;margin:15px 18px;}
</style>

<div id="dcWrap"> 
	<!--头部导航开始-->
	<div id="dcHead">
		<div id="head">
			<div class="logo">
				<a href="<?php echo Yii::app()->createAbsoluteUrl('/')?>" target="_blank"><img alt="logo" src="<?php echo Yii::app()->request->baseurl?>/assets/admin/images/xcent.gif"/></a></div>
			<div class="nav">
				<ul>
				    <li class="M" style="display:none;"><a class="topAdd" href="JavaScript:void(0);">新建</a>
				     <div class="drop mTopad">
				     	<a href="">商品</a>
				     	<a href="article.php?rec=add">文章</a>
				     	<a href="nav.php?rec=add">自定义导航</a>
				     	<a href="show.php">首页幻灯</a>
				     </div>
				    </li>
				    <li><a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('/')?>">查看站点</a></li>
				    <li><a href="<?php echo $this->createUrl('setup/clear')?>">清除缓存</a></li>
				    <li class="noRight"></li>
				</ul>
				<ul class="navRight">
				    <li class="M noLeft"><a href="JavaScript:void(0);">您好，<?php echo Yii::app()->session['sysuser_user']?></a>
				     <div class="drop mUser"> <a href="<?php echo $this->createAbsoluteUrl('user/passwd')?>">修改密码</a> </div>
				    </li>
				    <li class="noRight"><a href="<?php echo $this->createAbsoluteUrl('user/logout')?>">退出</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!--头部导航结束-->
	<!-- 后台菜单 -->
	<div id="dcLeft">
		<div id="menu">
			<ul class="top">
				<li><a href="<?php echo $this->createUrl('/admin')?>"><i class="home"></i><em>管理首页</em></a></li>
			</ul>
			<?php if($this->checkOperModule('sysrole')):?>
				<ul>
					<li <?php if('sysrole'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('sysrole/')?>"><i class="system"></i><em>权限管理</em></a></li>
				</ul>
            <?php endif;?>

            <?php if($this->checkOperModule('manager')):?>
                <ul>
                    <li <?php if('manager'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('manager/')?>"><i class="manager"></i><em>管理员管理</em></a></li>
                </ul>
            <?php endif;?>
			<?php if($this->checkOperModule('adpos')):?>
				<ul>
					<li <?php if('adpos'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('adpos/')?>"><i class="show"></i><em>广告位管理</em></a></li>
				</ul>
			<?php endif;?>
            <?php if($this->checkOperModule('ad')):?>
                <ul>
                    <li <?php if('ad'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('ad/')?>"><i class="page"></i><em>广告管理</em></a></li>
                </ul>
            <?php endif;?>
			<?php if($this->checkOperModule('category')):?>
				<ul>
					<li <?php if('category'==$this->nav || 'attr'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('category/')?>"><i class="productCat"></i><em>分类信息管理</em></a></li>
				</ul>
			<?php endif;?>

			<?php /*if($this->checkOperModule('goods')):*/?><!--
			<ul>
				<li <?php /*if('goods'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('goods/')*/?>"><i class="product"></i><em>教师信息管理</em></a></li>
			</ul>
			--><?php /*endif;*/?>

			<?php if($this->checkOperModule('article')):?>
				<ul>
					<li <?php if('article'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('article/')?>"><i class="link"></i><em>文章信息管理</em></a></li>
				</ul>
			<?php endif;?>

			<?php if($this->checkOperModule('feedback')):?>
				<ul>
					<li <?php if('feedback'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('feedback/')?>"><i class="link"></i><em>留言信息管理</em></a></li>
				</ul>
			<?php endif;?>

<!--		<?php /*if($this->checkOperModule('donorman')):*/?>
				<ul class="bot">
					<li <?php /*if('donorman'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('donorman/')*/?>"><i class="guestbook"></i><em>捐助管理</em></a></li>
				</ul>
			--><?php /*endif;*/?>

			<?php /*if($this->checkOperModule('exam')):*/?><!--
				<ul>
					<li <?php /*if('exam'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('exam/')*/?>"><i class="guestbook"></i><em>测试科目管理</em></a></li>
				</ul>
			--><?php /*endif;*/?>

			<?php /*if($this->checkOperModule('examlog')):*/?><!--
				<ul class="bot">
					<li <?php /*if('examlog'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('examlog/')*/?>"><i class="guestbook"></i><em>测试结果管理<?php /*if($this->tests):*/?><span class="on"></span><?php /*endif;*/?> </em></a></li>
				</ul>
			--><?php /*endif;*/?>

<!--			<?php /*if($this->checkOperModule('order')):*/?>
				<ul class="bot">
					<li <?php /*if('order'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('order/')*/?>"><i class="guestbook"></i><em>预约管理 <?php /*if($this->news):*/?><span class="on"></span><?php /*endif;*/?> </em></a></li>
				</ul>
			--><?php /*endif;*/?>

<!--			<?php /*if($this->checkOperModule('special')):*/?>
                            <ul>
                                <li <?php /*if('special'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /* echo $this->createAbsoluteUrl('special/')*/?>"><i class="link"></i><em>专题活动管理</em></a></li>
                            </ul>
			--><?php /*endif;*/?>

			<?php if($this->checkOperModule('setup')):?>
                <ul>
                    <li <?php if('setup'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('setup/')?>"><i class="system"></i><em>系统设置</em></a></li>
                </ul>
            <?php endif;?>

            <?php if($this->checkOperModule('operlog')):?>
                <ul>
                    <li <?php if('operlog'==$this->nav):?>class="cur"<?php endif;?>><a href="<?php echo $this->createAbsoluteUrl('operlog/')?>"><i class="article"></i><em>操作日志</em></a></li>
                </ul>
            <?php endif;?>

<!--            <?php /*if($this->checkOperModule('customers')):*/?>
                <ul class="bot">
                    <li <?php /*if('customers'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('customers/')*/?>"><i class="guestbook"></i><em>留言反馈（客户）</em></a></li>
                </ul>
            --><?php /*endif;*/?>

           <!-- <?php /*if($this->checkOperModule('feiyong')):*/?>
                <ul class="bot">
                    <li <?php /*if('feiyong'==$this->nav):*/?>class="cur"<?php /*endif;*/?>><a href="<?php /*echo $this->createAbsoluteUrl('feiyong/')*/?>"><i class="guestbook"></i><em>费用评估</em></a></li>
                </ul>
            --><?php /*endif;*/?>

		</div>
	</div>
	<!--左侧菜单结束-->
	<div id="dcMain"> 
	
	
	<!-- 当前位置 -->
	<?php echo $content; ?>
 	</div>
	<div id="dcFooter">
 		<div id="footer">
	  		<div class="line"></div>
	 		<ul><li>版权所有 © 成都先讯物联网技术有限公司，并保留所有权利。</li></ul>
 		</div>
	</div>

</div>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/static/json2.min.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/admin/js/global.js"></script>
<script type="text/javascript">
$('td').hover(function(){
	$(this).parent().css('background', '#eeeeee');
},function(){
	$(this).parent().css('background', '');
});
setInterval(function(){
	$.get('<?php echo $this->createUrl('user/heart')?>', '');
}, 5000);
</script>
</body>
</html>