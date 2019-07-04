<html>
	<head>
		<meta charset="UTF-8">
		<title>烟台畜牧微观网</title>
		<meta name="keywords" content="烟台畜牧微观网">
		<meta name="description" content="烟台畜牧微观网">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link href="/Content/wx/mobile/style.css" rel="stylesheet" type="text/css">
		<link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
		<link href="/Content/wx/mobile/need/layer.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/Content/wx/mobile/layer.js"></script>
		<script type="text/javascript" src="/Content/js/jquery-3.1.1.min.js"></script>
	</head>
<body>
	<section>
		<div class="mainbg"><img src="/Content/wx/mobile/images/jsp.jpg" /></div>
		<ul class="mainmenu">
			<li><a href="<?php echo base_url('wxqd/lists/'); ?>"><p><img src="/Content/wx/mobile/images/14.png"><span>官方兽医签到</span></p></a></li>
			<li><a href="<?php echo base_url('wxsy/'); ?>"><p><img src="/Content/wx/mobile/images/1.png"><span>散养户日志</span></p></a></li>
			<li><a href="<?php echo base_url('wxsynews/'); ?>"><p><img src="/Content/wx/mobile/images/14.png"><span>散养户信息</span></p></a></li>
			<li><a href="<?php echo base_url('wxsafe/'); ?>"><p><img src="/Content/wx/mobile/images/1.png"><span>安全生产</span></p></a></li>
			<li><a href="<?php echo base_url('wxharmless/'); ?>"><p><img src="/Content/wx/mobile/images/xhhs.png"><span>无害化处理</span></p></a></li>
		</ul>
	</section>
	<div class="top_bar">
		<nav>
			<ul id="top_menu" class="top_menu">
				<li><a href="javascript:;"><img src="/Content/wx/mobile/images/recommend_a.png" width='30'><label>首页</label></a></li>
				<!-- <li><a href="javascript:;"><img src="images/user.png" width='30'><label>用户</label></a></li> -->
			</ul>
		</nav>
	</div>
	<script>
	$(function(){
		/* layer.open({
			content: 'hello layer'
			,skin: 'msg'
			,time: 2
		});
		layer.open({
			content: '移动版和PC版不能同时存在同一页面'
			,btn: '我知道了'
		});
		layer.open({
			content: '您确定要刷新一下本页面吗？'
			,btn: ['刷新', '不要']
			,yes: function(index){
			  location.reload();
			  layer.close(index);
			}
		}); */
	});
	</script>
</body>
</html>
