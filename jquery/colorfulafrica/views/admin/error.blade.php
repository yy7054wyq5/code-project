@extends('admin.adminbase')
@section('title', '错误列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">错误列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>错误码</th>
                        <th>错误信息</th>
                        <th>创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($errors) {?>
                    <?php foreach($errors as $error) {?>
                    <tr>
                        <td><?= $error->code ?></td>
                        <td><?= $error->message ?></td>
                        <td><?= $error->createTime ?></td>
                    </tr>
                    <?php }?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>


@endsection