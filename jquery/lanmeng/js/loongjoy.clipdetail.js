$(document).ready(function() {
    var noLogin = Cookies.get('lAmE_simple_auth')===undefined;//判断登录
    var downPoints = $('.clipPoints').text();//下载所需积分
    var clipClassic = $('.clipClassic').text();//素材分类
    var userApprove = Cookies.get('isauth');//用户是否认证
    var userPoints = $('#Integral').val();//用户积分
    var userPower = $('#userPower').val(); //用户权限
    var clipPower = $('#clipPower').val();//素材所属品牌ID
    var clipURL = $('#mProductFile').val();//素材下载地址
    var areadyDown = $('#areadyDown').val();//用户已下载该值为0

    $('#downBtn').click(function () {
            var downTips = {
                'login':'请先登录！',
                'points': '你没有足够的积分，无法下载。' ,
                'affirm': '下载该素材需要扣除' + downPoints + '积分，积分将赠送给上传素材的用户，请问是否确认？',
                'power': '不是' + clipClassic + '认证经销商，无权限下载。',
                'approve': '您尚未通过认证，无权限下载。'+'<a href=\"/mine/auth"  target=\"_blank\">点击认证</a>'
            };
            if(noLogin){//未登录
                alertTips(downTips.login,'/login','登录');
            }
            else{
                //案例详情页
                if($('.innovate-example-detail').hasClass('innovate-example-detail')){

                }
                //素材详情页
                else{
                        if (areadyDown === 0) {
                            //点击下载
                            alertTips('你已下载过本资源，本次不扣分。',clipURL,'下载');
                        } 
                        else {
                            //用户积分不够下载
                            if (parseInt(userPoints) < parseInt(downPoints)) {
                                alertTips(downTips.points,'/innovate/score','赚积分');
                            }
                            else {
                                //用户通过认证
                                if (userApprove == 0) {
                                    //用户有权限
                                    if(userPower===clipPower){
                                        if(downPoints==0){
                                            location.href = clipURL;
                                        }
                                        else{
                                            alertTips(downTips.affirm,clipURL,'确定');
                                        } 
                                    }
                                    else{
                                        littleTips(downTips.power);
                                    }
                                }
                                else {//用户未通过认证
                                    alertTips(downTips.approve,'/mine/auth','去认证');
                                }     
                            }
                    }
                }       
        }//结束
    });

});