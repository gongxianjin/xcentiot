/**
 +----------------------------------------------------------
 * 刷新验证码
 +----------------------------------------------------------
 */
function refreshimage()
{
  var cap = $("#captcha");
  var wh = cap.attr('src').indexOf('?');
  src = wh!=-1 ? cap.attr('src').substring(0, wh) : cap.attr('src');
  src += '?v='+Math.random(1, 10000);
  
  cap.attr('src', src);
}

/**
 +----------------------------------------------------------
 * 无组件刷新局部内容
 +----------------------------------------------------------
 */
function csx_callback(page, name, value, target)
{
	$.ajax({
		type: "GET",
		url: page,
		data: name + "=" + value,
		dataType: "html",
		success: function(html){$(target).html(html);}
	});
}

Array.prototype.remove=function(dx){
	if(isNaN(dx)||dx>this.length){return false;}
	for(var i=0,n=0;i<this.length;i++)
	{
		if(this[i]!=this[dx])
		{
			this[n++]=this[i];
		}
	}
	this.length-=1;
};

$(function(){

	//全选的实现
	$(".check-all").click(function(e){
		e.stopPropagation();
		$(".ids").attr('checked', this.checked);
	});
	$(".ids").click(function(e){
		e.stopPropagation();
	});

	$('.del').click(function(){
		var _msg_attr = $(this).attr('warning');
		var callback = $(this).attr('callback');
		if(_msg_attr){
			var _confirm = confirm(_msg_attr);
			if(!_confirm){
				return false;
			}
		}
		
		$.ajax({
			type:'get',    //可选get
			url: $(this).attr('href'), //这里是接收数据的PHP程序
			dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
			timeout : 10000, // 10秒超时
			success:function(msg){
				if(msg.code==200){
					window.location.reload();
				}else{
					if(callback) {
						callback = eval(callback);
						callback(msg.msg);
					}else{
						alert(msg.msg);
					}
				}
			},
			error: function(a,b,c){
				alert(b.responeText);
			}
		});
		return false;
	});

	$('.del_multi').click(function(e){
		var delId = [];
		var _msg_attr = $(this).attr('warning');
		var callback = $(this).attr('callback');
		
		e.stopPropagation();
		$('.ids[type=checkbox]').each(function(){
			if(this.checked){
				delId.push(this.value);
			}
		});
		
		if(delId.length<=0) return false;

		if(_msg_attr){
			var _confirm = confirm(_msg_attr);
			if(!_confirm){
				return false;
			}
		}
		
		$.ajax({
			type:'get',    //可选get
			url: $(this).attr('href'), //这里是接收数据的PHP程序
			dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
			data: 'ids='+delId.join(','),
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
	
	//ajax get请求
	$('.ajax-get').click(function(){
		var target;
		var that = this;
		var callback = $(this).attr('callback');
		var _msg_attr = $(this).attr('warning');
		if(_msg_attr){
			var _confirm = confirm(_msg_attr);
			if(!_confirm){
				return false;
			}
		}
		
		if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
			$.ajax({
				type: 'post',    //可选get
				url: target, //这里是接收数据的PHP程序
				data: '',
				dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
				timeout : 10000, // 10秒超时
				success:function(msg){
					if(!callback){
						window.location.href = msg.forward;
					}else{
						if(callback) {
							callback = eval(callback);
							callback(msg);
						}else{
							alert(msg.msg);
						}
					}
				},
				error: function(a,b,c){
					alert(b.responeText);
				}
			});
			return false;

		}
		return false;
	});


	$('form').submit(function(){return false;});

	//ajax post submit请求
	$('.ajax-post').click(function(){
		var target,query,form;
		var that = this;
		var target_form = $(this).attr('target-form');
		var callback = $(this).attr('callback');
		var _msg_attr = $(this).attr('warning');
		if(_msg_attr){
			var _confirm = confirm(_msg_attr);
			if(!_confirm){
				return false;
			}
		}
		if( ($(this).attr('type')=='submit') || (target == $(this).attr('href')) || (target == $(this).attr('url')) ){
			form = $('.'+target_form);
			target = target ? target : form.attr('action');
			query = form.length ? form.serialize() : '';
			if(!target) return false;
			
			$.ajax({
				type:'post',    //可选get
				url: target, //这里是接收数据的PHP程序
				data: query,
				dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
				timeout : 10000, // 10秒超时
				success:function(msg){
					if(msg.code==200){
						if(!callback){
							window.location.href = msg.forward;
						}else{
							callback = eval(callback);
							callback(msg);
						}
					}else{
						$('.error').html(msg.msg).show();
						if(callback){
							callback = eval(callback);
							callback();
						}
					}
				},
				error: function(a,b,c){
					$('.error').html(e.name+":"+e.message).show();
					$(that).removeClass('disabled').removeAttr('autocomplete', 'on').prop('disabled',false);
				}
			});
			
		}
		return false;
	});
	
	// POST请求，用于layer弹窗窗口中，请求成功1秒自动关闭弹窗
	$('.ajax-post-layer').unbind('click').click(function(){
		var target,query,form;
		var that = this;
		var target_form = $(this).attr('target-form');
		var callback = $(this).attr('callback');
		var _msg_attr = $(this).attr('warning');
		if(_msg_attr){
			var _confirm = confirm(_msg_attr);
			if(!_confirm){
				return false;
			}
		}
		if( ($(this).attr('type')=='submit') || (target == $(this).attr('href')) || (target == $(this).attr('url')) ){
			form = $('.'+target_form);
			target = target ? target : form.attr('action');
			query = form.length ? form.serialize() : '';
			if(!target) return false;
			
			$.ajax({
				type:'post',    //可选get
				url: target, //这里是接收数据的PHP程序
				data: query,
				dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
				timeout : 10000, // 10秒超时
				success:function(msg){
					$('.error').html(msg.msg).show();
					if(msg.code==200){
						setTimeout(function(){
							window.parent.location.reload();
							window.parent.layer.close(layer_index);
						}, 1000);
					}
				},
				error: function(a,b,c){
					$('.error').html(a.responseText).show();
					$(that).removeClass('disabled').removeAttr('autocomplete', 'on').prop('disabled',false);
				}
			});
			
		}
		return false;
	});

	//搜索功能
	$("#search").click(function(){
		var url = $('.search-form').attr('action');
		var query  = $('.search-form').find('input,select').serialize();
		query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
		query = query.replace(/^&/g,'');
		if( url.indexOf('?')>0 ){
			url += '&' + query;
		}else{
			url += '?' + query;
		}
		_url = url.substr(url.lastIndexOf('?')+1);
		if(_url=='') return false;

		window.location.href = url;
	});
	
	$('.order').click(function(e){
		e.stopPropagation();
		if($(this).find('input').length) return false;
		
		pos = $(this).attr('pos');
		ids = $(this).attr('ids');
		
		cscOrder($(this), ids, pos);
	});

	$('input[type=text],textarea').focus(function(){
		$(this).select();
	});

});

var cscOrder = function(obj, ids, pos){
	var input = $('<input type="text" value="'+obj.html()+'" style="width:80px;text-align:center;" size="3"/>');
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
};

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
	$.ajax({
			type:'get',    //可选get
			url: pos, //这里是接收数据的PHP程序
			data:data,
			dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
			timeout : 10000, // 10秒超时
			success:function(msg){
				if(msg.code==200){
					showPcaList(msg);
				}else{
					alert(msg.msg);
				}
			},
			error: function(a,b,c){
				alert(b.responeText);
			}
	});
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

//顶部下拉菜单
$(document).ready(function(){
  $('.M').hover(
    function(){
      $(this).addClass('active');
    },
    function(){
      $(this).removeClass('active');
    });
});

function change(id, choose)
{
  document.getElementById(id).value = choose.options[choose.selectedIndex].title;
}
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