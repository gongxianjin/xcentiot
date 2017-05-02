<?php


return <<<EOT
$('input[type=submit]').click(function(){

 	data = $('.tableBasic').find('input,select,textarea').serialize();

    //alert(data);
    	
 	pos = $(this).attr('pos');
 	//alert(pos);
 	if(!pos) return false;
 	Post(pos, data, function(rs){
 	  if(rs.code!=200){
 	      alert(rs.msg);
          return;
 	  }
      alert(rs.msg);
//      window.location.reload();
      window.location.href = rs.forward; 
 	});
 });

EOT;
?>