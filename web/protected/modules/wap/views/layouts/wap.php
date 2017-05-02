<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $this->title?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>

<?php $this->loadCssOrJs('/wap/css/t_css.css')?>

<body>

<?php echo $content?>

<?php $this->loadCssOrJs('/wap/js/jquery-1.11.1.min.js', 'js')?>
<?php $this->loadCssOrJs('/wap/js/t_js.js', 'js')?>
<?php $this->loadCssOrJs('/wap/js/jquery.touchSlider.js', 'js')?>
<?php $this->loadCssOrJs('/wap/js/jquery.event.drag-1.5.min.js', 'js')?>

</body>

</html>