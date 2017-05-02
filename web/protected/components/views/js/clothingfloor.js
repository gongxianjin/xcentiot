<?php
return <<<EOT

$('.fzc_fz_t li').hover(function(){
	var fcid = $(this).attr('f_cid');
	$(this).addClass('you').removeClass('chen');
	$(this).siblings().addClass('chen').removeClass('you');
	$('.tipic').hide();
	$('.tipic[f_cid='+fcid+']').show();
	
},function(){});


EOT;
?>