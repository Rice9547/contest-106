<?php
	$back = array(10, 10, 10);
	include 'sql.php';
	for($i=0; $i<3; $i++){
		$SQL = "select * from `meal` where `useDate` = '".$_POST['date']."' AND `useTime` = $i";
		$res = mysqli_query($db, $SQL);
		while($meal = $res->fetch_assoc()){
			if(isset($_POST['rdnum']) && $meal['rdnum']==$_POST['rdnum']) continue;
			$back[$i] -= $meal['deskNum'];
		}
		echo "$back[$i]";
		if($i!=2) echo ',';
	}
?>