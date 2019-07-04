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
    <title>增加散养户详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加散养户详情 　
                <a href='javascript:;' class='a_add' data='<?php echo count($m)?(count($m)-1):0;?>'><font color='red'>加</font></a> 
                <a href='javascript:;' class='a_del'><font color='red'>减</font></a>
            </h2>
        </blockquote>
        <form action="/synews/sedit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name='id' type='hidden' value='<?php echo $id?>' />
			<?php if($m){foreach($m as $ks => $mv):?>
            <div class='aid<?php echo $ks?$ks:"";?>'>
                <div class="layui-form-item">
					<label class="layui-form-label">畜禽种类</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="breed">
							<?php foreach($breed as $k => $v): ?>
							<option value="<?php echo $k; ?>" <?php if($k == $mv['breed']){echo 'selected';}?>><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
                    <label class="layui-form-label">畜禽品种</label>
                    <div class="layui-input-inline">
                        <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="types">
							<?php foreach($variety as $k => $v): ?>
							<option value="<?php echo $k; ?>" <?php if($k == $mv['types']){echo 'selected';}?>><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">存栏数量</label>
                    <div class="layui-input-inline">
                        <input name="stock" autocomplete="off" lay-verify="number" value="<?php echo $mv['stock']?>" placeholder="存栏数量" class="layui-input" type="text">
                    </div>
					<label class="layui-form-label">单位</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="unit">
							<?php foreach($unit as $k => $v): ?>
							<option value="<?php echo $k; ?>" <?php if($k == $mv['unit']){echo 'selected';}?>><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
                </div>
            </div>
			<?php endforeach;}else{?>
			<div class='aid'>
                <div class="layui-form-item">
					<label class="layui-form-label">畜禽种类</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="breed">
							<option value="0" selected>请选择畜禽种类</option>
							<?php foreach($breed as $k => $v): ?>
							<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
                    <label class="layui-form-label">畜禽品种</label>
                    <div class="layui-input-inline">
                        <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="types">
							<option value="0" selected>请选择畜禽品种</option>
							<?php foreach ($variety as $k => $v): ?>
							<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">存栏数量</label>
                    <div class="layui-input-inline">
                        <input name="stock" autocomplete="off" lay-verify="number" value="0" placeholder="存栏数量" class="layui-input" type="text">
                    </div>
					<label class="layui-form-label">单位</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="unit">
							<option value="0" selected>请选择单位</option>
							<?php foreach($unit as $k => $v): ?>
							<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
                </div>
            </div>
			<?php }?>
			<div class='zt'></div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPostAllS" data-href="/synews/sedit"><i class="fa fa-save"></i>提交</a>
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
    <script type="text/javascript">
        layui.use(['layer', 'form'], function () {
            var $ = layui.jquery
            , layer = layui.layer
            , form = layui.form();
			//form.render();
            $('.a_add').click(function(){
                var num = $(this).attr('data');
                if(num > 4){
                    layer.msg('最多添加5条！');
                } else {
                    var obj = $('.aid').clone();
                    $(this).attr('data', (num*1+1));
                    obj.removeClass('aid');
                    obj.addClass('aid'+(num*1+1));
                    $('.zt').before(obj);
					form.render();
                }
                
            });
            $('.a_del').click(function(){
                var num = $(this).siblings('.a_add').attr('data');
                if(num > 0){
                    $('.aid'+num).remove();
                    $(this).siblings('.a_add').attr('data', (num*1-1));
					form.render();
                } 
            });
        });
    </script>
</body>
</html>