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
    <title>添加养殖场信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>添加养殖场信息 <a class="layui-btn layui-btn-small do-action" data-type="doShow" data-href="/ausers/bind.html"><i class="fa fa-plus"></i>绑定登录账号</a></h2>
        </blockquote>
        <form action="/yznews/yznewsadd" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name='aid' type='hidden' value='' />
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">养殖场名称</label>
					<div class="layui-input-block">
						<input name="name" autocomplete="off" lay-verify="required" placeholder="必填,养殖场名称" class="layui-input" type="text">
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline address">
					<label class="layui-form-label">养殖场地址</label>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="addr_city" data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" lay-filter="select">
							<option selected="selected" value="<?php echo $city; ?>"><?php echo $city_name['name']; ?></option>
						</select>
					</div>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="addr_county" data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的">
							<option value="0">请选择</option>
							<?php foreach($county as $k=>$v) : ?>
								<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="layui-input-inline" style="width: 300px;">
						<input name="addr" autocomplete="off" lay-verify="required" placeholder="必填,养殖场地址" class="layui-input" type="text">
					</div>
				</div>
            </div>
			<fieldset class="layui-elem-field site-demo-button" style="margin-top: 25px;margin-bottom: 25px;width: 630px;">
				<legend>养殖种类</legend>
					<div class="layui-input-block" style="margin-left:15px;">
						<?php foreach($cate as $k=>$v) { ?>
							<input type="checkbox" name="cate[<?php echo $k; ?>]" lay-skin="primary" title="<?php echo $v; ?>" value="<?php echo $k; ?>" />
						<?php } ?>
					</div>
			</fieldset>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">经度</label>
					<div class="layui-input-block">
						<input name="lng" id="jname" autocomplete="off" lay-verify="required" placeholder="必填,经度" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">纬度</label>
					<div class="layui-input-block">
						<input name="lat" id="wname" autocomplete="off" lay-verify="required" placeholder="必填,纬度" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<a class="layui-btn layui-btn-small" id="getvector"  data-href="/yznews/yznewsadd">选择</a>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">法人</label>
					<div class="layui-input-block">
						<input name="legal_name" autocomplete="off" lay-verify="required" placeholder="必填,法人姓名" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">联系电话</label>
					<div class="layui-input-block">
						<input name="phone" autocomplete="off" lay-verify="required" placeholder="必填,联系电话" class="layui-input" type="text">
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">负责人</label>
					<div class="layui-input-block">
						<input name="charge_id" autocomplete="off" lay-verify="required" placeholder="必填,负责人姓名" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">联系电话</label>
					<div class="layui-input-block">
						<input name="tel" autocomplete="off" lay-verify="required" placeholder="必填,联系电话" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">身份证号</label>
					<div class="layui-input-block">
						<input name="charge_idcard" autocomplete="off" lay-verify="required" placeholder="必填,身份证号" class="layui-input" type="text">
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">信号接入点</label>
				<div class="layui-input-inline">
					<input name="point" autocomplete="off" lay-verify="required" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">监管兽医</label>
				<div class="layui-input-inline">
					<input name="vet" autocomplete="off" lay-verify="required" placeholder="必选,监管兽医" class="layui-input" type="hidden">
				</div>
				<div class="layui-input-inline">
					　<a class="layui-btn layui-btn-small do-action" data-type="doShow" data-href="/ausers/sylist.html" style='margin-top:4px;'><i class="fa fa-plus"></i>　 请 选 择 监 管 兽 医 　</a>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">防疫合格证</label>
					<div class="layui-input-block">
						<input name="prevent_num" autocomplete="off" lay-verify="required" placeholder="必选,防疫合格证" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">发放时间</label>
					<div class="layui-input-block">
						<input name="issuing_time" autocomplete="off" lay-verify="required" placeholder="必选,发放时间" id="issuing_time" lay-verify="date" placeholder="yyyy-MM-dd" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">厂容厂貌</label>
				<div class="layui-input-inline">
					<input name="pic" autocomplete="off" lay-verify="required" value="" placeholder="必传,图片" class="layui-input" type="hidden">
					<input type="file" name="userfile[]" multiple lay-ext="jpg|png|gif" lay-type="file" lay-title="上传" class="layui-upload-file">
				</div>
			</div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/yznews/yznewsadd"><i class="fa fa-save"></i>提交</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href=""><i class="fa fa-refresh fa-spin"></i>刷新</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doGoBack" data-href="/yznews/index"><i class="fa fa-mail-reply"></i>返回上一页</a>
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
		layui.use(['layer', 'laypage', 'common', 'form', 'paging', 'upload'], function () {
            var $ = layui.jquery, layer = layui.layer, laypage = layui.laypage, common = layui.common, form = layui.form(), paging = layui.paging(), upload = layui.upload;
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
							$('select[name=addr_county]').html(e);
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
        });
	</script>
</body>
</html>