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

