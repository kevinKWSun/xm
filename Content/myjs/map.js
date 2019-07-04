layui.use(['layer', 'laypage', 'common', 'form', 'paging'], function () {
    var $ = layui.jquery, layer = layui.layer;
    var pjdName = 'FYJd'; //经度
    var pwdName = 'FYWd'; //纬度
    //初始化地图
    var map;
    var zoom = 12;
    var imageURL = "http://t0.tianditu.cn/img_w/wmts?" +
    "SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=img&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles" +
    "&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}";
    lay = new T.TileLayer(imageURL, { minZoom: 1, maxZoom: 18 });
    map = new T.Map("mapdiv");
    //设置显示地图的中心点和级别 
    map.centerAndZoom(new T.LngLat(121.43669, 37.45687), zoom);
    if ($("#dmapType").val() == "1") {
        map.addLayer(lay);
    }
    addMapClick();
    LoadPOINT();
    //矢　量
    $('#vector').on('click',function(){
    	$("#dmapType").val("0");
        map.removeLayer(lay);
    });
    //影　像
    $('#satellite').on('click',function(){
        $("#dmapType").val("1");
        map.addLayer(lay);
    });
    function addMapClick() {
        map.removeEventListener("click", MapClick);
        map.addEventListener("click", MapClick);
    }
    
    function MapClick(e) {
        map.clearOverLays();
        SetPOINT(e.lnglat.getLng(), e.lnglat.getLat());
    }
    //页面初始化加载点
    function LoadPOINT() {
        var jd = $(window.parent.document).find("#" + pjdName).val();
        var wd = $(window.parent.document).find("#" + pwdName).val();
        if (jd != "" && wd != "") {
            SetPOINT(jd, wd);
        }
    }
    //设置点
    function SetPOINT(longitude, latitude) {
        $("#longitude").val(longitude);
        $("#latitude").val(latitude);
        var icon = new T.Icon({
            iconUrl: "./Content/img/marker-icon.png",
            iconSize: new T.Point(19, 27),
            iconAnchor: new T.Point(10, 25)
        });
        var marker = new T.Marker(new T.LngLat(longitude, latitude), { icon: icon });
        map.addOverLay(marker);
    }
    var index = parent.layer.getFrameIndex(window.name);
    $('#transmit').on('click', function(){
    	var l = $("#longitude").val();
    	var w = $("#latitude").val();
    	if(! l || ! w){
    		layer.msg('请先获取经纬度');
    		return;
    	}
	    $(window.parent.document).find('#jname').val(l);
	    $(window.parent.document).find('#wname').val(w);
	    parent.layer.close(index);
	});
});