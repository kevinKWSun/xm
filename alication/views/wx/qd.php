<!doctype html>
<html lang="zh">
<html>
<head>
    <meta charset="utf-8">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
	   Remove this if you use the .htaccess -->
	
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=0.1, minimum-scale=1.0, width=device-width">
	<meta content="yes" name="apple-mobile-web-app-capable" />
	<meta content="black" name="apple-mobile-web-app-status-bar-style" />
	<meta content="telephone=no" name="format-detection" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!--<meta name="viewport" content="initial-scale=1.0, target-densitydpi=device-dpi" /><!-- this is for mobile (Android) Chrome -->
	<!--<meta name="viewport" content="initial-scale=1.0, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  -->

	<link href="/Content/wx/css/cate.css" rel="stylesheet" type="text/css">
	<link href="/Content/wx/css/iscroll.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Content/wx/sign/libs/modernizr.js"></script>
	<!--[if lt IE 9]>
	<script type="text/javascript" src="Content/wx/sign/libs/flashcanvas.js"></script>
	<![endif]-->
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<style type="text/css">
	
		div {
			margin-top:1em;
			margin-bottom:1em;
		}
		input {
			padding: .5em;
			margin: .5em;
		}
		select {
			padding: .5em;
			margin: .5em;
		}
		
		#signatureparent {
			color:darkblue;
			background-color:darkgrey;
			/*max-width:600px;*/
			padding:20px;
		}
		
		/*This is the div within which the signature canvas is fitted*/
		#signature {
			border: 2px dotted black;
			background-color:lightgrey;
		}

		/* Drawing the 'gripper' for touch-enabled devices */ 
		// html.touch #content {
			// float:left;
			// width:92%;
			// background-color:red;
		// }
		// html.touch #scrollgrabber {
			// float:right;
			// width:4%;
			// margin-right:2%;
			// background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)
		// }
		html.borderradius #scrollgrabber {
			border-radius: 1em;
		}
	</style>
</head>
<body>
<div id="wrap" style="width:100%;">
	<form id="qd-form" onsubmit="return fasle;">
		<div id="ablum" style="padding:15px;">
		</div>
		<div>
			<input type="button" value="拍照" style="height:60px;width:93%;font-size:24px;border-radius:15px;font-weight:bold;" id="subimg" onclick="wxupload.chooseImage($('#ablum'))"/>
		</div>
		<div id="location">
			<input type="hidden" name="longitude" value=""/>
			<input type="hidden" name="latitude" value=""/>
			<input type="hidden" name="speed" value=""/>
			<input type="hidden" name="accuracy" value=""/>
		</div>
		<div id="content">
			<div><span style="padding-left:15px;font-size:24px;">签名</span></div>
			<div id="signatureparent">
				<div id="signature"></div>
			</div>
			<div id="tools"></div>
			<div>
				<div id="displayarea"></div>
			</div>
			<input type="hidden" name="sign" value="" />
		</div>
	</form>
	<div style="clear:both;"></div>
	<div style="">
		<input id="submit" type="button" value="提交" style="height:60px;width:93%;font-size:24px;border-radius:15px;font-weight:bold;"/>
	</div>
