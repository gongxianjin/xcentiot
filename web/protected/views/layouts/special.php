<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo $this->title?></title>
    <meta name="Keywords" content="<?php echo Yii::app()->params['site']['keyword']?>"/>
    <meta name="Description" content="<?php echo Yii::app()->params['site']['description']?>"/>
    <meta name="Author" content="gxj"/>
    <?php $this->loadCssOrJs('/home/css/index.css')?>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" >
    <link href="<?php echo yii::app()->request->baseurl?>/assets/static/favicon_xcent.ico" rel="shortcut icon"/>
</head>
<body>

<?php echo $content; ?>

</body>
</html>
