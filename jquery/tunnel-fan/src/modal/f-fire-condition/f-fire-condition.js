$(document).ready(function () {
  // 灭火救援设定风速
  function _setFanSpeed(val) {
    layer.closeAll('page');
    $('.fire-house-mode .out-fire')
      .addClass('active')
      .find('.wind-v')
      .text('排烟风速:' + val + 'm/s')
      .show();
  }

  /*
  * 风机：火灾工况
  */
  $('.menu .fan.fire').click(function () {
    layer.open({
      type: 1,
      title: '火灾工况',
      resize: false,
      area: ['421px', '280px'],
      content: $('.fire-condition').html()
    });
  });
  // 选择工况
  $(document)
    .on('click', '.fire-condition-table div.choose', function () {
      $('.fire-condition-table div.choose').removeClass('active');
      $(this).addClass('active');
    })
    // 选择模式
    .on('click', '.fire-condition-table .btn', function () {
      var $chooseMode = $(this).parents('.fire-condition-table').find('.choose.active');
      var type = $chooseMode.data('type');
      $('.tunnel-content .status .fan.fire').show();
      // 设置当前状态文字
      $('.status-txt').text($chooseMode.text());
      layer.closeAll('page');
      // type: 1 普通火灾工况（变频） 3 零风速模式
      if (type === 1 || type === 3) {
        $('ul.fire-house').height(90);
        $('.tunnel-right-hole>.hack').addClass('fire-house-mode');
        $('.mode-content .fire-house-mode').removeClass('hide');
        $('.mode-content .other-mode').addClass('hide');
        if (type === 3) {
          $('.evacuate span.wind-v').text('固定风速:0.0m/s');
        }
        // 重置已选择状态
        $('.sign-fire-point').addClass('active');
        $('.out-fire').removeClass('active');
        $('.fire-point').removeClass('normal').removeClass('active');
      }
    })
    // 标记着火点
    .on('click', '.fire-point', function () {
      $('.fire-point').addClass('normal');
      $(this).removeClass('normal').addClass('active');
      $('.fire-house-mode.fire-house .sign-fire-point').removeClass('active');
      $('.fire-house-mode .evacuate').addClass('active').find('span.wind-v').show();
      $('.fire-house-mode .out-fire').removeClass('active').find('span.wind-v').hide();
    })
    // 点击灭火救援模式
    .on('click', '.fire-house-mode .out-fire', function () {
      $('.fire-house-mode.fire-house .evacuate').addClass('active');
      layer.open({
        type: 1,
        title: '灭火救援模式',
        area: ['460px', '290px'],
        content: $('.cut-fire-mode').html()
      });
    })
    // 灭火救援模式确定按钮
    .on('click', 'table.cut-fire-mode .btn', function () {
      var $layerContent = $('.layui-layer-content');
      var val = $layerContent.find('input[name="slide-bar-value"]').val();
      var $isOk = $('.cut-fire-mode .isOk');
      $('.fire-house-mode .evacuate').removeClass('active').find('span.wind-v').hide();
      if (val) {
        if ($isOk.hasClass('active')) {
          if (val < 2 || val > 3) {
            layer.msg('请填写正确的风速值');
          } else {
            _setFanSpeed(val);
          }
        } else {
          _setFanSpeed(val);
        }
      } else {
        layer.msg('请填写正确的风速值');
      }
    })
    // 退出火灾排烟工况 
    .on('click', '.fire-house-mode .out-fire-mode', function () {
      layer.confirm('是否退出火灾排烟工况？', { icon: 3, title: '提示' }, function (index) {
        layer.close(index);
        window.outFireMode();
      });
    });
});