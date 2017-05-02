//设为首页加入收藏
$.fn.addFavorite = function(l, h) {
	return this.click(function() {
		var t = jQuery(this);
		if(jQuery.browser.msie) {
			window.external.addFavorite(h, l);
		} else if (jQuery.browser.mozilla || jQuery.browser.opera) {
			t.attr("rel", "sidebar");
			t.attr("title", l);
			t.attr("href", h);
		} else {
			alert("请使用Ctrl+D将本页加入收藏夹！");
		}
	});
};

//刷新验证码
function refreshimage()
{
  var cap = $("#captcha");
  var wh = cap.attr('src').indexOf('?');
  src = wh!=-1 ? cap.attr('src').substring(0, wh) : cap.attr('src');
  src += '?v='+Math.random(1, 10000);

  cap.attr('src', src);
}


$('.del').click(function(){
	var _msg_attr = $(this).attr('warning');
	if(_msg_attr){
		var _confirm = confirm(_msg_attr);
		if(!_confirm){
			return false;
		}
	}
	$.ajax({
		type:'get',    //可选get
		url: $(this).attr('pos'), //这里是接收数据的PHP程序
		dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
		timeout : 10000, // 10秒超时
		success:function(msg){
			if(msg.code==200){
				window.location.reload();
			}else{
				alert(msg.msg);
			}
		},
		error: function(a,b,c){
			alert(b.responeText);
		}
	});
	return false;
});
function SetHome(obj,vrl){ 
	try{ 
		obj.style.behavior= 'url(#default#homepage)';obj.setHomePage(vrl); 
	} 
	catch(e){ 
		if(window.netscape) { 
			try { 
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
				var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
				prefs.setCharPref( browser.startup.homepage ,vrl); 
			}catch (e) { 
				alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为 true ,双击即可。");
			} 
		}else{ 
			alert("您的浏览器不支持，请按照下面步骤操作：\n1.打开浏览器设置。\n2.点击设置网页。\n3.输入："+vrl+"点击确定。"); 
		} 
	} 
} 

function getCookie(name){
    var val=$.cookie(name);
    return val;
}
function setCookie(name,value,day){
	var date=new Date();
    date.setTime(date.getTime() + day * 24 * 3600 * 1000);
    var newOptions = {
    	domain: window.global.domain,
        path: '/',
        expiresAt: date
    };
    $.cookie(name, value, newOptions);
}
function _request(url, data, methord, success, error, options) {
    if (methord == "POST") {
        data = typeof data == "string" ? data : JSON.stringify(data);
    }
    var ops = {
        type: methord,
        url: url,
        dataType: "json",
        data: data,
        timeout: 10000,
        error: error,
        success: success
    };
    if ((options) && typeof (options) == "object") {
        for (var k in options) {
            ops[k] = options[k];
        }
    } 
    $.ajax(ops);
};
function Get(url, data, success, error, options) {
    _request(url, data, "GET", success, error, options);
};
function Post(url, data, success, error, options) {
    _request(url, data, "POST", success, error, options);
};
/* 格式化金额 */
function fomartPrice(price){
    if(typeof(PRICE_FORMAT) == 'undefined'){
        PRICE_FORMAT = '&yen;%s';
    }
    price = number_format(price, 2);
    return PRICE_FORMAT.replace('%s', price);
}

function number_format(num, ext){
    if(ext < 0){
        return num;
    }
    num = Number(num);
    if(isNaN(num)){
        num = 0;
    }
    var _str = num.toString();
    var _arr = _str.split('.');
    var _int = _arr[0];
    var _flt = _arr[1];
    if(_str.indexOf('.') == -1){
        /* 找不到小数点，则添加 */
        if(ext == 0){
            return _str;
        }
        var _tmp = '';
        for(var i = 0; i < ext; i++){
            _tmp += '0';
        }
        _str = _str + '.' + _tmp;
    }else{
        if(_flt.length == ext){
            return _str;
        }
        /* 找得到小数点，则截取 */
        if(_flt.length > ext){
            _str = _str.substr(0, _str.length - (_flt.length - ext));
            if(ext == 0){
                _str = _int;
            }
        }else{
            for(var i = 0; i < ext - _flt.length; i++){
                _str += '0';
            }
        }
    }

    return _str;
}

