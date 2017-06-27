@extends('admin.adminbase')
@section('title', '活动列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$detail['name']}}评论列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>电话</th>
                        <th>昵称</th>
                        <th>性别</th>
                        <th>年龄</th>
                        <th>内容</th>
                        <th>评论时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($comments)
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{$comment['user']['mobile']}}</td>
                                <td>{{$comment['user']['nickname']}}</td>
                                @if($comment['user']['sex'] == 1)
                                    <td>男</td>
                                @elseif($comment['user']['sex'] == 2)
                                    <td>女</td>
                                @else
                                    <td>未知</td>
                                @endif
                                <td>{{$comment['user']['age']? $comment['user']['age']:'18'}}</td>
                                <td>{{$comment['content']}}</td>
                                <td>{{$comment['createTime']}}</td>

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


@endsection