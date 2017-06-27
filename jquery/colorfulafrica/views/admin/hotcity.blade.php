@extends('admin.adminbase')
@section('title', '热门城市')
@section('content')
    <style>
        .cellitem span {
            position: relative;
            float: left;
            padding: 3px 15px 3px 25px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
        .cellitem span.active {
            background: #dd4b39;
            border-color: #d73925;
            color: #fff;
        }
        .cellitem span.active .fa {
            display: block;
        }
        .cellitem span .fa {
            display: none;
            position: absolute;
            top: 6px;
            left: 5px;
        }
        .selectedItem span {
            position: relative;
            float: left;
            padding: 3px 15px;
            margin: 10px;
            border: 1px solid #ddd;
            background: #f4f4f4;
            cursor: pointer;
        }
    </style>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">热门城市</h3>
        </div>
        <form action="<?=url('admin/config/save-hot-city')?>" method="post" class="form-horizontal" m-bind="ajax">
            <div class="box-body">
                <!-- 提示信息 -->
                <div class="alert alert-danger errMsgBox">
                    <button class="close">&times;</button>
                    <div class="result"></div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-sm-2">已选择</label>
                    <div class="col-sm-8 selectedItem">
                        <?php if ($hotCities) { ?>
                        <?php foreach ($hotCities as $hotCity) { ?>
                        <span  data-resourceId="<?= $hotCity['cityId'] ?>"><?= $hotCity['value'] ?></span>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <input type="hidden" id="selectedID" name="hotCityIds">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
                <hr>

                <div class="form-group">
                    <label for="" class="control-label col-sm-2 required">请选择省份</label>
                    <div class="col-sm-10">
                        <select id="province" name="provinceId"  class="form-control" style="display: inline-block;width: auto;">
                            {{--<option value="">请选择省份</option>--}}
                            <?php foreach ($provinces as $province) { ?>
                            <option value="<?= $province['id'] ?>"><?= $province['value'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-sm-2">可选城市</label>
                    <div class="col-sm-8 cellitem city">
                        <?php foreach ($cities as $city) { ?>
                        <?php if (!empty($hotCityIds) && in_array($city['id'], $hotCityIds)) { ?>
                        <span class="active" data-resourceId="<?= $city['id'] ?>"><?= $city['value'] ?><i class="fa fa-check"></i></span>
                        <? } else { ?>
                        <span data-resourceId="<?= $city['id'] ?>"><?= $city['value'] ?><i
                                    class="fa fa-check"></i></span>
                        <? } ?>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-sm-offset-2">
                    <button type="submit" class="btn btn-primary">确定</button>
                    <a href="javascript:history.go(-1);" class="btn btn-default">取消</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        ;
        (function () {
            var resultIpt = $('#selectedID');
            $('.cellitem span').click(function () {
                process($(this));
            });

            $('#province').on('change', function () {
                $.get('/admin/config/cities?provinceId=' + $(this).val(), function (data) {
                    if (data.status == 'success' && data.cities) {
                        var html = '', selectedCity = selected(), cities = data.cities;
                        $.each(cities, function (index) {
                            var city = cities[index];
                            if ($.inArray(city.id, selectedCity) != -1) {
                                html += '<span class="active" data-resourceId="' + city.id + '">' + city.value + '<i class="fa fa-check"></i></span>';
                            } else {
                                html += '<span data-resourceId="' + city.id + '">' + city.value + '<i class="fa fa-check"></i></span>'
                            }
                        });
                        $('.city').html(html);
                        $('.cellitem span').click(function () {
                            process($(this));
                        });
                    } else {
                        alert(data.msg);
                    }
                }, 'json');
            });


            function selected() {
                var value = [];
                $.each($('.selectedItem span'), function () {
                    returnId = $(this).attr('data-resourceId');
                    value.push(returnId);
                });
                return value;
            }


            function process(dataObj)
            {
                var id = $(dataObj).attr('data-resourceId');
                if ($(dataObj).hasClass('active')) {
                    $.each($('.selectedItem span'), function () {
                        var _id = $(this).attr('data-resourceId');
                        if (id == _id) $(this).remove();
                    });
                } else {
                    $('.selectedItem').append('<span data-resourceId="' + id + '" ' +  '">' + $(dataObj).text() + '</span>');
                }
                $(dataObj).toggleClass('active');
                var v = [];
                $.each($('.selectedItem span'), function () {
                    returnId = $(this).attr('data-resourceId');
                    v.push(returnId);
                });
                resultIpt.val(JSON.stringify(v));
            }


        })()
    </script>
@endsection