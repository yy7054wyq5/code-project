@extends('admin.adminbase')
@section('title', '圈子列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">圈子列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>兴趣</th>
                        <th>位置</th>
                        <th>用户名</th>
                        <th>手机</th>
                        <th>已删除</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($groups) {?>
                    <?php foreach($groups as $group) {?>
                    <tr>
                        <td><a href="/admin/group/detail?groupId={{$group['id']}}" class="label label-info">{{$group['name']}}</a></td>
                        <td><?php if(array_get($group,'interests')) {
                                $interestArr = [];
                                foreach($group['interests'] as $value){
                                    $interestArr[] = $value['name'];
                                }
                                echo implode(',', $interestArr);
                            } else { echo '无';}?></td>
                        <td><?= $group['address'] ?></td>
                        <td><?= $group['createUser']['nickname'] ?></td>
                        <td><?= $group['createUser']['mobile'] ?></td>
                        @if($group['deleted'] ==0)
                            <td>否</td>
                        @else
                            <td>是</td>
                        @endif
                        <td>
                            @if($group['deleted'] == 0)
                            <a href="/admin/group/remove?groupId={{$group['id']}}" class="label label-danger" m-bind="confirm">删除</a>
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