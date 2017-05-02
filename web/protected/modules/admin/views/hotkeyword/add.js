<?php
$df_title = Yii::app()->params['title'];
return <<<EOT
var input_handle;
function showSelectValue(data){
	var select_data = JSON.parse(data);
	select_data = select_data[0];
	input_handle.val(select_data.name);
	input_handle.siblings('input[type=hidden]').val(select_data.id);
}
$('.selectCate').click(function(){
	// 指定选择参数回传句柄
	input_handle = $(this);
	csx_layer_callback = showSelectValue;
	
	title = $(this).attr('title');
	$.layer({
	    type: 2,
	    shade: [0.2, '#eee'],// 遮罩层
	    border: [5, 1, '#ccc'], // 边框
	    fix: false,
	    title: title?title:'{$df_title}',
	    maxmin: true,
	    iframe: {src : $(this).attr('pos')},
	    area: ['800px' , '440px']
	}); 
});
EOT;
?>