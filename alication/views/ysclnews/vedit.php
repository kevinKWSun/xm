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
    <title>编辑生鲜乳运输车信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑生鲜乳运输车信息　<a href='javascript:;' id='photo'>查看图片</a></h2>
        </blockquote>
        <form action="/yclnews/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name="id" value="<?php echo $m['id'];?>" type="hidden">
			<div class="layui-form-item">
				<label class="layui-form-label">车牌号</label>
                <div class="layui-input-inline">
                    <input name="num" lay-verify="required" placeholder="必填,运输车牌号" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['num']?>" />
                </div>
                <label class="layui-form-label">日运奶量</label>
                <div class="layui-input-inline">
                    <input name="yield" lay-verify="" placeholder="选填,日运奶量(吨)" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['yield']?>" />
                </div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">准运证编号</label>
				<div class="layui-input-inline">
					<input name="permit" autocomplete="off" lay-verify="required" value="<?php echo $m['permit']?>" placeholder="必填,准运证编号" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">发证机关</label>
				<div class="layui-input-inline">
					<input name="issuing" autocomplete="off" lay-verify="required" value="<?php echo $m['issuing']?>" placeholder="必填,发证机关" class="layui-input" type="text">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">核定载重</label>
				<div class="layui-input-inline">
					<input name="payload" autocomplete="off" lay-verify="" value="<?php echo $m['payload']?>" placeholder="选填,核定最大载重(吨)" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">最大距离</label>
				<div class="layui-input-inline">
					<input name="distance" lay-verify="required" autocomplete="off" value="<?php echo $m['distance']?>" placeholder="选填,最大运奶距离(千米)" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">司机姓名</label>
				<div class="layui-input-inline">
					<input name="driver" autocomplete="off" lay-verify="" value="<?php echo $m['driver']?>" placeholder="选填,运输车司机姓名" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">联系电话</label>
				<div class="layui-input-inline">
					<input name="dtel" autocomplete="off" lay-verify="" value="<?php echo $m['dtel']?>" placeholder="选填,联系电话" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">车辆所有者</label>
				<div class="layui-input-inline">
					<input name="owner" autocomplete="off" lay-verify="" value="<?php echo $m['owner']?>" placeholder="选填,运输车辆所有者" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">联系电话</label>
				<div class="layui-input-inline">
					<input name="otel" autocomplete="off" lay-verify="" value="<?php echo $m['otel']?>" placeholder="选填,联系电话" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">质量负责人</label>
				<div class="layui-input-inline">
					<input name="charge" autocomplete="off" lay-verify="" value="<?php echo $m['charge']?>" placeholder="选填,质量负责人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">联系电话</label>
				<div class="layui-input-inline">
					<input name="ctel" autocomplete="off" lay-verify="" value="<?php echo $m['ctel']?>" placeholder="选填,联系电话" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">运输车照片</label>
				<div class="layui-input-block" style='width:600px;'>
					<input name="pic" autocomplete="off" lay-verify="" value="<?php echo $m['pic']?>" placeholder="选填,运输车照片" class="layui-input" type="hidden">
					<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　　　　　　　　　　　　　 上传运输车照片　　　　　　　　　　 　" class="layui-upload-file up1">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">乡镇监管人</label>
				<div class="layui-input-inline">
					<input name="super" autocomplete="off" lay-verify="required" value="<?php echo $m['super']?>" placeholder="必填,乡镇监管责任人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">单位</label>
				<div class="layui-input-inline">
					<input name="uintxz" lay-verify="required" autocomplete="off" value="<?php echo $m['uintxz']?>" placeholder="必填,乡镇监管责任单位" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">县级监管人</label>
				<div class="layui-input-inline">
					<input name="supers" autocomplete="off" lay-verify="required" value="<?php echo $m['supers']?>" placeholder="必填,县级监管责任人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">单位</label>
				<div class="layui-input-inline">
					<input name="uintxj" lay-verify="required" autocomplete="off" value="<?php echo $m['uintxj']?>" placeholder="必填,县级监管责任单位" class="layui-input" type="text">
				</div>
            </div>
			<div id="layer-photos-demo" class="layer-photos-demo" style='display:none'>
				<img layer-pid="1" layer-src="<?php echo $m['pic'];?>" src="<?php echo $m['pic'];?>" alt="">
			</div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/yclnews/edit"><i class="fa fa-save"></i>提交</a>
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
			layui.upload({
				elem:'.up1',
				url: '/login/do_upload'
			    ,before: function(input){
				    console.log('文件上传中');
			    }
			    ,success: function(res){
					layer.msg('上传完毕');
					var img = '';
					if(res.code == 200){
						$('input[name=pic]').val(res.savepath);
					}
				}
			});
			$('#photo').on('click', function(){
				$('#layer-photos-demo img').click();
			});
			layer.photos({
				photos: '#layer-photos-demo'
			});
        });
    </script>
</body>
</html>