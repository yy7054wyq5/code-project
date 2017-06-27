@extends('admin.adminbase')
@section('title', '专题列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">专题列表</h3>
        </div>
        <div class="box-body">
            <p>
                <a href="{{url('/backstage/line/add-special').'/'.$id}}" class="btn btn-primary">新增专题</a>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.addmodule.id'),$jurisdiction))
                    <a href="{{url('/backstage/line/add-special')}}" class="btn btn-primary">新增专题</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="35">标题</th>
                        <th width="35%">创建时间</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($lines)
                        @foreach($lines['data'] as $line)
                            <tr>
                                <td>{{$line['title']}}</td>
                                <td>{{$line['createTime']}}</td>
                                
                                <td>
                                    @if($line['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.editSpecial.id'),$jurisdiction))
                                            <a href="/backstage/line/edit-special/{{$line['id']}}" class="label label-success" >编辑</a>
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.lineManage.removeSpecial.id'),$jurisdiction))
                                            <a href="/backstage/line/remove-special/{{$line['qid']}}/{{$line['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            <?php echo isset($pager)?$pager:'' ?>
        </div>
    </div>
@endsection