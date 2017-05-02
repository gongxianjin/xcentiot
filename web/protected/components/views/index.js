<?php
return <<<EOT

$('.z_detail').click(function(){
	var pos = $(this).attr('pos');
	$.ajax({
		type: "POST",
		url: pos,
		data: '',
		success: function(rs){
			if(rs.code!=200) {
				alert(rs.msg);
				return;
			}else{
				$('.scrollWrap div').remove();
				var div = $('<div class="dlList"></div>');
				for(var i=0;i<rs.data.imgs.length; i++){
					if(i>=rs.data.imgs.length) break;
					div.append('<dl><div class="z_teacherImg1"><div class="z_teacherImg2"><img src="'+rs.data.imgs[i]+'" /></div></div></dl>');
				}
				$('.scrollWrap').append(div);
				$('.z_tjsR').html(rs.data.desc);
				$('.tname').text(rs.data.name);
				$('.z_teacherD3').show();
				slide();
			}
		}
	});
});
function slide(){
	jQuery(".ladyScroll03").slide({ mainCell:".dlList", effect:"leftLoop",vis:1});
}

EOT;
?>