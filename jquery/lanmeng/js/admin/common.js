String.prototype.trim = function() {return this.replace(/^\s+|\s+$/g,"");}
String.prototype.ltrim = function() {return this.replace(/^\s+/,"");}
String.prototype.rtrim = function() {return this.replace(/\s+$/,"");}


/**
 * [ajaxHandler description]
 * @param  {[type]} result [description]
 * @return {[type]}        [description]
 */
function ajaxHandler(result) {
	if($('div.alertsigns')){
		$('div.alertsigns').remove();
	}
	var message = jQuery('<div class="alert alertsigns fade in"><button type="button" class="close" data-dismiss="alert">×</button>' + result.errorInfo + '</div>');
	
	message.addClass(!result.success ? 'alert-error' : 'alert-success');
	jQuery(':first', this).before(message);
	//回到顶部
	$('body,html').animate({scrollTop:0},1000);
	if (result.success) {
		//success
		if (result.content && 'redirect' in result.content) {
			setTimeout(function() {
				if(!result.tips){
					window.location.href = result.content.redirect;
				}else{
					$('div.alertsigns').remove();
					confirmDialog("操作成功,继续选择操作?",result.content.redirect);
				}
			}, 'time' in result.content ? result.content.time * 1000 : 0);
		}
	} else {
		jQuery("input[name='captcha']", this).val('');
		jQuery("img.captcha", this).trigger('click');
	}
}

/**
 * [isEmptyObject description]
 * @param  {[type]}  obj [description]
 * @return {Boolean}     [description]
 */
function isEmptyObject(obj){
	for(var name in obj){
		return false;
	}
	return true;
}

/**
 * [formSubmit description]
 * @param  {[type]}   form     [description]
 * @param  {Function} callback [description]
 * @return {[type]}            [description]
 */
function formSubmit(form, callback) {
	form = jQuery(form);
	jQuery('.error', form).removeClass('error').find('span.help-inline').html(null);

	//set default method
	if(!form.attr('method') || !form.attr('method').localeCompare('get')) {
		form.attr('method', 'post');
	}


	var fs = jQuery("[type='submit']", form);
	if (fs.data('locked') == undefined) {
		fs.data('locked', false);
	}

	jQuery("[type='submit']", form).attr('disabled', 'disabled');
	if(isEmptyObject(window.allComplete)){
		if (fs.data('locked')) {
			return false;
		}
		jQuery.ajax({
			url : form.attr('action'),
			dataType : 'json',
			type : form.attr('method'),
			beforeSend : function(xhr) {
				//loading
				form.trigger('before');
				jQuery('.progress', form).show();
				fs.data('locked', true);
			},
			complete : function(xhr, status) {
				//unloading
				jQuery("[type='submit']", form).removeAttr('disabled');
				jQuery('.progress', form).hide();
				form.trigger('after');
				fs.data('locked', false);
			},
			context : form,
			data : form.serializeArray(),
			success : function(result, status, xhr) {
				if (typeof callback == "function") {
					callback.call(this, result);
				} else {
					ajaxHandler.call(this, result);
				}
			}
		});
	} else {
		for(var name in window.allComplete){
			jQuery('#' + name).uploadify('upload', '*');
		}
	}
	return false;
}

/**
 * 删除弹出来的按钮
 * @param  object  
 * @return
 */
 function  returnValidateDel(object) {
    var $this = $(object);
    $('#myModal').modal('show').on('shown', function() {
          $(".btn-primary").live('click', function() {
            $.get($this.attr('data-url'), {}, function(json) {
                      if (json.success != '1') {
                                $('#myModal').modal('hide');
                                alert(json.errorInfo);
                      } else {
                                window.location.href = json.content.redirect;
                      }
            }, 'json');
          })
    });
    return false;
 }

jQuery(function(){
	window.allComplete = {};
	jQuery('form').validator({
		inputEvent: 'blur'
	}).bind("onFail", function(e, objects){
		jQuery(objects).each(function(){
			this.input.next('span').html(this.messages[0]);
		});
		return false;
	}).bind('onSuccess', function(e, objects){
		jQuery(objects).each(function(){
			jQuery(this).next('span').html(null);
		});
	}).submit(function(e){
		formSubmit(jQuery(e.target));
		return false;
	});
});