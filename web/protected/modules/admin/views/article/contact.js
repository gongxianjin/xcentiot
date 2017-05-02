<?php
$url = $this->createUrl('article/pca');
$ur = $this->createUrl('article/faqcity');
return <<<EOT

$(document).ready(function(){

        // 选择不同的省的时候
    $("#provice").change(function(){
        var provice = $("#provice").val();

            // 省份不为0时点击的时候需要将city和town都清空
            // 省份点击 ’请选择‘的时候也需要将city和town清空，
            // 如果不清空会出现选‘请选择'的时候第三个下拉框还会有上一次保留的值
        if (provice != 0) {
            $.ajax({
                type: "POST",
                url: "{$url}",
                data: "provice="+provice,
                success: function(msg){
                    $("#city").css("display", "");
                    $("#city").empty();
                    $("#city").append(msg);
                }
            });
        } else {
                $("#city").css("display", "none").empty();
        }
    });
    //$("#submit").click(function(){
    //    var city = $("#city").val();
    //    var data = 'pca_id='+ ;
    //    //alert(data);return false;
    //    $.post("{$ur}", data, function(json){
    //        alert(json);
    //            setTimeout(function(){
    //                window.location.href = json.forward;
    //            }, 400);
    //
    //    });
    //});
    //$('#submit').click(function(){
    //
    //    var strs= new Array();
    //    //定义一数组
    //    var str=$("#city").val(); //这是一字符串
    //    if (str != 0) {
    //        $.ajax({
    //            type: "POST",
    //            url: "{$ur}",
    //            data: "pca_id="+str,
    //            success: function(msg){
    //                strs=msg.split(","); //字符分割
    //                for(var i=0;i<(strs.length-1);i+=2){
    //                    setMapCenter(strs[i],strs[i+1]);
    //
    //                }
    //            }
    //        });
    //    }
    //
    //});
})
EOT;
?>