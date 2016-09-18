<!-- jquery的jsonp实现 -->
<script type="text/javascript">
<!--
$.getJSON('<?php echo STATIC_URL; ?>/jsonp/connateCallback.html?callback=?', function(jsonData) {
	console.log(jsonData);
	alert(jsonData.data.msg);
});
// jquery会自动生成一个全局函数来替换callback=?中的问号，之后获取到数据后又会自动销毁，实际上就是起一个临时代理函数的作用。
// $.getJSON方法会自动判断是否跨域，不跨域的话，就调用普通的ajax方法；跨域的话，则会以异步加载js文件的形式来调用jsonp的回调函数。

jQuery(document).ready(function () {
$.ajax({
	'async' : false,
	'url' : '<?php echo STATIC_URL; ?>/jsonp/connateCallback.html',
	'type' : 'POST', // 如果是Jsonp，这里的post是无效的，默认（也只能）jsonp是通过get方式请求
	'dataType' : 'jsonp', // 如果是jsonp那么就和ajax无关了
	'jsonp' : 'callback', // 用以获得jsonp回调函数名的参数名
	//'data' : $datas,
	'timeout' : 5000,
	'success' : function (response) {
		console.log(response);
		alert(response.data.status);
	},
	error : function() {
        alert('fail');
	}
});
});
//-->
</script>