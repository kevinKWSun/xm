<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>无害化处理详情</title>
		<meta name="keywords" content="无害化处理详情">
		<meta name="description" content="无害化处理详情">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link href="/Content/wx/mobile/style.css" rel="stylesheet" type="text/css">
		<link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
		<link href="/Content/wx/mobile/layer.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/Content/wx/mobile/layer.js"></script>
		<script type="text/javascript" src="/Content/js/jquery-3.1.1.min.js"></script>
	</head>
<body>
	<section>
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
			<legend>无害化处理详情</legend>
		</fieldset>
	</section>
	<section style="padding-bottom: 70px;">
		<table class="layui-table" lay-filter="demo">
			<tbody>
				<tr>
					<th>养殖场名称</th>
					<td><?php echo $res['hname']; ?></td>
				</tr>
				<tr>
					<th>时间</th>
					<td><?php if($res['add_time']) { echo date('Y-m-d H:i', $res['add_time']); } ?></td>
				</tr>
				<tr>
					<th>申报信息</th>
					<td><?php echo $res['con']; ?></td>
				</tr>
				<tr>
					<td colspan='2' align='center'>
						<?php $images = explode(',', $res['images']); if(!empty($images)) { ?>
						<?php foreach($images as $v) { ?>	
							<img src="<?php echo '/',$v; ?>" width='100'/>
						<?php } } ?>	
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<div id="mapDiv" style="width:100%; height: 300px"></div>
					</td>
				</tr>
			</tbody>
		</table>
	</section>
	<div class="top_bar">
		<nav>
			<ul id="top_menu" class="top_menu">
				<li><a href="<?php echo base_url('wx'); ?>"><img src="/Content/wx/mobile/images/recommend_a.png" width='30'><label>首页</label></a></li>
			</ul>
		</nav>
	</div>
	<script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
	<script>
		$(function(){
			var map; 
			var zoom = 12;
			 map = new T.Map("mapDiv");
			//设置显示地图的中心点和级别
			map.centerAndZoom(new T.LngLat(<?php echo $res['lng'],', ',$res['lat'];?>), zoom);
			//创建标注对象
			var marker = new T.Marker(new T.LngLat(<?php echo $res['lng'],', ',$res['lat'];?>));
			//向地图上添加标注
			map.addOverLay(marker);
		});
	</script>
</body>
</html>