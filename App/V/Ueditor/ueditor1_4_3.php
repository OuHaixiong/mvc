<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8" />
    <title>Ueditor跨域实现</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <script type="text/javascript" charset="utf-8" src="<?php echo STATIC_URL; ?>/js/base/ueditor1.4.3/ueditor.config.js"></script> <!-- 配置文件 -->
    <script type="text/javascript" charset="utf-8" src="<?php echo STATIC_URL; ?>/js/base/ueditor1.4.3/ueditor.all.js"></script> <!-- 编辑器源码文件 -->
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="<?php echo STATIC_URL; ?>/js/base/ueditor1.4.3/lang/zh-cn/zh-cn.js"></script>
</head>

<body>
  <div>
    <h1>实现跨域上传图片</h1>
    <script id="editor_content" type="text/plain" style="width:1024px;height:500px;"></script>
  </div>
  
  <script type="text/javascript">
     // 火狐和谷歌浏览器跨域问题，此句对单图上传有影响。解决跨域上传图片问题.跨域下单图和多图不能兼容，即单图上传不支持跨域
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor_content'); //实例化编辑器
    document.domain = 'mvc.com';
    ue.ready(function () { //对编辑器的操作最好在编辑器ready之后再做
        // 通过重写getActionUrl方法可以改变图片上传路径
//      UE.Editor.prototype._bkGetActionUrl = UE.Editor.prototype.getActionUrl;
//      UE.Editor.prototype.getActionUrl = function(action){
//          return this._bkGetActionUrl(action);
//      }
//     	var content = ueditor.getContent();
//         console.log(content);
//         ueditor.setContent('hello'); //设置编辑器的内容
//         content = ueditor.getContent(); //获取html内容，返回: <p>hello</p>
//         console.log(content);
//         content = ueditor.getContentTxt(); //获取纯文本内容，返回: hello
//         console.log(content);
    });
    
    if (UE.browser.isCompatible) {
//         console.log('浏览器与UEditor能够良好兼容');
    }
  </script>
</body>
</html>