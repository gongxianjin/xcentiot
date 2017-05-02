<?php
//$url = $this->createUrl('test/index');
//$urlgd = $this->createUrl('site/gd');
return <<<EOT

$(function(){
    $('#carousel-example-generic ol li').on('mouseover', function() {
        var slideToNum = parseInt($(this).attr('data-slide-to'));
        $('.carousel').carousel(slideToNum);
    });
})

function mytest(){
    window.location.href = '{$url}';
}

function myanswer(){
    window.location = 'http://wpa.qq.com/msgrd?v=3&uin=616132756&site=qq&menu=yes';
}

$(function(){

    $('#order').click(function(){
        pos = $(this).attr('pos');
        data = $('.home-select').find('input,select,textarea').serialize();
        $.ajax({
            type:'POST',
            url:pos,
            data:data,
            dataType:"json",
            success:function(data){
                if(data.code == 200){
                    alert(data.msg);
                    window.location.href = data.forward;
                }else{
                    alert(data.msg);
                }
            }
        });
    });
})

$("#school").change(function(){
    var school = $("#school").val();
    // 学校不为-1时点击的时候需要将gd都清空
    // 学校点击 ’请选择‘的时候也需要将gd清空，
    // 如果不清空会出现选‘请选择'的时候第三个下拉框还会有上一次保留的值
    if (school != -1) {
        $.ajax({
            type: "POST",
            url: "{$urlgd}",
            data: "school="+school,
            success: function(data){
                $("#gd").css("display", "");
                $("#gd").empty();
                $("#gd").append(data);
            }
        });
    } else {
        $("#gd").css("display", "none").empty();
    }
});


EOT;
?>