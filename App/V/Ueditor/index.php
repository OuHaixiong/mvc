<!DOCTYPE HTML>
<html lang="en-US">
<head>
  <meta charset="UTF-8" />
  <title>Ueditor例子 -- 学习Ueditor</title>
</head>
<body>
  <script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/base/ueditor/ueditor.config.js"></script> <!-- 配置文件 -->
  <script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/base/ueditor/ueditor.all.js"></script> <!-- 编辑器源码文件 -->
  
  <script id="container" name="content" type="text/plain">这里是初始化配置</script> <!-- 加载编辑器的容器 -->
  
  
  
  <script type="text/javascript">
    var ueditor = UE.getEditor('container', { // 实例化编辑器
        autoHeight: true  // 貌似没什么用
    }); 
//     var ue_content = UE.getContent(); // 貌似没有这个方法

    ueditor.ready(function () {//对编辑器的操作最好在编辑器ready之后再做
        var content = ueditor.getContent();
        console.log(content);
        ueditor.setContent('hello'); //设置编辑器的内容
        content = ueditor.getContent(); //获取html内容，返回: <p>hello</p>
        console.log(content);
        content = ueditor.getContentTxt(); //获取纯文本内容，返回: hello
        console.log(content);
    });

    if (UE.browser.isCompatible) {
        console.log('浏览器与UEditor能够良好兼容');
    }

  </script>
</body>
</html>