@extends('admin.adminbase')
@section('title', '记录')
@section('content')
<div class="dialog-demo-box" style="display:none;"></div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">答题记录</h3>
        </div>
        <div class="box-body">
          
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>昵称</th>
                        <th>答题时间</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                    @if ($lines['data'])
                        @foreach($lines['data'] as $line)
                            <tr>
                                <td><a href="/backstage/line/record-detail/{{$line['qid']}}/{{$line['uid']}}" title="点击查看详情"> {{$line['nickname']}}</a></td>
                                <td>{{$line['createTime']}}</td>
                              
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            <?php echo isset($pager)?$pager:'' ?>
        </div>
    </div>

     <script type="text/javascript" >
        $(function(){
            $(".open").click(function(){
                var $d = $(".dialog-demo-box");
                var $content = $(this).attr('data-content');
                var special = JSON.parse($content);
                var html='';
                for (var i = 0; i <special.length; i++) {
                	console.log(special[i]);
                	var option =special[i].option;
                	html+='<li>'+special[i].title;
                	// for (var i = option.length - 1; i >= 0; i--) {
                		
                	// 	html+='<br/><input type="check" />'+option[i];
                	// }
                	
                	html +='</li>';
                };
                $d.dialog({
                    title: '答题记录',					// title
                    dragable:true,
                    html: '', 						// html template
                    width: 750,					// width
                    height: 400,				// height
                    confirmBtn:false,
                    cannelText: '取消',		// cannel text
                    confirmText: '确认',	    // confirm text
                    showFooter:true,
                    getContent:function(){ 	// get Content callback
                        $d.find('.body-content').html(html);
                    }
                }).open();
            });
        });
    </script>
@endsection