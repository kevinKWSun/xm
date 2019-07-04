<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>首页</title>
    <meta http-equiv="Content-Language" content="zh-cn" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0,initial-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link href="/Content/css/iglobal.css" rel="stylesheet" />
    <link href="/Content/css/index.css" rel="stylesheet" />
    <script type='text/javascript' src='/Content/js/jquery-1.7.2.min.js'></script>
    <script type='text/javascript' src='/Content/js/global.js'></script>
	<script type="text/javascript" src="/uploadify/js/uploadify.min.js"></script>
	<link href="/uploadify/common.css" rel="stylesheet" />
</head>
<body>

<div>
	<input type="button" name='file_upload' id='file_upload' value="选择图片" class='cursor' multiple="true" />
	<ul id="previewImgs"></ul>
	<textarea name="img" style="display:none;" id="saveurl"></textarea>
</div>
<script>
$(function(){
	$('#file_upload').uploadify({
		<?php $timestamp = time();?>
		'formData'      : {
			'timestamp' : '<?php echo $timestamp;?>',
			'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
		},
		'auto':true, //是否自动开始上传
		'debug' : false,// 是否开启浏览器调试
		'buttonText' : '请选择图片', // 上传按钮文字
		'fileTypeExts':'*.jpg;*.gif;*.bmp;*.png;*.jpeg', //允许的图片类型
		'fileSizeLimit' : '5MB', // 允许的单张图片的自大值
		'multi' : true, //是否允许多张图片一起上传
		'uploadLimit':20,
		'removeCompleted':true,
		'swf'      : '/uploadify/uploadify.swf',
		'uploader' : '/login/do_upload',
		'button_image_url' : '/uploadify/bai.png',
		'onUploadSuccess' : function(file,data,response){
			var obj = jQuery.parseJSON(data);
			var imgstr = '<li style="width:85px;float:left;padding-top:5px;"><img src="'+obj.savepath+'" width="80" height="70"><br><a href="javascript:;" onclick=goDel(this,"'+obj.savepath+'")>　　删除</a></li>';
			$("#previewImgs").append(imgstr);
			$("#saveurl").append(obj.savepath+'|');
		},
		'onFallback' : function() {
			alert('未检测到兼容版本的Flash.');
		}

	});
});
function goDel(objdom,src){
	$(objdom).parent().remove();
	var imgs = '';
	$('#saveurl').text(imgs);
	$('ul#previewImgs li img').each(function(){
		var src = $(this).attr('src');
		imgs = imgs + src + '|';
		$('#saveurl').text(imgs);
	});
	return false;
}

</script>
</body>
</html>