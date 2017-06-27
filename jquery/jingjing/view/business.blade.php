@extends('web.main')

@section('styles')
    <script src="/ueditor/ueditor.parse.min.js"></script>
    <script>
        uParse('.uecontent', {
            rootPath: '/static/public/ueditor'
        });</script>
@endsection
@section('body')
    <div class="projectDetail-ct uecontent">
        <?php if (!empty($article)) {?>
        <p><?php echo  htmlspecialchars_decode($article['description'])?></p>
        <?php } else {?>
        <p><?php echo  '该文章不存在或已被删除'?></p>
        <?php } ?>
    </div>
@endsection
