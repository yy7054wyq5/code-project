@extends('admin.adminbase')
@section('title', '上传app')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">参数配置</h3>
        </div>

        <form name="form1" id="fileUpload" class="form-horizontal" action="set-param" m-bind="ajax">
            <div class="box-body">
                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">热门活动</label>

                    <div class="col-sm-10">
                        <select name="hotActivity" id="hotActivity" class="form-control" style="display: inline-block;width: auto;">
                            <option value="">热门活动起始值</option>
                            @foreach(range(1,\App\Models\Activity::$maxJoiners) as $value)
                                @if($value == config('hot.hotActivity'))
                                    <option value="{{$value}}" selected="selected">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">热门圈子</label>
                    <div class="col-sm-10">
                        <select name="hotGroup" id="hotGroup" class="form-control" style="display: inline-block;width: auto;">
                            <option value="">热门圈子起始值</option>
                            @foreach(range(10,100, 10) as $value)
                                @if($value == config('hot.hotGroup'))
                                    <option value="{{$value}}" selected="selected">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                            @foreach(range(100,1000, 100) as $value)
                                @if($value == config('hot.hotGroup'))
                                    <option value="{{$value}}" selected="selected">{{$value}}</option>
                                @else
                                    <option value="{{$value}}">{{$value}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">确定提交</button>
                        <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection