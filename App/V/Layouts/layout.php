<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->title; ?></title>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/base/jquery-1.10.2.js"></script>
</head>

<body>
 <div id="contents">
<?php
echo $this->render('Layouts/left'); // 这里是左边
?>
<?php echo $layoutContent; //模板（布局）以外的内容，就是视图模板文件内容 ?>
 </div>
 
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
/*
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="//v2.zopim.com/?46gyA9bwVGTXIRw4rA8zbR2sSnNXRDAp";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
*/
</script>
<!--End of Zopim Live Chat Script-->
<!-- zopim账号：258333309@qq.com -->

</body>
</html>