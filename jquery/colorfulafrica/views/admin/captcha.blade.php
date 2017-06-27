@extends('admin.adminbase')
@section('title', '验证码列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">验证码列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">用户手机</label>
                    <div class="col-sm-4">
                        <input type="text" name="mobile" value="{{request('mobile')? request('mobile') : ''}}">
                    </div>
                    <button class="btn btn-info">确定</button>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>手机号</th>
                        <th>验证码</th>
                        <th>Tag</th>
                        <th>过期时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($captchas)
                        @foreach($captchas as $captcha)
                            <tr>
                                <td>{{$captcha['mobile']}}</td>
                                <td>{{$captcha['captcha']}}</td>
                                @if($captcha['tag'] == 1)
                                    <td>注册和密码</td>
                                @elseif($captcha['tag'] == 2)
                                    <td>创建活动</td>
                                @elseif($captcha['tag'] == 3)
                                    <td>参加活动</td>
                                @elseif($captcha['tag'] == 4)
                                    <td>创建圈子</td>
                                @elseif($captcha['tag'] == 5)
                                    <td>加入圈子</td>
                                @elseif($captcha['tag'] == 6)
                                    <td>取消活动</td>
                                @elseif($captcha['tag'] == 7)
                                    <td>解散圈子</td>
                                @endif
                                <td>{{$captcha['expireTime']}}</td>
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
    </div>
    <script>
        //搜索按钮
        $('.btn.btn-info').click(function()
        {
            var mobile = $("input[name='mobile']").val();
//            if (!activityId  && !mobile) alert('请提供活动id或手机号');
            $.get('/admin/account/search-captcha', {'mobile':mobile}, function (res){
                if(res['status'] == 'success') {
                    var captchas = res['captchas'];
                    var html='';
                    $(captchas).each(function(index){
                        html += '<tr>' +
                        '<td>'+captchas[index]['mobile']+'</td>' +
                        '<td>'+captchas[index]['captcha']+'</td>';
                        if (captchas[index]['tag'] == 1) {
                            html += '<td>注册和密码</td>';
                        } else if (captchas[index]['tag'] == 2) {
                            html += '<td>创建活动</td>';
                        } else if (captchas[index]['tag'] == 3) {
                            html += '<td>参加活动</td>';
                        } else if (captchas[index]['tag'] == 4) {
                            html += '<td>创建圈子</td>';
                        } else if (captchas[index]['tag'] == 5) {
                            html += '<td>加入圈子</td>';
                        } else if (captchas[index]['tag'] == 6) {
                            html += '<td>取消活动</td>';
                        } else if (captchas[index]['tag'] == 7) {
                            html += '<td>解散圈子</td>';
                        }
                        html +='<td>'+ captchas[index]['expireTime']+'</td> ' +
                        '</tr>'
                    });
                    $("tbody").html( html);
                    $('.box-footer').html(res['pager'])
                } else {
                    alert(res['msg']);
                }

            });
        });
    </script>

@endsection