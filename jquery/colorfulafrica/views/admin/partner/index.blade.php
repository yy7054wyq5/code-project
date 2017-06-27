@extends('admin.adminbase')
@section('title', '合作伙伴管理')
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">合作伙伴列表</h3>
        </div>
        <div class="box-body">
            <p>
                @if(in_array(\Illuminate\Support\Facades\Config::get('app.partnerManage.addPartner.id'),$jurisdiction))
                      <a href="{{url('/backstage/partner/add-partner')}}" class="btn btn-primary">新增合作伙伴</a>
                @endif
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>英文标题</th>
                        <th>缩略图</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($partners)>0)
                        @foreach($partners as $list)
                            <tr>
                                <td>{{$list['name']}}</td>
                                <td>{{$list['nameEn']}}</td>

                                <td>@if($list['picKey'])<img src="/image/get/{{$list['picKey']}}" style="width:50px; height: 50px;" /> @endif</td>
                                <td>
                                    @if($list['deleted'] == 0)
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.partnerManage.editPartner.id'),$jurisdiction))
                                             <a href="/backstage/partner/edit-partner/{{$list['id']}}?start={{Input::get('start',0)}}" class="label label-success" >编辑</a>
                                        @endif
                                         @if(in_array(\Illuminate\Support\Facades\Config::get('app.partnerManage.recommend.id'),$jurisdiction))
                                         @if($list['isRecommend']==0)
                                             <a href="/backstage/partner/recommend/{{$list['id']}}" class="label label-primary" >推荐</a>
                                          @else
                                             <a href="javascript:;" data-type="6" data-id="{{$list['id']}}" class="label label-default unrecommand" >取消推荐</a>
                                         @endif
                                        @endif
                                        @if(in_array(\Illuminate\Support\Facades\Config::get('app.partnerManage.removePartner.id'),$jurisdiction))
                                             <a href="/backstage/partner/remove-partner/{{$list['id']}}" class="label label-danger" m-bind="confirm">删除</a>
                                        @endif
                                    @endif
                                </td>
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
    <script>
    $(function () {
            $('.unrecommand').on('click',function(){
                $('.btn').attr('disabled',true);
                $.post('/backstage/index/unrecommand',{'id':$(this).attr('data-id'),'type':$(this).attr('data-type')},function(res){
                    res = JSON.parse(res);
                    alert(res.msg);
                   location=location;
                });
            });
        });
    </script>
    </div>
@endsection