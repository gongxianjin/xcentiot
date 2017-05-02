<?php
$cart_add = yii::app()->createUrl('cart/add');
return <<<EOT
$(function(){
	$(".jqzoom").jqueryzoom({ xzoom: 422, yzoom: 310 });
	
	// 图片替换效果
	$('.spx_ai_l_b li').mouseover(function(){
		$(this).addClass('on').siblings().removeClass('on');
		$('.spx_ai_l p img').attr('src',$(this).attr('qimg'));
		$('.spx_ai_l p img').attr('jqimg',$(this).attr('jqimg'));
	});
	
	//点击后移动的距离
	var left_num = -106;
	
	//整个ul超出显示区域的尺寸
	var li_length = ($('.L_xqy_xunh1 li').width() + 20) * $('.L_xqy_xunh1 li').length - 430;
	
	$('.L_xq_btn1_L').click(function(){
		var posleft_num = $('.L_xqy_xunh1').position().left;
		if($('.L_xqy_xunh1').position().left > - li_length){
			$('.L_xqy_xunh1').css({'left': posleft_num + left_num});
		}
	});
	
	$('.L_xq_btn1_R').click(function(){
		var posleft_num = $('.L_xqy_xunh1').position().left;
		if($('.L_xqy_xunh1').position().left < 0){
			$('.L_xqy_xunh1').css({'left': posleft_num - left_num});
		}
	});
	lhNumber();
})

//商品数量加减
function lhNumber(){
	var jia = $(".L_xq_sl_R .jia"), jian = $(".L_xq_sl_L .jian"), number = $(".L_xq_sl_C .number");
	jia.click(function(){
		jia.removeClass("on");
		var maxNumber = $('#csc_stock').text();
		var curNumber = Number(number.val())+1;
		if(curNumber<=maxNumber){
			number.val(curNumber);	
		}else{
			$(this).addClass("on");	
		}	
	});
	jian.click(function(){
		var curNumber = Number(number.val())-1;
		if(curNumber>=1){
			number.val(curNumber);	
		}else{
			$(this).addClass("on");	
		}
	});
}

function buy(id)
{
	var spec_id =$('#spec_id').val();
    var quantity = $(".number").val();
    if (quantity == '')
    {
        alert('请输入购买数量');
        return;
    }
    if (parseInt(quantity) < 1)
    {
        alert('您输入的数量不正确');
        return;
    }
    add_to_cart(spec_id,quantity,id);
}

function add_to_cart(spec_id,quantity,id)
{
    var url = '$cart_add';
    $.getJSON(url, {'spec_id':spec_id, 'quantity':quantity}, function(data){
        if (data.code==200)
        {
          if(id==0){
			 alert(data.msg);  
			 window.location.reload();
		  }else{
			 location.href =data.forward; 
		  }
          
        }
        else
        {
            alert(data.msg);
        }
    });
}



csx_spec_adapter.render();



EOT;
?>