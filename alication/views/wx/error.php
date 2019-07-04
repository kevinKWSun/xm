<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Language" content="zh-cn" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0,initial-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>403_未授权访问</title>
	<link href="/Content/wx/mobile/style.css" rel="stylesheet" type="text/css">
    <link href="/Content/layui/css/layuis.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body style='background:#ffffff'>
    <div class="main-wrap">
        <div class="bd-content-wrap">
            <div class="template-soon" style='max-width:724px; margin:0 auto'>
                <img src="/Content/img/404.png" width='100%' />
            </div>
        </div>
    </div>
	<div class="top_bar">
		<nav>
			<ul id="top_menu" class="top_menu">
				<li><a href="<?php echo base_url('wx'); ?>"><img src="/Content/wx/mobile/images/recommend_a.png" width='30'><label>首页</label></a></li>
			</ul>
		</nav>
	</div>
</body>
</html>
	<!--/* <div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html> */-->