<?php
return <<<EOT
$(function(){
	$('.spxiq li').click(function(){
		$(this).addClass('on').siblings().removeClass('on');
		if($(this).index()==2){
			$(this).find('span').attr('style','color:#fff');
		}else{
			$('#num_color').attr('style','color:#e74e40');
		}
	});
})

EOT;
?>
