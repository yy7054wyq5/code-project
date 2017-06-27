@extends('admin.adminbase')
@section('title', '上传app')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">上传安卓app</h3>
        </div>

        <form name="form1" id="fileUpload" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">上传安卓app</label>
                    <div class="col-sm-10">
                        <input class="custom-file-input" type="file" name="file" id="file1"  enctype="multipart/form-data"/>
                    </div>
                </div>
            </div>
        </form>
    </div>


<script>
    $(function () {
        var file = $('#file1');
        file.on('change', function () {
            $('#fileUpload').ajaxSubmit({
                dataType: "json",
                type: 'post',
                url: '/admin/config/upload-app',
                data: file.val(),
                clearForm: true,
                resetForm: true,
                success: function (result) {
                    if (result.status == 'success') {
                        alert(result.msg);
                    }
                    else {
                        alert(result.msg);
                    }
                },
                error: function (result) {
                    alert(result.msg);
                }
            });
        });
    });
</script>
@endsection