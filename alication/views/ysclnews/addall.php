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
    <title>车辆承运详情</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>车辆承运详情 　
                <a href='javascript:;' class='a_add' data='<?php echo count($m)?(count($m)-1):0;?>'><font color='red'>加</font></a> 
                <a href='javascript:;' class='a_del'><font color='red'>减</font></a>
            </h2>
        </blockquote>
        <form action="/yclnews/addall" class="layui-form layui-form-pane" id="formrec" method="post" role="form">
			<input name='id' type='hidden' value='<?php echo $id?>' />
			<?php if($m){foreach($m as $ks => $mv):?>
            <div class='aid<?php echo $ks?$ks:"";?>'>
				<div class="layui-form-item">
					<label class="layui-form-label">往来类型</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="types">
							<option value="1" <?php if($mv['types']==1){echo 'selected';}?>>往来奶站</option>
							<option value="2" <?php if($mv['types']==2){echo 'selected';}?>>往来企业</option>
						</select>
					</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">往来名称</label>
                    <div class="layui-input-inline">
                        <input name="stock" autocomplete="off" lay-verify="required" value="<?php echo $mv['stock']?>" placeholder="名称" class="layui-input" type="text">
                    </div>
                </div>
				<div class="layui-form-item">
					<label class="layui-form-label">运输车类型</label>
                    <div class="layui-input-inline">
                        <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="breed">
							<option value="1" <?php if($mv['breed']==1){echo 'selected';}?>>租用</option>
							<option value="2" <?php if($mv['breed']==2){echo 'selected';}?>>自备</option>
						</select>
                    </div>
				</div>
            </div>
			<?php endforeach;}else{?>
			<div class='aid'>
                <div class="layui-form-item">
					<label class="layui-form-label">往来类型</label>
					<div class="layui-input-inline">
						<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="types">
							<option value="0">请选择往来类型</option>
							<option value="1">往来奶站</option>
							<option value="2">往来企业</option>
						</select>
					</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">往来名称</label>
                    <div class="layui-input-inline">
                        <input name="stock" autocomplete="off" lay-verify="required" value="" placeholder="往来名称" class="layui-input" type="text">
                    </div>
                </div>
				<div class="layui-form-item">
					<label class="layui-form-label">运输车类型</label>
                    <div class="layui-input-inline">
                        <select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="breed">
							<option value="0">请选择运输车类型</option>
							<option value="1">租用</option>
							<option value="2">自备</option>
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
                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="doPostAllSy" data-href="/yclnews/addall"><i class="fa fa-save"></i>提交</a>
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