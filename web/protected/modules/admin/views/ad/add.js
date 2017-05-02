<?php
$fileManager = $this->createUrl('gd/filemanager');
$fileDelete = $this->createUrl('gd/filedel');
$upload = $this->createUrl('gd/upload');
$flashUpload = $this->createUrl('gd/upload',array('dir'=>'flash'));
		
$df_title = Yii::app()->params['title'];
return <<<EOT
var input_handle;
function showSelectValue(data){
	var select_data = JSON.parse(data);
	select_data = select_data[0];
	$('#pos_name').val(select_data.name);
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

laydate({
	elem: '#form .laydate',
	festival: true,
	istoday:true
});
laydate.skin('huanglv');

function showUploadImg(box, url, title){
	$(box).siblings('input[type=hidden]').val(url);
	var prevImg = $(box);
	var img = $('<img height="108" alt=""/>');
	img.attr({
		src: url,
		alt: title
	});
	prevImg.children().remove();
	prevImg.append(img);
	
	prevImg.removeClass('noheader').addClass('header');
}

function showUploadFlash(box, url, title){
	$(box).siblings('input[type=hidden]').val(url);
	var prevImg = $(box).siblings('.simpleUFlash');
	var flash = $('<embed height="100" border="0" align="middle" wmode="opaque" src="'+url+'">');
	prevImg.children().remove();
	prevImg.append(flash);
	
	prevImg.removeClass('nosflash').addClass('sflash');
}

KindEditor.ready(function(K) {
	var editor = K.editor({
		fileManagerJson : '{$fileManager}',
		fileDeleteJson : '{$fileDelete}',
		uploadJson : '{$upload}',
		allowFileManager : true,
		selectMultiFile : true
	});
	/* 图片  */
	K('.simpleUImg').click(function() {
		var _self = K(this);
		editor.loadPlugin('image', function() {
			editor.plugin.imageDialog({
				clickFn : function(url, title) {
					url = url.split(',');
					showUploadImg(_self, url[0], title);
					editor.hideDialog();
				}
			});
		});
	});
	
	/* FLASH  */
	var uploadbutton = K.uploadbutton({
		button : K('#simpleUFlash')[0],
		fieldName : 'imgFile',
		url : '{$flashUpload}',
		afterUpload : function(data) {
			if (data.error === 0) {
				showUploadFlash('#simpleUFlash', data.url);
			} else {
				alert(data.message);
			}
		},
		afterError : function(str) {
			alert('系统错误 ');
		}
	});
	uploadbutton.fileBox.change(function(e) {
		uploadbutton.submit();
	});
	
	$('select[name=type]').change(function(){
		$('tr.ad_meta').hide().eq(this.value).show();

		$('tr.ad_meta input').attr('disabled', 'disabled');
		$('tr.ad_meta:eq('+this.value+') input').removeAttr('disabled');
		
	}).trigger('change');
});


EOT;
?>