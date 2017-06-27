

$(document).ready(function () {
  /*
* 照明：控制模式
*/
  $('.controll.light').click(function () {
    layer.open({
      type: 1,
      title: '控制模式',
      resize: false,
      area: ['420px', '340px'], //宽高
      content: $('.light-controll').html()
    })
  });
  // 选择模式
  $(document)
    .on('click', 'table.light-controll .sure', function () {
      var radio = $(this).parents('table.light-controll').find('input[type="radio"][name="light-controll"]');
      for (var index = 0; index < radio.length; index++) {
        if (radio[index].checked) {
          $('.status-txt').text(radio[index].value);
          layer.closeAll('page');
          return;
        }
      }
      // 
    });
});