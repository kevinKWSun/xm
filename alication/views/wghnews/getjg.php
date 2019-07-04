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
    <title>监管对象</title>
    <link href="/Content/layui/css/layui.css" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesome.css" rel="stylesheet" />
    <script src="/Content/layui/layui.js"></script>
</head>
<body>
    <div class="main-wrap">
        <blockquote class="layui-elem-quote fhui-admin-main_hd">
            <h2>监管对象</h2>
        </blockquote>
        <div class="y-role">
            <!--工具栏-->
            <div id="floatHead" class="toolbar-wrap">
                <div class="toolbar">
                    <div class="box-wrap">
                        <div class="l-list clearfix">
                            <form id="tt" class="layui-form layui-form-pane">
                                <div class="layui-form-item">
									<div class="layui-input-inline">
										<select data-val="true" data-val-number="字段 Int32 必须是一个数字" data-val-required="Int32 字段是必需的" name="cateid">
											<option value="1">养殖场</option>
										</select>
									</div>
									<div class="layui-input-inline" style="margin-left: 0px">
										<input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="地址或名称" class="layui-input" type="text" />
									</div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>查询
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/wghnews/getjg.html">
                                            <i class="fa fa-refresh"></i>重新载入
                                        </a>
										<a class="layui-btn layui-btn-small dx" href='javascript:;'><i class="fa fa-save"></i>确定</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--/工具栏-->
            <!--文字列表-->
            <div class="fhui-admin-table-container">
                <form class="form-horizontal" id="formrec" method="post" role="form">
                    <table class="layui-table layui-tables" lay-skin="line">
                        <thead>
                            <tr>
								<th><input type="checkbox" id="selected-all" /></th>
                                <th>名称</th>
                                <th>地址</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(! $synews){ ?>
                            <tr>
                                <td class="nodata" colspan="7">暂无数据！</td>
                            </tr>
                            <?php }else{foreach ($synews as $v): ?>
                            <tr class='ck'>
								<td>
									<input id="ck" ids="<?php echo isset($v['id']) ? $v['id'] : $v['uid']; ?>" name="ck" type="checkbox" value="true" rel="<?php echo $v['name']; ?>" />
                                </td>
                                <td><?php echo $v['name']; ?></td>
								<td><?php echo $v['area'] ?></td>
                            </tr>
                            <?php endforeach;} ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <!--/文字列表-->
            <div class="fhui-admin-pagelist">
                <div id="page">
                    <div class="pagelist">
                        <div class="l-btns">
                            <span>共 <?php echo $totals; ?> 条</span>
                        </div>
                        <div id="PageContent" class="default"><?php echo $page; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/list.js"></script>
    <script>
        layui.use(['layer', 'laypage', 'common', 'form', 'paging'], function () {
            var $ = layui.jquery, layer = layui.layer, laypage = layui.laypage, common = layui.common, form = layui.form(), paging = layui.paging();
            //监听查询
            form.on('submit(cx)', function (data) {
                var keywords = data.field.skey;
                $.post('/wghnews/farm', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/wghnews/farm/1?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
			var index = parent.layer.getFrameIndex(window.name);
			$('.dx').on('click', function(){
				if ($(".layui-table tbody input:checked").size() < 1) {
                    common.layerAlertE('对不起，请选中您要操作的记录！', '提示');
                    return false;
                }
                var name = "";
				var	ids = "";
                var checkObj = $(".layui-table tbody input:checked");
                if(checkObj.length > 1){
                    for (var i = 0; i < checkObj.length; i++) {
                        if (checkObj[i].checked && $(checkObj[i]).attr("disabled") != "disabled"){
							if(i == checkObj.length - 1){
								ids += $(checkObj[i]).attr("ids");
								name += $(checkObj[i]).attr("rel");
							}else{
								ids += $(checkObj[i]).attr("ids") + ',';
								name += $(checkObj[i]).attr("rel") + ',';alert(i);								
							}							
                        } 
                    }
                }else{
                    if (checkObj[0].checked && $(checkObj[0]).attr("disabled") != "disabled"){
                        ids += $(checkObj[0]).attr("ids");
						name += $(checkObj[0]).attr("rel");
                    }
                }
				var cid = $('select[name=cateid]').val();
				$(window.parent.document).find('input[name=cid]').val(cid);
				$(window.parent.document).find('textarea[name=jgdx]').val(name);
				$(window.parent.document).find('textarea[name=cid_1]').val(ids);
                parent.layer.close(index);
			});
        });
    </script>
</body>
</html>