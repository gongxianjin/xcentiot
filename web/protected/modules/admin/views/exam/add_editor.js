<?php
$df_title = Yii::app()->params['title'];
$FileManager = $this->createAbsoluteUrl('gd/filemanager');
$FileDelete = $this->createAbsoluteUrl('gd/filedel');
$Upload = $this->createAbsoluteUrl('gd/upload');
$session_id = Yii::app()->getSession()->getSessionID();

$url = $this->createUrl('profile/feedback');
return <<<EOT
//实例化编辑器
KindEditor.ready(function(K) {
	var editor = K.editor({
		fileManagerJson : '{$FileManager}',
		fileDeleteJson : '{$FileDelete}',
		uploadJson : '{$Upload}',
		allowFileManager : true,
		selectMultiFile : true
	});
    //初始化
    K.create('.editor_id', {
		fileManagerJson : '{$FileManager}',
		fileDeleteJson : '{$FileDelete}',
		uploadJson : '{$Upload}',
		selectMultiFile : true,
		allowFileManager : true,
		//autoHeightMode : true,
		afterCreate : function() {
			this.loadPlugin('autoheight');
		},
		afterBlur:function(){
        	this.sync();
        },
		extraFileUploadParams : {sessionid : '{$session_id}'}
	});
});

var input_handle;
function showSelectValue(data){
	var select_data = JSON.parse(data);
	select_data = select_data[0];
	input_handle.val(select_data.name);
	input_handle.siblings('input[type=hidden]').val(select_data.id);
}


EOT;
?>