@extends('admin.adminbase')
@section('title', '文章-关于我们')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">关于我们</h3>
        </div>
        <form action="<?= url('admin/article/save-article') ?>" class="form-horizontal" m-bind="ajax">
            <div class="box-body">

                <!-- 错误提示 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">中文标题</label>
                    <div class="col-sm-4">
                        <?php if ($article) { ?>
                        <input type="hidden" name="articleId" class="form-control" value="<?= $article['id']?>">
                        <?php } ?>
                        <input type="text" name="nameCn" class="form-control" value="<?php if ($article) {echo $article['nameCn'];} else { echo '关于我们';}?>" readOnly="true">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                    <div class="col-sm-6">
                        <p class="small text-muted form-control-static"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">英文标题</label>
                    <div class="col-sm-4">
                        <input type="text" name="nameEn" class="form-control" value="<?php if ($article) {echo $article['nameEn'];} else { echo 'aboutUs';}?>" readOnly="true">
                    </div>
                    <div class="col-sm-6">
                        <p class="small text-muted form-control-static"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">详情描述</label>
                    <div class="col-sm-8">
                        <textarea class="foo" id="docEditor1" class="form-control docEditor" name="description" style="height: 270px;width: 100%;"><?php if ($article) {echo $article['description'];}?></textarea>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确认添加</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">返回</a>
                </div>
            </div>
        </form>
    </div>
@endsection