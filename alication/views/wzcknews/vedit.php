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
    <title>编辑出库信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑出库信息</h2>
        </blockquote>
        <form action="/wzcknews/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name='id' type='hidden' value="<?php echo $m['id']?>" />
			<div class="layui-form-item">
                <label class="layui-form-label">物资名称</label>
                <div class="layui-input-inline">
					<input name="title" autocomplete="off" lay-verify="required" value="<?php echo explode(' ', $m['bname'])[0];?>" placeholder="物资名称" class="layui-input" type="text" disabled>
					<input name="cate" autocomplete="off" lay-verify="number" value="<?php echo $m['cate']?>" placeholder="物资名称" class="layui-input" type="hidden" disabled>
                </div>
				<label class="layui-form-label">生产厂家</label>
                <div class="layui-input-inline">
                    <input name="cj" autocomplete="off" lay-verify="required" value="<?php echo explode(' ', $m['bname'])[1]; ?>" placeholder="必填,生产厂家" class="layui-input" type="text" disabled>
                </div>
				<div class="layui-input-inline">
					<a class="layui-btn layui-btn-small do-action" data-type="doShow" data-href="/wzcknews/lists.html" style='margin-top:4px;'><i class="fa fa-plus"></i>选择</a>
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">单位</label>
				<div class="layui-input-inline">
				<input name="dw" lay-verify="required" value="<?php echo explode(' ', $m['bname'])[2]; ?>" placeholder="单位" autocomplete="off" class="layui-input" type="text" disabled />
				</div>
				<label class="layui-form-label">出库数量</label>
				<div class="layui-input-inline">
					<input name="output_num" autocomplete="off" lay-verify="number" value="<?php echo $m['output_num']?>" placeholder="必填,出库数量" class="layui-input" type="text">
				</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">生产批号</label>
                <div class="layui-input-inline">
                    <input name="ph" autocomplete="off" lay-verify="required" value="<?php echo explode(' ', $m['bname'])[3]; ?>" placeholder="必填,生产批号" class="layui-input" type="text" disabled>
                </div>
				<label class="layui-form-label">领用单位</label>
				<div class="layui-input-inline">
					<input name="leading_name" autocomplete="off" lay-verify="required" value="<?php echo $m['leading_name']?>" placeholder="必选,领用单位" class="layui-input" type="text">
					<input name="leading_unit" autocomplete="off" lay-verify="number" value="<?php echo $m['leading_unit']?>" placeholder="必填,领用单位" class="layui-input" type="hidden">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">领用人员</label>
				<div class="layui-input-inline">
					<input name="leading_person" autocomplete="off" lay-verify="required" value="<?php echo $m['leading_person']?>" placeholder="必填,领用人员" class="layui-input" type="text" >
				</div>
				<label class="layui-form-label">出库日期</label>
				<div class="layui-input-inline">
					<input name="output_time" autocomplete="off" lay-verify="date" value="<?php echo date('Y-m-d', $m['output_time']);?>" placeholder="必填,出库日期" class="layui-input" type="text" readonly onclick="layui.laydate({elem: this})">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">用途</label>
				<div class="layui-input-inline">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="purpose">
						<?php foreach ($this->config->item('use') as $k => $vc): ?>
						<option value="<?php echo $k; ?>" <?php if($m['purpose'] == $k){echo ' selected';}?>><?php echo $vc; ?></option>
						<?php endforeach; ?>
					</select>
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
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/wzcknews/edit"><i class="fa fa-save"></i>提交</a>
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
		layui.use(['layer', 'form'], function () {
            var $ = layui.jquery, layer = layui.layer, form = layui.form();
			$('input[name=leading_name]').on('click', function(){
				layer.open({
                    type: 2,
                    title: name,
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: true,
                    area: ['700px', '520px'],
                    fixed: true,
                    content: ['/wzcknews/sylists','yes']
                });
			});
        });
	</script>
</body>
</html>