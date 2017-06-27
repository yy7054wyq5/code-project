@include('admin.header')
<div id="main-content">
    <div class="container">
        <div class="row">
            <div id="content" class="col-lg-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-header">
                            <ul class="breadcrumb">
                                <li>
                                    <i class="fa fa-home"></i>
                                    <a href="/superman">首页</a>
                                </li>
                                <li>
                                    {{ $nav }}
                                </li>
                            </ul>
                            @section('content')
                            <div class="clearfix">
                                <h3 class="content-title pull-left"><?=Config::get('app.appName')?>系统数据</h3>
                            </div>
                            <div class="description">调用system moudle数据</div>
                            @show
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- HOME END -->
@include('admin.footer')