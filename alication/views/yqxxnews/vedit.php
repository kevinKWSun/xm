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
    <title>编辑疫情信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑疫情信息</h2>
        </blockquote>
        <form action="/yqxxnews/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name="id" value="<?php echo $m['id'];?>" type="hidden">
			<div class="layui-form-item">
                <label class="layui-form-label">经纬度</label>
                <div class="layui-input-inline">
                    <input id='jname' name="lng" lay-verify="required" readonly placeholder="必选,经度" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['lng'];?>" />
                </div>
                <div class="layui-input-inline">
                    <input id='wname' name="lat" lay-verify="required" readonly placeholder="必选,纬度" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['lat'];?>" /> 
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
						<option value="<?php echo $vc['id']; ?>" <?php if($m['addr_c'] == $vc['id']){echo 'selected';}?>><?php echo $vc['name']; ?></option>
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
				<label class="layui-form-label">报告时间</label>
				<div class="layui-input-inline">
					<input name="times" lay-verify="required" placeholder="必填,报告时间" autocomplete="off" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text" readonly value="<?php echo date('Y-m-d',$m['times']);?>" />
				</div>
				<label class="layui-form-label">疫情地点</label>
				<div class="layui-input-inline">
					<input name="addr" lay-verify="required" placeholder="必填,地点" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['addr'];?>" />
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">单位/个人</label>
				<div class="layui-input-inline">
					<input name="unit" lay-verify="" placeholder="选填,单位/个人" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['unit'];?>" />
				</div>
				<label class="layui-form-label">联系方式</label>
				<div class="layui-input-inline">
					<input name="tel" lay-verify="" placeholder="选填,联系方式" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['tel'];?>" />
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">疑似疫病</label>
				<div class="layui-input-inline">
					<input name="suspected" lay-verify="required" placeholder="必填,疑似疫病" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['suspected'];?>" />
				</div>
				<label class="layui-form-label">发病种类</label>
				<div class="layui-input-inline">
					<select name="type" lay-verify="required">
						<?php foreach($this->config->item('fbtype') as $k => $v):?>
						<option value="<?php echo $k?>" <?php if($k==$m['type']){echo 'selected';}?>><?php echo $v?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">存栏数量</label>
				<div class="layui-input-inline">
					<input name="cnumber" lay-verify="" placeholder="选填,存栏数量" id="date" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['cnumber'];?>" />
				</div>
				<label class="layui-form-label">发病数量</label>
				<div class="layui-input-inline">
					<input name="fnumber" lay-verify="required" placeholder="选填,发病数量" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['fnumber'];?>" />
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">死亡数量</label>
				<div class="layui-input-inline">
					<input name="number" lay-verify="" placeholder="选填,死亡数量" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['number'];?>" />
				</div>
				<label class="layui-form-label">临床症状</label>
				<div class="layui-input-inline">
					<input name="symptom" lay-verify="" placeholder="选填,临床症状" id="" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['symptom'];?>" />
				</div>
			</div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/yqxxnews/edit"><i class="fa fa-save"></i>提交</a>
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
			var sid = <?php echo $m['addr_c']?>;
			var sids = <?php echo $m['addr_t']?>;
			$.get('/xcsy/getarea/'+sid+'/'+sids+'.html',function(e){
				if(e){
					$('select[name=addr_t]').html(e);
					form.render();
				}
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