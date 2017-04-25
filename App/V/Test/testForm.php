<form action="http://member.csc86.com/upload" method="post" enctype="multipart/form-data">
<div><input type="file" name="file_data" /></div>
<div><input type="text" name="type" value="texteditor" /></div>

<div><input type="submit" value="上传图片" /></div>
<p>
  <a href="/data/脑洞大开.txt">测试下载文件</a><br />
  <a href="<?php
    echo $this->createUrl('/download/down', array('name'=>'脑洞大开.txt'));
  ?>">到一个php页面进行下载</a><br />
  <a href="<?php
    echo $this->createUrl('/download/down', array('name'=>'小浣熊水浒卡_水浒英雄传_高清无水印_电子版.doc'));
  ?>">到一个php页面进行下载(2)</a>
</p>
</form>
<!-- 下面是屏蔽按住F5键不停刷新按钮 -->
<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/base/jquery-1.10.2.js"></script>
<!--[if lt IE 9]>
  <script>
   function document.onkeydown() 
    { 
    	if ( event.keyCode==116) 
    	{ 
    		event.keyCode = 0; 
    		event.cancelBubble = true; 
    		return false; 
    	}
    }
    function document.onkeyup() 
    { 
    	if ( event.keyCode==116) 
    	{ 
    		window.location.reload();
    	}
    }
  </script>
<![endif]-->
<script type="text/javascript">
$(document).ready(function () {
    if (navigator.userAgent.indexOf("MSIE") === -1 || parseInt(/msie\s*(\d*)\..*/i.exec(navigator.userAgent)[1], 10) > 8) {
		$(document).keydown(function (event) {
	        if (event.keyCode == 116) {
// 	            console.log('按下F5键了');
	            event.keyCode = 0; 
	            event.cancelBubble = true;
	            return false;
	        }
	    });
	    
	    $(document).keyup(function (event) {
	        if (event.keyCode == 116) {
// 	            console.log('弹起F5键了');
	            window.location.reload();
	        }
	    });
    }
});
</script>
<p>下面测试注册</p>

<form action="http://member.csc86.com/upload" method="post" enctype="multipart/form-data">
<div>用户名：<input type="text" name="username" value="" /></div>

<div><input type="submit" value="注册" /></div>
<?php
// 防XSS攻击
echo htmlspecialchars(base64_decode('PGh0bWw+PHNjcmlwdD5hbGVydCgiWFNTIik8L3NjcmlwdD48L2h0bWw+'), ENT_QUOTES, 'UTF-8'); 
?>
</form>
