@extends('admin.adminbase')
@section('title', '活动列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">活动列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>类型</th>
                        <th>发起人</th>
                        <th>开始</th>
                        <th>结束</th>
                        <th>费用</th>
                        <th>参与人数</th>
                        <th>状态</th>
                        <th>已删除</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($activities) {?>
                    <?php foreach($activities as $activity) {?>
                    <tr>
                        <td><a href="/admin/activity/detail?activityId={{$activity['id']}}" class="label label-info">{{$activity['name']}}</a></td>
                        <td><?php echo $activity['type'] == 1 ? '组织':'个人'?></td>
                        <td><?php  echo $activity['createUser']['name']? $activity['createUser']['name']: $activity['createUser']['nickname'] ?></td>
                        <td><?= substr($activity['timeStart'], 0, 16) ?></td>
                        <td><?= substr($activity['timeEnd'], 0, 16)?></td>
                        <td><?= $activity['fee'] ?></td>
                        <td><?= $activity['sumJoiners']  ?></td>
                        @if($activity['status'] ==1)
                        <td>未开始</td>
                        @elseif($activity['status'] ==2)
                            <td>正在进行</td>
                        @elseif($activity['status'] ==3)
                            <td>已结束</td>
                        @else
                            <td>已取消</td>
                        @endif
                        @if($activity['deleted'] ==0)
                            <td>否</td>
                        @else
                            <td>是</td>
                        @endif
                        <td>
                            @if($activity['deleted'] == 0)
                            <a href="/admin/activity/remove?activityId={{$activity['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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


@endsection