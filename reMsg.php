<?php
	include "sql.php";
	$id = $_GET['id'];
	$reMsg = $_GET['reMsg'];
	$sql = "update `msg` set `reMsg` = '$reMsg' where `id` = $id";
	mysqli_query($db, $sql);
	header('location: manage.php');
?>