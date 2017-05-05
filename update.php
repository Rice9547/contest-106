<?php
	include 'sql.php';
	$sql = 'select * from `meal` where `useDate` = "'.str_replace('-','',$_POST['_useDate']).'" order by `rdnum` DESC';
	$result = mysqli_query($db, $sql);
	$OAO = mysqli_fetch_assoc($result);
	$num = $OAO['rdnum'];
	$count = mysqli_num_rows($result);
	$sql = "";
	foreach ($_POST as $key => $value) {
		if($key == '_OAO' || $key == '_rdnum') continue;
		if($key == '_useDate') $value = str_replace('-','',$value);
		$key = substr($key, 1, strlen($key));
		$sql .= "`$key` = '$value', ";
	}
	$rdnum = $_POST['_rdnum'];
	if($num == 0) $_POST['_rdnum'] = str_replace('-','',$_POST['_useDate'])+"0001";
	else if(str_replace('-','',$_POST['_useDate']) != $OAO['useDate']) $_POST['_rdnum'] = ($num+1);
	$sql = "UPDATE `meal` SET ".$sql."`rdnum`='".$_POST['_rdnum']."' where `rdnum` = '$rdnum'";
	echo $sql;
	mysqli_query($db, $sql);
	header('location: manageOrder.php');
?>