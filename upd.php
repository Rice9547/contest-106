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
			border-style: none;
		}
		.main > button, td>button, input[type=button], input[type=submit]{
			font-size: 40px;
			color: black;
			background-color: yellow;
			margin: 5px;
			padding: 2px 80px;
			border-radius: 15px;
			border-style: solid;
		}
		input[type=text], select, input[type=date]{
			font-size: 36px;
			float: left;
		}
	</style>
</head>
<body>
	<?php
		include "nav.php";
		include "sql.php";
		$sql = "select * from `meal` where `rdnum` = '".$_GET['rdnum']."'";
		$result = mysqli_query($db, $sql);
		$Time = ['午餐', '下午茶', '晚餐'];
		$meal = mysqli_fetch_assoc($result);
	?>
	<div class="body">
		<div class="title">
			<input type="button" value="留言管理" name='msg' onclick="location.href='manage.php'">
			<input type="button" value="訂餐管理" name='order' style="background-color: orange;">
		</div>
		<div class="main">
			<form action="update.php" method="post">
				<table>
					<tr>
						<td><button disabled="disabled">訂餐編號</button></td>
						<td><input type="text" name="_rdnum" readonly="readonly" value="<?php echo $meal['rdnum'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">用餐日期</button></td>
						<td><input type="date" name="_useDate" value="<?php 
							for($i=0; $i<strlen($meal['useDate']); $i++){
								if($i==4 || $i==6) echo "-"; 
								echo $meal['useDate'][$i];
							}?>">
						</td>
					</tr>
					<tr>
						<td><button disabled="disabled">用餐時段</button></td>
						<td>
							<select name="_useTime">
								<option value="0">午餐</option>
								<option value="1">下午茶</option>
								<option value="2">晚餐</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐數量</button></td>
						<td><input type="text" name="_mealNum" value="<?php echo $meal['mealNum'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">套餐名稱</button></td>
						<td>
							<select name="_mealType">
								<?php
									for($i=1; $i<=10; $i++)
										echo "<option value='$i'>food$i</option>";
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐桌數</button></td>
						<td><input type="text" name="_deskNum" value="<?php echo $meal['deskNum'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂單桌號</button></td>
						<td>
							<!-- <input type="text" name="_deskID" value="<?php echo $meal['deskID'];?>"> -->
							<select name="_deskID">
							</select>
						</td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐姓名</button></td>
						<td><input type="text" name="_name" value="<?php echo $meal['name'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐電話</button></td>
						<td><input type="text" name="_phone" value="<?php echo $meal['phone'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐信箱</button></td>
						<td><input type="text" name="_email" value="<?php echo $meal['email'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐備註</button></td>
						<td><input type="text" name="_remark" value="<?php echo $meal['remark'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">用餐金額</button></td>
						<td><input type="text" name="_total" readonly="readonly" value="<?php echo $meal['total'];?>"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">需付訂金</button></td>
						<td>
							<input type="text" name="_OAO" readonly="readonly" value="<?php echo $meal['total']*0.1;?>">
						</td>
					</tr>
				</table>
				<input type="submit" name="" value="送出">
				<input type="button" name="" value="取消" onclick="location.href='manageOrder.php'">
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
	var useTime = <?php echo $meal['useTime'];?>;
	var food = <?php echo $meal['mealType'];?>;
	var Time = ['午餐', '下午茶', '晚餐'];
	var remain = [];
	var desk = [];
	var out = [];
	var flag = [];
	var init = true;
	function checkDesk(){
		if($('input[name=_deskNum]').val()>parseInt(remain[$('select[name=_useTime]').val()])){
			alert('剩餘桌數不足');
			$('input[name=_deskNum]').val('');
			$('select[name=_deskID]').hide();
		}else{
			$('select[name=_deskID]').show();
		}
		//console.log($('input[name=_deskNum]').val()+","+parseInt(remain[$('select[name=_useTime]').val()]));
	}
	function getDesk(){
		out = [];
		for(var i=1; i<=10; i++) desk[i] = flag[i] = false;
		$.ajax({
			url: "desk.php",
			type: "post",
			data: "date="+$('input[name=_useDate]').val().replace(/-/g, '')+"&useTime="+$('select[name=_useTime]').val()+"&rdnum="+$('input[name=_rdnum]').val(),
			success: function(msg) {
				var array = JSON.parse(msg), num = parseInt($('select[name=deskNum]').val());
				for(var i=0; i<array.length; i++)
					desk[array[i]] = true;
				$('select[name=_deskID]>option').remove();
				dfs(0, $('input[name=_deskNum]').val());
				if(init){
					$("select[name=_deskID]").children().each(function(){
						if($(this).text() == '<?php echo $meal['deskID'];?>')
							$(this).attr('selected', true);
					})
					init = false;	
				}
				
			}
		})
	}
	$(function(){
		$('select[name=_useTime]').val(useTime);
		$('select[name=_mealType]').val(food);
		$.ajax({
			url: "date.php",
			type: "post",
			data: "date="+$('input[name=_useDate]').val().replace(/-/g, '')+"&rdnum="+$('input[name=_rdnum]').val(),
			success: function(msg){
				//console.log(msg);
				remain = msg.split(',');
				$('select[name=_useTime]>option').each(function(){
					$(this).text(Time[parseInt($(this).val())]+"(剩餘"+remain[parseInt($(this).val())]+"桌)");
				})
			}
		})
		getDesk();
	})
	$('input[name=_mealNum]').change(function(){
		$('input[name=_total]').val($('input[name=_mealNum]').val()*300);
		$('input[name=_OAO]').val($('input[name=_mealNum]').val()*30);
	})
	$('input[name=_useDate]').change(function(){
		$.ajax({
			url: "date.php",
			type: "post",
			data: "date="+$('input[name=_useDate]').val().replace(/-/g, ''),
			success: function(msg){
				remain = msg.split(',');
				$('select[name=_useTime]>option').each(function(){
					$(this).text(Time[parseInt($(this).val())]+"(剩餘"+remain[parseInt($(this).val())]+"桌)");
				})
				checkDesk();
			}
		})
		getDesk();
	})
	$('select[name=_useTime]').change(function(){
		checkDesk();
		getDesk();
	})
	$('input[name=_deskNum]').change(function(){
		checkDesk();
		getDesk();
	})
	function dfs(index, len){
		//console.log('OAO');
		if(index == len){
			//console.log(out);
			$('select[name=_deskID]').append("<option value="+out+">"+out+"</option>");
			return;
		}
		for(var i=1; i<=10; i++){
			if(index!=0 && i<out[index-1]) continue;
			if(!desk[i] && !flag[i]){
				out[index] = i;
				flag[i] = true;
				dfs(index+1, len);
				flag[i] = false;
			}
		}
	}
</script>
</html>