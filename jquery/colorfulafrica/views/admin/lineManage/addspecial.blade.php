@extends('admin.adminbase')

@section('title', '新增专题')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">新增专题</h3>
        </div>
        <form action="{{url('/backstage/line/add-special')}}" class="form-horizontal" method="post" m-bind="ajax" id="formV" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="qid" value="{{$qid}}">
            <div class="box-body">
                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>
               
                <div class="form-group">
                    <label for="username" class="control-label col-sm-2 required"> 题目</label>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="title" ></textarea>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static text-muted small">请输入题目(不能超过200字)</p>
                    </div>
                </div>
                <div class="isspec">
                    <div class="form-group specadd">
                        <label for="" class="control-label col-sm-2 required">选项</label>
                        <div class="col-sm-4">
                            <button class="btn btn-primary spec" ><i class="fa fa-plus-circle"></i> 添加</button>
                        </div>
                        <div class="col-sm-6">
                        <p class="form-control-static text-muted small">选项(不能超过100字)</p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认更新</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        <?php $timestamp = time();?>

        $(document).on('click', '.specadd', function (event) {
            event.preventDefault();
            var length = $('.form-group.spec').length;
            var index = length + 1;
            var html = '<div class="form-group spec" data-index="'+index+'">' +
                    '<label for="" class="control-label col-sm-2 required"></label>' +
                    '<div class="col-sm-4">' +
                    '<div class="input-group" style="width: 350px;" >' +
                    '<div class="input-group-addon">选项</div>' +
                    '<input type="text" class="form-control" name="option[]">' +
                    '<div class="input-group-addon" onclick="$(this.parentElement.parentElement.parentElement).remove()"><i class="fa fa-minus"></i></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            if (length >0) {
                $($('.form-group.spec')[length-1]).after(html);
            }else {
                $('.form-group.specadd').after(html);
            }
        });
    </script>
@endsection