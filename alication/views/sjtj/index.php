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
    <title>数据统计</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
	<style>
		#thSlashd
		{
			background-color:#fff;
			width:120px;
		}
		#theadTrSlashd
		{
			border-top-width: 130px;
			border-top-color: #fff;
			border-top-style: solid;
			border-left: 120px Grey solid;
			width: 0;
			height: 0;
			position: relative;
			color: #545454;
			padding-top: 0px;
		}
		#theadTrSlashd span
		{
			display: block;
			width: 80px;
		}
		.theadTrSlashds1
		{
			position: absolute;
			top: -90px;
			left: -70px;
			color: #000;
		}
		.theadTrSlashds2
		{
			position: absolute;
			bottom: 30px;
			right: 35px;
			left: -120px;
			color: #000;
		}
		
		
		
		
		
		
		
		/*
		#thSlashd
		{
			background-color:#cccccc;
		}
		#theadTrSlashd
		{
			border-top-width: 130px;
			border-top-color: #cccccc;
			border-top-style: solid;
			border-left: 120px Grey solid;
			width: 0;
			height: 0;
			position: relative;
			color: #FFF;
			padding-top: 0px;
		}
		#theadTrSlashd span
		{
			display: block;
			width: 80px;
		}
		.theadTrSlashds1
		{
			position: absolute;
			top: -90px;
			left: -64px;
			color: #FFF;
		}
		.theadTrSlashds2
		{
			position: absolute;
			bottom: 30px;
			right: 35px;
		}
		#theadTrSlashds
		{
			border-top: 260px #cccccc solid;
			border-left: 170px Grey solid;
			width: 0;
			height: 300px;
			position: relative;
			color: #FFF;
			padding-top: 0px;
		}
		#theadTrSlashds span
		{
			display: block;
			width: 60px;
		}
		.theadTrSlashds3
		{
			display: block;
			position: absolute;
			top: -155px;
			left: -64px;
			color: #FFF;
			min-height: 100%;
		}

		#theadTrSlashdts2
		{
			border-top: 100px #cccccc solid;
			border-left: 120px Grey solid;
			position: relative;
			color: #FFF;
			padding-top: 0px;
			clear: both;
			display: block;
			min-height: 100%;
		}
		#theadTrSlashdts2 span
		{
			display: block;
			width: 60px;
		}
		#theadTrSlashdts3
		{
			border-top: 130px #cccccc solid;
			border-left: 120px Grey solid;
			position: relative;
			color: #FFF;
			padding-top: 0px;
			clear: both;
			display: block;
		}
		#theadTrSlashdts3 span
		{
			display: block;
			width: 60px;
			height: 100%;
		}

		.theadTrSlashds4
		{
			position: absolute;
			top: -130px;
			left: -64px;
			color: #FFF;
		}
		#theadTrSlashdtss
		{
			border-top: 130px #cccccc solid;
			border-left: 120px Grey solid;
			position: relative;
			color: #FFF;
			padding-top: 0px;
			clear: both;
			display: block;
		}
		#theadTrSlashdtss span
		{
			display: block;
			width: 60px;
			height: 100%;
		}
		#theadTrSlashdss1
		{
			border-top: 130px Grey solid;
			border-left: 120px Grey solid;
			width: 0;
			height: 0;
			position: relative;
			color: #FFF;
			padding-top: 0px;
		}
		#theadTrSlashdss1 span
		{
			display: block;
			width: 80px;
		}
		.theadTrSlashdcs1
		{
			position: absolute;
			top: -70px;
			left: -70px;
			color: #FFF;
		}*/
	</style>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>数据统计 　
                <a class="layui-btn layui-btn-small" onclick="$('#myPrintArea').printArea();"><i class="fa fa-print"></i>打印</a>
				<?php echo $nav; ?>
            </h2>
        </blockquote>
        <div class="y-role">
            <!--文字列表-->
            <div class="fhui-admin-table-container" id='myPrintArea'>
                <?php echo $html; ?>
            </div>
            <!--/文字列表-->
        </div>
    </div>
    <script type="text/javascript" src="/Content/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/Content/jquery.PrintArea.js"></script>
	<script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/modify.js"></script>
</body>
</html>