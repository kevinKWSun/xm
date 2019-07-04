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
    <title>增加无害化处理厂信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加无害化处理厂信息</h2>
        </blockquote>
        <form action="/clcnews/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
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
				<label class="layui-form-label">具体地址</label>
                <div class="layui-input-inline">
                    <input name="addr" lay-verify="required" placeholder="必填,具体地址" autocomplete="off" class="layui-input" type="text" />
                </div>
                <label class="layui-form-label">处理厂名称</label>
                <div class="layui-input-inline">
                    <input name="name" lay-verify="required" placeholder="必填,处理厂名称" autocomplete="off" class="layui-input" type="text" />
                </div>
            </div>
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
            <div class="layui-form-item">
				<label class="layui-form-label">负责人</label>
				<div class="layui-input-inline">
					<input name="charge" autocomplete="off" lay-verify="required" value="" placeholder="必填,负责人真实姓名" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">手机</label>
				<div class="layui-input-inline">
					<input name="phone" autocomplete="off" lay-verify="phone" value="" placeholder="必填,联系电话" class="layui-input" type="text">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">身份证号</label>
				<div class="layui-input-inline">
					<input name="xm" autocomplete="off" lay-verify="identity" value="" placeholder="必填,畜主身份证号" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">一卡通号</label>
				<div class="layui-input-inline">
					<input name="card" lay-verify="required" autocomplete="off" value="" placeholder="必填,一卡通号" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">处理方式</label>
				<div class="layui-input-inline">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="mode">
						<option selected="selected" value="0">选择处理方式</option>
						<?php foreach ($this->config->item('mode') as $kv => $vc): ?>
						<option value="<?php echo $kv; ?>"><?php echo $vc; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<label class="layui-form-label">日处理能力</label>
				<div class="layui-input-inline">
					<input name="volum" autocomplete="off" lay-verify="number" value="" placeholder="必选,日处理能力(吨)" class="layui-input" type="text">
				</div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/clcnews/add"><i class="fa fa-save"></i>提交</a>
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
                    maxmin: false,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: ['/map.html','no']
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