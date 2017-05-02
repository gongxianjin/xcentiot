<?php
$df_title = Yii::app()->params['title'];
return <<<EOT
$(function(){
	$('.li_p input[type=checkbox]').change(function(){
		if($(this).parent().index()==0){
			if(this.checked){
				$(this).parent().parent().find('input[type=checkbox]:not(:eq(0))').prop("checked", this.checked);
			}else{
				$(this).parent().parent().find('input[type=checkbox]:not(:eq(0))').prop("checked", this.checked);
			}
		}else{
			if(this.checked){
				$(this).parent().parent().find('label:eq(0) input[type=checkbox]').prop("checked", this.checked);
			}
		}
	});
	
});
EOT;
?>