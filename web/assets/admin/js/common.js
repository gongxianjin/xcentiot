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

function reload(){
	var a=window.location.href;
	if(/index/.test(a)){
		window.history.back();
		window.location.load(window.location.href);
	}if(/select/.test(a)){
		window.history.back();
	}else{
		window.history.go(-2);
		window.location.load(window.location.href);
	}

}
//dom加载完成后执行的js
function setCntwapHeight(h){
	h = h - $('.L_footwap').height()-$('.L_title_wap').height();
	$('body').height('0px');
	$('.L_cntL').height(h+'px');
	$('.L_cntR').height(h+'px');

	if($('.L_cntR2').height()<$('.L_cntR2').parent().height()){
		var lcntr2Top = parseInt($('.L_cntR2').css('top'));
		$('.L_cntR2').height(($('.L_cntR2').parent().height()-lcntr2Top)+'px');
	}
}

//顶部导航栏控制
function setTopBannerIndex(index){
	index--;
	index = index<0?0:index;
	$('.L_title_R ul li:eq('+index+')').find('span').addClass('Lmw1');
}
//侧边栏控制
function setSidebarIndex(index, subIndex){
	index--;
	index = index<0?0:index;

	subIndex--;
	subIndex = subIndex<0?0:subIndex;

	$('.L_cntL h2:eq('+index+')').find('span').addClass('exp');
	$('.L_cntL h2:eq('+index+')').siblings('h2').find('span').addClass('fold');
	$('.L_cntL h2:eq('+index+')').next('ul').show();
	$('.L_cntL h2:eq('+index+')').next('ul').find('li:eq('+subIndex+')').addClass('L_dq1');
}

