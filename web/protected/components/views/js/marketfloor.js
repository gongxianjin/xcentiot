<?php
return <<<EOT
$(function(){
	$('.tjsp li:not(.more)').hover(function(){
		var index = $(this).index();
		
		$(this).parent().parent().next().find('.djcs_r_shpin').hide().eq(index).show();
		
		if($(this).hasClass('more')){
			$(this).siblings().removeClass('on');
		}else{
			$(this).addClass('on').siblings().removeClass('on');
		}
		
		
	},function(){});
	
	$('.youti li').hover(function(){
		$('.youzong').hide().eq($(this).index()).show();
		$(this).addClass('rx1').siblings().removeClass('rx1');
	},function(){});
	
	$('.you_l li').hover(function(){
		$(this).parent().siblings('.you_lo').hide().eq($(this).index()).show();
	},function(){});
	
});


EOT;
?>