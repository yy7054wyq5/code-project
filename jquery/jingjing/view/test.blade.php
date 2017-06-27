@extends('web.main')
@section('title', '测试')
@section('body')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">测试专用</h3>
        </div>
        <form name="form1" enctype="multipart/form-data" method="post" action="<?=url('/image/upload')?>">
            <input class="custom-file-input"  type="file" name="file1" id="foo"/>
            {{--<input class="custom-file-input"  type="file" name="file2" id="foo"/>--}}
            <input class="custom-file-input" type="submit" name="Submit" value="添加" />
        </form>
        </div>
    @for($i=0; $i<500; $i++)
        <img src="/image/get/1/1/800x800">
        <img src="/image/get/2/1/800x800">
        <img src="/image/get/3/1/800x800">
        <img src="/image/get/4/1/800x800">
        <img src="/image/get/5/1/800x800">
    @endfor
@endsection