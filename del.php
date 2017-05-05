<?php
	include 'sql.php';
	$rdnum = $_GET['rdnum'];
	$sql = "DELETE FROM `meal` WHERE `rdnum` = '$rdnum'";
	mysqli_query($db, $sql);
	header('location: manageOrder.php');
?>