<?php
	session_start();
	$_SESSION['body_page'] = 'customer_msg';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
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
		$sql = "select * from `msg` order by `id` desc";
		$result = mysqli_query($db, $sql);
		$num = mysqli_num_rows($result);
	?>
	<div class="body">
		<h1 class="title dark">訪客留言列表<button onclick="location.href = 'newMsg.php'">新增留言</button></h1>
		<div class="main">
			<table border="1">
			<?php 
				if($num == 0) echo "<h1>目前沒有留言</h1>";
				else{ 
					while($msg = $result->fetch_assoc()){ ?>
				<tr>
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
							if(!$msg['appear']&1) echo "已刪除";
							else{
						?>
						留言序號：<br>
						<input type="pwd" name="pwd" id="<?php echo $msg['pwd'];?>"><br>
						<span class="clk" id="newMsg.php?id=<?php echo $msg['id'];?>">編輯</span>
						<span class="clk" id="newMsg.php?id=<?php echo $msg['id'];?>&state=del">刪除</span>
						<?php }?>
					</td>
				</tr>
				<tr style="text-align: left">
					<td colspan="2">發表於<?php echo date("Y/m/d H:m:s" ,strtotime($msg['time'])); 
						if($msg['time'] != $msg['updTime']){
							echo " ● ".($msg['appear']&1?"更新於:":"刪除於:").date("Y/m/d H:m:s" ,strtotime($msg['updTime']));
						}
					?>
					</td>
				</tr>
				<tr style="margin-bottom: 15px;">
					<td><?php echo $msg['appear']&4?$msg['email']:"不顯示";?></td>
					<td><?php echo $msg['appear']&2?$msg['phone']:"不顯示";?></td>
				</tr>
				<?php
					if($msg['reMsg'] != ""){ ?>
				<tr>
					<td>管理員回覆</td>
					<td colspan="3" style="text-align: left;"><?php echo $msg['reMsg'];?></td>
				</tr>
				<?php }?>
				<tr>
					<td style="border-style: none; color: #FFF;">.</td>
				</tr>
			<?php }} ?>
			</table>	
		</div>
		
	</div>
</body>
<script type="text/javascript">
	$('.clk').click(function(){
		if($(this).parent().children().eq(1).val() == $(this).parent().children().eq(1).attr('id')){
			location.href = $(this).attr('id');
		}
	})
</script>
</html>