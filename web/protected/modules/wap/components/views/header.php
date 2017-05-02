<!-- 导航 -->
<div class="z_container z_menu">
	<div class="z_logo"><img src="/assets/wap/images/logo.png" alt=""></div>
	<a href="#" class="z-nav-btn"><img src="/assets/wap/images/nav_btn.png" alt=""></a>
</div>
<div class="z_menu_clear"></div>
<div class="z-menu-con">
	<ul class="">
		<li><a  app_target="_blank"  <?php if(Yii::app()->getController()->id=='index'):?> class="on" <?php endif;?> href="<?php echo Yii::app()->createAbsoluteUrl('/wap')?>">首页<span></span></a></li>
		<?php foreach($nav as $v):?>
			<?php if($v->csc_show):?>
				<li>
					<a app_target="_blank" <?php if(Yii::app()->getController()->id==$v->csc_pinyin):?> class="on" <?php endif;?> href="<?php echo Yii::app()->createUrl('/wap/'.$v->csc_pinyin.'/index')?>"><?php echo $v->csc_name?><span></span></a>
				</li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>
<!-- 导航 end -->
