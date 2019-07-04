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
    <title>编辑入库信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑入库信息</h2>
        </blockquote>
        <form action="/wzrknews/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name="id" value="<?php echo $m['id'];?>" type="hidden">
            <div class="layui-form-item">
                <label class="layui-form-label">物资类别</label>
                <div class="layui-input-inline cate">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="cate" lay-filter="select">
						<?php foreach (get_wzlb() as $k => $vc): ?>
						<option value="<?php echo $k; ?>" <?php if($k == $m['cate']){echo ' selected';}?>><?php echo $vc; ?></option>
						<?php endforeach; ?>
					</select>
                </div>
				<label class="layui-form-label">物资名称</label>
				<div class="layui-input-inline cate_name">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="cate_name" lay-filter="cate_name">
						<?php foreach (get_wzmc()[1] as $k => $vc): ?>
						<option value="<?php echo $k; ?>" <?php if($k == $m['cate_name']){echo ' selected';}?>><?php echo $vc; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="layui-input-inline">
				<input name="unit" lay-verify="required" value="<?php echo $m['unit']?>" autocomplete="off" class="layui-input" type="text" readonly />
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">入库数量</label>
                <div class="layui-input-inline">
                    <input name="num" lay-verify="number" placeholder="必填,入库数量" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['num']?>" />
                </div>
                <label class="layui-form-label">生产厂家</label>
                <div class="layui-input-inline">
                    <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="manufacturer">
						<?php foreach (get_company()[1] as $k => $vc): ?>
						<option value="<?php echo $k; ?>" <?php if($k == $m['manufacturer']){echo ' selected';}?>><?php echo $vc; ?></option>
						<?php endforeach; ?>
					</select>
                </div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">生产批号</label>
				<div class="layui-input-inline">
					<input name="batch_num" autocomplete="off" lay-verify="required" value="<?php echo $m['batch_num']?>" placeholder="必填,生产批号" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">签收单位</label>
				<div class="layui-input-inline">
					<input name="sign_uint" autocomplete="off" lay-verify="required" value="<?php echo $m['sign_uint']?>" placeholder="必填,签收单位" class="layui-input" type="text" readonly >
					<input name="sign_uint_id" autocomplete="off" lay-verify="required" value="<?php echo $m['sign_uint_id']?>" placeholder="必填,签收单位ID" class="layui-input" type="hidden">
				</div>
				<div class="layui-input-inline">
					<a class="layui-btn layui-btn-small do-action" data-type="doShow" data-href="/wzrknews/lists.html" style='margin-top:4px;'><i class="fa fa-plus"></i>签收单位</a>
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">签收人</label>
				<div class="layui-input-inline">
					<input name="sign_person" autocomplete="off" lay-verify="required" value="<?php echo $m['sign_person']?>" placeholder="必填,签收人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">入库时间</label>
				<div class="layui-input-inline">
					<input name="input_time" lay-verify="date" autocomplete="off" value="<?php echo date('Y-m-d',$m['input_time']);?>" placeholder="必填,入库时间" class="Wdata layui-input" type="text" onclick="layui.laydate({elem: this})" readonly>
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">有效期至</label>
				<div class="layui-input-inline">
					<input name="expiry_time" lay-verify="date" autocomplete="off" value="<?php echo date('Y-m-d',$m['expiry_time']);?>" placeholder="必填,有效期" class="Wdata layui-input" type="text" onclick="layui.laydate({elem: this})" readonly>
				</div>
				<label class="layui-form-label">备注</label>
				<div class="layui-input-inline">
					<input name="remark" lay-verify="" autocomplete="off" value="<?php echo $m['remark']?>" placeholder="选填,备注" class="layui-input" type="text">
				</div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/wzrknews/edit"><i class="fa fa-save"></i>提交</a>
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
				var sid = data.value;
				$.get('/wzrknews/getchild/'+sid+'/1.html',function(e){
					$('select[name=cate_name]').html(e.o);
					$('input[name=unit]').val(e.c);
					$('select[name=manufacturer]').html(e.cy);
					form.render();
				});
            }, 'json');
			form.on("select(cate_name)", function(data){
				var sid = data.value;
				$.get('/wzrknews/getchild/'+sid+'/2.html',function(e){
					if(e){
						$('input[name=unit]').val(e.o);
						$('select[name=manufacturer]').html(e.cy);
						form.render();
					}
				});
            }, 'json');
        });
    </script>
</body>
</html>