<div>测试google analytics的事件跟踪</div>
<p>
点击如下按钮，ga即可跟踪点击量等信息：<br />
<a class="ga_event_track" href="javascript:;" data-url="https://www.centos.org/download/" data-target="_blank" 
data-event_category="download" data-event_action="mBlockForLinux" data-event_label="CentOS 7" data-event_value="7.0">下载</a>
</p>

<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/google/gaEventTrack.js"></script>
<script>
/*  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40881605-2', 'auto');
  ga('send', 'pageview'); */
</script>