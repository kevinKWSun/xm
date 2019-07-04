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
    <title>编辑生鲜乳收购站信息</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>

</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>编辑生鲜乳收购站信息　<a href='javascript:;' id='photo'>查看图片</a></h2>
        </blockquote>
        <form action="/nzglnews/edit" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
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
                <label class="layui-form-label">收购站名称</label>
                <div class="layui-input-inline">
                    <input name="name" lay-verify="required" placeholder="必填,生鲜乳收购站名称" autocomplete="off" class="layui-input" type="text" value="<?php echo $m['name'];?>" />
                </div>
            </div>
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
			<div class="layui-form-item">
				<label class="layui-form-label">开办单位</label>
				<div class="layui-input-inline">
					<input name="unit" autocomplete="off" lay-verify="required" value="<?php echo $m['unit'];?>" placeholder="必填,收购站开办单位" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">收购站类型</label>
				<div class="layui-input-inline">
					<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="types">
						<?php foreach ($this->config->item('milktype') as $k => $vc): ?>
						<option value="<?php echo $k; ?>"  value="<?php if($m['types'] == $k){echo ' selected';}?>"><?php echo $vc; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">许可证号</label>
				<div class="layui-input-inline">
					<input name="license" autocomplete="off" lay-verify="required" value="<?php echo $m['license'];?>" placeholder="必填,收购许可证编号" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">日收奶量</label>
				<div class="layui-input-inline">
					<input name="yield" autocomplete="off" lay-verify="number" value="<?php echo intval($m['yield']);?>" placeholder="必填,日收奶量(吨)" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">有效期</label>
				<div class="layui-input-inline">
					<input name="term" autocomplete="off" lay-verify="date" value="<?php echo date('Y-m-d', $m['term']);?>" placeholder="必填,有效期" class="Wdate layui-input" type="text"  onclick="layui.laydate({elem: this})" readonly>
				</div>
				<label class="layui-form-label">收购种类</label>
				<div class="layui-input-inline">
					<input name="cate" autocomplete="off" lay-verify="" value="<?php echo $m['cate'];?>" placeholder="选填,牛乳/牛奶/生鲜牛乳" class="layui-input" type="text">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">收购来源</label>
				<div class="layui-input-inline">
					<input name="soruce" autocomplete="off" lay-verify="required" value="<?php echo $m['soruce'];?>" placeholder="选填,收购来源" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">销售去向</label>
				<div class="layui-input-inline">
					<input name="take" autocomplete="off" lay-verify="" value="<?php echo $m['take'];?>" placeholder="选填,销售去向" class="layui-input" type="text">
				</div>
            </div>
            <div class="layui-form-item">
				<label class="layui-form-label">负责人</label>
				<div class="layui-input-inline">
					<input name="charge" autocomplete="off" lay-verify="required" value="<?php echo $m['charge'];?>" placeholder="必填,收购站负责人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">联系电话</label>
				<div class="layui-input-inline">
					<input name="phone" lay-verify="phone" autocomplete="off" value="<?php echo $m['phone'];?>" placeholder="必填,负责人联系电话" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">单位法人</label>
				<div class="layui-input-inline">
					<input name="legal" autocomplete="off" lay-verify="" value="<?php echo $m['legal'];?>" placeholder="选填,开办单位法人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">联系电话</label>
				<div class="layui-input-inline">
					<input name="tel" lay-verify="" autocomplete="off" value="<?php echo $m['tel'];?>" placeholder="选填,法人联系电话" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<input name="pic" lay-verify="" value="<?php echo $m['pic'];?>" type="hidden">
				<input name="station_pic" lay-verify="" value="<?php echo $m['station_pic'];?>" type="hidden">
				<input name="billboard" lay-verify="" value="<?php echo $m['billboard'];?>" type="hidden">
				<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　上传收购站照片 　" class="layui-upload-file up1">
				<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　上传奶站照片 　" class="layui-upload-file up2">
				<input type="file" name="userfile" lay-ext="jpg|png|gif" lay-title="　上传奶站监管公示牌照片　" class="layui-upload-file up3">
			</div>
			<div class="layui-form-item">
				<label class="layui-form-label">乡镇监管人</label>
				<div class="layui-input-inline">
					<input name="super" autocomplete="off" lay-verify="required" value="<?php echo $m['super'];?>" placeholder="必填,乡镇监管责任人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">单位</label>
				<div class="layui-input-inline">
					<input name="uintxz" lay-verify="required" autocomplete="off" value="<?php echo $m['uintxz'];?>" placeholder="必填,乡镇监管责任单位" class="layui-input" type="text">
				</div>
            </div>
			<div class="layui-form-item">
				<label class="layui-form-label">县级监管人</label>
				<div class="layui-input-inline">
					<input name="supers" autocomplete="off" lay-verify="required" value="<?php echo $m['supers'];?>" placeholder="必填,县级监管责任人" class="layui-input" type="text">
				</div>
				<label class="layui-form-label">单位</label>
				<div class="layui-input-inline">
					<input name="uintxj" lay-verify="required" autocomplete="off" value="<?php echo $m['uintxj'];?>" placeholder="必填,县级监管责任单位" class="layui-input" type="text">
				</div>
            </div>
			<div id="layer-photos-demo" class="layer-photos-demo" style='display:none'>
				<img layer-pid="1" layer-src="<?php echo $m['pic'];?>" src="<?php echo $m['pic'];?>" alt="">
				<img layer-pid="2" layer-src="<?php echo $m['station_pic'];?>" src="<?php echo $m['station_pic'];?>" alt="">
				<img layer-pid="3" layer-src="<?php echo $m['billboard'];?>" src="<?php echo $m['billboard'];?>" alt="">
			</div>
            <!--底部工具栏-->
            <div class="page-footer">
                <div class="btn-list">
                    <div class="btnlist">
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPost" data-href="/nzglnews/edit"><i class="fa fa-save"></i>提交</a>
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
						$('input[name=station_pic]').val(res.savepath);
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
						$('input[name=billboard]').val(res.savepath);
					}
				}
			});
        });
    </script>
</body>
</html>