$(document).ready(function () {
  /*
* 风机：手动控制
*/
  $('.fan.handle').click(function () {
    layer.open({
      type: 1,
      title: '手动控制',
      resize: false,
      area: ['482px', '481px'],
      content: $('.handle-control').html()
    });
  });
});