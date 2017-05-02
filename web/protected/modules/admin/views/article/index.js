<?php
$df_title = Yii::app()->params['title'];
$fileManager = $this->createUrl('gd/filemanager');
$fileDelete = $this->createUrl('gd/filedel');
$upload = $this->createUrl('gd/upload');
return <<<EOT

    $("#dels").click(function(){
        if(confirm('确定删除?')==false){
            return false;
        }
        var dels = '';
        $("input:checkbox[name='check']:checked").each(function () {
            dels += $(this).val()+",";
        });
        var url = $("#dels").attr('url');
        window.location.href = url+'?dels='+dels;
    });


EOT;
?>