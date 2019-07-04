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
    <title>增加乡村兽医</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加乡村兽医　<a class="layui-btn layui-btn-small do-action" data-type="doShow" data-href="/ausers/bind.html"><i class="fa fa-plus"></i>绑定登录账号</a></h2>
				
        </blockquote>
        <form action="/xcsy/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name='aid' type='hidden' value='' />
            <div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">姓名</label>
					<div class="layui-input-inline">
						<input name="real_name" autocomplete="off" lay-verify="required" value="" placeholder="必填,真实姓名" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">身份证号</label>
					<div class="layui-input-inline">
						<input name="idcard" autocomplete="off" lay-verify="identity" value="" placeholder="必填,身份证号" class="layui-input" type="text">
					</div>
				</div>
            </div>
            <div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">联系手机</label>
					<div class="layui-input-inline">
						<input name="phone" autocomplete="off" lay-verify="phone" value="" placeholder="必填,联系手机" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">性别</label>
					<div class="layui-input-inline">
					  <input name="sex" value="1" title="男" type="radio" checked="" />
					  <input name="sex" value="2" title="女" type="radio" />
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">户口所在地</label>
					<div class="layui-input-inline">
						<input name="address" autocomplete="off" lay-verify="" value="" placeholder="选填,户口所在地" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">照片</label>
					<div class="layui-input-inline">
						<input name="pic" autocomplete="off" lay-verify="required" value="" placeholder="必填,注销时间" class="layui-input" type="hidden">
						<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-type="file" lay-title=" 请上传一张本人照片 " class="layui-upload-file">
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">登记证号</label>
					<div class="layui-input-inline">
						<input name="reg_num" autocomplete="off" lay-verify="required" value="" placeholder="必填,登记证号" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">登记时间</label>
					<div class="layui-input-inline">
						<input name="regs_time" lay-verify="date" autocomplete="off" value="" placeholder="必填,登记时间" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text" readonly>
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline address">
					<label class="layui-form-label">从业区域</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="obtain_area" lay-filter="select">
							<option selected="selected" value="0">选择区域</option>
							<?php foreach ($areas as $vc): ?>
							<option value="<?php echo $vc['id']; ?>"><?php echo $vc['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">从业地点</label>
					<div class="layui-input-inline cydd">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="obtain_place">
							<option selected="selected" value="0">选择地点</option>
						</select>
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">基层动监站</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="move_station" lay-filter="select">
							<option selected="selected" value="0">选择动监站</option>
							<option value="1">动监站1</option>
							<option value="2">动监站2</option>
						</select>
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">时间</label>
					<div class="layui-input-inline">
					  <input name="induction_time" lay-verify="date" autocomplete="off" value="" placeholder="必填,动监站时间" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text" readonly>
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">区市意见</label>
					<div class="layui-input-inline">
						<input name="opinion" autocomplete="off" lay-verify="required" value="" placeholder="必填,区市意见" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">时间</label>
					<div class="layui-input-inline">
					  <input name="option_time" lay-verify="date" autocomplete="off" value="" placeholder="必填,意见时间" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text" readonly>
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">专业</label>
					<div class="layui-input-inline">
						<input name="major" autocomplete="off" lay-verify="required" value="" placeholder="必填,专业" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">学历</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="education">
							<option selected="selected" value="0">选择学历</option>
							<?php foreach ($this->config->item('education') as $k => $v): ?>
							<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">毕业院校</label>
					<div class="layui-input-inline">
						<input name="university" autocomplete="off" lay-verify="required" value="" placeholder="必填,毕业院校" class="layui-input" type="text">
					</div>
				</div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/xcsy/add"><i class="fa fa-save"></i>提交</a>
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
			form.on("select(select)", function(data){
				if($(this).parent().parent().parent().parent().hasClass('address')){
					var sid = data.value;
					$.get('/xcsy/getarea/'+sid+'.html',function(e){
						if(e){
							$('select[name=obtain_place]').html(e);
							form.render();
						}
					});
				}
            });
			layui.upload({
			    url: '/login/do_upload'
			    ,before: function(input){
				    console.log('文件上传中');
			    }
			    ,success: function(res){
				console.log('上传完毕');
					if(res.code == 200){
						layer.msg('上传成功');
						$('input[name=pic]').val(res.savepath);
					}else{
						layer.msg('上传失败');
					}
				}
			});
			
        });
    </script>
</body>
</html>