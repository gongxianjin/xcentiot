// JavaScript Document
$(document).ready(function(e) {
		var innerW = $(window).width();//获取屏幕宽度
		var innerH = $(window).width()/(750/320);//根据图片的比值（W/H）计算高度
		$(".T_topbanner,.main_image").css("height",innerH);
		$(".T_topbanner ul li img").css("width",innerW);
		$(".T_topbanner ul li img").css("height",innerH);
		$(".flicking_inner").css("top",innerH-40);
		
        $(".main_visual").hover(function(){
            $("#btn_prev,#btn_next").fadeIn();
        },function(){
            $("#btn_prev,#btn_next").fadeOut();
        });
        $dragBln = false;
        $(".main_image li").each(function(i){
            $(".flicking_inner").append("<a href=\"javascript:;\">"+(i+1)+"</a>");
        });
        $(".main_image").touchSlider({
            flexible : true,
			btn_prev: $("#btn_prev"),
			btn_next: $("#btn_next"),
            speed : 200,
            paging : $(".flicking_con a"),
            counter : function (e) {
                $(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
            }
        });
        $(".main_image").bind("mousedown", function() {
            $dragBln = false;
        });
        $(".main_image").bind("dragstart", function() {
            $dragBln = true;
        });
        $(".main_image a").click(function() {
            if($dragBln) {
                return false;
            }
        });
        timer = setInterval(function() { $("#btn_next").click();}, 3000);
        $(".main_visual").hover(function() {
            clearInterval(timer);
        }, function() {
            timer = setInterval(function() { $("#btn_next").click();}, 3000);
        });
        $(".main_image").bind("touchstart", function() {
            clearInterval(timer);
        }).bind("touchend", function() {
            timer = setInterval(function() { $("#btn_next").click();},3000);
        });
		
		
    //$(".xing").find("input,strong").click(function(){
	//	if($(".downbox").css("display") == 'block'){
	//		$(".downbox").hide();
	//	}else{
	//		$(".downbox").show();
	//	}
	//});

    $("#checkMsg").click(function(){
    	if($(".downbox").css("display") == 'block'){
    		$(".downbox").hide();
    	}else{
    		$(".downbox").show();
    	}
    });

    $(".downbox p").click(function(){
		$("#checkMsg").val($(this).html());
		$(".downbox").hide();
	});
	
	
});