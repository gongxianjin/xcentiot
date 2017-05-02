// 导航下拉
$(function(){
	$(".z-nav-btn").click(function(){
		$(".z-menu-con").toggle();
	})
})
// 导航Box高度,兼容性个度;
$(function(){
	$(".z-menu-con").height($("body,html").height()+100);
})
//友情链接切换
$(function(){
	$(".z-home-Ltitle2 > dl > a").click(function(){
		var mIndex=$(this).parent("dl").index();
		$(this).addClass("on");
		$(this).parent("dl").siblings().find("a").removeClass("on");
		$(".home-list4Con").find("ul").eq(mIndex).show();
		$(".home-list4Con").find("ul").eq(mIndex).siblings().hide();
	})
})
// 弹出层 我要捐助 我要求助
$(function(){
	$(".popupOpen1").click(function(){
		$(".z-popup01").show();
	})
	$(".popupOpen2").click(function(){
		$(".z-popup02").show();
	})
	$(".z-popup-close>span,.z-popup-btn>span").click(function(){
		$(".z-popup").hide();
	})
})
//帮助中心，关于我们list切换
$(function(){
	$(".z-mut>span").click(function(){
		if ($(this).parent(".z-mut").siblings(".z-mucScon").length>0) {
			$(this).parents(".z-muc").addClass("zmucShow");
			$(this).parents(".z-muc").siblings(".z-muc").removeClass("zmucShow");
		};
	})
})