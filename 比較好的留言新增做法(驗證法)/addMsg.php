<?php 
	session_start();
	$_SESSION['page'] = 'c_msg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<?php
		require 'nav.php';
		require 'sql.php';
	?>
	<div class="title">
		<h1>訪客留言列表<button onclick="location.href = 'c_msg.php'">新增留言</button></h1>
	</div>
	<div class="main">
		<form action="newMsg.php" method="post">
			<table>
				<tr>
					<td>姓名</td>
					<td><input type="text" name="name"></td>
				</tr>
				<tr>
					<td>E-mail</td>
					<td><input type="text" name="email"></td>
					<td><input type="checkbox" name="sh1">顯示</td>
				</tr>
				<tr>
					<td>電話</td>
					<td><input type="text" name="phone"></td>
					<td><input type="checkbox" name="sh2">顯示</td>
				</tr>
				<tr>
					<td>內容</td>
					<td><input type="text" name="content"></td>
				</tr>
				<tr>
					<td>留言序號</td>
					<td><input type="text" name="pwd"></td>
				</tr>
				<tr>
					<td colspan="3">
						<input type="submit" name="">
						<input type="reset" name="">
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
<script type="text/javascript">
	var re = {
		"name": /^.{1,}$/,
		"email": /^[A-Za-z0-9]{1,}@[A-Za-z0-9]{1,}\.[A-Za-z0-9.]{1,}$/,
		"phone": /^([0-9]{2}[0-9]{7,8}|[0-9]{4}[0-9]{6})$/,
		"content": /^.{1,}$/,
		"pwd": /^[a-zA-Z]{3}[0-9]{3}$/
	};
	$('input[type=submit]').click(function(e){
		var ok = true;
		$('input[type=text]').each(function(){
			$(this).css('border-color', 'black');
			if(!re[$(this).attr('name')].exec($(this).val())){
				$(this).css('border-color', 'red');
				ok =  false;
			}
		})
		if(!ok) e.preventDefault();
	})
</script>
</html>