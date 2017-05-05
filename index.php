<?php
	session_start();
	$_SESSION['body_page'] = 'index';
	$_SESSION['login'] = false;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		include "nav.php";
	?>
	<div class="body">
		<h1 style="font-size: 120px;">線上訂餐網站系統<br>網頁內容</h1>
	</div>
</body>
</html>