function flushCartState(rs){
	if(rs.code==200){
		window.location.reload();
	}else{
		layer.msg(rs.msg, 3, -1);
	}
}
// 搜索
$('.top_search').click(function(){
	pos = $(this).attr('pos');
	word = $(this).siblings('input').val();
	if(!pos) return false;
	
	s = 'w='+encodeURIComponent(word);
	pos = pos.indexOf('?')==-1 ? pos+'?' : pos;
	window.location.href = pos + s;
});
$('.t_s_t').keypress(function(e){
	if(e.keyCode == 13){
		$('.top_search').trigger('click');
	}
});

// 购物车全选
$('.gw_checkbox').change(function(){
	chk = this.checked;
	var rec_id='';
	var is_row=0;
	$('tr input[type=checkbox]').each(function(){
		this.checked = chk;
		if($(this).attr("value")){
			if($(this).attr("checked")==true){
				is_row +=1;
			}else{
				is_row +=0;
			}
			rec_id +=$(this).attr("value")+',';
		}
	});
	u_cart(rec_id,is_row);
});

$('tr input[type=checkbox]').click(function(){
	var rec_id='';
	var is_row=0;
	if($(this).attr("checked")==true){
		is_row =1;
	}else{
		is_row =0;
	}
	rec_id =$(this).attr("value")+',';
	u_cart(rec_id,is_row);
});

/* add cart */
function u_cart(rec_id,is_row)
{ 
	var url = $('.gw_checkbox').attr('pos');
	data = 'rec_id='+rec_id+'&is_row='+is_row;
	$.getJSON(url,data, function(data){
		if (data.code==200)
		{
		   $('#cart_amount').html('￥'+data.data.amount);
		   $('#store_amount').html(data.data.store);
		   if(data.data.quantity > 0){
				$(".jies_btn").attr("href",$('#jies_btn_a').attr('pos')); 
			}else{
				$(".jies_btn").attr("href","javascript:;"); 
			}	
		}
	});

}

// 清空购物车
$('.flush_cart').click(function(){
	Post($(this).attr('pos'),'', flushCartState);
});

// 单价计数
function jsCart(){
	selectNum = cPrice = mPrice = 0;
	$('tr input[type=checkbox]').each(function(){
		if(this.checked){
			selectNum ++;
			p = parseInt($(this).attr('price'));
			n = parseInt($(this).attr('num'));
			mp = $(this).attr('minprice');
			mp = mp ? parseInt(mp):0;
			
			cPrice += p*n;
			mPrice += mp*n;
		}
	});
	$('.buy_foot .price2:first').html(' '+selectNum+' ');
	$('.buy_foot .price2:last').html(cPrice);
	if($('.buy_foot .price2').length>2){
		$('.buy_foot .price2:eq(1)').html(fomartPrice(mPrice));
	}
	if($('.buy_foot .price2:first')!==0){
		$('.jies_btn').css('cursor', 'pointer').removeClass('jies_btn_no');
	}
}
function deleteRecoverState(rs){
	if(rs.code!=200) alert(rs.msg)
	else  window.location.reload();
}
// 删除项目
$('.trade-operate a').click(function(){
	war = $(this).attr('warning');
	pos = $(this).attr('href');
	
	if(!pos) return false;
	
	if(war){
		if(!window.confirm(war)) return false;
	}
	Get($(this).attr('pos'), 'ids='+$(this).attr('cid'), deleteRecoverState);
});

// 获取购物车已选择结算项目
function getSelectCartGoods(){
	data = [];
	$('tr input[type=checkbox]').each(function(){
		if(this.checked){
			data.push(this.value);
		}
	});
	
	if(data.length==0){
		$('.jies_btn').css('cursor', 'not-allowed').addClass('jies_btn_no');
	}else{
		$('.jies_btn').css('cursor', 'pointer').removeClass('jies_btn_no');
	}
	
	return data;
}

