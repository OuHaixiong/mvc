<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->title; ?></title>
</head>

<body>
	<div id="contents">
这里是布局文件
<?php
echo $this->render('Layouts/left'); // 这里是左边
?>
<?php echo $layoutContent; //模板（布局）以外的内容，就是视图模板文件内容 ?>
</div>
</body>
</html>