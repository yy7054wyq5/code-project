$(document).ready(function () {

  /**
   * 编辑照明方案后进详情页
   * 
   */
  function _editLightPro() {
    layer.closeAll('page');
    layer.open({
      type: 1,
      title: '方案详情',
      resize: false,
      area: ['790px', '602px'],
      content: $('.pro-detail').html()
    });
  }

  $(document)
    // 编辑
    .on('click', '.pro .edit', function () {
      var hash = location.hash;
      layer.closeAll('page');
      if (hash.indexOf('fan') > -1) {
        layer.open({
          type: 1,
          title: '编辑方案',
          resize: false,
          area: ['800px', '602px'],
          content: $('.fan-pro-edit').html()
        });
      } else {
        layer.open({
          type: 1,
          title: '编辑计划',
          resize: false,
          area: ['760px', '600px'],
          content: $('.edit-light-plan').html()
        });
      }
    })
    // 添加
    .on('click', '.pro .add', function () {
      var hash = location.hash;
      layer.closeAll('page');
      if (hash.indexOf('light') > -1) {
        layer.open({
          type: 1,
          title: '添加计划',
          resize: false,
          area: ['800px', '602px'],
          content: $('.edit-light-plan').html()
        });
      } else {
        layer.open({
          type: 1,
          title: '添加计划',
          resize: false,
          area: ['800px', '602px'],
          content: $('.fan-pro-edit').html()
        });
      }
    })
    // 删除
    .on('click', '.pro-table .delete', function () {
      layer.confirm('确定删除三岔顶隧道方案？', { icon: 3, title: '提示' }, function (index) {
        //do something
        layer.close(index);
      });
    })
    // 保存风机方案
    .on('click', '.layui-layer-content .fan-pro-edit-con .save', function () {
      // 方案详情
      layer.open({
        type: 1,
        title: '方案详情',
        resize: false,
        area: ['790px', '602px'],
        content: $('.pro-detail').html()
      });
    })
    // 保存照明方案
    .on('click', '.layui-layer-content .edit-light-plan-con .sure', function () {
      var id = 1;
      if (id) {
        layer.confirm('确定覆盖源文件或另存新方案', {
          btn: ['覆盖', '另存'] //按钮
        }, function () {
          _editLightPro();
        }, function () {
          layer.prompt({ title: '提示', formType: 0, value: '请输入另存方案名' }, function (text, index) {
            if (text && text !== '请输入另存方案名') {
              layer.close(index);
              _editLightPro();
            } else {
              layer.msg('请输入方案名');
            }
          });

        });
      } else {
        _editLightPro();
      }

    });
});