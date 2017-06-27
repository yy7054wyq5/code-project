$(document).ready(function () {
  /*
* 风机：参数配置
*/
  $('.fan.config').click(function () {
    layer.open({
      type: 1,
      title: '参数配置',
      resize: false,
      skin: 'layui-layer-rim', //加上边框
      area: ['420px', '340px'], //宽高
      content: $('.params-config').html()
    });
  });
});