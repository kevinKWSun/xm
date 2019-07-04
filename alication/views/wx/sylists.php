<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>散养户日志</title>
		<meta name="keywords" content="散养户日志">
		<meta name="description" content="散养户日志">
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
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
			<legend>日志列表　<a href='<?php echo base_url('wxsy/add'); ?>'><button class="layui-btn layui-btn-small">新增日志</button></a></legend>
		</fieldset>
	</section>
	<section>
		<table class="layui-table">
			<thead>
				<tr>
					<th>姓名</th>
					<th>时间</th>
					<th>详情</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php foreach($lists as $k=>$v) : ?>
						<tr>
							<td><?php echo $v['name']['realname']; ?></td>
							<td><?php if(!empty($v['addtime'])) { echo date('Y-m-d H:i:s', $v['addtime']); } ?></td>
							<td><a  href='<?php echo base_url('/wxsy/art/'.$v['id']); ?>'>查看</a></td>
						</tr>
					<?php endforeach ?>
				</tr>
			</tbody>
		</table>
		<center style="padding-bottom:70px;">
			<?php if($total>1){?>
			<button id="listsview" class="layui-btn layui-btn-small" style="with:100%;" data-url="<?php echo base_url('/wxsy/index/'.($p+1)); ?>">加载更多</button>
			<?php }else{echo '没有更多';}?>
		</center>
	</section>
	<div class="top_bar">
		<nav>
			<ul id="top_menu" class="top_menu">
				<li><a href="<?php echo base_url('wx'); ?>"><img src="/Content/wx/mobile/images/recommend_a.png" width='30'><label>首页</label></a></li>
			</ul>
		</nav>
	</div>
	<script>
		$(function() {
			$('#listsview').click(function() {
				var url = $(this).attr('data-url');
				$.get(url, {}, function(r) {
					if(r.html) {
						$(r.html).appendTo($('tbody'));
						$('#listsview').attr('data-url', r.url);
						if(r.flag) {
							var obj = $('#listsview').parent();
							obj.html('');
							$('<span>加载完毕</span>').appendTo(obj);
						}
					} else {
						var obj = $('#listsview').parent();
						obj.html('');
						$('<span>加载完毕</span>').appendTo(obj);
					}
				}, 'json');
			});
		});
	</script>
</body>
</html>