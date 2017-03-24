<h3>下面是普通js的练习</h3>
<script>
if (window.localStorage) {
    alert('This browser supports localStorage.本地缓存是html5才支持的');
} else {
    alert('This browser does not support localStorage.');
}

localStorage.a = 3; // 增
localStorage['a'] = 'aaaaa'; // 改 ([]内的字符串一定要用引号)
localStorage.setItem('a', '你好'); // 增/改
localStorage.removeItem('a'); // 删

// var a = localStorage.a;
// var a = localStorage['a']; // 查
var a = localStorage.getItem('a');
alert(a);


</script>