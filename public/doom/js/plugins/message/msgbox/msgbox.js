/**
 * 消息提示
 * @author taiqichao
 */
//msg:消息提示文字
//icon:提示小图标,可选值 成功:success,错误:error ,警告：warning, clear
//time:持续时间,毫秒
(function($) {
    var $msgbox = function(options) {
    	if ($('link[href$="msgbox.css"]').length == 0) {
			$('<link href="/plugins/message/msgbox/msgbox.css" rel="stylesheet" type="text/css" />').appendTo('head');
		}
     	var defaults = {    
    		msg: '系统提示',    
     		icon: 'clear',
     		time:'2000'
   		};
    	var settings = jQuery.extend(defaults, options);
    	var tipiconclass="gtl_ico_"+settings.icon;
    	$('#ts_Msgbox').remove();
    	var box="<div class=\"ts_msgbox_layer_wrap\" id=\"ts_Msgbox\" style=\"display:none\"><span class=\"ts_msgbox_layer\" style=\"z-index: 10000;\" id=\"mode_tips_v2\"><span class=\""+tipiconclass+"\"></span>"+settings.msg+"<span class=\"gtl_end\"></span></span></div>";
    	$("body").append(box);
    	$('#ts_Msgbox').fadeIn();
    	window.setTimeout("$('#ts_Msgbox').fadeOut();", settings.time);
    }
    $.msgbox = function(options){ return new $msgbox(options); }    
    return $.msgbox;
})(jQuery);
