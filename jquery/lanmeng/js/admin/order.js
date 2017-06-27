function showLogistics() {
	var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    if (!temp) {
    	layer.msg("抱歉，您还没有选择订单哟~o(︶︿︶)o");
    	return false;
    }
	$.post("/superman/logistics/alllogistics", {_token : $("#token").val()}, function(data){
        var html = '<table class="table table-striped table-hover table-bordered">';
	    html += "<tr><td class='name'>物流用户</td><td>";
	    html += "<select class=\"form-control\" id=\"logisticsuser\">";
        $.each(data['content'], function (index, val) {
            html += "<option value=\""+val.uid+"\">"+val.username+"---"+val.realname+"</option>";
        });
        html += "</select>";
	    html += "</td></tr>";
	    html += "<tr><td class='name'></td><td>";
	    html += "<button onclick=\"distribute()\" class=\"btn btn-sm btn-info\">确认分发</button>";
	    html += "</td></tr>";
	    html += "</table>";
        layer.open({
	        type: 1,
	        title: '分发订单至物流用户',
	        skin: 'layui-layer-rim', //加上边框
	        area: ['420px', '180px'], //宽高
	        content: html
	    });
    }, "json");
}

function distribute()
{
	var temp = "";
    $("input[name='check[]']:checked").each(function(){
        temp += ',' + $(this).val();
    });
    if (!temp) {
    	layer.msg("抱歉，您还没有选择订单哟~o(︶︿︶)o");
    	return false;
    }
    var uid = $("#logisticsuser  option:selected").val();

    if (!uid) {
    	layer.msg("抱歉，您还没有选择物流用户哟~o(︶︿︶)o");
    	return false;
    }
    $.post("/superman/logistics/distribute", {group : temp, uid : uid, _token : $("#token").val()}, function(data){
    	if (data.status == 0) {
    		layer.msg("订单分发已完成，本页即将自动刷新");
    		setTimeout("close()", 1000);
    	}
    }, "json");
}

function close()
{
	layer.closeAll();
	window.location.reload();
}