

$(document).ready(function () {
  /*
* 照明： 单灯状态
*/
  // single-light-status
  $('.light.one-light').click(function () {
    layer.open({
      type: 1,
      title: '功率控制',
      resize: false,
      area: ['310px', '215px'],
      content: $('.single-light-status').html()
    });
  });
});