//排序方法
var cscOrder = function(obj, ids, pos){
	var input = $('<input type="text" value="'+obj.html()+'" style="width:60px;text-align:center;" size="3"/>');
	input.blur(function(){
		var _self = this;
		$.post(pos, 'ids='+ids+'&num='+this.value, function(data){
			try{
				if (data.code==200) {
					
					$(_self).parent().html(_self.value);
				}else{
					alert(data.msg);
				}
			}catch(e){
				
				alert(e.name+":"+e.message);
			}
		});
	});
	obj.html('').append(input);
}

$('.order-bd').click(function(){
	if($(this).find('.padding_l input').length==0) return;
	$(this).find('.padding_l input').get(0).checked = true;
	$(this).find('.padding_l input').trigger('change');
});
//修改排序
$('.alter').click(function(e){
	e.stopPropagation();
	if($(this).find('input').length) return false;
	
	pos = $(this).attr('pos');
	ids = $(this).attr('ids');
	
	cscOrder($(this), ids, pos);
});
//修改状态
$('.status').click(function(e){
	e.stopPropagation();
	
	pos = $(this).attr('pos');
	ids = $(this).attr('ids');
	val = $(this).attr('value');
	var _self = this;
	$.post(pos, 'ids='+ids+'&val='+val, function(data){
		try{
			if (data.code==200) {
				
				alert('修改成功');
				if($(_self).hasClass('pic2')){
					$(_self).removeClass('pic2').addClass('pic1');
				}else{
					$(_self).removeClass('pic1').addClass('pic2');
				}
			}else{
				alert(data.msg);
			}
		}catch(e){
			
			alert(e.name+":"+e.message);
		}
	});
});
// 购物车数量增减
$('.increase').click(function(){
	n = parseInt($(this).siblings('input').val());
	
	n++;
	if(n>100) {
		alert('单笔订单最大数量不能超过100');return false;
	}
	
	$(this).siblings('input').val(n);
	
	$(this).parent().siblings().first().find('input').attr('num', n);
});
$('.decrease').click(function(){
	n = parseInt($(this).siblings('input').val());
	
	if(n==1) return false;
	n--;
	
	$(this).siblings('input').val(n);
	$(this).parent().siblings().first().find('input').attr('num', n);
});

$('.decrease').siblings('input').keyup(function(){
	n = parseInt(this.value);
	this.value = n;
	$(this).parent().siblings().first().find('input').attr('num', n);
	
	$(this).parent().click();
});

//购物车更改单品数量
$('.padding_l input').change(function(){
	cart_id = this.value;
	price = $(this).attr('price');
	num = $(this).attr('num');
	pos = $(this).attr('pos');
	
	if(!price || !num || !pos) return;
	
	data = 'cart_id='+cart_id+'&price='+price+'&num='+num;
	
	Post(pos, data, upCartNumState);
	
});

function upCartNumState(rs){}

// 显示回购参数详情
$('.quantity').click(function(){
	html = $(this).clone();
	html.find('ul').removeAttr('style');
	
	pageii = $.layer({
	    type: 1,
	    title: false,
	    //area: [460, 480],
	    //border: [1], //去掉默认边框
	    //shade: [1], //去掉遮罩
	    //closeBtn: [0, false], //去掉默认关闭按钮
	    //shift: 'top', //从左动画弹出
	    page: {
	        html: html.html()
	    }
	});
});

//购物车结算
/*$('.jies_btn').click(function(){
	data = getSelectCartGoods();
	if(data.length==0) return false;
	
	url = $(this).attr('pos');
	url = url.indexOf('?')!=-1 ? url+'&' : url+'?';
	url += 'js_p='+data.join(',');
	
	window.location.href = url;
});*/

