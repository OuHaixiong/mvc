<form method="post">
    <div class="item">
		<label>用户名：</label> 
		<input type="text" size="24" value="" name="username" />
	</div>
	<div class="item">
		<label>密码：</label> 
		<input type="password" size="24" value="" name="password" />
	</div>
	<div class="item">
		<label>数字账号：</label> 
		<input type="text" size="24" name="num" />
	</div>
	<input type="submit" value="添加用户" />
</form>
<div><?php
echo $this->successInfo;
?></div>