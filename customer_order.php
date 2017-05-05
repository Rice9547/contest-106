<?php
	session_start();
	$_SESSION['body_page'] = 'customer_order';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		table{
			margin-left: auto;
			margin-right: auto;
			border-style: solid;
			border:1px;
			font-size: 40px;
		}
		.main > button, td>button, input[type=button]{
			font-size: 40px;
			color: black;
			background-color: yellow;
			margin: 5px;
			padding: 2px 80px;
			border-radius: 15px;
			border-style: solid;
		}
		input[type=text], select{
			font-size: 36px;
		}
		select{
			float: left;
		}
	</style>
</head>
<body>
	<?php
		include "nav.php";
		include "sql.php";
	?>
	<div class="body">
		<h1 class="title dark">訪客訂餐─選擇訂餐資訊</h1>
		<div class="main" id="main">
			<?php
				if(isset($_GET['rdnum'])){
			?>
			<script type="text/javascript">
				alert('訂餐成功!訂餐編號為<?php echo $_GET['rdnum'];?>');
			</script>
			<?php } ?>
			<table>
				<tr>
					<td colspan="8" >
						<button style="float: left; background-color: transparent;" onclick="w++;getWeek();">前一週<<</button>
						<span id="header"></span>
						<button style="float: right; background-color: transparent;" onclick="w--;getWeek();">>>下一週</button>
					</td>
				</tr>
				<tr>
					<td rowspan="2"></td>
					<?php
						$mon = ['一','二','三','四','五','六','日'];
						for($i=0 ;$i<count($mon); $i++){
							echo "<td class='mon'>星期$mon[$i]</td>";
						}
					?>
				</tr>
				<tr id="date">
				</tr>
				<?php
					$time = ['午餐','下午茶','晚餐'];
					for($i=0; $i<3; $i++){
						echo "<tr><td>$time[$i]</td>";
						for($j=0; $j<7; $j++)
							echo "<td id='$i-$j'></td>";
						echo "</tr>";
					}
				?>
			</table>
			<table id="OAO">
				<tr>
					<td><button disabled="disabled">日期</button></td>
					<td><input type="text" name="date" value="尚未選擇" readonly="readonly"></td>
					<td><button disabled="disabled">時段</button></td>
					<td>
						<select id="Time">
							<option value="0">中午</option>
							<option value="1">下午</option>
							<option value="2">晚上</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><button disabled="disabled">訂餐數量</button></td>
					<td>
						<select name='mealNum'>
							<?php
								for($i=1; $i<100; $i++){
									echo "<option>".$i."客</option>";
								}
							?>
						</select>			
					</td>
					<td><button disabled="disabled">套餐名稱</button></td>
					<td>
						<select name='mealType'>
							<?php
								for($i=1; $i<=10; $i++)
									echo "<option value='$i'>Food".($i<10?'0':'').$i."</option>";
							?>
						</select>			
					</td>
				</tr>
				<tr>
					<td><button disabled="disabled">訂餐桌數</button></td>
					<td>
						<select name='deskNum'>
							<?php
								for($i=1; $i<=10; $i++)
									echo "<option value='$i'>".$i."桌</option>";
							?>
						</select>			
					</td>
					<td colspan="2"><input type="button" style="background-color: mediumorchid;" value="自動產生桌號" onclick="getDesk('ac')"></td>
				</tr>
				<tr>
					<td><button disabled="disabled">桌號</button></td>
					<td><input type="text" name="deskID" readonly="readonly" value="尚未選擇"></td>
					<td colspan="2"><input type="button" style="background-color: mediumorchid;" onclick="go();" value="選擇桌號"></td>
				</tr>
			</table>
			<input type="button" value="確定訂餐" style="background-color: orange;" onclick="sub()">
			<input type="button" value="取消" style="background-color: orange;" onclick="location.href='customer_order.php'">
		</div>
		<div class="main" id="next">
			<table id="chDesk" border="1px">
				<tr>
					<th id="deskTitle" colspan="4"></th>
				</tr>
				<tr class="desk">
				</tr>
				<tr class="desk">
				</tr>
				<tr class="desk">
				</tr>
			</table>
			<div>
				<button onclick="checkDesk();">確定選取</button>
				<button onclick="resetDesk();">取消選取</button>
				<button onclick="$('#main').show();$('#next').hide();">放棄離開</button>
			</div>
		</div>
		<div class="main" id="sub">
			<form id="form" action="meal.php" method="post">
				<table style="margin:0px;" id='QAQAQ'>
					<tr>
						<td><button disabled="disabled">日期</button></td>
						<td><input type="text" name="_useDate" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">時段</button></td>
						<td><input type="text" name="_useTime" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐數量</button></td>
						<td><input type="text" name="_mealNum" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">套餐名稱</button></td>
						<td><input type="text" name="_mealType" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">訂餐桌數</button></td>
						<td><input type="text" name="_deskNum" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">桌號</button></td>
						<td><input type="text" name="_deskID" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">總金額</button></td>
						<td><input type="text" name="_total" readonly="readonly"></td>
					</tr>
					<tr>
						<td><button disabled="disabled">需付訂金</button></td>
						<td><input type="text" name="_OAO" readonly="readonly"></td>
					</tr>
					<tr>
						<td colspan="2">
							<button style="background-color:orange;" onclick="end();">確定訂餐</button>
							<button style="background-color:orange;" onclick="location.href='customer_order.php'">取消</button>
						</td>
					</tr>
				</table>
				<div id='mail'>
					<table>
						<tr>
							<td><button disabled="disabled">姓名</button></td>
							<td><input type="text" name="_name" class="re"></td>
						</tr>
						<tr>
							<td><button disabled="disabled">Email</button></td>
							<td><input type="text" name="_phone" class="re"></td>
						</tr>
						<tr>
							<td><button disabled="disabled">電話</button></td>
							<td><input type="text" name="_email" class="re"></td>
						</tr>
						<tr>
							<td><button disabled="disabled">備註</button></td>
							<td><input type="text" name="_remark" class="re"></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="button" name="sub" value="送出">
								<input type="button" name="reset" value="重設">
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
	var w = 0;
	var last, lastColor='#FFF';
	var desk = [];
	var deskCount = 0;
	var goSub = false;
	$('#form').submit(function(e){
		if(!goSub)	e.preventDefault();
	})
	$('input[name=reset]').click(function(){
		$('.re').val('');
	})
	$('input[name=sub]').click(function(){
		var submit = true;
		$('.re').each(function(){
			if($(this).val()==''){
				$(this).css('border-color', 'red');
				submit = false;
			}
		})
		if(submit){
			goSub = true;
			$("#form").submit();
		}
	})
	$('.re').change(function(){
		if($(this).val()!='') $(this).css('border-color', 'black');
	})
	function end(){
		$('#QAQAQ').hide();
		$('#mail').show();
		$('.title').text('訪客訂餐─填寫連絡方式');
	}
	function sub(){
		if($('input[name=deskID]').val()=='' || $('input[name=deskID]').val()=='尚未選擇' || $('input[name=date]').val()=='' || $('input[name=date]').val()=='尚未選擇') return;
		var t = ['午餐', '下午茶', '晚餐'];
		$('.title').text('訪客訂餐─已選擇訂餐資訊再確認');
		$('.title').css('font-size', '72px');
		$('#main').hide();
		$('#sub').show();
		$('#mail').hide();
		$('input[name=_useDate]').val($('input[name=date]').val());
		$('input[name=_useTime]').val(t[$('#Time').val()]);
		$('input[name=_mealNum]').val($('select[name=mealNum]').val());
		$('input[name=_mealType]').val($('select[name=mealType]').val());
		$('input[name=_deskNum]').val($('select[name=deskNum]').val());
		$('input[name=_deskID]').val($('input[name=deskID]').val());
		$('input[name=_total]').val(parseInt($('input[name=_mealNum]').val().replace('客',''))*300);
		$('input[name=_OAO]').val(parseInt($('input[name=_mealNum]').val().replace('客',''))*30);
	}
	$(function(){
		getWeek();
		$('#next').hide();
		$('#sub').hide();
	})
	function go(){
		$('#next').show();
		$('.title').text('訪客訂餐─選擇桌號');
		$('#main').hide();
		getDesk('new');
	}
	function drawBg(){
		for(var i=0; i<6; i++){
			var color = i%2?"lightblue":"lightskyblue";
			$('tr').eq(i).css('background-color', color);
		}
	}
	function getWeek(){
		$("#date").html("");
		var D = new Date();
		var K = D.getDay();
		var week = '';
		for(var i=1; i<8; i++){
			var Q = new Date();
			Q.setDate(Q.getDate() + i - K - w*7);
			if(i==7) week += "~";
			if(i==1 || i==7) week += Q.getFullYear()+"年"+(Q.getMonth()+1)+"/"+Q.getDate();
			$("#date").append("<td id='"+(Q.getFullYear())+"'>"+(Q.getMonth()+1)+"/"+Q.getDate()+"</td>");
			function OAO(Q,i){
				$.ajax({
					url:"date.php",
					type:"POST",
					dataType:"text",
					data:"date="+Q.getFullYear()+(Q.getMonth()>8?'':0)+(Q.getMonth()+1)+(Q.getDate()>9?'':0)+Q.getDate(),
					success:function(msg){
						var array = msg.split(',');
						for(var j=0; j<3; j++){
							$('#'+j+"-"+(i-1)).html(array[j]);
						}
					}
				})
			}OAO(Q,i);
		}
		$("#header").html(week);
		drawBg();
	}
	$('td').click(function(){
		if($(this).closest('div').attr('id') != 'main' || $(this).attr('class') == 'mon' || $(this).closest('table').attr('id') == 'OAO') return;
		if($('input[name=date]').val()!="尚未選擇"){
			$('#'+last).css('background-color', lastColor);
		}
		last= $(this).attr('id'); 
		lastColor = $(this).css('background-color');
		$(this).css('background-color', 'yellow');
		$('input[name=date]').val(lastColor);
		var Time = $(this).attr('id')[0];
		var date = $(this).attr('id')[2];
		$('#Time option').eq(Time).prop('selected', true);
		var year = $('#date > td').eq(date).attr('id');
		var day = $('#date > td').eq(date).html().split('/');
		var mon = ['一','二','三','四','五','六','日'];
		$('input[name=date]').val(year+"-"+(day[0]<10?'0':'')+day[0]+'-'+(day[1]<10?'0':'')+day[1]+"星期"+mon[date]);
		$('input[name=deskID]').val('');
	})
	$('#Time').change(function(){
		$('#'+last).css('background-color', lastColor);
		//console.log(last[0]);
		last = $('#Time').val() + last.substr(1,2);
		$('#'+last).css('background-color', 'yellow');
	})
	function getDesk(type){
		var day = $('input[name=date]').val().substr(0, 10).replace(/-/g,'');
		var useTime = $('#Time').val();
		for(var i=1; i<=10; i++) desk[i] = false;
		$.ajax({
			url: "desk.php",
			type: "POST",
			data: "date="+day+"&useTime="+useTime,
			dataType: "text",
			success:function(msg){
				console.log(msg);
				var array = JSON.parse(msg), num = parseInt($('select[name=deskNum]').val());
				for(var i=0; i<array.length; i++)
					desk[array[i]] = true;
				if(type=='ac'){
					if(num + array.length > 10){
						alert('剩餘桌數不足');
						$('input[name=deskID]').val('尚未選擇');
					}else{
						$('input[name=deskID]').val('');
						var count = 0, str = '';
						for(var i=1; i<=10&&count<num; i++){
							if(!desk[i]){
								str += (count==0?'':',') + i;
								count++;
							}
						}
						$('input[name=deskID]').val(str);
					}	
				}else{
					if(num + array.length > 10){
						$('.title').text('訪客訂餐─選擇訂餐資訊');
						$('#main').show();
						$('#meal').hide();
						alert('剩餘桌數不足');
					}else{
						$("#deskTitle").html($('input[name=date]').val());
						var html = '';
						//for(var i=1; i<=10; i++) console.log(desk[i]);
						for(var i=1; i<=4; i++){
							html += "<td id='"+i+"'>"+i+"號桌<br>"+(desk[i]?'已訂':'空')+"</td>";
						}
						$('.desk').eq(0).html(html);
						html = '';
						for(var i=5; i<=6; i++){
							html += "<td colspan='2' id='"+i+"'>"+i+"號桌<br>"+(desk[i]?'已訂':'空')+"</td>";
						}
						$('.desk').eq(1).html(html);
						html='';
						for(var i=7; i<=10; i++){
							html += "<td id='"+i+"'>"+i+"號桌<br>"+(desk[i]?'已訂':'空')+"</td>";
						}
						$('.desk').eq(2).html(html);
						deskCount = 0;
						chCss();
					}
				}
			}
		})
	}
	function chCss(){
		$('.desk>td').each(function(){
			//console.log($(this).html());
			if($(this).html().indexOf('已訂')>-1){
				$(this).css('background-color', 'purple')
			}
		})
		$('.desk>td').click(function(){
			if($(this).css('background-color') != 'rgba(0, 0, 0, 0)') return;
			if(deskCount == $('select[name=deskNum]').val()){
				alert('桌數已達上限');
				return;
			}
			$(this).css('background-color', 'yellow');
			deskCount++;
		})
	}
	function resetDesk(){
		$('.desk>td').each(function(){
			//console.log($(this).css('background-color'));
			if($(this).css('background-color') == 'rgb(255, 255, 0)'){
				$(this).css('background-color', '#FFF');
			}
			deskCount = 0;
		})
	}
	function checkDesk(){
		if(deskCount < $('select[name=deskNum]').val()){
			alert('請選取足夠的桌數');
			return;
		}
		var str = '';
		for(var i=0; i<$('.desk>td').length; i++){
			if($('.desk>td').eq(i).css('background-color') == 'rgb(255, 255, 0)'){
				if(str != '') str += ',';
				str += $('.desk>td').eq(i).attr('id');
			}
		}
		$('input[name=deskID]').val(str);
		$('#main').show();
		$('#next').hide();
		$('.title').text('訪客訂餐─選擇訂餐資訊');
	}
</script>
</html>