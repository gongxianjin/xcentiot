$(function(){
	lhBanner();
	lhTab();
	lhRoll();
	lhTwobanner();
	lhAcco();
	lhNav();
})

//banner 轮播
function lhBanner(){
	jQuery(".lh_banner").slide({titCell:".lh_banner_hd ul",mainCell:".lh_banner_bd ul",effect:"left",autoPage:true,autoPlay:true});
}
//tab切换
function lhTab(){
	jQuery(".lh_tab_change").slide({titCell:".lh_tab_hd ul li",mainCell:".lh_tab_bd"});
}
//列表滚动
function lhRoll(){
	jQuery(".lh_roll").slide({mainCell:".lh_tab_bd ul",effect:"top",autoPage:true,autoPlay:true,vis:5});
}
//两行 轮播
function lhTwobanner(){
	jQuery(".lh_twoBanner").slide({titCell:".lh_twoBanner_hd ul",mainCell:".lh_twoBanner_bd",effect:"left",autoPage:true,autoPlay:true});	
}
//手风琴
function lhAcco(){
	jQuery(".lh_acco").slide({titCell:".lh_acco_hd a", targetCell:".lh_acco_bd dl",defaultIndex:1,effect:"slideDown",delayTime:300,returnDefault:true});	
}
//三级导航
function lhNav(){
	$(".lh_item").hover(function(){
		$(this).addClass("lh_item1");
		$(this).find(".lh_three_nav").fadeIn(300);	
	},function(){
		$(this).removeClass("lh_item1");
		$(this).find(".lh_three_nav").fadeOut(300);
	});
}
