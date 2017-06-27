@extends('admin.adminbase')
@section('title', '敏感词管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">更新敏感词</h3>
        </div>
        <form action="{{url('/backstage/textfilter/edit-textfilter')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$detail['id']}}">
            <input type="hidden" name="start" value="{{Input::get('start',0)}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="home">
                        <p>
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">关键字名称</label>
                            <div class="col-sm-4">
                                <input name="keyword" id="keyword" type="text" class="form-control" value="{{$detail['keyword']}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入关键字名称</p>
                            </div>
                        </div>
                       {{--  <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">关键字英文名称</label>
                            <div class="col-sm-4">
                                <input name="keywordEn" id="keywordEn" type="text" class="form-control" value="{{$detail['keywordEn']}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入关键字英文名称</p>
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">替换字符</label>
                            <div class="col-sm-4">
                                <input name="replaceChar" type="text" class="form-control" value="{{$detail['replaceChar']}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入替换字符</p>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="username" class="control-label col-sm-2 required">英文替换字符</label>
                            <div class="col-sm-4">
                                <input name="replaceCharEn" type="text" class="form-control" value="{{$detail['replaceCharEn']}}" >
                            </div>
                            <div class="col-sm-6">
                                <p class="form-control-static text-muted small">请输入英文替换字符</p>
                            </div>
                        </div> --}}
                        </p>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-sm-offset-2">
                        <button type="submit" class="btn btn-primary">确认更新</button>
                        <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
