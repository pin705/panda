$(function() {
	$('.login-form').bootstrapValidator({
        fields: {
        	account: {
                validators: {
                	notEmpty: {
                        message: '请输入用户名'
                    },
                    stringLength: {
                        min: 4,
                        max: 10,
                        message: '用户名长度位 4到10位'
                    },
                    remote: {
                        type: 'POST',
                        url: '/admin/sign/validataName',
                        data:{  
                             'account':function(){//不能写'account':$('#account').val() account请求的值会一直不变的
                            	 return $('#account').val();
                             }
                        },
                        message: '用户名已经存在',
                        delay: 1000
                    }
                }
            },
            email: {
                validators: {
                	notEmpty: {
                        message: '请输入电子邮箱'
                    },
                    stringLength: {
                        min: 1,
                        max: 30,
                        message: '电子邮箱长度位 1到30位'
                    },
                    emailAddress:{
                    	message: '请输入正确的电子邮箱地址'
                    },
                    remote: {
                        type: 'POST',
                        url: '/admin/sign/validataRegisterEmail',
                        data:{  
                             'email':function(){//不能写'account':$('#account').val() account请求的值会一直不变的
                            	 return $('#email').val();
                             }
                        },
                        message: '邮箱已经存在',
                        delay: 1000
                    }
                }
                
            },
            password: {
                validators: {
                	notEmpty: {
                        message: '请输入密码'
                    },
                    stringLength: {
                        min: 6,
                        max: 10,
                        message: '密码长度位 6到10位'
                    }
                }
                
            },
            confirm_password: {
                validators: {
                	notEmpty: {
                        message: '请输入密码'
                    },
                    identical: {
                        field: 'password',
                        message: '2次密码不一致'
                    }
                }
                
            }
        }
    }).on('success.form.bv', function(e) {
    	e.preventDefault();
        var $form = $(e.target);
        var bv = $form.data('bootstrapValidator');
        var xval=getBusyOverlay();
        $.ajax({
    		url:$form.attr('action'),
    		type:'post',
    		async:false,
    		data:$form.serialize(),
    		success:function(data){
    			xval.remove();
    			xval = null;
    			if(data.code == 'success'){
                	location.href="/admin/sign/index"
    			}else{
	    			$('.alert-danger').text(data.message);
	    			$('.alert-danger').show();
    			}
    		},
    		error:function(){
    			alert('与服务器通信失败，请稍后再试！');
    		}
    	});
    })
});