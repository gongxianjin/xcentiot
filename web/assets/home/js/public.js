;$(function(){
//下拉
	$(".z-menu>ul>li").hover(function(){
		$(this).find("ul").stop().slideDown(300);
	},function(){
		$(this).find("ul").slideUp(300);
	})
//banner
	$(".fullSlide").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click",delayTime:300});
});
//IE流浏览器兼容；
$(function(){
	var test2=navigator.userAgent;
	var ienum=navigator.userAgent.split(" ")[3].substr(0,1);
	var all=navigator.appName.indexOf("Microsoft Internet Explorer")!=-1;
	//var all=navigator.appName
	//首页select
	if(ienum<=9 && all==true){
		$(".home-selectbox").find("span").hide();
	}
	//极客介绍百分比
	if(ienum<=8 && all==true){
		$(".circleR").css("left","110px")
	}
});
//百分比js
(function($){
	$.fn.pct=function(options){
		var defaults={p1:15};
		var opt=$.extend(defaults,options);
		var M=this;
		var T=M.find("span").text();
		if (T<=50) {
			$(this).find(".circleL").css('transform','rotate(-'+(T*3.6)+'deg)');
		}else{
			$(this).find(".circleL").css({'transform':'rotate(0deg)',"background": "#103d5e"});
			$(this).find(".circleR").css('transform','rotate(-'+((T-50)*3.6)+'deg)');
		};
	}
})(jQuery);
//百分比调用
$(function(){
	$(".circle1").pct();
	$(".circle2").pct();
	$(".circle3").pct();
});
// 极客师选择按钮
$(function(){
	$(".z-jksLs>ul>li.no").find("input").attr("checked",true);
	$(".z-jksLs>ul>li").click(function(){
		$(this).addClass("no");
		$(this).find("input").attr("checked",true);
		$(this).siblings().removeClass("no");
		$(this).siblings().find("input").attr("checked",false);
	})
});
//极客展示
$(function(){
	$(".ladyScroll01").slide({ mainCell:".dlList", effect:"leftLoop",vis:4});
	$(".ladyScroll02").slide({ mainCell:".dlList", effect:"leftLoop",vis:3});
});
//找平下拉展示
$(function(){
	$(".z-SrecruitBtn").click(function(){
		$(this).parent("dl").siblings(".z-SrecruitShow").addClass("on");
		$(this).parents("li").siblings().find(".z-SrecruitShow").removeClass("on");
		$(this).parents("li").siblings().find("a").removeClass("on");
		$(this).parents("li").siblings().find("a").text("更多");
		var name = $(this).attr('name');
		var stext=$(this).text();
		if(stext=="更多"){
			$(this).text("关闭");
			$(this).addClass("on")
			document.getElementById(name).style.display="none";
		}else{
			$(this).parent("dl").siblings(".z-SrecruitShow").removeClass("on");
			$(this).text("更多");
			$(this).removeClass("on")
			document.getElementById(name).style.display="block";
		}
	})
});
//关于我们-极客历程左右判断；
$(function(){
	function judgementLR(){
		var cmnu = new Array();
		var ctext=$(".z-courseLL").find("h3").text();
		var clength=$(".z-courseLL").length;
		cmnu = ctext.split(' ',clength);
		for (var i = cmnu.length; i > 0; i--) {
			if(cmnu[i]%2==0){
				$('.'+cmnu[i]).addClass("zcourseLR");
			}
		};
	}
	judgementLR();
});
//友情链接高度
$(function(){
	$(".z-fLinkTitle").height($(".z-fLink").height()+30);
});

//微信弹窗
$(function(){
	$(".z-weixin").click(function(){
		$(".z-wxbox").show();
	});
	$(".z-wxcolse").click(function(){
		$(".z-wxbox").hide();
	})
});

$(function () {
	$(".z-answerspan").click(function(){
		$(this).addClass("on");
		$(this).find("input").attr("checked",true);
		$(this).parent().siblings().find('.z-answerspan').removeClass("on");
		$(this).parent().siblings().find(".z-answerspan").find("input").attr("checked",false);
	})
})