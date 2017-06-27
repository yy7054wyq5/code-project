@extends('admin.adminbase')
@section('title', '私人订制')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">私人订制</h3>
        </div>
        <div class="box-body">
            <p>
                <a href="{{url('/backstage/line/add-invest')}}" class="btn btn-primary">新增私人订制</a>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.addmodule.id'),$jurisdiction))
                    <a href="{{url('/backstage/line/add-invest')}}" class="btn btn-primary">新增私人订制</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($lines['data'])
                        @foreach($lines['data'] as $line)
                            <tr>
                                <td>{{$line['title']}}</td>
                                <td>{{$line['createTime']}}</td>

                                <td>
                                    @if($line['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.editInvest.id'),$jurisdiction))
                                            <a href="/backstage/line/edit-invest/{{$line['qid']}}?start={{Input::get('start',0)}}" class="btn label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.special.id'),$jurisdiction))
                                            <a href="/backstage/line/special/{{$line['qid']}}" class="btn label-primary" >专题</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.specialRecord.id'),$jurisdiction))
                                            <a href="/backstage/line/special-record/{{$line['qid']}}" class="btn label-primary" >记录</a>
                                        @endif
                                        @if($line['enable'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.enableInvest.id'),$jurisdiction))
                                            <a href="javascript:;"  class="btn label-primary enable" data-type="1" data-id="{{$line['qid']}}">启用</a>
                                        @endif
                                        @else
                                            @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.enableInvest.id'),$jurisdiction))
                                                <a href="javascript:;"  class="btn label-danger enable" data-type="0" data-id="{{$line['qid']}}">停用</a>
                                            @endif
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.removeInvest.id'),$jurisdiction))
                                            <a href="/backstage/line/remove-invest/{{$line['qid']}}" class="btn label-danger" m-bind="confirm">删除</a>
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
            <?php echo isset($pager) ? $pager : '' ?>
        </div>
    </div>
    <script>
        $(function () {
            $('.enable').on('click',function(){
                $('.btn').attr('disabled',true);
                $.post('/backstage/line/enable-invest',{'qid':$(this).attr('data-id'),'type':$(this).attr('data-type')},function(res){
                    alert(res.msg);
                   location=location;
                });
            });
        });
    </script>
@endsection