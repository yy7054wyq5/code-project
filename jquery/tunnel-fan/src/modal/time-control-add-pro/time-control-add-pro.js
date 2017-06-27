$(document).ready(function () {
  /*
  * 时序控制
  */
  // 风机
  $('.fan.time').click(function () {
    var hasPro = false;
    if (!hasPro) {
      // 新增
      layer.open({
        type: 1,
        title: '时序控制',
        resize: false,
        area: ['790px', '602px'],
        content: $('.pro-add').html()
      })
    } else {
      // 方案详情
      layer.open({
        type: 1,
        title: '方案详情',
        resize: false,
        area: ['790px', '602px'],
        content: $('.pro-detail').html()
      })
    }
  });

  // 照明
  $(document)
    .on('click', '#set-light-controll', function () {
      layer.closeAll('page');
      var hasPlan = false;
      if (!hasPlan) {
        // 新增
        layer.open({
          type: 1,
          title: '时序控制',
          resize: false,
          area: ['790px', '602px'],
          content: $('.pro-add').html()
        })
      } else {
        // 方案详情
        layer.open({
          type: 1,
          title: '方案详情',
          resize: false,
          area: ['790px', '602px'],
          content: $('.pro-detail').html()
        })
      }
    });

  /*
  * 新增按钮
  */
  $(document)
    .on('click', '.pro-add-con .btn', function () {
      var hash = location.hash;
      layer.closeAll('page');
      if (hash.indexOf('light') > -1) {
        layer.open({
          type: 1,
          title: '编辑计划',
          resize: false,
          area: ['760px', '600px'],
          content: $('.edit-light-plan').html()
        });
      } else {
        layer.open({
          type: 1,
          title: '编辑方案',
          resize: false,
          area: ['800px', '602px'],
          content: $('.fan-pro-edit').html()
        });
      }
    });

});