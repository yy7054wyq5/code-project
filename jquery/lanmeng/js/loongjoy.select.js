$(function() {
    var isCreative = $('.innovate-main').hasClass('creative');
    var isClip = $('.innovate-main').hasClass('clip');
    var isDeal = $('.deal-main').hasClass('deal-main');
    
    //品牌的选项卡
    $(document).on('mouseover', '.brand-tab>li', function(event) {
        $(this).addClass('active').siblings().removeClass('active');
        $brandUI = $(this).parents('.brand-tab').siblings('.brand-content');
        var index = $(this).children('a').attr('index');
        if(index===undefined){
            $brandUI.children('a').show();
        }
        else{
            $brandUI.children('a').hide();
            $brandUI.children('a.brand'+index).show();
        }
        //console.log(index);
    });
    $('.sub-dropdown').mouseover(function(event) {
        $('.sub-dropdown').removeClass('active');
        $('.sub-box').hide();
        $(this).addClass('active').siblings('.sub-box').show();
    });

    //创库首页,交易平台首页筛选效果（除品牌、分类）
    $(document).on('click', '.dropSelect .dropdown-menu>li>a', function(event) {
        if($(this).siblings('.sub-box').hasClass('sub-box')){//该目录下有子目录时点击失效
            return false;
        }
        else{
            if($(this).parents('.dropSelect').hasClass('deal-list-bottom')){
                //排除交易平台首页下方的按钮点击效果
            }
            else{
                $('.chosed-box').show();
                var classic = $(this).parents('.dropdown-menu').attr('classic');
                $('.chosed-box>li>span.'+classic).text($(this).text()).addClass('spanTag').parent('li').css('visibility','visible');
            }
            //传值
            if($(this).parents('.dropdown-menu').attr('classic')=='theme'){
                //创意主题ID
                handleURL.jump('subjectId',$(this).attr('data-id'));
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='point'){
                //创意积分ID                
                handleURL.jump('integral',$(this).attr('data-id'));
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='type'){
                //交易类型ID
                handleURL.jump('type',$(this).attr('data-id'));
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='status'){
                //交易状态
                handleURL.jump('status',$(this).attr('data-id'))
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='subtype'){
                //交易按照成色还是时间排序
                handleURL.jump('subtype',$(this).attr('data-id'));
                if(isDeal){
                    handleURL.jump('sub',$(this).attr('data-id'));
                }
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='rank'){
                //排序ID包括创意和交易
                handleURL.jump('sort',$(this).attr('data-id'));
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='time'){
                //创意时间ID
                if(isCreative){
                    handleURL.jump('data',$(this).attr('data-id'));
                }
                else if(isDeal){
                    handleURL.jump('time',$(this).attr('data-id'));
                }
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='fenlei'){
                //素材分类ID
                handleURL.jump('categoryId',$(this).attr('data-id'));
            }
            else if($(this).parents('.dropdown-menu').attr('classic')=='car-type'){
                //素材车型ID
                handleURL.jump('modelsId',$(this).attr('data-id'));
                //交易车型
                if(isDeal){
                    handleURL.jump('car',$(this).text());
                }
            }
        }
    });

    //品牌选中
    $(document).on('click', '.dropSelect .dropdown-menu>li>.sub-box>.brand-content>a', function(event) {
        var dataId = $(this).attr('data-id');
        $('.chosed-box').show();
        $('.chosed-box>li>span.brand').text($(this).text()).addClass('spanTag').parent('li').css('visibility','visible');
        handleURL.jump('brandId',dataId);
    });

    //获取车型
    if(handleURL.markValue('brandId')==undefined||handleURL.markValue('brandId')==''){}
    else{
        var carData = [];
        $.get('/innovate/getMaterialModelsInterface/'+handleURL.markValue('brandId'), function(res) {
            var $cayTypeUI = $('.dropdown-menu[classic="car-type"]');
            var li='';
            window.car = res.content;
            $.each(res.content, function(index, val) {
                li +=  '<li><a data-id=\"'+this.id+'\" title=\"'+this.name+'\">'+this.name+'</a></li>';
            });
            $cayTypeUI.html(li);
        });
    }

    if(isClip||isCreative){
        var ajaxUrl;
        var classicName;
        if(isClip){
            ajaxUrl = '/innovate/getMaterialCategoryInterface';
            classicName = 'fenlei';
        }
        else if(isCreative){
            ajaxUrl = '/innovate/getSubjectTwoLevelApi';
            classicName = 'theme';
        }
        $.get(ajaxUrl, function(data) {
            var category = data.content;
            //console.log(category);
            for (var i = 0; i < category.length; i++) {//遍历一级分类
              var caName = category[i].name;
              var caId = category[i].id;
              $caUI = $('.dropdown-menu[classic="'+classicName+'"]');
              //判断该一级分类是否含有二级分类
              if(category[i].subclass.length<1){
                $caUI.append('<li><a title=\"'+caName +'\" data-id=' +caId+ ' >' +caName+ '</a></li>');
              }
              else{
                var maList = category[i].subclass;
                $caUI.append('<li class=\"re\"><a role=\"button\" title=\"'+ caName +'\" data-id=' + caId + ' class=\"sub-dropdown\" ><span>'+caName+'</span></a><ul class=\"sub-box\"></ul></li>');
                //遍历二级分类
                for (var j = 0; j < maList.length; j++) {
                    var maName = maList[j].name;
                    var maId = maList[j].id;
                    var $maUI = $('.sub-dropdown[data-id="'+caId+'"]');
                    $maUI.siblings('.sub-box').append('<li><a role=\"button\" title=\"'+ maName +'\"  data-id=\"'+maId +'\">'+maName+'</a></li>');
                }
              }
            }
        },'json');
    }
    
    //分类和主题
    $(document).on('mouseover', 'ul.fenlei>li>a,ul.theme>li>a', function(event) {
        $(this).parents('ul.dropdown-menu').children('li').children('a').removeClass('active');
        $(this).parents('ul.dropdown-menu').children().children('.sub-box').hide();
        $(this).addClass('active').siblings().show();
    });

    //分类选中和主题选中
    $(document).on('click', '.dropdown-menu.fenlei .sub-box>li>a,.dropdown-menu.theme .sub-box>li>a', function(event) {
        var txt = $(this).parents('.sub-box').siblings('a').text()+'>'+$(this).text();
        var chosedname;
        var paramname;
        if(isCreative){
            chosedname = 'theme';
            paramname = 'subjectId';
        }
        else if(isClip){
            chosedname = 'fenlei';
            paramname = 'categoryId';
        }
        $('.chosed-box').show().find('span.'+chosedname+'').text(txt).addClass('spanTag').attr('title',txt).parent('li').css('visibility','visible');
        handleURL.jump(paramname,$(this).attr('data-id'));
    });

    //交易平台首页的地区选中在其页面中

    //翻页传值
    $('.page-action').on('click', 'a', function(event) {
        //翻页
          var page = $('div>.page-action').find('a.active').text();
          var totalPage = $('#totalPage').val();
          //上一页
          if($(this).hasClass('page-up')){
              if(page==1) return false;//li中的上一页
              else page = parseInt(page) - 1;
          }
          //下一页
          else if($(this).hasClass('page-down')){
                if(page==totalPage) return false;//li中的下一页 
                else page = parseInt(page) + 1;    
          }
          //翻页的确定按钮
          else if($(this).hasClass('btn')){
              if($(this).siblings('input').val()==='') ;//输入框为空，不给page重新给值;
              else page = $(this).siblings('input').val();
          }
          else{
              page = $(this).attr('index');
          }
          handleURL.jump('page',page);     
    });

    //取消选中
    $(document).on('click', '.chosed-box>li>i', function(event) {
        $(this).siblings('span').text('').removeClass('spanTag').parent('li').css('visibility', 'hidden');
        var li = $(this).parents('.chosed-box').children('li');
        var spanTag = $(this).parents('.chosed-box').find('span.spanTag');
        if(spanTag.length==0){
            $(this).parents('.chosed-box').hide();
        }
        if($(this).siblings('span').hasClass('brand')){
            handleURL.jump('brandId','');
        }
        else if($(this).siblings('span').hasClass('theme')){
            handleURL.jump('subjectId','');
        }
        else if($(this).siblings('span').hasClass('point')){
            handleURL.jump('integral','');
        }
        else if($(this).siblings('span').hasClass('rank')){
            if(isCreative) handleURL.jump('sort','');
            else if(isDeal) handleURL.jump('sort',0);
        }
        else if($(this).siblings('span').hasClass('time')){    
            if(isDeal) handleURL.jump('time',4);
            else if(isCreative) handleURL.jump('data','');
        }
        else if($(this).siblings('span').hasClass('fenlei')){
            handleURL.jump('categoryId','');
        }
        else if($(this).siblings('span').hasClass('car-type')){
            if(isClip) handleURL.jump('modelsId','');
            else if(isDeal) handleURL.jump('car','');
        }
        else if($(this).siblings('span').hasClass('type')){
            handleURL.jump('type',-1);
        }
        else if($(this).siblings('span').hasClass('part')){
            handleURL.jump('province',0,handleURL.set('city',0));
        }
        else if($(this).siblings('span').hasClass('status')){
            handleURL.jump('status','');
        }
        
    });

//JS结束
});
