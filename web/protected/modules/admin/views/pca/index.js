<?php
$url = yii::app()->createUrl('admin/pca/select');
$site = yii::app()->createUrl('admin/pca/site');
return <<<EOT
select_pca();

function select_pca(){
	$('.prc').find('.img').unbind('click').click(function(){
		var _this = $(this);
		var ids = $(this).parent().attr('ids');
		var pid = $(this).parent().attr('pid');
		var _class = $(this).parent().parent().attr('class');

		$('.'+ids).remove();
		
		if($(this).hasClass('on')){
			
			//关闭
			$(this).removeClass('on');
			
		}else{
			
			//打开下一级
			$.post('{$url}','ids='+ids, function(rs){
				if(rs.code!=200){
					alert(rs.msg);
					return;
				}
				
				_this.addClass('on');
				/*追加地区*/
				if(rs.data==null) return;
				
				for(var i=rs.data.length-1; i>=0; i--){
					
					var site = '';
					var margin = 40;
					if(rs.data[i].csc_type=='city'){
						if(rs.data[i].csc_site==0){
							var site = '<a href="{$site}'+'?ids='+rs.data[i].csc_id+'">开通站点</a>';
						}else{
							var site = '<a style="color:red" href="{$site}'+'?ids='+rs.data[i].csc_id+'">已开通</a>';
						}
					}else if(rs.data[i].csc_type=='area'){
						margin = 80;
					}
					
					var html = '<tr class="'+_class+' '+ids+'">'
						+'<td ids="'+rs.data[i].csc_id+'" pid="'+ids+'">'
						+'<span style="margin-left:'+margin+'px;" class="img">&nbsp;&nbsp;&nbsp;</span>'
						+'<span style="margin-left:'+20+'px;">'+rs.data[i].csc_name+'</span>'
						+'</td>'
						+'<td>'+rs.data[i].csc_pinyin+'</td>'
						+'<td>'+site+'</td>'
						+'</tr>';
					_this.parent().parent().after(html);
				}
				select_pca();
		
			});
		}
	});
}



	
EOT;
?>