</div>
<script src="Content/wx/sign/libs/jquery.js"></script>
<script>
/*  @preserve
jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)
Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
http://dojofoundation.org/license for more information.
*/
(function($) {
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
<script src="Content/wx/sign/src/jSignature.js"></script>
<script src="Content/wx/sign/src/plugins/jSignature.CompressorBase30.js"></script>
<!--<script src="Content/wx/sign/src/plugins/jSignature.CompressorSVG.js"></script>-->
<script src="Content/wx/sign/src/plugins/jSignature.UndoButton.js"></script> 
<script src="Content/wx/sign/src/plugins/signhere/jSignature.SignHere.js"></script> 
<script>
$(document).ready(function() {
	
	// This is the part where jSignature is initialized.
	var $sigdiv = $("#signature").jSignature({'UndoButton':true})
	
	// All the code below is just code driving the demo. 
	, $tools = $('#tools')
	, $extraarea = $('#displayarea')
	, pubsubprefix = 'jSignature.demo.';
	
	// var export_plugins = $sigdiv.jSignature('listPlugins','export')
	// , chops = ['<span><b>生成图片 </b></span><select>','<option value="">(select export format)</option>']
	// , name;
	// for(var i in export_plugins){
		// if (export_plugins.hasOwnProperty(i)){
			// name = export_plugins[i];
			// chops.push('<option value="' + name + '">' + name + '</option>')
		// }
	// }
	var export_plugins = $sigdiv.jSignature('listPlugins','export')
	, chops = ['<input type="button" value="生成签名" style="height:45px;width:100px;border-radius:5px;font-weight:bold;"/>']
	, name;
	name = 'image';
	//chops.push('</select><span><b> 或者: </b></span>');
	$(chops.join('')).bind('click', function(e){
		var data = $sigdiv.jSignature('getData', name);
		$.publish(pubsubprefix + 'formatchanged');
		$('input[name=sign]').val(data.join(','));
		$.publish(pubsubprefix + data[0], data);
	}).appendTo($tools)
	// $(chops.join('')).bind('change', function(e){
		// if (e.target.value !== ''){
			// var data = $sigdiv.jSignature('getData', e.target.value);
			// $.publish(pubsubprefix + 'formatchanged')
			// if (typeof data === 'string'){
				// $('textarea', $tools).val(data)
			// } else if($.isArray(data) && data.length === 2){
				// $('textarea', $tools).val(data.join(','))
				// $.publish(pubsubprefix + data[0], data);
			// } else {;
				// try {
					// $('textarea', $tools).val(JSON.stringify(data))
				// } catch (ex) {
					// $('textarea', $tools).val('Not sure how to stringify this, likely binary, format.')
				// }
			// }
		// }
	// }).appendTo($tools)
	
	$('<input type="button" value="重写" style="height:45px;width:100px;border-radius:5px;font-weight:bold;">').bind('click', function(e){
		$sigdiv.jSignature('reset');
		$('input[name=sign]').val('');
		$extraarea.html('');
	}).appendTo($tools)
	
	//$('<div><textarea style="width:100%;height:7em;"></textarea></div>').appendTo($tools)
	
	$.subscribe(pubsubprefix + 'formatchanged', function(){
		$extraarea.html('');
	})

	// $.subscribe(pubsubprefix + 'image/svg+xml', function(data) {

		// try{
			// var i = new Image()
			// i.src = 'data:' + data[0] + ';base64,' + btoa( data[1] )
			// $(i).appendTo($extraarea)
		// } catch (ex) {

		// }
		
		// var message = ["浏览器不支持生成图片"]
		// $( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
	// });

	// $.subscribe(pubsubprefix + 'image/svg+xml;base64', function(data) {
		// var i = new Image()
		// i.src = 'data:' + data[0] + ',' + data[1]
		// $(i).appendTo($extraarea)
		
		// var message = [
			// "浏览器不支持"
           // ]
		// $( "<div>" + message.join("<br/>") + "</div>" ).appendTo( $extraarea )
	// });
	
	$.subscribe(pubsubprefix + 'image/png;base64', function(data) {
		var i = new Image()
		i.src = 'data:' + data[0] + ',' + data[1]
		$('<span><b></b></span>').appendTo($extraarea);
		$(i).appendTo($extraarea);
	});
	
	// $.subscribe(pubsubprefix + 'image/jsignature;base30', function(data) {
		// $('<span><b>This is a vector format not natively render-able by browsers. Format is a compressed "movement coordinates arrays" structure tuned for use server-side. The bonus of this format is its tiny storage footprint and ease of deriving rendering instructions in programmatic, iterative manner.</b></span>').appendTo($extraarea)
	// });

	if (Modernizr.touch){
		$('#scrollgrabber').height($('#content').height())		
	}
	
})
</script>
</body>
</html>
<script type="text/javascript">
	$(function() {
		$('#submit').click(function() {
			//var sign = $('input[name=sign]').val();
			$.post('<?php echo base_url('wxqd/sign'); ?>', $('#qd-form').serialize() ,function(r) {
				alert(r.message);
			}, 'json');
		});
	});
</script>
<?php if(is_array($signPackage)) { ?>
	<script type="text/javascript">
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
					//var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
					$('input[name=latitude]').val(res.latitude);
					//var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
					$('input[name=longitude]').val(res.longitude);
					//var speed = res.speed; // 速度，以米/每秒计
					$('input[name=speed]').val(res.speed);
					//var accuracy = res.accuracy; // 位置精度
					$('input[name=accuracy]').val(res.accuracy);
				},
				cancel: function (res) {
					alert('用户拒绝授权获取地理位置');
				}
			});
			wxupload.chooseImage = function(obj){
				// 选择张片
				wx.chooseImage({
					count: 9, // 默认9
					sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
					sourceType: ['camera'], // 可以指定来源是相册还是相机，默认二者都有
					success: function(res) {
						var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
						$('<img style="width:50px;height:50px;float:left;margin-right:15px;" src="'+localIds+'"/>').appendTo(obj);
						// 上传照片
						wx.uploadImage({
							localId: '' + localIds,
							isShowProgressTips: 1,
							success: function(res) {
								serverId = res.serverId;
								$('<input name="img[]" type="hidden" value="'+serverId+'"/>').appendTo(obj);
								//$(obj).next().val(serverId); // 把上传成功后获取的值附上
							}
						});
					}
				});
			}
		});
	</script>
<?php } ?>
