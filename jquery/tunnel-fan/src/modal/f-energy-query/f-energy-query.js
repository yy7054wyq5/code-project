$(document).ready(function () {
  /*
* 风机：能耗查询
*/
  $('.fan.use').click(function () {
    layer.open({
      type: 1,
      title: '能耗查询',
      resize: false,
      skin: 'layui-layer-rim',
      area: ['967px', '370px'],
      content: $('.energy-query').html()
    });
  });
});