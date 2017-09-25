
$('.ga_event_track').on('click', function (e) {
//    console.log(e);
    e.preventDefault();
//    ga('send', 'event', 'Category', 'Action', 'Tag');
    // 事件类别、操作、标签、值
    // 标签：事件的额外信息【另一个报告维度】
    // 值：是一个整数而非字符串，不支持负整数
    
    var redirectTriggered = false;
    var eventParameters = {};
    eventParameters['eventCategory'] = $(this).data('event_category'); // 事件类别
    eventParameters['eventAction'] = $(this).data('event_action'); // 事件操作
    var tag = $(this).data('event_label');
    if (typeof(tag) != 'undefined') {
	eventParameters['eventLabel'] = tag; // 事件标签
    }
    var value = $(this).data('event_value');
    if (typeof(value) != 'undefined') {
	value = parseInt(value)
	if (value > 0) {
	    eventParameters['eventValue'] = value; // 事件值
	}
    }

    ga('send', 'event', eventParameters);
//    var url = $(this).attr('href');
    var url = $(this).data('url');
    var target = $(this).data('target');

    setTimeout(function () {
	if (!redirectTriggered && (typeof(url) != 'undefined')) {
	    if (target == '_blank') {
		window.open(url);
	    } else { // undefined
		document.location = url;
	    }
	}
    }, 1000);
});
