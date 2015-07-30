<?php
?>
<style type="text/css">
html,body{ height:100%} 
#id1,#id2 {
	position: relative;
	left: 0px;
	top: 0px;
}
#id1 .sz,#id2 .sz {
	position: absolute;
	top: 20px;
	right: 50px;
	z-index: 98;
}
#id1 .image,#id2 .image {
	position: absolute;
	top: 30px;
	right: 150px;
	z-index: 99;
}
#hui{
	background-color: #000;
	position: fixed;
	height: 100%;
	width: 100%;
	left: 0px;
	top: 0px;
	filter: alpha(opacity=50);
	-moz-opacity: 0.5;
	-khtml-opacity: 0.5;
	opacity: 0.5;
	z-index: 88;
}
#id2 .image {
	display: none;
}
</style>
<div id="hui">&nbsp;</div>

<div id="id1">
    <h2>这里是第一个个大块</h2>
    <div class="sz"><a href="#">设置1</a></div>
    <div class="image" id="im1" onclick="display_2()"><a href="#m2"><img  alt=""  src="/images/kao.jpg" /></a></div>
</div>

<p>
&nbsp;
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
</p>
<p>
&nbsp;
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
中间是n个p
<br/>
</p>

<div id="id2">
    <h2>这里是第二个大块<a name="m2" id="m2"></a></h2>
    <div class="sz"><a href="#">设置1</a></div>
    <div class="image" id="im2"><img alt=""  src="/images/52_avatar_middle.jpg" /></div>
</div>

<script type="text/javascript">
function display_2() {
	document.getElementById('im1').style.display='none';
	document.getElementById('im2').style.display='block';
}

</script>