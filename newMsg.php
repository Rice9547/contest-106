<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="jquery-3.1.1.min.js"></script>
	<style type="text/css">
		table {
			margin-left: auto;
			margin-right: auto;
		}
		td > button {
			font-size: 40px;
			color: black;
			background-color: yellow;
			margin: 5px;
			padding: 2px 80px;
			border-radius: 15px;
			border-style: solid;
		}
		td > input[type=text], input[type=password] {
			font-size: 40px;
			border-radius: 15px;
			border-style: solid;
		}
		form > input[type=submit], input[type=reset] {
			background-color: yellow;
			font-size: 40px;
			margin: 80px 15px;
		}
		span > input[type=checkbox] {
			zoom: 3.5;
		}
		td > span {
			font-size: 60px;
		}
		form {
			margin-top: -40px;
		}
	</style>
	<?php
		include "sql.php";
		if(isset($_GET['state'])){
			if(isset($_GET['auth'])){
				$sql = "delete from `msg` where `id` = ".$_GET['id'];
				mysqli_query($db, $sql);
				echo $sql;
				header('location: manage.php');
			}else{
				$sql = "UPDATE `msg` SET `appear` = 0 WHERE `id` = ".$_GET['id'];
				mysqli_query($db, $sql);
				echo $sql;
				header('location: customer_msg.php');
			}	
		}
		if(isset($_GET['id'])){
			$sql = "select * from `msg` where `id` = ".$_GET['id'];
			$result = mysqli_query($db, $sql);
			$msg = $result->fetch_assoc();
			$id = $msg['id'];
			$name = $msg['name'];
			$email = $msg['email'];
			$phone = $msg['phone'];
			$content = $msg['content'];
			$pwd = $msg['pwd'];
			$appear = $msg['appear'];
			$img = $msg['img'];
	?>
	<script type="text/javascript">
		$(function(){
			var img = '<?php echo $img;?>';
			$('input[name=name]').val('<?php echo $name?>');
			$('input[name=email]').val('<?php echo $email?>');
			$('input[name=phone]').val('<?php echo $phone?>');
			$('input[name=content]').val('<?php echo $content?>');
			$('input[name=pwd]').val('<?php echo $pwd?>');
			$('input[name=showEmail]').attr(<?php echo ($appear&4)?"'checked','true'":"''"; ?>);
			$('input[name=showPhone]').attr(<?php echo ($appear&2)?"'checked','true'":"''"; ?>);
			if(img.length > 30){
				$('#putImg').prepend('<img src="<?php echo $img;?>" height="300px" id="testImg">');
				$('input[name=img]').val('<?php echo $img;?>');
			}
		})		
	</script>
	<?php	}
	?>
	<?php
		if(isset($_POST['email'])){
			$name = $_POST['name'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$content = $_POST['content'];
			$pwd = $_POST['pwd'];
			$appear = 1;
			$appear += isset($_POST['showEmail'])*4;
			$appear += isset($_POST['showPhone'])*2;
			$img = $_POST['img'];
			if(isset($_POST['id'])){
				$sql = "UPDATE `msg` SET `name` = '$name', `email` = '$email', `phone` = '$phone', `content` = '$content', `pwd` = '$pwd', `appear` = '$appear', `img` = '$img' WHERE `id` = ".$_POST['id'];
			}else{
				$sql = "INSERT INTO `msg` (`name`, `email`, `phone`, `content`, `pwd`, `appear`, `img`) VALUES ('$name', '$email', '$phone', '$content', '$pwd', '$appear', '$img')";
			}
			mysqli_query($db, $sql);
			//if(isset($_POST['auth'])) header('location: manage.php');
			//else header('location: customer_msg.php');
			echo $sql;
		}
	?>
</head>
<body>
	<?php
		include "nav.php";
	?>
	<div class="body">
		<h1 class="title">
			訪客留言--<?php echo isset($_GET['id'])?"編輯":"新增"?>
			<button onclick="location.href = 'customer_msg.php'">回留言列表</button>
		</h1>
		<div class="main">
			<form id="newMsg" method="post" action="newMsg.php">
				<table>
					<tr>
						<td><button disabled="disabled">姓名</button></td>
						<td><input type="text" name="name"></td>
						<td></td>
					</tr>
					<tr>
						<td><button disabled="disabled">信箱</button></td>
						<td><input type="text" name="email"></td>
						<td><span><input type="checkbox" name="showEmail">顯示</span></td>
					</tr>
					<tr>
						<td><button disabled="disabled">電話</button></td>
						<td><input type="text" name="phone"></td>
						<td><span><input type="checkbox" name="showPhone">顯示</span></td>
					</tr>
					<tr>
						<td><button disabled="disabled">內容</button></td>
						<td><input type="text" name="content"></td>
						<td></td>
					</tr>
					<tr>
						<td><button disabled="disabled">圖片</button></td>
						<td id="putImg">
							<br>
							<input type="file" name="image/*" name="upImg">
						</td>
					</tr>
					<tr>
						<td><button disabled="disabled">留言序號</button></td>
						<td><input type="text" name="pwd"></td>
						<td></td>
					</tr>
				</table>
				<?php if(isset($_GET['id'])) echo "<input type='hidden' name='id' value='$id'>"?>
				<input type="submit" name="submit" value="送出">
				<input type="reset" name="reset" value="重設">
				<input type="hidden" name="img">
				<?php if(isset($_GET['auth'])) echo "<input type='hidden' name='auth' value='true'>"?>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
	$('input[type=file]').change(function(){
		var file = new FileReader();
		file.onload = function(e){
			$('#testImg').remove();
			$('#putImg').prepend("<img src='"+e.target.result+"' height='300px' id='testImg'>")
			$('input[name=img]').val(e.target.result);
		};
		file.readAsDataURL(this.files[0]);
	})
	$('#newMsg').submit(function(e){
		console.log('OAO');
		var reEmail = /^[A-Za-z0-9]{1,}@[A-Za-z0-9]{1,}\.[A-Za-z0-9.]{1,}$/;
		var rePhone = /^(([0-9]{2}\-?[0-9]{7,8})|([0-9]{4}\-?[0-9]{6}))$/;
		var rePwd = /^[A-Za-z]{3}[0-9]{3}$/;
		var name = $('input[name=name]').val(),
			email = $('input[name=email]').val(),
			phone = $('input[name=phone]').val(),
			content = $('input[name=content]').val(),
			pwd = $('input[name=pwd]').val();
		if(!reEmail.exec(email) || !rePhone.exec(phone) || !rePwd.exec(pwd) || name == "" || content == ""){
			e.preventDefault();
		}
		else{
			console.log(reEmail.exec(email));
			console.log(rePhone.exec(phone));
			console.log(rePwd.exec(pwd));
		}
	})
	$('input[type=reset]').click(function(){
		$('#testImg').remove();
	})
</script>
</html>