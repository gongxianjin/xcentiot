<?php
$df_title = Yii::app()->params['title'];
$fileManager = $this->createUrl('gd/filemanager');
$fileDelete = $this->createUrl('gd/filedel');
$upload = $this->createUrl('gd/upload');
$url = $this->createUrl('special/del_path');
return <<<EOT
var input_handle;
function showSelectValue(data){
	var select_data = JSON.parse(data);
	select_data = select_data[0];
	input_handle.val(select_data.name);
	input_handle.siblings('input[type=hidden]').val(select_data.id);
}
//$(".simpleUFile").click(function(){
//
//	var file = $("#file").val();
//	var data = 'file='+file;
//	//alert(data);return false;
//	$.post("{$url}", data, function(json){
//	    alert(json.msg);
//		if (json.code != 200){
//			$(".error").css('color', 'red').html(json.msg);
//		}else{
//			$(".error").css('color', '#6abcda').html('删除成功');
//			setTimeout(function(){
//				window.location.href = json.forward;
//			}, 400);
//		}
//	});
//
//});
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
$("#type").change(function () {
    if($("#type").val()==1){

        $(".wanzheng").show();
        $(".jiandan").hide();
    }else{
        $(".wanzheng").hide();
        $(".jiandan").show();
    }
});
$(function(){
    if($("#type").val()==1){

        $(".wanzheng").show();
        $(".jiandan").hide();
    }else{
        $(".wanzheng").hide();
        $(".jiandan").show();
    }
})

//分类上传logo
function showUploadImg(box, url, title){
	$(box).siblings('input[type=hidden]').val(url);
	var prevImg = $(box);
	var img = $('<img/>');
	img.attr({
		src: url,
		alt: title,
		width:prevImg.width(),
		height:prevImg.height()
	});
	prevImg.children().remove();
	prevImg.append(img);

	prevImg.removeClass('noheader').addClass('header');
}

KindEditor.ready(function(K) {
	var editor = K.editor({
		fileManagerJson : '{$fileManager}',
		fileDeleteJson : '{$fileDelete}',
		uploadJson : '{$upload}',
		allowFileManager : true,
		selectMultiFile : true
	});
	/* 商品图片  */
	K('.simpleUFile').click(function() {
		var _self = K(this);
		editor.loadPlugin('insertfile', function() {
			editor.plugin.fileDialog({
				clickFn : function(url, title) {
					url = url.split(',');
					showUploadImg(_self, url[0], title);
					editor.hideDialog();
				}
			});
		});
    K('#path').val(' ');
	});
});
EOT;
?>
