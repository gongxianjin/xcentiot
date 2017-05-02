<?php
return <<<EOT
$(function(){
	$('.sjsm_t .pjo_r li').hover(function(){
		ul_cls = $(this).attr('ul_cls');
		box_num = $(this).attr('box_num');
		
		$(this).addClass('on').siblings().removeClass('on');
		
		$(".box_"+ box_num +" .nei_c").each(function(){
			if($(this).attr('ul_cls') == ul_cls){
				$(this).css('display', 'block');
			}else{
				$(this).css('display', 'none');
			}
		});
		$(".box_"+ box_num +" .nei_r").each(function(){
			if($(this).attr('ul_cls') == ul_cls){
				$(this).css('display', 'block');
			}else{
				$(this).css('display', 'none');
			}
		});
	});
	
})


EOT;
?>