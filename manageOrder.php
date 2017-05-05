<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.title > input[type=button] {
			background-color: gold;
			border: 1px;
			border-style: solid;
			border-radius: 15px;
			font-size: 70px;
			padding: 15px 45px 10px 45px;
		}
		table{
			margin: 0px auto;
		}
	</style>
</head>
<body>
	<?php
		include "nav.php";
		include "sql.php";
		$start = '10000000';
		$end = '99999999';
		if(isset($_GET['start']) && isset($_GET['end']) && strlen($_GET['start'])+strlen($_GET['end'])==20){
			$start = str_replace('-','',$_GET['start']);
			$end = str_replace('-','',$_GET['end']);
		}
		$sql = 'select * from `meal` order by `rdnum`';
		$result = mysqli_query($db, $sql);
		$Time = ['午餐', '下午茶', '晚餐'];
	?>
	<div class="body">
		<div class="title">
			<input type="button" value="留言管理" name='msg' onclick="location.href='manage.php'">
			<input type="button" value="訂餐管理" name='order' style="background-color: orange;">
		</div>
		<div class="main">
			<form>
				起始日:<input type="date" name="start">
				終止日:<input type="date" name="end">
				<input type="submit" name="" value="搜尋">
			</form>
			<table border="1">
				<tr>
					<th>訂餐編號</th>
					<th>用餐日期</th>
					<th>用餐時段</th>
					<th>餐點類型</th>
					<th>餐點數量</th>
					<th>桌數</th>
					<th>桌號</th>
					<th>姓名</th>
					<th>電話</th>
					<th>信箱</th>
					<th>訂單操作</th>
				</tr>
			<?php
				while($order = mysqli_fetch_assoc($result)){
					if($order['useDate'] > $end || $order['useDate'] < $start) continue;
			?>
				<tr>
					<td><?php echo $order['rdnum'];?></td>
					<td><?php echo $order['useDate'];?></td>
					<td><?php echo $Time[$order['useTime']];?></td>
					<td>Food<?php echo $order['mealType'];?></td>
					<td><?php echo $order['mealNum'];?></td>
					<td><?php echo $order['deskNum'];?></td>
					<td><?php echo $order['deskID'];?></td>
					<td><?php echo $order['name'];?></td>
					<td><?php echo $order['phone'];?></td>
					<td><?php echo $order['email'];?></td>
					<td><a href="upd.php?rdnum=<?php echo $order['rdnum'];?>">編輯</a> <a href="del.php?rdnum=<?php echo $order['rdnum'];?>">刪除</a></td>
				</tr>
			<?php } ?>
			</table>
		</div>
	</div>
</body>
</html>