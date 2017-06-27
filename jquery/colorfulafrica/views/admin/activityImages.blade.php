@extends('admin.adminbase')
@section('title', '活动列表')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{$detail['name']}}图片列表</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                @if($images)
                    @foreach($images as $image)
                    <div class="col-sm-5">
                        <img src="{{$image['url']}}" width="300px" height="300px" >
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="box-footer">
            <?php echo $pager ?>
        </div>
    </div>
@endsection