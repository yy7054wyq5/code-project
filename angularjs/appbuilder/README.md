# appbuilderphp
build by angular

# 文件夹结构
        /less 
        /js 写的angularjs
        /app 
            /bower_components 包含angular jquery bootstrap库文件 
            /css 编译压缩后的css
            /img
            /js 内含基础js
            /html 页面
                    home.html   引入css、js的主页面
                    search.html 搜索
                    car.html    购物车
                    /partials   公用组件
                        addcut.html          数量加减按钮
                        footer-sale.html    促销底部
                        footer-subshop.html 分店底部 notice:3个底部回到首页的链接不一样
                        footer.html         发现底部                       
                        header.html         首页顶部
                        slideimg.html       图片轮播
                        swipemenu.html      菜单横向滑动
                    /enter      入口页面
                        login.html          登录
                        reg.html            注册
                        forget.html         找回密码
                    /index      首页
                        find.html           发现
                        sale.html           促销
                        subshop.html        分店
                        subshop-detail.html 分店详情
                    /product    品类（产品）
                        index.html          首页（一级、二级、三级分类页）
                        detail.html         产品详情
                        size.html           产品规格
                    /community  论坛
                        index.html          首页（主列表页）
                        sublist.html        次级列表页
                        edit.html             发布帖子
                    /article
                        index.html         列表页
                    /mine       个人中心
                        index.html          首页
                        reset.html          重设密码
    

# 基础less
	@basebg: #f1f1f1;
            @basecolor: #555555;
            @baseborder: #dbdbdb;
            @pricecolor:#ed4f44;
            @activecolor:#ed4f44;
            @btncolor:#ed4f44;
            @salecolor:#999999;
            @bannerheight:7.31rem;
            @baselineheight: .08rem;
            .border(@color){
                border: .01rem solid @color;
            }
            .border-top(@color){
                border-top: .01rem solid @color;
            }
            .border-bottom(@color){
                border-bottom: .01rem solid @color;
            }
            .block-center{
                display: block;
                margin: 0 auto;
            }
            .block-float{
                display: block;
                float: left;
            }
            .font20{font-size: .35rem;}
            .font24{font-size: .4rem;}
            .font28{font-size: .45rem;}
            .font32{font-size: .5rem;}
            .font36{font-size: .52rem;}
            .font42{font-size: .56rem;}
            .font46{font-size: .6rem;}
            .line-ellipsis{/*单行省略号*/
              white-space:nowrap;
              overflow:hidden;
              text-overflow:ellipsis;
            }

# angular coding记录
* 页面交互相关指令
            购物车：car
            数量加减，有计算单个产品的总价，这是配合购物车的计算：addcut
            产品规格：size
            横向滑动菜单：swipemenu和swipenavmenu，因为有页面同时存在两个滑动菜单
            图片轮播：slideimg
            返回顶部：gotop
            百度地图：map
            分店详情向上按钮：mapupbtn
            首页顶部滑动线：headerline
            选择地区：chosepart
            选择导购：selectguide
            数字动画效果：animatenumber
            手机号打*号：phonenumber
            返回上一页：backpage
            评价打星：star
            立即评价：usercomment
            以及其他一些无交互的指令。
* 翻页指令：scroll
            需要在router内重置两个参数，$rootScope.currentPage=1和$rootscope.totalPage=2；
            在指令内做全部的数据加载操作；
            但是在控制器内需要将数据的$scope改为$rootscope。

##备注

* 微网站访问方式:域名+/phoneweb/app/index.html 
* 各个栏目的首页数据已存入ng缓存，刷新即销毁。栏目选项卡数据加入数组，切换路由即销毁。
* 用户信息和APP信息存入sessionStorage，刷新即销毁。
* 产品详情ID和已选规格的字符串存入cookie，与后台能对得起的已选规格value值，论坛列表ID存入cookie
* 用户名密码存入cookie

