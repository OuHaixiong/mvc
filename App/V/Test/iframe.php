<div>
<h2>测试非同源策略下，读取密码</h2>
<script type="text/javascript">
<!--
function clickButton() {
	var pwd = window.frames['innerIframe'].document.getElementById('pwd');
	alert(pwd.value);
}
//-->
</script>
<iframe name="innerIframe" src="http://www.mvc.com/test/innerIframe.html"></iframe>
<div><input type="button" value="点击查看" onclick="clickButton()" /></div>
</div>