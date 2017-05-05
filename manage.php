<?php
	session_start();
	$_SESSION['login'] = true;
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
		table {
			margin-left: auto;
			margin-right: auto;
			border-style: solid;
			border: 1px;
			border-color: black;
			border-radius: 15px;
		}
	</style>
</head>
<body>
	<?php
		include "nav.php";
		include "sql.php";
		$sql = "select * from `msg` order by `id` DESC";
		$result = mysqli_query($db, $sql);
		$num = mysqli_num_rows($result);
	?>
	<div class="body">
		<div class="title">
			<input type="button" value="留言管理" name='msg' style="background-color: orange;">
			<input type="button" value="訂餐管理" name='order' onclick="location.href='manageOrder.php'">
		</div>
		<div class="main">
		<table border="1">
		<?php
			if($num == 0) echo "<h1>目前沒有留言</h1>";
			else{
				while($msg = $result->fetch_assoc()){
		?>
			<tr>
				<td rowspan="4">
					<?php 
						if($msg['oldId']) echo "<a href='msg_head.php?id=".$msg['id']."&oldId=".$msg['oldId']."'>取消置頂</a>";
						else echo "<a href='msg_head.php?id=".$msg['id']."'>置頂</a>";
					?>
				</td>
				<td rowspan="3">
					<?php 
						if(strlen($msg['img']) > 10) echo "<img src='".$msg['img']."' height='150px'>";
						else echo '沒有圖片';
					?>
				</td>
				<td style="background-color: lightblue;"><?php echo $msg['name'];?></td>
				<td><?php echo $msg['content'];?></td>
				<td rowspan="3">
					<?php 
						if($msg['appear']&1){
					?>
					<span class="clk" id="newMsg.php?id=<?php echo $msg['id'];?>&auth=true">編輯</span>
					<?php }?>
					<span class="clk" id="newMsg.php?id=<?php echo $msg['id'];?>&state=del&auth=true">刪除</span>
				</td>
			</tr>
			<tr style="text-align: left">
				<td colspan="2">發表於<?php echo date("Y/m/d H:m:s", strtotime($msg['time'])); 
					if($msg['time'] != $msg['updTime']){
						echo " ● ".($msg['appear']&1?"更新於:":"刪除於:").date("Y/m/d H:m:s", strtotime($msg['updTime']));
					}
				?>
				</td>
			</tr>
			<tr style="margin-bottom: 15px;">
				<td><?php echo $msg['appear']&4?$msg['email']:"不顯示";?></td>
				<td><?php echo $msg['appear']&2?$msg['phone']:"不顯示";?></td>
			</tr>
			<tr>
				<td>回覆內容</td>
				<td colspan="2"><input type="text" name="reMsg" size="43" placeholder="請輸入回覆內容" value="<?php echo $msg['reMsg'];?>" id="re<?php echo $msg['id'];?>"></td>
				<td><button onclick="reMsg(<?php echo $msg['id']?>)">送出</button></td>
			</tr>
			<tr>
				<td style="border-style: none; color: #FFF;">.</td>
			</tr>
		<?php }}?>
		</table>
		</div>
	</div>
</body>
<script type="text/javascript">
	$('.clk').click(function(){
		location.href = $(this).attr('id');
	})
	function reMsg(id){
		location.href = "reMsg.php?id="+id+"&reMsg="+$('#re'+id).val();
	}
</script>
</html>