<?php
return <<<EOT
$(function(){
	jQuery("#l_latelyDeal").slide({titCell:".l_hd ul", mainCell:".l_bd ul", effect:"leftLoop", autoPage:true, autoPlay:true, vis:3})
})

EOT;
?>