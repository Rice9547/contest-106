<?php
	session_start();
	$_SESSION['body_page'] = 'owner_manage';
	if($_SESSION['login']) header('location: manage.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.main > button{
			font-size: 60px;
			color: black;
			background-color: yellow;
			margin: 5px;
			padding: 2px 80px;
			border-radius: 15px;
			border-style: solid;
		}
		.main > input[type=text], input[type=password] {
			font-size: 60px;
			border-radius: 15px;
			border-style: solid;
		}
		.main > input[type=submit], input[type=reset] {
			background-color: yellow;
			font-size: 60px;
			margin: 80px 15px;
		}
	</style>
</head>
<body>
	<?php
		include "nav.php";
	?>
	<div class="body">
		<h1 class="title dark">網站管理--登入</h1>
		<div class="main">
			<button disabled="disabled">帳號</button><input type="text" name="user" class="re"><br>
			<button disabled="disabled">密碼</button><input type="password" name="pwd" class="re"><br>
			<input type="submit" name="submit" value="登入">
			<input type="reset" name="reset" value="重設">
		</div>
	</div>
</body>
<script type="text/javascript">
	$('input[name=submit]').click(function(){
		if($('input[name=user]').val()=='admin' && $('input[name=pwd]').val()=='1234') 
			location.href = 'manage.php';
	})
	$('input[name=reset]').click(function(){
		$('.re').val('');
	})
</script>
</html>