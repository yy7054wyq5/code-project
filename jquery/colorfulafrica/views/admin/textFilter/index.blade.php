@extends('admin.adminbase')
@section('title', '敏感词管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">敏感词列表</h3>
        </div>
        <div class="box-body">
             <form action="/backstage/textfilter/list" method="get">
                <div class="form-group">
                    <label for="" class="control-label col-sm-2">关键字名称</label>
                    <div class="col-sm-2">
                        <input type="text" name="keyword" value="{{request('keyword')? request('keyword') : ''}}">
                    </div>
                    <label for="" class="control-label col-sm-2">替换字符</label>
                    <div class="col-sm-2">
                        <input type="text" name="replaceChar" value="{{request('replaceChar')? request('replaceChar') : ''}}">
                    </div>
                    <button class="btn btn-info btn-xs">搜索</button>
                </div>
                </form>
            <p><a href="{{url('/backstage/textfilter/add-textfilter')}}" class="btn btn-primary">新增字符过滤</a></p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="20%">关键字名称</th>
                         {{--    <th width="25%">英文关键字名称</th> --}}
                            <th width="20%">替换字符</th>
                            {{-- <th width="25%">英文替换字符</th> --}}
                            <th width="10%">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (isset($lists) && count($lists)>0)
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list['keyword']}}</td>
                                {{-- <td>{{$list['keywordEn']}}</td> --}}
                                <td>{{$list['replaceChar']}}</td>
                                {{-- <td>{{$list['replaceCharEn']}}</td> --}}
                                <td>
                                    @if($list['deleted'] == 0)
                                        <a href="/backstage/textfilter/edit-textfilter/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        <a href="/backstage/textfilter/remove/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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
            {{isset($pager) && $pager}}
        </div>
    </div>
@endsection
