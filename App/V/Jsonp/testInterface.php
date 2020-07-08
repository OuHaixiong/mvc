<H3>接口测试</H3>

<form action="#" method="post" enctype="multipart/form-data">
<div>请求方式：
    <label><input name="method" type="radio" value="GET" checked="checked" />GET</label> 
    <label><input name="method" type="radio" value="POST" />POST</label> 
</div>
<div>请求URL：<input id="request_url" type="text" name="url" value="" size="150" /></div>
<div>请求数据：<textarea id="request_data" name="data" rows="10" cols="100"></textarea></div>
<div><input id="button" type="button" value="提交" /></div>
<?php
 
?>
</form>

<script type="text/javascript">
<!--

$('#button').click(function () {
  var requestMethod = $('input[name="method"]:checked').val();
  var requestUrl = $('#request_url').val();

  $.ajax({
	'async' : false,
	'url' : requestUrl,
	'type' : requestMethod, // 如果是Jsonp，这里的post是无效的，默认（也只能）jsonp是通过get方式请求
	// 'dataType' : 'jsonp', // 如果是jsonp那么就和ajax无关了  (貌似这里测试跨域请求不能写下面的三行)
	// 'jsonp' : 'callback', // 用以获得jsonp回调函数名的参数名
	// 'jsonpCallback' : 'doSomething', // 自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名，也可以写"?"，jQuery会自动为你处理数据
	headers: {
        "Authorization" : 'X-Authorization',
        "lang" : "en",
    },
	'data' : {
		page: 1,
        pageSize: 20,
    },
	'timeout' : 5000,
	'success' : function (response) {
		console.log(response);
		//alert(response.data.status);
	},
	error : function(response) {
        alert('fail');
	}
  })
});

//-->
</script>