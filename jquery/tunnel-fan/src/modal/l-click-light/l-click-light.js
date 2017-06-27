

$(document).ready(function () {
  /*
* 照明： 点击单灯
*/
  $(document)
    .on('click', '.tunnel-right-hole.light .tunnel-box', function () {
      var lightlName = $(this).data('light-name');
      $('.click-light .light-name').text(lightlName);
      layer.open({
        type: 1,
        title: '回路控制',
        resize: false,
        area: ['420px', '340px'], //宽高
        content: $('.click-light').html()
      })
    });
});