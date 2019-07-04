<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="zh-cn" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0,initial-scale=1.0,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
    <title>编辑散养户基本信息</title>
    <link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
			<legend>编辑散养户基本信息　<a href='javascript:;' id='photo'>查看图片</a></legend>
		</fieldset>
        <form action="/wxsynews/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name="id" value="<?php echo $m['id'];?>" type="hidden">
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
				<label class="layui-form-label">具体地址</label>
                <div class="layui-input-inline">
                    <input name="addr" lay-verify="required" placeholder="必填,具体地址" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['addr'];?>" />
                </div>
                <label class="layui-form-label">禽场名称</label>
                <div class="layui-input-inline">
                    <input name="num" lay-verify="required" placeholder="必填,种畜禽场名称" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['num'];?>" />
                </div>
            </div>
			<div class="layui-form-item">
                <label class="layui-form-label">经度</label>
                <div class="layui-input-inline">
                    <input id='jname' name="lng" lay-verify="required" readonly placeholder="必选,经度" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['lng'];?>" />
                </div>
				<label class="layui-form-label">纬度</label>
                <div class="layui-input-inline">
                    <input id='wname' name="lat" lay-verify="required" readonly placeholder="必选,纬度" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['lat'];?>" /> 
                </div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">真实名称</label>
				<div class="layui-input-inline">
					<input name="real_name" autocomplete="off" lay-verify="required" value="<?php echo $m['real_name'];?>" placeholder="必填,管理者真实姓名" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">手机</label>
				<div class="layui-input-inline">
					<input name="phone" autocomplete="off" lay-verify="phone" value="<?php echo $m['phone'];?>" placeholder="必填,手机" class="layui-input" type="text">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">身份证号</label>
				<div class="layui-input-inline">
					<input name="idcard" autocomplete="off" lay-verify="identity" value="<?php echo $m['idcard'];?>" placeholder="必填,身份证号" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">一卡通号</label>
				<div class="layui-input-inline">
					<input name="card" lay-verify="required" autocomplete="off" value="<?php echo $m['card'];?>" placeholder="必填,一卡通号" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">有无摄像头</label>
				<div class="layui-input-inline">
					<input name="camera" value="1" title="有" type="radio" <?php echo ($m['camera']==1)?'checked':'';?> />
					<input name="camera" value="2" title="无" type="radio" <?php echo ($m['camera']==2)?'checked':'';?> />
				</div>
				<label class="layui-form-label">监管兽医</label>
				<div class="layui-input-inline">
					<input name="vet" autocomplete="off" lay-verify="required" value="<?php echo $m['vet'];?>" placeholder="必选,监管兽医" class="layui-input" type="hidden">
				</div>
				<div class="layui-input-inline">
					　<a class="layui-btn layui-btn-small do-action" data-type="doShow" data-href="/ausers/sylist.html" style='margin-top:4px;'><i class="fa fa-plus"></i>　 请 选 择 监 管 兽 医 　</a>
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">备注</label>
				<div class="layui-input-inline">
					<input name="remark" autocomplete="off" lay-verify="" value="<?php echo $m['remark'];?>" placeholder="选填,备注" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">图片</label>
				<div class="layui-input-inline">
					<input name="pic" autocomplete="off" lay-verify="required" value="<?php echo $m['pic'],',';?>" placeholder="必传,图片" class="layui-input" type="hidden">
					<input type="file" name="userfile[]" multiple lay-ext="jpg|png|gif" lay-type="file" lay-title="身份证号及一卡通　" class="layui-upload-file">
				</div>
            </div>
			<div id="layer-photos-demo" class="layer-photos-demo" style='display:none'>
				<?php foreach(explode(',', $m['pic']) as $k => $v): ?>
				<img layer-pid="<?php echo $k+1;?>" layer-src="<?php echo $v;?>" src="<?php echo $v;?>" alt="">
				<?php endforeach; ?>
			</div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/wxsynews/edit"><i class="fa fa-save"></i>提交</a>
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
			layui.upload({
			    url: '/login/do_uploads'
			    ,before: function(input){
				    console.log('文件上传中');
			    }
			    ,success: function(res){
					layer.msg('上传完毕');
					var img = '';
					$.each(res, function(key, val){
						if(res[key].code == 200){
							img += res[key].savepath + ',' ;
						}
					});
					if(img){
						$('input[name=pic]').val(img);
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