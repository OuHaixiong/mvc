<p>下面测试防止表单重复提交</p>

<form action="#" method="post" enctype="multipart/form-data">
<div>用户名：<input type="text" name="username" value="" /></div>

<div><input type="submit" value="注册" /></div>
</form>
<script>
$(document).ready(function () {
    $('form').submit(function () {
        if (typeof($.data(this, 'disabledOnSubmit')) == 'undefined') {
            jQuery.data(this, 'disabledOnSubmit', {'submited':true});
            $('input[type=submit]', this).each(function () {
                $(this).attr('disabled', 'disabled');
            });
//             return true;
            console.log('提交了！！');return false;
        } else {
            return false;
        }
	});
});
</script>