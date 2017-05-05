<?php
	include "sql.php";
	$id = $_GET['id'];
	if(isset($_GET['oldId'])){
		$oldId = $_GET['oldId'];
		$sql = "update `msg` set `id` = $oldId, `oldId` = 0 where `id` = $id";
	}else{
		$sql = "update `msg` set `id` = 2147483647, `oldId` = $id where `id` = $id";
	}
	mysqli_query($db, $sql);
	header("location: manage.php");
?>