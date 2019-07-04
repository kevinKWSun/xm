<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>新增签到</title>
		<meta name="keywords" content="官方兽医签到">
		<meta name="description" content="官方兽医签到">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link href="/Content/wx/mobile/style.css" rel="stylesheet" type="text/css">
		<link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
		<link href="/Content/wx/mobile/need/layer.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/Content/wx/mobile/layer.js"></script>
		<!--<script type="text/javascript" src="/Content/js/jquery-3.1.1.min.js"></script>-->
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		
		<script type="text/javascript" src="/Content/wx/sign/libs/modernizr.js"></script>
		<script type="text/javascript" src="/Content/wx/sign/libs/jquery.js"></script>
	</head>
<body>
	<section>
		<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
			<legend>新增签到</legend>
		</fieldset>
	</section>
	<section>
		<form class="layui-form layui-form-pane" onSubmit='return false;' id="qd-form" style='padding-bottom:80px;'>
			<div id="ablum"></div>
			<div id="location">
				<input type="hidden" name="longitude" value=""/>
				<input type="hidden" name="latitude" value=""/>
				<input type="hidden" name="speed" value=""/>
				<input type="hidden" name="accuracy" value=""/>
			</div>
			<div class="layui-form-item layui-form-text">
				<div class="layui-input-block" style='margin:0 1%;'>
					<div id="mapDiv" style="width:100%; height: 120px"></div>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">签名</label>
				<div class="layui-input-block" style='border:1px dashed #ddd; margin:10px 9%;'>
					<div id="signatureparent">
						<div id="signature"></div>
					</div>
				</div>
				<div class="layui-input-block">
					<center id="tools"><input type="hidden" name="signbak"/></center>
				</div>
				<!--<div class="layui-input-block">
					<div id="displayarea" style="display:none;"></div>
				</div>-->
				<input type="hidden" name="sign" value="" />
			</div>
			<div class="layui-form-item layui-form-text">
				<label class="layui-form-label">备注内容</label>
				<div class="layui-input-block">
					<textarea placeholder="选填备注内容" class="layui-textarea" name="remark"></textarea>
				</div>
			</div>
			<div class="layui-form-item layui-form-text">
				<div class="layui-form-item">
					<center id="sumit_center">
						<button type="button" class="layui-btn layui-btn-normal" onclick="wxupload.chooseImage($('#ablum'))" style='width:40%'><!-- <i class="layui-icon">&#xe67c;</i> -->拍照</button>
						
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
<script>
(function($) {
	var signstatus = {};
	signstatus.stat = false;
	var topics = {};
	$.publish = function(topic, args) {
	    if (topics[topic]) {
	        var currentTopic = topics[topic],
	        args = args || {};
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            currentTopic[i].call($, args);
	        }
	    }
	};
	$.subscribe = function(topic, callback) {
	    if (!topics[topic]) {
	        topics[topic] = [];
	    }
	    topics[topic].push(callback);
	    return {
	        "topic": topic,
	        "callback": callback
	    };
	};
	$.unsubscribe = function(handle) {
	    var topic = handle.topic;
	    if (topics[topic]) {
	        var currentTopic = topics[topic];
	
	        for (var i = 0, j = currentTopic.length; i < j; i++) {
	            if (currentTopic[i] === handle.callback) {
	                currentTopic.splice(i, 1);
	            }
	        }
	    }
	};
})(jQuery);
</script>
<script src="/Content/wx/sign/src/jSignature.js"></script>
<script src="/Content/wx/sign/src/plugins/jSignature.CompressorBase30.js"></script>
<script src="/Content/wx/sign/src/plugins/jSignature.UndoButton.js"></script> 
<script src="/Content/wx/sign/src/plugins/signhere/jSignature.SignHere.js"></script> 
<script>
$(document).ready(function() {
	// This is the part where jSignature is initialized.
	var $sigdiv = $("#signature").jSignature({'UndoButton':true})
	// All the code below is just code driving the demo. 
	, $tools = $('#tools')
	, $extraarea = $('#displayarea')
	, pubsubprefix = 'jSignature.demo.';
	var export_plugins = $sigdiv.jSignature('listPlugins','export')
	//, chops = ['<input type="button" value="生成签名" class="layui-btn layui-btn-normal"/>']
	, chops = ['<button class="layui-btn layui-btn-normal" id="submit" style="width:40%">提交</button>']
	, name;
	name = 'image';
	$(chops.join('')).bind('click', function(e){
		var data = $sigdiv.jSignature('getData', name);
		$.publish(pubsubprefix + 'formatchanged');
		$('input[name=sign]').val(data.join(','));
		$.publish(pubsubprefix + data[0], data);
		$.post('<?php echo base_url('wxqd/sign'); ?>', $('#qd-form').serialize() ,function(r) {
			layer.open({
				content: r.message
				,skin: 'msg'
				,time: 2
			});
			if(r.state == 1) {
				location.href = '<?php echo base_url('wxqd/lists'); ?>';
			}
		}, 'json');
		// if(!jSignatureInstance.dataEngine.data.length)
			// layer.open({
				// content: '请签名!'
				// ,skin: 'msg'
				// ,time: 2
			// });
		// } else {
			
		// }
		
	}).appendTo($('#sumit_center'));
	$('<input type="button" value="重写" class="layui-btn layui-btn-normal" style="width:83%;"/>').bind('click', function(e){
		$sigdiv.jSignature('reset');
		$('input[name=sign]').val('');
		$extraarea.html('');
		$('input[name=signbak]').val(0);
	}).appendTo($tools)
	$.subscribe(pubsubprefix + 'formatchanged', function(){
		$extraarea.html('');
	})
	$.subscribe(pubsubprefix + 'image/png;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		$('<span><b></b></span>').appendTo($extraarea);
		$(i).appendTo($extraarea);
	});
	// if (Modernizr.touch){
		// $('#scrollgrabber').height($('#content').height())		
	// }
})
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
					$('input[name=latitude]').val(res.latitude);
					$('input[name=longitude]').val(res.longitude);
					$('input[name=speed]').val(res.speed);
					$('input[name=accuracy]').val(res.accuracy);
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