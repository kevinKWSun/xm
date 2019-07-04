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
    <title>增加网格化监管信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加网格化监管信息</h2>
        </blockquote>
        <form action="/wghnews/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<div class="layui-form-item">
                <label class="layui-form-label">经纬度</label>
                <div class="layui-input-inline">
                    <input id='jname' name="lng" lay-verify="required" readonly placeholder="必选,经度" autocomplete="off" class="layui-input" type="text" />
                </div>
                <div class="layui-input-inline">
                    <input id='wname' name="lat" lay-verify="required" readonly placeholder="必选,纬度" autocomplete="off" class="layui-input" type="text" /> 
                </div>
                <div class="layui-inline">
                    <a class="layui-btn layui-btn-small" id="getvector" style='margin-top:4px;'>
                        <i class="fa fa-search"></i>获取经纬度
                    </a>
                </div>
            </div>
			<div class="layui-form-item address">
                <label class="layui-form-label">地址</label>
                <div class="layui-input-inline">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="addr_c" lay-filter="select">
						<option selected="selected" value="0">选择区域</option>
						<?php foreach ($areas as $vc): ?>
						<option value="<?php echo $vc['id']; ?>"><?php echo $vc['name']; ?></option>
						<?php endforeach; ?>
					</select>
                </div>
				<label class="layui-form-label">地点</label>
				<div class="layui-input-inline">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="addr_t">
						<option selected="selected" value="0">选择地点</option>
					</select>
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">编号</label>
				<div class="layui-input-inline">
					<input name="num" lay-verify="required" placeholder="必填,编号" autocomplete="off" class="layui-input" type="text" />
				</div>
				<label class="layui-form-label">名称</label>
				<div class="layui-input-inline">
					<input name="name" lay-verify="required" placeholder="必填,网格名称" autocomplete="off" class="layui-input" type="text" />
				</div>
			</div>
			<div class="layui-form-item" style='width:609px;'>
				<label class="layui-form-label">填报单位</label>
				<div class="layui-input-block">
					<input name="tunit" lay-verify="required" placeholder="必填,填报单位" autocomplete="off" class="layui-input" type="text" />
				</div>
			</div>
			<div class="layui-form-item layui-form-text" style='width:609px;'>
				<label class="layui-form-label">管辖区域   
					<a class="layui-btn layui-btn-small" id="getgx" style='margin-top:-25px; float:right;'>
                        <i class="fa fa-search"></i>获取管辖区域
                    </a>
				</label>
				<div class="layui-input-block">
				    <textarea placeholder="必选,管辖区域" name="gxarea" class="layui-textarea" disabled ></textarea>
				</div>
		    </div>
			<div class="layui-form-item layui-form-text" style='width:609px;'>
				<label class="layui-form-label">监管区域</label>
				<div class="layui-input-block">
				    <textarea placeholder="必填,监管区域" name="jgarea" class="layui-textarea"></textarea>
				</div>
		    </div>
			<div class="layui-form-item">
				<label class="layui-form-label">监管单位</label>
				<div class="layui-input-inline">
					<input name="unit" lay-verify="required" placeholder="必填,监管责任单位" autocomplete="off" class="layui-input" type="text" />
				</div>
				<label class="layui-form-label">联系方式</label>
				<div class="layui-input-inline">
					<input name="tel" lay-verify="phone" placeholder="必填,联系方式" autocomplete="off" class="layui-input" type="text" />
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">监管人</label>
				<div class="layui-input-inline">
					<input name="admin" lay-verify="" placeholder="必填,监管责任人" id="date" autocomplete="off" class="layui-input" type="text" />
				</div>
				<label class="layui-form-label">监管人职务</label>
				<div class="layui-input-inline">
					<input name="jname" lay-verify="required" placeholder="必填,责任人职务" autocomplete="off" class="layui-input" type="text" />
				</div>
			</div>
			<div class="layui-form-item layui-form-text" style='width:609px;'>
				<label class="layui-form-label">监管对象   
					<a class="layui-btn layui-btn-small" id="getjg" style='margin-top:-25px; float:right;'>
                        <i class="fa fa-search"></i>获取监管对象
                    </a>
				</label>
				<div class="layui-input-block">
				    <textarea placeholder="必填,监管对象" name="jgdx" class="layui-textarea" disabled ></textarea>
				</div>
				<textarea placeholder="必填,监管对象" name="cid_1" class="layui-textarea" disabled style='display:none;'></textarea>
		    </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/wghnews/add"><i class="fa fa-save"></i>提交</a>
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
			$('#getvector').on('click',function(){
                layer.open({
                    type: 2,
                    title: '获取经纬度',
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: true,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: ['/map.html','no']
                });
            });
			$('#getgx').on('click',function(){
                layer.open({
                    type: 2,
                    title: '获取管辖区域',
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: true,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: ['/wghnews/getgx.html','no']
                });
            });
			$('#getjg').on('click',function(){
                layer.open({
                    type: 2,
                    title: '获取监管对象',
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: true,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: ['/wghnews/getjg.html','no']
                });
            });
			form.on("select(select)", function(data){
				if($(this).parent().parent().parent().parent().hasClass('address')){
					var sid = data.value;
					$.get('/xcsy/getarea/'+sid+'.html',function(e){
						if(e){
							$('select[name=addr_t]').html(e);
							form.render();
						}
					});
				}
            });
        });
    </script>
</body>
</html>