$(function(){
	$(window).resize(function(){
		setCntwapHeight($(window).height());
	}).resize();

	// 表格颜色
	$('tbody tr:even').attr('bgcolor','#f8f8f8');
	$('tbody tr:odd').attr('bgcolor', '#eee');

	$('.L_cntL h2').click(function(){
		var cl = $(this).find('span').attr('class');
		if(cl=='exp'){// 点击收起
			$(this).find('span').removeClass(cl).addClass('fold');
			$(this).next('ul').hide();
		}else if(cl=='fold'){
			$(this).find('span').removeClass(cl).addClass('exp');
			$(this).siblings('h2').find('span').removeClass('exp').addClass(cl);
			$(this).next('ul').show();
			$(this).next('ul').siblings('ul').hide();
		}
	});

	//全选的实现
	$(".check-all").click(function(e){
		e.stopPropagation();
		$(".ids").prop("checked", this.checked);
	});
	$(".ids").click(function(e){
		e.stopPropagation();
	});

	$('.list_table tr').hover(function(){
		$(this).find('td').addClass('list_table_tr_hover');
	},function(){
		$(this).find('td').removeClass('list_table_tr_hover');
	});



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

	$('.submit-btn').click(function(){
		var _msg_attr = $(this).attr('warning');
		if(_msg_attr){
			var _confirm = confirm(_msg_attr);
			if(!_confirm){
				return false;
			}
		}
		$.ajax({
			type: 'post',    //可选get
			url: $(this).parents('form').attr('action'), //这里是接收数据的PHP程序
			data: $(this).parents('form').serialize(),
			dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
			timeout : 10000, // 10秒超时
			success:function(msg){
				alert(msg.msg);
				if(msg.code==200){
					window.location.href = msg.forward;
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
		if ( $(this).hasClass('confirm') ) {
			if(!confirm('确认要执行该操作吗?')){
				return false;
			}
		}
		if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) ) {
			$.get(target).success(function(data){
				if (data.status==1) {
					if (data.url) {
						updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
					}else{
						updateAlert(data.info,'alert-success');
					}
					setTimeout(function(){
						if (data.url) {
							location.href=data.url;
						}else if( $(that).hasClass('no-refresh')){
							$('#top-alert').find('button').click();
						}else{
							location.reload();
						}
					},1500);
				}else{
					updateAlert(data.info);
					setTimeout(function(){
						if (data.url) {
							location.href=data.url;
						}else{
							$('#top-alert').find('button').click();
						}
					},1500);
				}
			});

		}
		return false;
	});


	$('form').submit(function(){return false;});

	//ajax post submit请求
	$('.ajax-post').click(function(){
		var target,query,form;
		var form_submit = false;
		var target_form = $(this).attr('target-form');
		var that = this;
		var nead_confirm=false;
		if( ($(this).attr('type')=='submit') || (target == $(this).attr('href')) || (target == $(this).attr('url')) ){
			form = $('.'+target_form);

			if ($(this).attr('hide-data') === 'true'){//无数据时也可以使用的功能
				return false;
			}else if (form.get(0)==undefined){
				return false;
			}else if ( form.get(0).nodeName=='FORM' ){
				if ( $(this).hasClass('confirm') ) {
					if(!confirm('确认要执行该操作吗?')){
						form_submit = false;
					}
				}
				if($(this).attr('url') !== undefined){
					target = $(this).attr('url');
				}else{
					target = form.get(0).action;
				}
				form_submit = true;
				query = form.serialize();
			}else if( form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA') {
				form.each(function(k,v){
					if(v.type=='checkbox' && v.checked==true){
						nead_confirm = true;
					}
				});
				if ( nead_confirm && $(this).hasClass('confirm') ) {
					if(!confirm('确认要执行该操作吗?')){
						return false;
					}
					form_submit = true;
				}
				query = form.serialize();
			}else{
				if ( $(this).hasClass('confirm') ) {
					if(!confirm('确认要执行该操作吗?')){
						return false;
					}
					form_submit = true;
				}
				query = form.find('input,select,textarea').serialize();
			}
			if(!form_submit) return false;
			form_submit = false;
			$.ajax({
				type:'post',    //可选get
				url: target, //这里是接收数据的PHP程序
				data: query,
				dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
				timeout : 10000, // 10秒超时
				success:function(msg){
					if(msg.code==200){
						window.location.href = msg.forward;
					}else{
						$('.error').html(msg.msg).show();
						$(that).removeClass('disabled').removeAttr('autocomplete', 'on').prop('disabled',false);
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

	//搜索功能
	$("#search").click(function(){
		var url = $(this).attr('url');
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
		$.post(pos, 'ids='+ids+'&num='+this.value).success(function(data){
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
			var waper = $('<div class="more_img_wap">'+
					'<div class="more_img_big"></div>'+
					'<div class="more_img_wap2">'+
					'	 <div class="more_img_wap2L"><a></a></div>'+
					'    <div class="more_img_wap2C">'+
					'    	<ul></ul>'+
					'    </div>'+
					'    <div class="more_img_wap2R"><a></a></div>'+
					'</div>'+
			'</div>');
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

		}
};

var cscCond = {
		data:[],
		id : 'cscCond',
		input : false,
		box: $('<div></div>'),
		
		getCondData : function(cid){
			var _self = this;
			if(this.data.length==0){
				$.ajax({
					type:'get',    //可选get
					url: $('#'+this.id).attr('pos'), //这里是接收数据的PHP程序
					data: 'cid='+cid,
					dataType: 'json',    //服务器返回的数据类型 可选XML ,Json jsonp script html text等
					timeout : 10000, // 10秒超时
					success:function(msg){
						if(msg.code==200){
							_self.data = msg.data;
							_self.show();
						}else{
							alert(msg.msg);
						}
					},
					error: function(a,b,c){
						alert(b.responeText);
					}
				});
			}else{
				this.show();
			}
		},
		show : function(){
			/*
			 <div class="control">
				<span>3. 液晶显示</span> <em style="cursor:pointer;color:red;font-size:14px;">?</em><br>
				<ul>
					<li class="select">正常</li>
					<li>有坏点或不显示</li>
				</ul>
			</div>*/
			var _self = this;
			this.box.children().remove();
			this.box.html('');
			
			for(var i=0;i<this.data.length;i++){
				tmp = this.data[i];
				var div_control = $('<div class="control"></div>');
				var span = $('<span>'+(i+1)+'. '+tmp.name+'</span> <em style="cursor:pointer;color:red;font-size:14px;">?</em><br>');
				var ul = $('<ul pid="'+ tmp.id +'"></ul>');
				for(var j=0;j<tmp['item'].length;j++){
					var tp = tmp['item'][j];
					var li = $('<li sid="'+ tp.id +'">'+tp.name+'<a style="color:red;cursor:pointer;">X</a></li>');
					if(tp.select) li.addClass('select');
					ul.append(li);
				}
				div_control.append(span);
				div_control.append(ul);
				div_control.append('<div class="clear"></div>');
				this.box.append(div_control);
			}
			
			this.box.attr('pos', $('#'+this.id).attr('pos'));
			$('#'+this.id).replaceWith(this.box);
			
			this.box.find('li a').on('click', function(){
				_self.refreshInput($(this).parent().attr('sid'));
				if($(this).parent().parent().children().length<=1){
					$(this).parent().parent().parent().remove();
				}else{
					$(this).parent().remove();
				}
			});
			this.refreshInput();
		},
		
		refreshInput: function(removeVal){
			// 1|s1,s2,s3-2|s21,s22,s23
			var val = [];
			for(var i=0;i<this.data.length;i++){
				tmp = this.data[i];
				_val = [];
				for(var j=0;j<tmp['item'].length;j++){
					var tp = tmp['item'][j];
					if(tp.id == removeVal) {
						tmp['item'].remove(j);
						this.data[i] = tmp;
						continue;
					}
					_val.push(tp.id);
				}
				if(_val.length>0){
					s = tmp.id+'|' + _val.join(',');
					val.push(s);
				}
			}
			this.input.val( val.join('-') );
		},
		
		init: function(ids, id, input){
			if(!id)return ;
			
			this.id = id;
			this.input = input;
			this.box.attr('id', this.id);
			if(ids){
				this.getCondData(ids);
			}else{
				this.show();
			}
		}
		
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

function upInfoState(rs){
	if(rs.code != 200){
		alert(rs.msg);
	}else{
		window.location.reload();
	}
}
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


