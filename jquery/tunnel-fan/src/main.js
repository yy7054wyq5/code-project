/*
* 退出火灾工况模式
*/

window.outFireMode = function () {
  $('.status-txt').text('平常工况');
  layer.closeAll('page');
  // 火灾工况模式下退出按钮和平常工况按钮隐藏
  $('.tunnel-content .status .fan.fire').hide();
  $('.tunnel-right-hole.fan .hack').removeClass('fire-house-mode')
  $('.fire-house-mode.fire-house').addClass('hide');
  $('.other-mode').removeClass('hide');
}

/**
 * 
 * 清除风机旋转interval
 */

window.clearFanRotateInterVal = function (id) {
  if (!id) {
    if (window.interValId && window.interValId.length > 1) {
      for (var index = 0; index < window.interValId.length; index++) {
        clearInterval(window.interValId[index]);
      }
    }
  } else {
    clearInterval(id);
    console.log(id);
    for (var i = 0; i < window.interValId.length; i++) {
      if (window.interValId[i] === id) {
        window.interValId.splice(index, 1);
        console.log(window.interValId);
      }
    }
  }
}

/**
 * 
 * 切换系统
 * @param {any} string 
 */

function _changeSys(string) {
  if (string) {
    location.hash = string;
    sessionStorage.setItem('hash', string);
  } else {
    layer.msg('请选择系统');
    return;
  }
  window.outFireMode();
  if (string === 'login') {
    $('.index').addClass('hide');
    $('.login').removeClass('hide');
    window.clearFanRotateInterVal();
  }
  // 照明
  else if (string === 'light') {
    window.clearFanRotateInterVal();
    $('.index').removeClass('hide');
    $('.login').addClass('hide');
    $('.menu a.light').parent().show();
    $('.menu a.fan').parent().hide();
    $('.sys-change').addClass('visit-wind').removeClass('visit-light');
    $('.wrap>.crumbs>.line').text('照明控制');
    $('.status-name').text('当前控制模式：');
    $('.status span.plan.txt').show().text('执行方案：');
    $('.status span.plan.status-txt').show().text('三岔顶照明');
    $('.status a.fan').hide();
    $('.status a.light').show();
    $('.tunnel .item').addClass('light');
    $('.tunnel-right-hole').addClass('light').removeClass('fan');
    $('.wind-speed').hide();
    $('.fan-rate').hide();
    $('.dust-thickness').hide();
    $('.co-thickness').hide();
    $('.outside-bright').show();
    $('.enter-one-bright').show();
    $('.car-number').show();
    $('.tunnel-name div.light').show();
    $('.tunnel-name div.fan').hide();
    $('.crumbs.real-time').hide();
    $('.real-time-chart.light').show();
    $('.real-time-chart.fan').hide();
    $('.status-txt').text('应急照明模式');
    $('.status .plan').hide();
  } else { // 风机
    $('.index').removeClass('hide');
    $('.login').addClass('hide');
    $('.menu a.light').parent().hide();
    $('.menu a.fan').parent().show();
    $('.sys-change').addClass('visit-light').removeClass('visit-wind');
    $('.wrap>.crumbs>.line').text('通风控制');
    $('.status-name').text('当前状态：');
    $('.status span.plan.txt').hide();
    $('.status span.plan.status-txt').hide();
    $('.status a.light').hide();
    $('.tunnel .item').removeClass('light');
    $('.tunnel-right-hole').removeClass('light').addClass('fan');
    $('.wind-speed').show();
    $('.fan-rate').show();
    $('.dust-thickness').show();
    $('.co-thickness').show();
    $('.outside-bright').hide();
    $('.enter-one-bright').hide();
    $('.car-number').hide();
    $('.tunnel-name div.light').hide();
    $('.tunnel-name div.fan').show();
    $('.crumbs.real-time').show();
    $('.real-time-chart.light').hide();
    $('.real-time-chart.fan').show();
  }
}