// 回收订单生成
/*$('.ls_ddzx_sum a').click(function(){
	url = $(this).attr('pos');
	ship_address = false;
	
	$('input[name=ship_address]').each(function(){
		if(this.checked) ship_address = this.value;
	});
	
	data = getSelectCartGoods();
	if(!ship_address || data.length==0 || !url) return false;
	
	data = 'ship_address='+ship_address+'&js_p='+data.join(',');
	
	Post(url, data, orderState);
});*/
//积分订单生成
$('.ls_ddzx_score a').click(function(){
	url = $(this).attr('pos');
	ship_address = false;
	
	$('input[name=ship_address]').each(function(){
		if(this.checked) ship_address = this.value;
	});
	
	data = getSelectCartGoods();
	if(!ship_address || data.length==0 || !url) return false;
	
	data = 'ship_address='+ship_address+'&js_p='+data.join(',');
	
	Post(url, data, orderState);
});
function orderState(rs){
	if(rs.code!=200){
		alert(rs.msg);
	}else{
		window.location.href = rs.forward;
	}
}

// 省份城市地区选择改变
$('.L-myzl-R1 select').change(function(){
	h = '';
	$(this).children().each(function(){
		if(this.selected){
			h = $(this).html();
		}
	});
	$(this).siblings('.wrapword').html(h);
	
	pos = $(this).attr('pos');
	name = $(this).attr('name');
	if(!pos) return;
	
	data = '';
	switch(name){
	case 'province_id': 
		data = 'province_id='+this.value;
		break;
	case 'city_id':
		data = 'province_id='+$('select[name=province_id]').val()+'&city_id='+this.value;
		break;
	}
	
	Post(pos, data, showPcaList);
});
function showPcaList(rs){
	if(rs.code != 200){
		alert(rs.msg);
	}else if(rs.data.type == 'province'){
		$('select[name=city_id]').parent().next().hide();
		$('select[name=city_id]').html('');
		
		data = rs.data.item;
		for(var i=0; i<data.length; i++){
			tmp = data[i];
			$('select[name=city_id]').append( $('<option value="'+tmp.csc_id+'">'+tmp.csc_name+'</option>'));
		}
		$('select[name=city_id]').trigger('change');
		showDefaultPca();
	}else if(rs.data.type == 'city'){
		$('select[name=area_id]').html('');
		$('select[name=area_id]').parent().show();
		
		data = rs.data.item;
		for(var i=0; i<data.length; i++){
			tmp = data[i];
			$('select[name=area_id]').append( $('<option value="'+tmp.csc_id+'">'+tmp.csc_name+'</option>'));
		}
		$('select[name=area_id]').trigger('change');
		showDefaultPca();
	}
}
function showDefaultPca(){
	$('.L-myzl-R1 .wrapword').each(function(){
		name = '';
		cid = $(this).attr('cid');
		if(!name || name==''){
			cid = $(this).siblings('select').val();
		}
		if(cid){
			$(this).siblings('select').find('option').each(function(){
				if(cid==$(this).attr('value')){
					name = $(this).html();
				}
			});
			if(name) $(this).html(name);
		}
	});
}
// 删除收货地址
function deladdress(obj){
	pos = $(obj).attr('pos');
	if(!pos) return false;
	
	Get(pos, '', flushCartState);
}

