<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>新增无害化处理</title>
		<meta name="keywords" content="新增无害化处理">
		<meta name="description" content="新增无害化处理">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link href="/Content/wx/mobile/style.css" rel="stylesheet" type="text/css">
		<link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
		<link href="/Content/wx/mobile/need/layer.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/Content/wx/mobile/layer.js"></script>
		<script type="text/javascript" src="/Content/js/jquery-3.1.1.min.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	</head>
<body>
	<section>
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
			<legend><?php echo $fname?>处理</legend>
		</fieldset>
	</section>
	<section>
		<form class="layui-form layui-form-pane" onSubmit='return false;' id="sy-form">
			<div class="layui-form-item layui-form-text">
				<div class="layui-input-block" style='margin:0 1%;'>
					<div id="mapDiv" style="width:100%; height: 150px"></div>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">申报信息</label>
				<div class="layui-input-block">
					<textarea placeholder="必填,申报信息" class="layui-textarea" name="remark"></textarea>
				</div>
			</div>
			<div id="sy-ablum"></div>
			<div id="location">
				<input type="hidden" name="hname" value="<?php echo $fname?>"/>
				<input type="hidden" name="lng" value=""/>
				<input type="hidden" name="lat" value=""/>
			</div>
			<div class="layui-form-item layui-form-text">
				<div class="layui-form-item">
					<center>
						<button type="button" class="layui-btn layui-btn-normal" onclick="wxupload.chooseImage($('#sy-ablum'))" style='width:40%'><!-- <i class="layui-icon">&#xe67c;</i> -->拍照(死亡情况)</button>
						<button id="sy-submit" class="layui-btn layui-btn-normal" style='width:40%'>提交</button>
					</center>
				</div>
			</div>
		</form>
	</section>
	<div class="top_bar">
		<nav>
			<ul id="top_menu" class="top_menu">
				<li><a href="<?php echo base_url('wx'); ?>"><img src="/Content/wx/mobile/images/recommend_a.png" width='30'><label>首页</label></a></li>
			</ul>
		</nav>
	</div>
	<script type="text/javascript">
		$(function(){
			$('#sy-submit').click(function() {
				$.post('<?php echo base_url('wxharmless/add'); ?>', $('#sy-form').serialize(), function(r) {
					layer.open({
						content: r.message
						,skin: 'msg'
						,time: 2
					});
					if(r.state == 1) {
						location.href = '<?php echo base_url('wxharmless'); ?>';
					}
				}, 'json');
			});
		});
	</script>
</body>
</html>
<script type="text/javascript" src="http://api.tianditu.com/api?v=4.0"></script>
<?php if(is_array($signPackage)) { ?>
	<script type="text/javascript">
		var map; 
		var zoom = 12;
		map = new T.Map("mapDiv");
		var wxupload = wxupload || {};
		wx.config({
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: <?php echo $signPackage["timestamp"];?>,
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: [
				'checkJsApi',
				'openLocation',
				'getLocation',
				'chooseImage',
				'uploadImage'
			  ]
		});
		wx.ready(function () {
			wx.checkJsApi({
				jsApiList: [
					'getLocation',
					'chooseImage',
					'uploadImage'
				],
				success: function (res) {
					if (res.checkResult.getLocation == false) {
						alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
						return;
					}
				}
			});
			wx.getLocation({
				success: function (res) {
					$('input[name=lat]').val(res.latitude);
					$('input[name=lng]').val(res.longitude);
					map.centerAndZoom(new T.LngLat(res.longitude, res.latitude), zoom);
					var marker = new T.Marker(new T.LngLat(res.longitude, res.latitude));
					//向地图上添加标注
					map.addOverLay(marker);
				},
				cancel: function (res) {
					alert('用户拒绝授权获取地理位置');
				}
			});
			wxupload.chooseImage = function(obj){
				wx.chooseImage({
					count: 9,
					sizeType: ['original', 'compressed'],
					sourceType: ['camera'],
					success: function(res) {
						var localIds = res.localIds;
						wx.uploadImage({
							localId: '' + localIds,
							isShowProgressTips: 1,
							success: function(res) {
								serverId = res.serverId;
								$('<input name="img[]" type="hidden" value="'+serverId+'"/>').appendTo(obj);
							}
						});
					}
				});
			}
		});
	</script>
<?php } ?>