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
    <title>散养户基本信息</title>
	<link href="/Content/wx/mobile/style.css" rel="stylesheet" type="text/css">
    <link href="/Content/layui/css/layuis.css?rel=<?php echo time()?>" rel="stylesheet" />
    <link href="/Content/fhuaui/css/fhuaui.css" rel="stylesheet" />
    <link href="/Content/Font-Awesome/css/font-awesomes.css" rel="stylesheet" />
	<link href="/Content/wx/mobile/need/layer.css" rel="stylesheet" type="text/css">
    <script src="/Content/layui/layui.js"></script>
</head>
<body style='background: #ffffff'>
	<div class="main-wrap">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
			<legend>散养户基本信息</legend>
		</fieldset>
        <div class="y-role">
            <div id="floatHead" class="toolbar-wrap">
                <div class="toolbar">
                    <div class="box-wrap">
                        <div class="l-list clearfix">
                            <form id="tt" class="layui-form layui-form-pane">
                                <div class="layui-form-item">
									<div class="layui-input-inline" style="margin-left: 0px">
										<input name="skey" lay-verify="required" value="" autocomplete="off" placeholder="地址或散养户名称" class="layui-input" type="text" />
									</div>
                                    <div class="layui-inline">
                                        <a class="layui-btn layui-btn-small" lay-submit="" lay-filter="cx">
                                            <i class="fa fa-search"></i>　　　查　　询　　　
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAdd" data-href="/wxsynews/add.html">
                                            <i class="fa fa-plus"></i>　新　增　
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/wxsynews/lock.html">
                                            <i class="fa fa-lock"></i>　关　闭　
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doRefresh" data-href="/wxsynews.html">
                                            <i class="fa fa-refresh"></i>重新载入
                                        </a>
										<a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/wxsynews/sh.html">
                                            <i class="fa fa-refresh"></i>　通　过　
                                        </a>
										<a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/wxsynews/desh.html">
                                            <i class="fa fa-refresh"></i>　不通过　
                                        </a>
                                        <a class="layui-btn layui-btn-small do-action" data-type="doAction" data-href="/wxsynews/unlock.html">
                                            <i class="fa fa-unlock"></i>开　启
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fhui-admin-table-container">
                <form class="form-horizontal" id="formrec" method="post" role="form">
                    <table class="layui-table layui-tables" lay-skin="line">
                        <thead>
                            <tr>
								<th><input type="checkbox" id="selected-all" value="选择" /></th>
                                <th>名称</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php if(! $lists){ ?>
                            <tr>
                                <td class="nodata" colspan="12"><center>暂无数据！</center></td>
                            </tr>
                            <?php }else{foreach ($lists as $v): ?>
                            <tr>
								<td>
								<?php if($v['status']!=1){?>
                                    <input id="ck" ids="<?php echo $v['id']; ?>" name="ck" type="checkbox" value="true" />
								<?php }?>
                                </td>
								<td class='name'><?php echo $v['num']; ?></td>
								<td><?php if($v['status']==0){echo '待审';}elseif($v['status']==1){echo '通过';}elseif($v['status']==2){echo '未通过';}else{echo '已关闭';} ?></td>
                                <td><?php if($v['status']!=1){?>
                                    <a class="layui-btn layui-btn-small" href="/wxsynews/edit/<?php echo $v['id']; ?>.html">编辑</a><br><br>
								<?php }?>
									<a class="layui-btn layui-btn-small" href="/wxsynews/sedit/<?php echo $v['id']; ?>.html">详细</a><br><br>
								<a class="layui-btn layui-btn-small" href="/wxsynews/show/<?php echo $v['id']; ?>.html">查看</a>
								</td>
                            </tr>
                            <?php endforeach;} ?>
                        </tbody>
                    </table>
					<center style="padding-bottom:70px;">
						<?php if($total>1){?>
						<button id="listsview" class="layui-btn layui-btn-normal layui-btn-small" style="with:100%;" data-url="<?php echo '/wxsynews/',$c,'/',($p+1),'?query=',$keywords; ?>">加载更多</button>
						<?php }?>
					</center>
                </form>
            </div>
        </div>
    </div>
	<div class="top_bar">
		<nav>
			<ul id="top_menu" class="top_menu">
				<li><a href="<?php echo base_url('wx'); ?>"><img src="/Content/wx/mobile/images/recommend_a.png" width='30'><label>首页</label></a></li>
			</ul>
		</nav>
	</div>
	<script src="/Content/myjs/global.js"></script>
    <script src="/Content/myjs/list.js"></script>
    <script>
        layui.use(['layer', 'laypage', 'common', 'form', 'paging'], function () {
            var $ = layui.jquery, layer = layui.layer, laypage = layui.laypage, common = layui.common, form = layui.form(), paging = layui.paging();
            //监听查询
            form.on('submit(cx)', function (data) {
                var keywords = data.field.skey;
                $.post('/wxsynews/solor.html', { keywords: keywords },
                function (result, status) {
                    if (result.state == 1) {
                        window.location.href = '/wxsynews/solor/?query=' + result.message;//result.data;
                    }else{
                        common.layerAlertE('错误提示：' + s.message, '提示');
                    }
                });
            });
        });
    </script>
    </script>
</body>
</html>