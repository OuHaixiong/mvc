<h3>下面是返回页面顶部的js练习</h3>

<p>段</p>
<p>段<img src="/images/kao.jpg" /></p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>
<p>段</p>
<p>段</p>
<p>段落</p>

<a id="back_to_top" href="javascript:;">Back To Top</a> 
<style>
<!--
#back_to_top{
    position:fixed;
    display:none;
    bottom:100px;
    right:80px;
}
-->
</style>
<script type="text/javascript">
<!--
// Back To Top  
$(document).ready(function(){
    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            $('#back_to_top').fadeIn(1000);
        } else {
            $('#back_to_top').fadeOut(1000);
        }
    });
    $("#back_to_top").click(function(){
        $('body,html').animate({scrollTop:0},1000);
        return false;
    }); 

    // 下面是自动替换丢失的图片
    $("img").error(function () {  
	    $(this).unbind("error").attr("src", "missing_image.gif");  
	});

    // 在鼠标悬停时显示淡入/淡出特效
    $("img").hover(function(){
        $(this).fadeTo("slow", 1.0); // This should set the opacity to 100% on hover
    },function(){
        $(this).fadeTo("slow", 0.6); // This should set the opacity back to 60% on mouseout
    });
    
});
//-->
</script>
