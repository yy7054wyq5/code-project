

$(document).ready(function () {
  /*
* 照明：统计
*/
  $('.light.data').click(function () {
    layer.open({
      type: 1,
      title: '数据统计分析',
      resize: false,
      area: ['967px', '370px'],
      content: $('.data-count').html()
    });
  });
  $(document)
    .on('click', '.data-count-box a.nav', function () {
      $('.data-count-box a.nav').removeClass('active');
      $(this).addClass('active');
      $(this).data('con')
      $('.data-count-box .data-content').hide();
      $('.' + $(this).data('con')).show();
    });
});