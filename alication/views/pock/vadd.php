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
    <title>增加肉品品质检验合格报告单</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加肉品品质检验合格报告单</h2>
        </blockquote>
        <form action="/pock/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
            <div class="layui-form-item">
				<label class="layui-form-label">NO</label>
                <div class="layui-input-inline">
                    <input name="NO" lay-verify="number" placeholder="必填,编号" autocomplete="off" class="layui-input" type="text" />
                </div>
				<label class="layui-form-label">屠宰企业</label>
                <div class="layui-input-inline">
					<input name="bid" type="hidden" />
                    <input name="bname" lay-verify="required" placeholder="必选,屠宰企业" autocomplete="off" class="layui-input" type="text" disabled />
				</div>
				<div class="layui-input-inline">
					<a class="layui-btn layui-btn-small" id="getvector1" style='margin-top:4px;'>
						<i class="fa fa-search"></i>选择企业
					</a>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">质检负责人</label>
                <div class="layui-input-inline">
                    <input name="charge" lay-verify="required" placeholder="必填,肉品品质检验负责人" autocomplete="off" class="layui-input" type="text" />
                </div>
				<label class="layui-form-label">检疫号码</label>
				<div class="layui-input-inline">
					<input name="code" autocomplete="off" lay-verify="required" value="" placeholder="必填,入厂动物检疫证明号码" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">数量/重量</label>
				<div class="layui-input-inline">
					<input name="num" autocomplete="off" lay-verify="number" value="" placeholder="必填,数量/重量(公斤)" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">签字时间</label>
				<div class="layui-input-inline">
					<input name="qtime" autocomplete="off" lay-verify="date" value="" placeholder="必填,签字时间" class="layui-input" type="text" readonly onclick="layui.laydate({elem: this})">
				</div>
            </div>
			<fieldset class="layui-elem-field layui-field-title" style="width: 609px;">
                <legend>批注</legend>
            </fieldset>
            <div class="layui-form-item" style="width: 609px;">
				<textarea class="layui-textarea" placeholder="">1、本批产品未检出“瘦肉精”等违禁物质，未注水及他物质;
2、屠宰的种猪及晚阉猪，已在胴体及品质检验合格证上注明;
3、其他项目已按照《生猪屠宰产品品质检验规程》规定检验, 产品合格.</textarea>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/pock/add"><i class="fa fa-save"></i>提交</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href=""><i class="fa fa-refresh fa-spin"></i>刷新</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doGoBack" data-href=""><i class="fa fa-mail-reply"></i>返回上一页</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doGoTop" data-href=""><i class="fa fa-arrow-up"></i>返回顶部</a>
                    </div>
                </div>
            </div>
            <!--/底部工具栏-->
        </form>
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/modify.js"></script>
	<script>
        layui.use(['layer', 'form', 'upload'], function () {
            var $ = layui.jquery, layer = layui.layer, form = layui.form(), upload = layui.upload;
			$('#getvector1').on('click',function(){
                layer.open({
                    type: 2,
                    title: '屠宰企业名称',
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: false,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: ['/pock/sy.html','no']
                });
            });
        });
    </script>
</body>
</html>