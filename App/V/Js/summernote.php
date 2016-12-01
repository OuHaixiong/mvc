
<!-- 关于summernote的更多接口请查看http://summernote.org/deep-dive/ -->
<p>Summernote 0.8.2 测试</p>

<form action="<?php echo $this->createUrl('/default/js/summernote'); ?>" method="post" enctype="multipart/form-data">
  <!-- <div class="summernote">summernote 1 test</div>
   -->
  <div class="form-group">
    <label for="contents">Contents</label>
    <textarea name="text" class="summernote" id="contents" title="Contents"></textarea>
  </div>
  <div class="summernote">summernote 2 test</div>
  <div><input type="button" value="打印编辑器内容" id="see_contents" /></div>
  <div><input type="button" value="设置编辑器内容" id="set_contents" /></div>
  <div><input type="submit" value="提交" /></div>
</form>

<!-- include libraries BS3 （引入需要的js和css，下面的两个js和两个css都是必须的）-->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css" />
<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script>
<!-- 引入Summernote的样式和js文件 -->
<link rel="stylesheet" href="<?php //echo STATIC_URL; ?>/js/base/summernote_0.8.2/summernote.css" />
<script type="text/javascript" src="<?php //echo STATIC_URL; ?>/js/base/summernote_0.8.2/summernote.js"></script>
<script type="text/javascript" src="<?php //echo STATIC_URL; ?>/js/js/summernote.js"></script>
<script type="text/javascript" src="/js/base/summernote_0.8.2/lang/summernote-zh-CN.js" ></script><!-- 引入中文语言包 -->
