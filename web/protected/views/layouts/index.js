
<?php
$url = $this->createUrl('site/search');
return <<<EOT
jQuery(".nav").slide({
        type:"menu", //效果类型
        titCell:".m", // 鼠标触发对象
        targetCell:".sub", // 效果对象，必须被titCell包含
        effect:"slideDown",//下拉效果
        delayTime:300, // 效果时间
        triggerTime:0, //鼠标延迟触发时间
        //returnDefault:true  //返回默认状态
    });

jQuery(".slideBox").slide({
    mainCell:".bd ul",effect:"fold", autoPlay:true, delayTime:300
    });

jQuery(".sb").slide({
    mainCell:".bdd ul",effect:"leftLoop", autoPlay:true, delayTime:200
    });



$("#sub").click(function(){
	var search = $("#Header1_txbsearch").val();
	var data = 'sword='+search
	alert(data);return false;
	$.post("{$url}", data, function(json){
		if (json.code != 200){
			alert('没有相关文章');
		}else{
			setTimeout(function(){
				window.location.href = json.forward;
			}, 400);
		}
	});

});

jQuery(".ladyScroll03").slide({ mainCell:".dlList", effect:"leftLoop",vis:1});

EOT;
?>