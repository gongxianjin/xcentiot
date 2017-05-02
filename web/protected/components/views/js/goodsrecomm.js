<?php
return <<<EOT
$(function(){
	$('.L_xq_lyk a').click(function(e){
		e.stopPropagation();
		$('#comment_list').load($(this).attr('href'));
		return false;
	});
	
	$('.L_xq_lyk h5 a').click(function(e){
		e.stopPropagation();
		$(this).addClass('L_xq_dq9').siblings().removeClass('L_xq_dq9');
	});
	
})

EOT;
?>

spxiq