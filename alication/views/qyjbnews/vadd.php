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
    <title>增加屠宰企业信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>增加屠宰企业信息</h2>
        </blockquote>
        <form action="/qyjbnews/add" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
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
				<label class="layui-form-label">屠宰企业</label>
                <div class="layui-input-inline">
                    <input name="num" lay-verify="required" placeholder="必填,屠宰企业" autocomplete="off" class="layui-input" type="text" />
                </div>
				<label class="layui-form-label">具体地址</label>
                <div class="layui-input-inline">
                    <input name="addr" lay-verify="required" placeholder="必填,具体地址" autocomplete="off" class="layui-input" type="text" />
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">邮政编码</label>
                <div class="layui-input-inline">
                    <input name="zipcode" lay-verify="required" placeholder="必填,机构名称" autocomplete="off" class="layui-input" type="text" />
                </div>
				<label class="layui-form-label">法人代表</label>
				<div class="layui-input-inline">
					<input name="legal" autocomplete="off" lay-verify="required" value="" placeholder="必填,法人代表" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">组织机构代码</label>
				<div class="layui-input-inline">
					<input name="orgcode" autocomplete="off" lay-verify="required" value="" placeholder="必填,组织机构代码" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">工商注册日期</label>
				<div class="layui-input-inline">
					<input name="zctime" autocomplete="off" lay-verify="date" value="" placeholder="必填,工商注册日期" class="layui-input" type="text" readonly onclick="layui.laydate({elem: this})">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">负责人</label>
				<div class="layui-input-inline">
					<input name="charge" lay-verify="required" autocomplete="off" value="" placeholder="必填,负责人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">电话</label>
				<div class="layui-input-inline">
					<input name="phone" lay-verify="phone" autocomplete="off" value="" placeholder="必填,负责人电话" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">屠宰种类</label>
				<div class="layui-input-block">　
					<input type="checkbox" name="type" value='1' title="猪" lay-skin="primary">
					<input type="checkbox" name="type" value='2' title="牛" lay-skin="primary">
					<input type="checkbox" name="type" value='3' title="羊" lay-skin="primary">
					<input type="checkbox" name="type" value='4' title="鸡" lay-skin="primary">
					<input type="checkbox" name="type" value='5' title="鸭" lay-skin="primary">
					<input type="checkbox" name="type" value='6' title="鹅" lay-skin="primary">
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">企业类型</label>
				<div class="layui-input-inline">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="species">
						<option value="1">定点屠宰场</option>
						<option value="2">小型屠宰场</option>
					</select>
				</div>
				<label class="layui-form-label">年屠宰能力</label>
				<div class="layui-input-inline">
					<input name="volum" autocomplete="off" lay-verify="number" value="" placeholder="必填,年屠宰能力(头/只)" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">上年度屠宰量</label>
				<div class="layui-input-inline">
					<input name="last_volum" autocomplete="off" lay-verify="number" value="" placeholder="必填,上年度屠宰量(头/只)" class="layui-input" type="text" />
				</div>
				<label class="layui-form-label">驻厂兽医</label>
				<div class="layui-input-inline">
					<input name="vet_id" lay-verify="required" value="" type="hidden">　
					<a class="layui-btn layui-btn-small" id="getvector1" style='margin-top:4px;'>
						<i class="fa fa-search"></i>　 获 取 驻 厂 兽 医　 　
					</a>
				</div>
            </div>
			<div class="layui-form-item">
				<input name="commit_letter" lay-verify="required" value="" type="hidden">
				<input name="prevent_cert" lay-verify="required" value="" type="hidden">
				<input name="sewage_permit" lay-verify="required" value="" type="hidden">
				<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　上传安全承诺书　 　" class="layui-upload-file up1">
				<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　上传防疫合格证　 　" class="layui-upload-file up2">
				<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　上传排污许可证　　" class="layui-upload-file up3">
			</div>
			<fieldset class="layui-elem-field layui-field-title" style="width: 609px;">
                <legend>违规违法记录</legend>
            </fieldset>
            <div class="layui-form-item" style="width: 609px;">
                <textarea class="layui-textarea" name="remark" placeholder="选填,违规违法记录"></textarea>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPosttz" data-href="/qyjbnews/add"><i class="fa fa-save"></i>提交</a>
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
			$('#getvector1').on('click',function(){
                layer.open({
                    type: 2,
                    title: '获取经纬度',
                    //shadeClose: true,
                    shade: 0.5,
                    maxmin: false,
                    area: ['700px', '520px'],
                    fixed: false,
                    content: ['/qyjbnews/sy.html','no']
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
						$('input[name=commit_letter]').val(res.savepath);
					}
				}
			});
			layui.upload({
				elem:'.up2',
				url: '/login/do_upload'
			    ,before: function(input){
				    console.log('文件上传中');
			    }
			    ,success: function(res){
					layer.msg('上传完毕');
					var img = '';
					if(res.code == 200){
						$('input[name=prevent_cert]').val(res.savepath);
					}
				}
			});
			layui.upload({
				elem:'.up3',
				url: '/login/do_upload'
			    ,before: function(input){
				    console.log('文件上传中');
			    }
			    ,success: function(res){
					layer.msg('上传完毕');
					var img = '';
					if(res.code == 200){
						$('input[name=sewage_permit]').val(res.savepath);
					}
				}
			});
        });
    </script>
</body>
</html>