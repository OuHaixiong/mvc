
<form action="#" method="post">
    <div class="item">
		<label>用户名：</label> 
		<input type="text" size="24" value="" name="username" />
	</div>
	<div class="item">
		<label>密码：</label> 
		<input type="password" size="24" value="" name="password" />
	</div>
	<input type="submit" value="注册" />
</form>
<div><?php
echo $this->successInfo;
?></div>