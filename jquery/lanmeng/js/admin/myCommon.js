$(function () {

	// 载入中
	function loading (bool, ctx) {
        ctx = ctx ? $(ctx) : $('body');
        loading.loader || (loading.loader = $('<div id="loading" class="text-blue"><i class="fa fa-cog fa-spin"></i></div>').prependTo(ctx));
        bool ? loading.loader.fadeIn(200) : loading.loader.stop(true, true).hide();
    }

    // 刷新验证码
    $('img.captcha').click(function () {
        $(this).attr('src', $(this).attr('data-url') + Math.random());
    });

    // 解析处理ajax返回的data
    function ajaxHandler (data, ctx) {
        var tipBox = $('.form-tip', ctx),
            result = $('.result', tipBox);

        if (!data.success) {
            // 失败 显示错误信息
            result.html(data.errorInfo);
            tipBox.addClass('.alert-danger').fadeIn(200);
            $('html, body').animate({scrollTop: tipBox.offset().top - 10}, 400);
            $('.captcha', ctx).click();
        } else if ('redirect' in data.content) {
            // 成功 跳转
            tipBox.hide();
            window.location.href = data.content.redirect;
        }
    }

    // 关闭表单提示信息
    $(document).on('click', '.alert .close', function () {
        $(this).parent('.alert').fadeOut(200);
    });

    // ajax表单
    $('form[m-bind="ajax"]').submit(function () {
            $.ajax({
            url: $(this).attr('action'),
            data:  $(this).serialize(),
            type: 'post',
            dataType: 'json',
            context: this,
            beforeSend: function () {
                loading(true);
                $(':submit', this).attr('disabled', '');
            },
            complete: function () {
                loading(false);
                $(':submit', this).removeAttr('disabled');
            },
            success: function (data) {
                console.log(data);
                ajaxHandler(data, this);
            }
        });
        return false;
    });

    $('form[m-bind="get"]').submit(function () {
        var data = $(this).serialize();
        window.location.href = $(this).attr('action') + '?' + data;
        return false;
    });

    //  删除条目
    $(document).on('click', 'a[m-bind="delete"]', function () {
        var url;
        if (confirm('确认要删除该条数据吗？')) {
            url = this.href || $(this).attr('data-url');
            $.post(url, function (data) {
                console.log(data);
                if (data.success == 1) {
                    window.location.reload();
                }
            }, 'json');
        }
        return false;
    });

    //

    //  修改条目
    $(document).on('click', 'a[m-bind="report"]', function () {
        var url='';
        var noworganValue='';
        var warnidValue='';
            url =  $(this).attr('data-url');
            noworganValue = $(this).attr('data-noworgan');
            warnidValue = $(this).attr('data-warnid');
            $.post(url,{noworgan:noworganValue,warnid:warnidValue} ,function (data) {
                console.log(data);
                if (data.success == 1) {
                    alert(data.errorInfo);
                    window.location.reload();
                }else {
                    alert(data.errorInfo);
                }
            }, 'json');

        return false;
    });
    //  修改条目
    $(document).on('click', 'a[m-bind="reportStatus"]', function () {
        var url='';
        var statusValue='';
        var warnidValue='';
        url =  $(this).attr('data-url');
        statusValue = $(this).attr('data-status');
        warnidValue = $(this).attr('data-warnid');
        $.post(url,{status:statusValue,warnid:warnidValue} ,function (data) {
            console.log(data);
            if (data.success == 1) {
                alert(data.errorInfo);
                window.location.reload();
            }else {
                alert(data.errorInfo);
            }
        }, 'json');

        return false;
    });

})