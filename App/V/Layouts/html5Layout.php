<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (empty($this->title) ? '未设置标题' : $this->title); ?></title>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/base/jquery-1.10.2.js"></script>
</head>
<body>
<?php echo $layoutContent; //模板（布局）以外的内容，就是视图模板文件内容 ?>
</body>
</html>