<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Keywords" content="<?php echo Yii::app()->params['site']['keyword']?>"/>
    <meta name="Description" content="<?php echo Yii::app()->params['site']['description']?>"/>
    <meta name="Author" content="成都先讯物联网技术有限公司"/>
    <meta name="baidu-site-verification" content="xnjv9BgkGT" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" >
    <link href="<?php echo yii::app()->request->baseurl?>/assets/static/favicon_xcent.ico" rel="shortcut icon"/>

    <link rel="stylesheet" type="text/css" href="/assets/home/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="/assets/home/css/icomoon.css" />
    <link rel="stylesheet" type="text/css" href="/assets/home/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/assets/home/css/magnific-popup.css" />
    <link rel="stylesheet" type="text/css" href="/assets/home/css/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/home/css/owl.theme.default.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/home/css/style.css" />

    <!--[if lt IE 9]>
    <?php $this->loadCssOrJs('/home/js/respond.min.js','js')?>
    <![endif]-->


</head>
<body>

<?php $this->Widget('Header')?>

<?php echo $content; ?>

<?php $this->Widget('Footer')?>

<?php $this->loadCssOrJs('/home/js/jquery.min.js','js')?>
<?php $this->loadCssOrJs('/home/js/jquery.easing.1.3.js','js')?>
<?php $this->loadCssOrJs('/home/js/bootstrap.min.js','js')?>
<?php $this->loadCssOrJs('/home/js/jquery.waypoints.min.js','js')?>
<?php $this->loadCssOrJs('/home/js/owl.carousel.min.js','js')?>
<?php $this->loadCssOrJs('/home/js/jquery.countTo.js','js')?>
<?php $this->loadCssOrJs('/home/js/jquery.magnific-popup.min.js','js')?>
<?php $this->loadCssOrJs('/home/js/magnific-popup-options.js','js')?>
<?php $this->loadCssOrJs('/home/js/main.js','js')?>

</body>
</html>
