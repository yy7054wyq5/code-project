function showDate(url) {
    var html = '<table class="table table-striped table-hover table-bordered">';
    html += "<tr><td class='name'>开始时间</td><td>";
    html += "<input type=\"text\" id=\"etimeBegin\" placeholder=\"开始时间\" onclick=\"laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})\" class=\"form-control\" />";
    html += "</td></tr>";
    html += "<tr><td class='name'>截止时间</td><td>";
    html += "<input type=\"text\" id=\"etimeEnd\" placeholder=\"截止时间\" onclick=\"laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss', choose:chooseCbk})\" class=\"form-control\" />";
    html += "</td></tr>";
    html += "<tr><td class='name'></td><td>";
    html += "<button class=\"btn btn-sm btn-info\" onclick=\"eurl('"+url+"')\">确认导出</button>";
    html += "</td></tr>";
    html += "</table>";
    layer.open({
        type: 1,
        title: '导出Excel',
        skin: 'layui-layer-rim', //加上边框
        area: ['420px', '240px'], //宽高
        content: html
    });
}

function eurl(url) {
    $etimeBegin = $('#etimeBegin').val();
    $etimeEnd = $('#etimeEnd').val();
    window.location.href = url+'?begin='+$etimeBegin+'&end='+$etimeEnd
}

function exports(url) {
    window.location.href = url
}


var count = 0;
function chooseCbk(dates)
{
    count++;
    var h = dates.substring(11,13);
    var m = dates.substring(14,16);
    var s = dates.substring(17,19);
    if (h == '00' && m=='00' && s=='00' && count==1) $('#etimeEnd').val(dates.substring(0,10) + ' 23:59:59');
}