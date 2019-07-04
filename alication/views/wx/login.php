<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>烟台畜牧微观网登录</title>
		<meta name="keywords" content="烟台畜牧微观网">
		<meta name="description" content="烟台畜牧微观网">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
		<link href="/mobile/mobile/need/layer.css" rel="stylesheet" type="text/css">
		<link href="/mobile/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/mobile/mobile/layer.js"></script>
		<script type="text/javascript" src="/Content/js/jquery-3.1.1.min.js"></script>
	</head>
<body>
	<section>
		<div class="mainbg"><img src="/mobile/images/jsp.jpg" /></div>
		<form class="layui-form layui-form-pane" onSubmit='return false;' style='padding:50% 15% 0 15%'>
			<div class="layui-form-item layui-form-text">
				<div class="layui-input-block">
					<input type="text" name="admin_name" placeholder="登录名" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<div class="layui-input-block">
					<input type="password" name="admin_pass" placeholder="密码" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<div class="layui-input-block">
					<center><button class="layui-btn layui-btn-normal ui-dialog-submit" style='width:100%;'>登　录</button></center>
				</div>
			</div>
		</form>
	</section>
	<script>
	$(function() {
		//提交
		$('button.ui-dialog-submit').on('click', function() {
			$.post('/wxlogin/index', $('form').serialize(), function(r) {
				layer.open({
					content: r.message
					,skin: 'msg'
					,time: 2
				});
				if(r.state == 1) {
					location.href = r.url;
				}
			}, 'json');
		});
	});
	</script>
</body>
</html>
