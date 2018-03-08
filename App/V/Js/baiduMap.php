<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";}
		#allmap{width:100%;height:500px;}
		p{margin-left:5px; font-size:14px;}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=pzcADmHkemB6HuVNUPx40Xk5Q49vQ2ma"></script>
	<title>纯文本的信息窗口</title>
</head>
<body>
	<div id="allmap"></div>
	<p>点击标注点，可查看由纯文本构成的简单型信息窗口</p>
	<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	map.enableScrollWheelZoom();
	map.centerAndZoom('中国湖南', 5);
	var point = new BMap.Point(116.417854,39.921988);
	var marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);              // 将标注添加到地图中
	//map.centerAndZoom(point, 15);
	
	var opts = {
// 	  width : 200,     // 信息窗口宽度
	 // height: 500,     // 信息窗口高度 , 不能写百分比
	  title : "海底捞王府井店" , // 信息窗口标题
	  enableMessage:true,//设置允许信息窗发送短息
	  message:"亲耐滴，晚上一起吃个饭吧？戳下面的链接看下地址喔~"
	}
	var messageHtml = '<div><p>地址：北京市东城区王府井大街88号乐天银泰百货八层</p><p>点后：0755-89654321</p><p>营业时间：08:59-19:78</p></div>';
// 	var messageHtml = '地址：北京市东城区王府井大街88号乐天银泰百货八层 电话：0755-89654321';
	var infoWindow = new BMap.InfoWindow(messageHtml, opts);  // 创建信息窗口对象 
	marker.addEventListener("click", function(){          
		map.openInfoWindow(infoWindow,point); //开启信息窗口
	});


	var point1 = new BMap.Point(114.011924,22.602198);
	var marker1 = new BMap.Marker(point1);  // 创建标注
	map.addOverlay(marker1);              // 将标注添加到地图中
	//var opts = {
// 	  width : 200,     // 信息窗口宽度
	 // height: 500,     // 信息窗口高度 , 不能写百分比
	 // title : "海底捞王府井店" , // 信息窗口标题
	//  enableMessage:true,//设置允许信息窗发送短息
	 // message:"亲耐滴，晚上一起吃个饭吧？戳下面的链接看下地址喔~"
	//}
	var messageHtml = '<div><p>深圳创客工场科技有限公司</p><p>地址：深圳市南山智园C3栋4楼</p><p>电话：0755-89654321</p><p>营业时间：06:00-19:58</p></div>';
// 	var messageHtml = '地址：北京市东城区王府井大街88号乐天银泰百货八层 电话：0755-89654321';
	var infoWindow1 = new BMap.InfoWindow(messageHtml);  // 创建信息窗口对象 
	marker1.addEventListener("click", function(){          
		map.openInfoWindow(infoWindow1,point1); //开启信息窗口
	});
</script>
</body>
</html>
