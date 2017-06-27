@extends('admin.adminbase')
@section('title', '用户列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">用户列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <div class="form-group" id="content" style="display: none">
                    <label for="" class="control-label col-sm-1">发送消息</label>
                    <div class="col-sm-4">
                        <input class="col-sm-12" type="text" name="content" placeholder="请输入消息内容" value="">
                        <input type="hidden" name="userid" value="">
                    </div>
                    <button class="btn btn-info confirm">确定</button>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>头像</th>
                        <th>昵称</th>
                        <th>手机</th>
                        {{--<th>年龄</th>--}}
                        <th>性别</th>
                        <th>注册时间</th>
                        <th>最近访问</th>
                        <th>用户状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($users) && !empty($users)) {?>
                    <?php foreach($users as $user) {?>
                    <tr data-userid="{{$user['id']}}">
                        <td>
                            <img src="/image/get/{{$user['picKey']?$user['picKey']:''}}" width="40px" height="40px" >
                        </td>
                        <td>{{$user['nickname']}}</td>
                        <td>{{$user['mobile']}}</td>
                        {{--<td>{{$user['age'] ? $user['age']:18}}</td>--}}
                        @if($user['sex'] == 1)
                            <td>男</td>
                        @elseif($user['sex'] == 2)
                            <td>女</td>
                        @else
                            <td>保密</td>
                        @endif
                        <td>{{$user['createTime']}}</td>
                        <td>{{$user['visitedTime'] ? $user['visitedTime'] : '空'}}</td>
                        <td>{{$user['deleted'] == 0 ? '正常' : '删除'}}</td>
                        <td>
                            @if($user['deleted'] == 0)
                            <a href="/backstage/account/remove-user?userId={{$user['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                            @endif
                        </td>
                    </tr>
                    <?php }?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <?php echo $pager ?>
        </div>
    </div>
    <script>
        //搜索按钮
        $('.label.label-info.cntlabel').click(function()
        {
            $("#content input[name='userid']").val($(this).parent().parent().data('userid'));
            $("#content").toggle();
        });


        $('.btn.btn-info.confirm').click(function(){
            var content = $(this).parent().find("input[name='content']").val();
            var userid = $(this).parent().find("input[name='userid']").val();
            $.get('/backstage/account/send-message', {'userId':userid,'content':content}, function (res){
                if(res['status'] == 'success') {
                    $("#content").hide();
                    alert(res['msg']);
                } else {
                    alert(res['msg']);
                }

            });
        });

    </script>

@endsection