$(document).ready(function () {
  'use strict';
  var hash = location.hash.substring(1, location.hash.length);
  if (hash) {
    sessionStorage.setItem('hash', hash);
    _changeSys(hash);
  } else {
    location.hash = 'login';
    _changeSys('login');
  }

  /*
  * 选择左右洞
  */
  $('#chooseHole').change(function () {
    var val = $(this).val();
    $('.tunnel-' + val + '-hole').removeClass('hide');
    if (val === 'left') {
      $('.tunnel-right-hole').addClass('hide');
      $('.tunnel-center').text('三岔顶隧道左洞');
    } else if (val === 'right') {
      $('.tunnel-left-hole').addClass('hide');
      $('.tunnel-center').text('三岔顶隧道右洞');
    } else {
      $('.tunnel-left-hole').removeClass('hide');
      $('.tunnel-right-hole').removeClass('hide');
      $('.tunnel-center').text('三岔顶隧道');
    }
  });

  /*
  * 切换系统
  */
  $('.sys-change').click(function () {
    var hash = sessionStorage.getItem('hash');
    if (hash === 'light') {
      location.hash = 'fan';
      _changeSys('fan');
    } else {
      location.hash = 'light';
      _changeSys('light');
    }
  });

  /*
  * 生成时间选择器和销毁
  */
  $(document)
    .on('mouseenter', 'input.datetimepicker', function () {
      $.datetimepicker.setLocale('zh');
      var configStr = $(this).attr('date-time-config');
      configStr = configStr.replace(/#/g, '"');
      var config = JSON.parse(configStr);
      $(this).datetimepicker(config);
    })
    .on('blur', 'input.datetimepicker', function () {
      $(this).datetimepicker('destroy');
    });

  /*
  * slide-bar 交互
  */
  $(document)
    .on('click', '.slide-bar-finish', function () {
      var $input = $(this).siblings('input[name="slide-bar-value"]');
      var val = $input.val();
      var parentTable = $(this).parents('.slide-table');
      if (val == 0) {
        parentTable.find('.slide-bar.active').addClass('hide');
        return;
      }
      var initVal = val;
      var max = $input.data('max');
      val = parseInt(val, 10) / max * parentTable.find('.slide-bar .line.source').width();
      parentTable.find('.slide-bar.active').removeClass('hide');
      parentTable.find('.slide-bar.active .line').width(val);
      parentTable.find('.slide-bar-txt span').text(initVal);
    })
    .on('blur', 'input[name="slide-bar-value"]', function () {
      var val = $(this).val();
      var max = $(this).data('max');
      if (val > max || val < 0) {
        $(this).val(10);
      }
      $('.slide-bar-finish').trigger('click');
    });

  /*
  * 自定义radio
  */

  $(document)
    .on('click', '.l-radio>i', function () {
      if ($(this).parent().siblings().length !== 0) {
        $(this).parent().parent().attr('data-radio-value', $(this).parent().data('value')).find('.l-radio>i').removeClass('active');
        $(this).addClass('active');
      } else {
        if ($(this).hasClass('active')) {
          $(this).removeClass('active');
        } else {
          $(this).addClass('active');
        }
      }
    });

  /*
  * 竖列风机选中
  */
  $(document)
    // 手动控制列表
    .on('click', '.handle-control-left>li', function () {
      var $self = $(this);
      var $li = $('.layui-layer-content .handle-control-left>li');
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        if ($self.find('span').text() === $($li[0]).find('span').text()) {
          $li.removeClass('active');
        }
      } else {
        $(this).addClass('active');
        if ($self.find('span').text() === $($li[0]).find('span').text()) {
          $li.addClass('active');
        }
      }
    });

  /*
  * 风机：平常工况和退出模式
  */
  $('.normal.fan').click(function () {
    layer.confirm('是否启动平常工况？', { icon: 3, title: '提示' }, function (index) {
      layer.close(index);
      window.outFireMode();
    });
  });
  $('.out.fan').click(function () {
    layer.confirm('是否退出当前模式？', { icon: 3, title: '提示' }, function (index) {
      layer.close(index);
      window.outFireMode();
    });
  });

  /*
  * 主界面
  */
  $('.light.main').click(function () {
    location.hash = 'light';
    _changeSys('light');
  });

  /*
  * 应急照明系统
  */
  $(document)
    .on('click', '.status .light', function () {
      layer.confirm('是否启动应急照明？', { icon: 3, title: '提示' }, function (index) {
        layer.close(index);
      });
    });

  /*
  * 登录页操作
  */
  $(document)
    // 登录
    .on('click', '.login-input-content .btn.login', function () {
      var sys = $('.choose-sys').data('radio-value');
      if (sys) {
        _changeSys(sys);
      } else {
        layer.msg('请选择系统');
      }
    })
    .on('click', '.login-input-content .btn.reset', function () {
      $('.login-input-content input').val('');
    });


  /*
  * 退出
  */
  $('.user span').click(function () {
    layer.confirm('确定退出？', { icon: 3, title: '提示' }, function (index) {
      layer.close(index);
      _changeSys('login');
    });
  });
});