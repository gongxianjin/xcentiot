<?php

return <<<EOT

$('input[type=submit]').click(function(){
    var data = $(".form-horizontal").serialize();
    var pos = $('.form-horizontal').attr('action');
    if(!pos) return false;
    $.ajax({
        type:'POST',
        url:pos,
        data:data,
        dataType:"json",
        success:function(data){
            if(data.code == 200){
                layer.msg(data.msg, 15, {
                    rate: 'top',
                    type: -1,
                    shade: false
                });
                window.location.href = data.forward;
            }else{
                layer.msg(data.msg, 15, {
                    rate: 'top',
                    type: -1,
                    shade: false
                });
                return false;
            }
        }
    });
});

function nameBlur(value){
    if (value ==''){
        layer.tips('请输入姓名', '#name',{tips:2});
    }else {checkval('name')}
}

function phonenumberBlur(value){
    if (value ==''){
        layer.tips('请输入手机号码', '#phone',{tips:2});
    }else {checkval('phone')}
};

function subjectBlur(value){
    if (value ==''){
        layer.tips('请输入主题', '#subject',{tips:2});
    }else {checkval('subject')}
};

function messageBlur(value){
    if (value ==''){
        layer.tips('请输入留言信息', '#message',{tips:2});
    }else {checkval('message')}
};

function checkval(id){
    var val = $("#"+id).val();
    if (!val){
        return false;
    }else {
        layer.closeAll('tips');
        return true;
    }
}


EOT;
?>