var cscImgPreview = {
		container: '',
		data: [],
		input: '',
		imgIndex : 0,
		/**
		 * box: img preview container
		 * name: 表单提交项
		 * imgs: img list 可空
		 * 	Array[
		 * 		{
		 * 			'thumb': 缩略图,  可空
		 * 			'img': 显示图片,  必须指定
		 * 			'bigImg': 预览图  可空 待定后期扩展
		 * 		}
		 * ]
		 */
		init : function(box, name, imgs){
			this.container = box;
			if(typeof imgs == 'object'){
				this.data = imgs;
			}
			this.input = $('<input type="hidden" name="'+name+'">');
			this.show();
			this.refreshULWidth();
			this.setDefaultImg(true);
			this.container.append(this.input);
			this.container.find('ul li:eq(0) img').trigger('mouseover');
		},
		setDefaultImg : function(isdefault){
			bgDiv = this.container.find('.more_img_big');
			if(!isdefault){// 移除背景图
				bgDiv.attr('_bg', bgDiv.css('background')).css('background', 'none');
			}else{
				bgDiv.css('background', bgDiv.attr('_bg'));
				bgDiv.children().remove();
			}
		},
		setInput : function(val, type){
			var value = this.input.val().split(',');
			var len = value.length;
			if(type=='add'){
				value.push(val);
			}else if(type=='delete'){
				for(var i=0; i<len; i++){
					if(value[i]==val){
						value.splice(i, 1);
					}
				}
			}else{
				return;
			}

			for(var i=0; i<len; i++){
				if(value[i]==''){
					value.splice(i, 1);
				}
			}

			this.input.val(value.join(','));
		},
		show : function(){
			/*
		 <div class="more_img_big"></div>
		    <div class="more_img_wap2">
		    	<div class="more_img_wap2L"><a href="javascript:void(0)"></a></div>
		        <div class="more_img_wap2C">
		        	<ul>
			        	<li><img src="__IMG__/favicon.ico" width="73" height="73" border="0" /></li>
			        </ul>
		        </div>
		        <div class="more_img_wap2R"><a href="#"></a></div>
		    </div>
			 */
			var waper = $('<div class="more_img_big"></div>'+
					'<div class="more_img_wap2">'+
					'	 <div class="more_img_wap2L"><a></a></div>'+
					'    <div class="more_img_wap2C">'+
					'    	<ul></ul>'+
					'    </div>'+
					'    <div class="more_img_wap2R"><a></a></div>'+
					'</div>'
				);
			var len = this.data.length;
			for(var i=0; i<len; i++){
				waper.find('ul').append( this.createThumb(this.data[i]['thumb'], this.data[i]['img'], this.data[i]['bigImg']) );
			}
			this.container.append(waper);
			waper.find('.more_img_wap2L').click(function(){ cscImgPreview.slide('left'); });
			waper.find('.more_img_wap2R').click(function(){ cscImgPreview.slide('right'); });
		},
		createThumb : function(smallImg, img, bigImg){// 生成小图标 默认指定中图
			smallImg = smallImg ? smallImg : img;
			bigImg = bigImg ? bigImg : img;
			var li = $('<li><span class="delImg"></span><img src="'+smallImg+'" width="73" height="73" border="0" _img="'+img+'" _bigImg="'+bigImg+'" alt="'+ smallImg +'"/></li>');
			li.find('img').mouseover(function(){
				img_big = cscImgPreview.container.find('.more_img_big');
				img_big.children().remove();

				var img = $('<img src="'+$(this).attr('_img')+'" width="'+img_big.width()+'" height="'+img_big.height()+'" _bigImg="'+$(this).attr('_bigImg')+'" alt="'+$(this).attr('_img')+'"/>');
				img_big.append(img);
			});
			li.find('.delImg').click(function(){// 删除图片
				cscImgPreview.imgIndex = $(this).parent().index();
				var img = $(this).siblings('img').attr('_img');
				if($(this).parent().parent().find('li').length == 1){
					cscImgPreview.setDefaultImg(true);
				}
				$(this).parent().remove();
				cscImgPreview.next();
				cscImgPreview.setInput(img, 'delete');
			});
			this.setInput(img, 'add');
			return li;
		},
		refreshULWidth : function(){
			var li = this.container.find('ul li');
			var w = li.width()* (li.length+1);
			this.container.find('ul').width(w);
		},
		addImg : function(img){
			this.container.find('.more_img_wap2C ul').append( this.createThumb(img, img, img) );
			this.refreshULWidth();
			this.container.find('ul li:last img').trigger('mouseover');
		},
		prev : function(){
			this.imgIndex --;
			if(this.imgIndex<0){
				this.imgIndex = 0;
			}else{
				this.container.find('ul li').eq(this.imgIndex).find('img').trigger('mouseover');
				this.slide();
			}
		},
		next : function(){
			this.imgIndex ++;
			var length = this.container.find('ul li').length;
			if(this.imgIndex+1>length){
				this.imgIndex = length-1;
			}else{
				this.container.find('ul li').eq(this.imgIndex).find('img').trigger('mouseover');
				this.slide();
			}
		},
		slide : function(path){
			this.refreshULWidth();
			var wap2cW = this.container.find('.more_img_wap2C').width();
			var width = this.container.find('ul').width();
			var left = Math.abs(parseInt(this.container.find('ul').css('left')));

			if(!path){
				if(left>=width){
					left = 0;
					this.container.find('ul').animate({'left':-left+'px'});
				}
			}else if(path=='left'){
				if(left>0){
					left -= this.container.find('ul li').width() + 10;
					left = left>0?left:0;

					this.container.find('ul').animate({'left':-left+'px'});
				}
			}else if(path=='right'){
				if(width<=wap2cW){
					left = 0;
					this.container.find('ul').animate({'left':-left+'px'});
				}else if(width>(left+wap2cW) && left<width){
					left += this.container.find('ul li').width() + 10;
					this.container.find('ul').animate({'left':-left+'px'});
				}
			}

		},
		remove: function(){
			this.container.children().remove();
		}
};


