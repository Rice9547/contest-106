<?php
	include 'sql.php';
	$sql = 'select * from `meal` where `useDate` = '.$_POST['date']." AND `useTime` = ".$_POST['useTime'];
	$result = mysqli_query($db, $sql);
	$i=0;
	$back = array();
	while($desk = $result->fetch_assoc()){
		if(isset($_POST['rdnum']) && $desk['rdnum']==$_POST['rdnum']) continue;
		$back = array_merge($back,explode(',', $desk['deskID']));
	}
	echo json_encode($back);
?>