<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title><?php echo Yii::app()->params['title']?></title>
	<link href="<?php echo yii::app()->request->baseurl?>/assets/admin/css/public.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
	#mainBox{padding:0;}
	.xubox_title{font-size:18px;}
	.iframSelect .csx_pointer{cursor:pointer;}
	</style>
</head>
<body>

<div id="dcWrap">
	<div id="dcMain" style="margin:0;padding:6px;">
	<!-- 当前位置 -->
	<?php echo $content; ?>
 	</div>
</div>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/static/json2.min.js"></script>
<script type="text/javascript" src="<?php echo yii::app()->request->baseurl?>/assets/admin/js/global.js"></script>
<script type="text/javascript">
//获取当前窗口索引
var layer_index = window.parent.layer.getFrameIndex(window.name);
$('.csx_pointer').click(function(){
	var data = {};
	var _tr = $(this).parent().get(0);
	var _attr = _tr.attributes;
	var _len = _attr.length;
	for(var i=0;i<_len;i++){
		data[_attr[i].name] = _attr[i].value;
	}
	if(window.parent['layer_close']){
		window.parent['layer_close'](layer_index, '['+ JSON.stringify(data) +']');
	}else{
		window.parent.layer.close(layer_index);
	}
});

$('.csx_multi_pointer').click(function(){
	var data = [];
	$('.iframSelect input[type=checkbox]').each(function(){
		var tmp = {};
		var _tr = $(this).parent().parent().get(0);
		var _attr = _tr.attributes;
		var _len = _attr.length;
		
		if(this.checked){
			for(var i=0;i<_len;i++){
				tmp[_attr[i].name] = _attr[i].value;
			}
			data.push(tmp);
		}
	});
	if(window.parent['layer_close']){
		window.parent['layer_close'](layer_index, JSON.stringify(data));
	}else{
		window.parent.layer.close(layer_index);
	}
});
</script>
</body>
</html>