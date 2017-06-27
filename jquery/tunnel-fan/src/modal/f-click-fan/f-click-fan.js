$(document).ready(function () {
  window.interValId = [];

  /**
   * 
   * 风扇旋转
   * @param {any} obj 
   * @param {any} rotate 
   * @returns interValId
   */

  function _fanRotate(obj, rotate) {
    if(obj.attr('interval-id')){
      var id = obj.attr('interval-id');
      window.clearFanRotateInterVal(id);
      obj.attr('interval-id', 0);
    }
    var interValId = setInterval(function () {
      obj
        .rotate({
          angle: 0,
          animateTo: rotate,
          easing: $.easing.easeInOutExpo
        });
    }, 100);
    window.interValId.push(interValId);
    console.log(interValId);
    obj.attr('interval-id', interValId);
  }

  /*
  * 风机： 点击风机
  */

  $(document)
    .on('click', '.tunnel-right-hole.fan .tunnel-box', function () {
      var tunnelName = $(this).data('fan-name');
      var tunnelNumber = $(this).data('fan-number');
      $('.click-fan .slide-bar.active').addClass('hide');
      $('.click-fan .fan-name').text(tunnelName);
      $('.click-fan .slide-bar-txt span').text('');
      layer.open({
        type: 1,
        title: 'RFAN' + tunnelNumber,
        resize: false,
        skin: 'layui-layer-rim', //加上边框
        area: ['420px', '340px'], //宽高
        content: $('.click-fan').html()
      });
    })
    .on('click', '.layui-layer-content .click-fan-con .sure', function () {
      var rotate = $('.layui-layer-content .l-radio').parent().data('radio-value');
      var fanName = $(this).parents('.click-fan-con').find('.fan-name').text();
      var $item = $('.tunnel-box[data-fan-name="' + fanName + '"]').find('.item');
      var intervalId = $item.attr('interval-id');
      if (!rotate) {
        layer.msg('选择风机状态');
        return;
      } else {
        if (rotate === 'normal') {
          _fanRotate($item, 180);
        } else if (rotate === 'reversal') {
          _fanRotate($item, -180);
        } else {
          window.clearFanRotateInterVal(intervalId);
          $item.attr('interval-id', 0);
        }
      }
      layer.closeAll('page');
    });
});