/**
 * 先讯商品规格适配器
 */
var csx_spec_adapter = {
		spec_name : [], // 规格名称
		spec_list : [], // 规格列表
		
		init: function(){
			this.spec_name = window.spec_name;
			this.spec_list = window.spec_list;
			
			this.showSpec();
		},
		
		render: function(){
			if(!window.spec_name || window.spec_name.length<=0) return;
			if(!window.spec_list || window.spec_list.length<=0) return;
			
			this.init();
		},
		
		// 生成规格项
		createSpec: function(index, spec_list){
			var name = this.spec_name[index];
			var dom = '<div class="L_xq_nr1_a"><div class="L_xq_nr1_aL L_xq_ts2" spec_name="'+name+'">'+name+'：</div><div class="L_xq_nr1_aR">';
			var len = spec_list.length;
			
			for(var i=0; i<len; i++){
				var tmp = spec_list[i];
				
				dom += '<a class="L_xq_lx3';
				if(i==0){
					// 选中样式  L_xq_dq2
					dom += ' L_xq_dq2';
				}
				dom += '" href="javascript:;">';
				
				switch(index){
				case 0: dom += tmp.spec_1; break;
				case 1: dom += tmp.spec_2; break;
				case 2: dom += tmp.spec_3; break;
				}
				dom += '</a>';
			}
			dom += '</div></div>';
			
			return this.specEvent(index, dom);
		},
		
		//规格项绑定事件
		specEvent: function(index, spec_dom){
			var _self = this;
			var _item = $(spec_dom);
			
			_item.find('.L_xq_lx3').click(function(){

				$('.goods_spec .L_xq_nr1_a:eq('+index+')').nextAll().remove();
				$(this).addClass('L_xq_dq2').siblings().removeClass('L_xq_dq2');
				
				var len = _self.spec_name.length;
				var select_spec = $('.goods_spec .L_xq_dq2');
				var spec_name = $('.goods_spec .L_xq_dq2:eq(0)').html();
					spec_name_1 = '';
					
				
				for(var i=index+1; i<len; i++){
					
					if(i==1){
						spec_list = _self.getSpec(i, spec_name);
					}
					if(i==2){
						spec_name_1 = $('.goods_spec .L_xq_dq2:eq(1)').html();
						spec_list = _self.getSpec(i, spec_name, spec_name_1);
					}
					
					if(spec_list.length>0){
						var dom = _self.createSpec(i, spec_list);
						$('.goods_spec').append(dom);
					}
				}
				_self.getSelectSpec();
			});
			
			return _item;
		},
		
		// 渲染规格列表
		showSpec: function(){
			var len = this.spec_name.length;
			var spec_name = '',
				spec_name_1 = '';
			
			for(var i=0; i<len; i++){
				
				switch(i){
				case 0: 
					spec_list = this.getSpec(i);
					spec_name = spec_list.length>0?spec_list[0].spec_1:'';
					break;
				case 1: 
					spec_list = this.getSpec(i, spec_name);
					spec_name_1 = spec_list.length>0?spec_list[0].spec_2:'';
					break;
				case 2: spec_list = this.getSpec(i, spec_name, spec_name_1);
				
				break;
				}
				
				if(spec_list.length>0){
					var dom = this.createSpec(i, spec_list);
					$('.goods_spec').append(dom);
				}
			}
			this.getSelectSpec();
		},
		
		// 获取第N层可选规格参数
		getSpec: function(index, spec_name, spec_name_1){
			var name = [],
				spec = [];
			var len = this.spec_list.length;
			
			index = (!index || index<0) ? 0 : index;
			index = index>=this.spec_name.length ? this.spec_name.length : index;
			
			if(index==0){
				for(var i=0; i<len; i++){
					tmp = this.spec_list[i];
					_name = name.join(',');
					
					if(_name.indexOf(tmp.spec_1)!=-1) continue;
					if(!tmp.spec_1) continue;
					
					name.push(tmp.spec_1);
					spec.push(tmp);
				}
			}else if(index==1){
				for(var i=0; i<len; i++){
					tmp = this.spec_list[i];
					_name = name.join(',');
					
					if(_name.indexOf(tmp.spec_1)!=-1 || tmp.spec_1!=spec_name) continue;
					if(!tmp.spec_2) continue;
					
					name.push(tmp.spec_2);
					spec.push(tmp);
				}
			}else if(index==2){
				for(var i=0; i<len; i++){
					tmp = this.spec_list[i];
					_name = name.join(',');
					
					if(_name.indexOf(tmp.spec_1)!=-1 || tmp.spec_1!=spec_name || tmp.spec_2!=spec_name_1) continue;
					if(!tmp.spec_3) continue;
					
					name.push(tmp.spec_3);
					spec.push(tmp);
				}
			}
			
			return spec;
		},
		
		// 获取已选择的规格
		getSelectSpec: function(){
			var select_name = [];
			var select_spec = {};
			var len = this.spec_list.length;
			
			$('.goods_spec .L_xq_dq2').each(function(){
				select_name.push($(this).html());
			});
			
			
			for(var i=0; i<len; i++){
				tmp = this.spec_list[i];
				
				switch(select_name.length){
				case 1: 
					if(select_name[0]==tmp.spec_1){
						select_spec = tmp; break;
					}
					break;
				case 2: 
					if(select_name[0]==tmp.spec_1 && select_name[1]==tmp.spec_2){
						select_spec = tmp; break;
					}
					break;
				case 3: 
					if(select_name[0]==tmp.spec_1 && select_name[1]==tmp.spec_2 && select_name[2]==tmp.spec_3){
						select_spec = tmp; break;
					}
					break;
				}
			}
			// 重新赋值选择规格编号
			$('#spec_id').val(select_spec.id);
			// 重新赋值选择规格库存
			$('#csc_stock').html(select_spec.stock);
			$('.eqq').html(select_spec.price);
			$('.market_price').html(select_spec.market_price);
			
			var n = parseInt($('#num').val());
			if(n>select_spec.stock){
				$('#num').val(select_spec.stock);
			}
		}
};

$('.sohuo').addFavorite(document.title,location.href);

/**
 * 回调参数传递并闭弹窗
 */
var csx_layer_callback;
function layer_close(index, data){
	if(csx_layer_callback){
		csx_layer_callback(data);
	}
	layer.close(index);
}


fzFloat();//右边浮动导航
function fzFloat(){
	$(".fz_list li").hover(function(){
		$(this).find(".fz_list_i").addClass("on");
		$(this).find(".fz_all").stop(true,true).show().animate({right:"35px"},500);
	},function(){
		$(this).find(".fz_list_i").removeClass("on");
		$(this).find(".fz_all").show().animate({right:"-276px"},500);	
	});
	$(".fz_list li.top").click(function(){
		$("html,body").animate({scrollTop:"0px"},1000);	
	});	
}
