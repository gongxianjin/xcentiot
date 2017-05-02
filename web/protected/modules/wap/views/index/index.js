<?php
    $url = $this->createUrl('index/award');
return <<<EOT

function phonenumberFocus(value){
  if (value =='请输入账号/手机号/邮箱'){
    $('#phonenumber').val('');
  }
};
function phonenumberBlur(value){
  if (value==''){
    checkphone('phonenumber')
  }
};
function checkphone(id){
  var phone = $("#"+id).val();
  if (!phone){
    phoneshow();
    return false;
  }else{
    return true;
  }
}
function phoneshow(){
  $(".z-dcc").show();
  $(".z-dcc1").html('请输入手机号');
  $(".z-dcc2").click(function(){
    $(".z-dcc").hide();
  })
};

function checkname(){

}

function checktel(){

}

function submitform(){
  //if (!checkname()){
  //  return false;
  //}
  //else if(!checktel()){
  //  return false;
  //}
  //else{
    gostep3();return false;
    //$("#register_form").submit();
  //}
};
function gostep3() {

  var data = $("form").serialize();

  $.ajax({
    type:"POST",
    url:"{$url}",
    data:data,
    dataType:"json",
    success:function(data){
      if(data.code==200){
        location.href =data.forward;
      }else{
        $(".z-dcc").show();
        $(".z-dcc1").html(data.msg);
        $(".z-dcc2").click(function(){
          $(".z-dcc").hide();
        })
      }
    },
  });
}
EOT;
?>