<script type="text/javascript" src="jquery-3.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="nav.css">
<div class="main_nav">
	<input type="button" value="訪客留言" name="customer_msg">
	<input type="button" value="訪客訂餐" name="customer_order">
	<input type="button" value="網站管理" name="owner_manage">
</div>

<script type="text/javascript">
	var body_page = '<?php echo $_SESSION['body_page'];?>';
	$('input[name='+body_page+']').css('background-color', 'orange');
	$('.main_nav > input[type=button]').click(function(){
		location.href = $(this).attr('name')+".php";
	})
</script>