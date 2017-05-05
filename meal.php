<?php
	include 'sql.php';
	$date = str_replace('-', '', substr($_POST['_useDate'], 0, 10));
	$sql = "select * from `meal` where `useDate` = '".$date."' order by `rdnum` DESC";
	$result = mysqli_query($db, $sql);
	$max = mysqli_fetch_assoc($result)['rdnum'];
	$num = mysqli_num_rows($result);
	$sql = "insert into `meal` (";
	$val = "";
	$Time = ['午餐', '下午茶', '晚餐'];
	foreach ($_POST as $key => $value) {
		if($key == "_OAO") continue;
		$sql .= "`".substr($key, 1, strlen($key))."`,";
		if($key == "_useDate") $value = str_replace('-', '', substr($value, 0, 10));
		if($key == "_useTime"){
			for($i=0; $i<3; $i++)
				if($Time[$i] == $value) $value = $i;
		}
		$val .= "'$value',";
	}
	$sql .= "`rdnum`) VALUES (";
	$sql .= $val."'";
	if($num==0) $max = $date.'0001';
	else $max = $max+1;
	$sql .= $max."')";
	mysqli_query($db, $sql);
	header("location: customer_order.php?rdnum=$max");
?>