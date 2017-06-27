@extends('admin.adminbase')
@section('title', '线路管理')
@section('content')
    <div class="dialog-demo-box" style="display:none;"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">线路管理</h3>
        </div>
        <div class="box-body">
            <form action="/backstage/line/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">线路名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
            </form>
            <p>
                <a href="{{url('/backstage/line/add-line')}}" class="btn btn-primary">新增线路</a>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.addmodule.id'),$jurisdiction))
                    <a href="{{url('/backstage/line/add-line')}}" class="btn btn-primary">新增线路</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>线路名称</th>
                        <th>参考费用</th>
                        <th>点赞数</th>
                        <th>评价</th>
                        <th>详情</th>
                        <th>缩略图</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($lines)>0)
                        @foreach($lines as $line)
                            <tr>
                                <td>{{$line['name']}}</td>
                                <td>{{$line['feeStart'].'-'.$line['feeEnd']}}</td>
                                <td>{{$line['favoriteNum']}}</td>
                                <td><a href="/backstage/line/comments/{{$line['id']}}" class="label label-default" >{{$line['commentNum']}}</a></td>
                                <td><button class="open btn" data-content="{{$line['detail']}}"  >查看</button></td>
                                <td><img src="/image/get/{{$line['picKey']}}" style="width:50px; height: 50px;" /> </td>
                                <td>
                                    @if($line['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.editLine.id'),$jurisdiction))
                                            <a href="/backstage/line/edit-line/{{$line['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.delLine.id'),$jurisdiction))
                                            <a href="/backstage/line/remove-line/{{$line['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
              <?php echo $pager ?>
        </div>
        <script type="text/javascript" >
        $(function(){
            $(".open").click(function(){
                var $d = $(".dialog-demo-box");
                var $content = $(this).attr('data-content');
                $d.dialog({
                    title: '线路详情',                  // title
                    dragable:true,
                    cache: false,
                    html: '',                       // html template
                    width: 750,                 // width
                    height: 400,                // height
                    confirmBtn:false,
                    cannelText: '取消',       // cannel text
                    confirmText: '确认',      // confirm text
                    showFooter:true,
                    getContent:function(){  // get Content callback
                        $d.find('.body-content').html($content);
                    }
                }).open();
            });
     });
        </script>
    </div>
@endsection
