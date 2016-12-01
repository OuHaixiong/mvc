
// 关于summernote的更多接口请查看http://summernote.org/deep-dive/
$(document).ready(function () {
    $('.summernote').summernote({ // 初始化（initialize）编辑器
        height : 250, // 内框高度
        //width : 300, // 宽度（默认100%）
        //toolbar : false, // 是否需要工具条；false：不要，true（默认）：要
        lang : 'zh-CN', // 设置语言为中文；默认语言为：en-US
        minHeight : 100, // 最小高度。指拖动拉伸条时，最大和最小的高度；同理宽度也可以
        maxHeight : 500, // 最大高度
        focus : true, // 是否打开页面时就获得焦点，默认false：不获取，true：获得焦点
          
            
    });
    
    $('#see_contents').click(function () {
//	$('.summernote').summernote('destroy'); // 取消掉编辑器，将回到没有编辑器状态
	console.log($('.summernote').summernote('code')); // 获取编辑器内容
//	var string = '<h1>this is 设置的尼日尔内容</h1>';
//	$('.summernote').summernote('code', string); // 设置编辑器内容
//	console.log($('.summernote').eq(1).summernote('code')); // 获取第二个编辑器内容（如果有多个的话）
        
    });
    $('#set_contents').click(function () {
        $('.summernote').summernote('code', '<p>发的是你的事，<br /> ni hao  w ye hao </p>'); // 设置编辑器内容
    });
});
