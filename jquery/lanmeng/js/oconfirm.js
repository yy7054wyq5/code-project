/*! loongjoy 2017-03-20 */
function getAllDispatch(){var a=0;$.each($('.oconfirm-panel5 select[name="shipid"]'),function(b,c){void 0===$(c).parent("td").attr("ship-id")&&$(c).parent("td").attr("ship-id",0),$(c).siblings(".loadingTxt").show(),$.get("/api/cart/getfreight",{type:$(c).parent("td").attr("data-type"),unit:$(c).parent("td").attr("data-unit"),shipid:$(c).parent("td").attr("ship-id"),rid:$(".oconfirm-panel1 .item.active").attr("data-id")||null,num:$(c).parent("td").attr("data-num")},function(b){if(0===b.status){$(c).siblings(".loadingTxt").hide(),$(c).siblings(".dis").children(".dispatch").html(b.tips),a=parseFloat(b.tips)+parseFloat(a),$("#dispatch").html(a);var d=parseFloat($("#price").attr("data-price"))+parseFloat(a)-parseFloat($("#all_save").html());$("#price").html(d.toFixed(2))}else littleTips(b.msg)})})}!function(){var a=$("#user-pay").val();0==a?($(".oconfirm-panel2 .group,.oconfirm-panel2 .dealer").hide(),$(".oconfirm-panel2 .direct").addClass("active").css("margin-left",0),$(".oconfirm-panel2-pay,.oconfirm-panel3").show()):($(".oconfirm-panel2 .group").addClass("active"),$(".oconfirm-panel2-pay").hide(),$(".oconfirm-panel3").hide()),$.validator.addMethod("pattern",function(a,b,c){var d=new RegExp(c);return this.optional(b)||d.test(a)},"Please check your input."),$(".oconfirm-panel5 .expanel .urow input").on("keyup keydown blur",function(){var a=$(this).val();a.length>200&&$(this).val(a.substring(0,200))});var b=$("#oconfirm");b.on("click",".oconfirm-panel1 .item .setdefault",function(){if($(this).hasClass("disabled"))return!1;var a=this,b=$(this).parent(".item");$.post("/user/api/setdefaultaddress",{id:b.attr("data-id")}).success(function(c){0!==c.status?alert(c.tips):($(a).text("默认地址").addClass("disabled"),b.siblings().find(".setdefault").text("设置为默认地址").removeClass("disabled"))}),getAllDispatch()}),b.on("click",".oconfirm-panel1 .item",function(){$(this).addClass("active").siblings().removeClass("active"),getAllDispatch()});var c=$("#modal1 .province"),d=$("#modal1 .city"),e=$("#modal1 .district");c.on("change",function(a,b,c){var f=$(this).val();f&&$.get("/user/api/city?id="+f).success(function(a){var f='<option value="">--选择市--</option>';$.each(a,function(){f+='<option value="'+this.id+'">'+this.name+"</option>"}),d.html(f),e.html('<option value="">--选择区--</option>'),b&&d.val(b).trigger("change",c)})}),d.on("change",function(a,b){var c=$(this).val();$.get("/user/api/city?id="+c).success(function(a){var c='<option value="">--选择区--</option>';$.each(a,function(){c+='<option value="'+this.id+'">'+this.name+"</option>"}),e.html(c),b&&e.val(b)})});var f=$("#modal1");b.on("click",".oconfirm-panel1 .item .edit",function(){var a=$(this).parent(".item");f.find(".modal-header").text("新增收货地址").end().find('[name="id"]').val(a.attr("data-id")).end().find('[name="consignee"]').val(a.attr("data-consignee")).end().find('[name="province"]').val(a.attr("data-province")).trigger("change",[a.attr("data-city"),a.attr("data-district")]).end().find('[name="address"]').val(a.attr("data-address")).end().find('[name="zipcode"]').val(a.attr("data-zipcode")).end().find('[name="mobile"]').val(a.attr("data-mobile")).end().find('[name="phone"]').val(a.attr("data-phone")).end().modal("show")}),b.on("click",".panel-tt .addAddress",function(){f.find("form").get(0).reset(),f.find(".modal-header").text("新增收货地址"),f.modal("show")}),f.find("form").validate({rules:{consignee:{required:!0},province:{required:!0,number:!0},city:{required:!0,number:!0},district:{required:!0,number:!0},address:{required:!0},zipcode:{required:!0,pattern:"^\\d{6}"},mobile:{required:!0,pattern:"^1\\d{10}$"}},messages:{consignee:"收货人不能为空",province:"请选择省&ensp;",city:"请选择市&ensp;",district:"请选择区&ensp;",address:"详细地址不能为空",zipcode:{required:"邮编不能为空",pattern:"请输入正确的邮编"},mobile:{required:"手机号不能为空",pattern:"请输入正确的手机号"}},errorElement:"span",errorPlacement:function(a,b){b.parents("td").find(".help").append(a)},submitHandler:function(a){$.post($(a).find('[name="id"]').val()?"/user/api/modifyaddress":"/user/api/addaddress",$(a).serialize()).success(function(a){littleTips(a.tips),0===a.status&&location.reload()})}});var g=$(".oconfirm-panel2 .item"),h=$(".oconfirm-panel2-pay .item"),i=$(".oconfirm-panel3 .item");g.click(function(a){$(this).hasClass("group")?($(".oconfirm-panel2-pay").hide(),$(".oconfirm-panel3").hide()):($(".oconfirm-panel2-pay").show(),$(".oconfirm-panel3").show()),g.removeClass("active"),$(this).addClass("active")}),h.click(function(a){i.add(h).removeClass("active"),$(this).addClass("active")}),i.click(function(a){return $(this).hasClass("disabled")?!1:(h.add(i).removeClass("active"),void $(this).addClass("active"))});var j=$(".oconfirm-panel4 .item");j.on("click",".ubtn",function(){j.toggleClass("active")})}(),function(){var a=$("#price"),b=$("#coupon"),c=$("#code_save"),d=$("#all_save"),e=50,f=$("#j_score_trf"),g=$("#couponCodes .ipt"),h=$(".oconfirm-panel6 .tab-ct .i-couponId"),i=null,j={score:0,code:0,coupon:0};getAllDispatch(),$(".oconfirm-panel5").on("change",'select[name="shipid"]',function(b){if(void 0===$(this).val())return!1;var c=$(this).parent("td").attr("data-type"),d=$(this).parent("td").attr("data-unit"),e=$(this).children("option:selected").attr("data-id"),f=$(this).parent("td").attr("data-num"),g=$(".oconfirm-panel1 .item.active").attr("data-id"),h=$(this).parent("td").attr("data-goodsid"),i=0;$(this).parent("td").attr("ship-id",e),load($.get("/api/cart/getfreight",{type:c,unit:d,shipid:e,rid:g,num:f})).done(function(b){0==b.status?$('td[data-goodsid="'+h+'"]').find(".dispatch").html(b.tips):littleTips(b.tips),$.each($(".dispatch"),function(a,b){i+=parseFloat($(b).html())}),$("#dispatch").html(i),a.trigger("_save",j)}).fail(function(){littleTips("获取运费失败，请重试")})}),$("#j_score_crt").on("keydown keyup blur",function(){var b=parseInt($(this).val()),c=parseInt($(this).attr("data-max")),d=null;b=$.isNumeric(b)?b:0,b=b>c?c:b,d=(b/e).toFixed(2),$(this).val(b),f.html("&yen;"+d),j.score=parseFloat(d),a.trigger("_save",j)}),g.on("keydown",function(a){var b=$(this).val().length;b>=4&&$(this).next().focus(),0===b&&8===a.keyCode&&$(this).prev().focus()}).on("keyup",function(){var b=g.map(function(){return $(this).val()}).toArray().join("");16!==b.length?(j.code=0,c.html("&yen;"+j.code.toFixed(2)),a.trigger("_save",j)):(clearTimeout(i),i=setTimeout(function(){c.html("获取中，请稍候..."),$.post("/user/api/offlinecoupons",{code:b.toUpperCase()}).done(function(b){0===b.status?(j.code=parseFloat(b.content.rmb),c.html("&yen;"+j.code.toFixed(2)),a.trigger("_save",j)):c.html(b.tips)})},200))}),b.on("click",".tab-hd a",function(){$(this).hasClass("active")||($(this).addClass("active").siblings().removeClass("active"),b.find(".tab-ct").removeClass("active").eq($(this).index()).addClass("active"))}),h.on("change",function(){h.not(this).prop("checked",!1),j.coupon=$(this).is(":checked")?parseFloat($(this).attr("data-save")):0,a.trigger("_save",j)}),a.on("_save",function(a,b){var c=b.score+b.code+b.coupon,e=parseFloat($(this).attr("data-price"))-c+parseFloat($("#dispatch").html());0>e&&(e=0),d.html(c.toFixed(2)),$(this).html(e.toFixed(2))})}(),function(){var a=$("#modal2");$(".oconfirm-panel4 .item .edit").on("click",function(){a.modal("show")});var b=$("#modal2 .province"),c=$("#modal2 .city"),d=$("#modal2 .district");b.on("change",function(a,b,e){var f=$(this).val();f&&$.get("/user/api/city?id="+f).success(function(a){var f='<option value="">--选择市--</option>';$.each(a,function(){f+='<option value="'+this.id+'">'+this.name+"</option>"}),c.html(f),d.html('<option value="">--选择区--</option>'),b&&c.val(b).trigger("change",e)})}),c.on("change",function(a,b){var c=$(this).val();$.get("/user/api/city?id="+c).success(function(a){var c='<option value="">--选择区--</option>';$.each(a,function(){c+='<option value="'+this.id+'">'+this.name+"</option>"}),d.html(c),b&&d.val(b)})});var e=$("#modal2 form");e.validate({groups:{area:"province city dist"},rules:{company:{required:!0},phone:{required:!0,pattern:"^([0-9]{3,4}-)?[0-9]{7,8}$"},taxnum:{required:!0},bank:{required:!0},address:{required:!0},account:{required:!0},username:{required:!0},mobile:{required:!0,pattern:"^1[0-9]{10}$"},province:{required:!0},city:{required:!0},dist:{required:!0},adddress:{required:!0}},messages:{company:"公司地址不能为空",phone:{required:"手机号不能为空",pattern:"手机号码格式错误"},taxnum:"纳税人识别码不能为空",bank:"开户行不能为空",address:"公司地址不能为空",account:"银行账号不能为空",username:"收票人不能为空",mobile:{required:"收票人手机不能为空",pattern:"手机号码格式错误"},adddress:"详细地址不能为空",province:"请选择省市区",city:"请选择省市区",dist:"请选择省市区"},errorElement:"div",errorPlacement:function(a,b){$(b).parents("td").find(".help").append(a)},submitHandler:function(a){var b=$(a).find('[name="id"]').val();$.post("/user/api/"+(b?"modifyinvoice":"invoice"),$(a).serialize()).success(function(a){littleTips(a.tips),0===a.status&&window.location.reload()})}})}(),function(){var a=$("#submitBtn"),b=$(".oconfirm-panel2 .item"),c=$(".oconfirm-panel3 .item,.oconfirm-panel2-pay .item"),d=$(".oconfirm-panel4 .item"),e="",f="";a.on("click",function(){var a=$(this);if(!a.hasClass("pending")){if(a.addClass("pending"),$.each($(".oconfirm-panel5").find("select"),function(a,b){return e=$(b).children("option:selected").attr("data-id"),void 0==e?!1:void 0}),void 0==e)return console.log(e),littleTips("请选择相应产品的配送方式"),a.removeClass("pending"),!1;$.each($(".oconfirm-panel5 select").parent("td"),function(a,b){f='{"goodsid":'+$(b).attr("data-goodsid")+',"shipid":'+$(b).attr("ship-id")+"},"+f}),f="["+f.substring(0,f.length-1)+"]",console.log(f);var g={};if(g.incoice=d.hasClass("active")?d.attr("data-id"):0,0==g.incoice&&confirm("发票信息未填写，如需增值税发票，请点”是“完善发票信息"))return $("#modal2").modal("show"),void a.removeClass("pending");g.rid=$(".oconfirm-panel1 .item.active").attr("data-id"),g.grouppay=b.filter(".active").attr("data-groupid"),g.pay=c.filter(".active").attr("data-id"),g.orderprice=0,g.score=$("#j_score_crt").val(),g.couponCode=$("#couponCodes input").map(function(){return $(this).val()}).toArray().join(""),g.exMsg=$("#exMsg").val(),g.couponId=$(".oconfirm-panel6 .tab-ct .i-couponId:checked").val(),g.shipid=f,f="",load($.post("/user/api/ocorder",$.param(g))).done(function(a){0===a.status?""!=a.url?window.location.href=a.url:window.location.href="/order?id="+a.content.ordersn:littleTips(a.tips)}).always(function(){a.removeClass("pending")})}})}();