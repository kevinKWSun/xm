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
    <title>添加饲料经营企业信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>添加饲料经营企业信息</h2>
        </blockquote>
        <form action="/jymessage/jyadd" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">企业名称</label>
					<div class="layui-input-block">
						<input name="name" autocomplete="off" lay-verify="required" placeholder="必填,企业名称" class="layui-input" type="text" />
					</div>
				</div>
            </div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">注册地址</label>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="reg_city" data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" >
							<option selected="selected" value="<?php echo $city; ?>"><?php echo $city_name['name']; ?></option>
						</select>
					</div>
					<div class="layui-input-inline" style="width: 100px;">
						<select name="reg_county" data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" >
							<?php foreach($county as $k=>$v) : ?>
								<option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="layui-input-inline" style="width: 300px;">
						<input name="reg_addr" autocomplete="off" lay-verify="required" placeholder="必填,企业注册地址" class="layui-input" type="text">
					</div>
				</div>
            </div>
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
					<label class="layui-form-label">邮编</label>
					<div class="layui-input-block">
						<input name="zipcode" autocomplete="off" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">仓库地址</label>
					<div class="layui-input-block">
						<input name="cang" autocomplete="off" class="layui-input" type="text">
					</div>
				</div>
			</div>
			<div class="layui-form-item">
				<div class="layui-inline">
					<label class="layui-form-label">经营许可证编号</label>
					<div class="layui-input-block">
						<input name="license" autocomplete="off" lay-verify="required" placeholder="必填,经营许可证编号" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">发证日期</label>
					<div class="layui-input-block">
						<input name="license_begin" autocomplete="off" lay-verify="required" placeholder="必选,发证日期" id="issuing_time" lay-verify="date" placeholder="yyyy-MM-dd" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">有效期至</label>
					<div class="layui-input-block">
						<input name="license_time" autocomplete="off" lay-verify="required" placeholder="必选,有效期至" id="issuing_time" lay-verify="date" placeholder="yyyy-MM-dd" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text">
						
					</div>
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
						<input name="legal_phone" autocomplete="off" lay-verify="required" placeholder="必填,联系电话" class="layui-input" type="text">
					</div>
				</div>
				<div class="layui-inline">
					<label class="layui-form-label">开办时间</label>
					<div class="layui-input-block">
						<input name="estab_time" autocomplete="off" lay-verify="required" placeholder="必选,开办时间"  lay-verify="date" placeholder="yyyy-MM-dd" class="Wdata layui-input" onclick="layui.laydate({elem: this})" type="text">
						
					</div>
				</div>
            </div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/sljynews/sljyadd"><i class="fa fa-save"></i>提交</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href=""><i class="fa fa-refresh fa-spin"></i>刷新</a>
                        <a class="layui-btn layui-btn-small do-action" data-type="doGoBack" data-href="/sljynenws/index"><i class="fa fa-mail-reply"></i>返回上一页</a>
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
                    var rel = $(this).parent().parent().parent().find('select').attr('rel');
                    $('.address select').each(function(){
                        var res = $(this).attr('rel');
                        if(res > rel){
                            $(this).parent().remove();
                        }
                    });
                    var sid = data.value;
                    if(sid > 0){
                        $.get('/map/getarea/'+sid+'.html',{},function(e){
                            if(e){
                                $('.address .area').before(e);
                                form.render();
                            }
                        });
                    }
                }
            });
        });
	</script>
</body>
</html>