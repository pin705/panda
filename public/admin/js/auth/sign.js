$(function(){
	//判断错误提示是否有内容，有内容直接显示
	var alert_text = $('.alert-danger').text();
	if(null != alert_text && alert_text != " ")
		$('.alert-danger').show();
	
	//点击登录按钮
	$('button[type="button"]').click(function(){
	    var account = $('input[name="account"]').val();
	    if(null == account || account == ""){
	        $('.alert-danger').text('请输入登录名');
	        $('.alert-danger').show();
	        return false;
	    }
	    var password = $('input[name="password"]').val();
	    if(null == password || password == ""){
	        $('.alert-danger').text('请输入密码');
	        $('.alert-danger').show();
	        return false;
	    }
	    $('.login-form').submit();
    });
});