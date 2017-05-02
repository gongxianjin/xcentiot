<?php
    $df_title = Yii::app()->params['title'];
$fileManager = $this->createUrl('gd/filemanager');
$fileDelete = $this->createUrl('gd/filedel');
$upload = $this->createUrl('gd/upload');
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
});

EOT;
?>