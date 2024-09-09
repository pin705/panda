<!-- 表单验证 -->
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">更新用户</h4>
</div>
<!-- BEGIN 表单-->
<form action="/admin/auth/user/doEdit" id="validation-form" class="form-horizontal">
	<div class="modal-body">
		<input type="hidden" name="id" id="user_id" value="@if(!empty($user)){{$user['id']}}@endif" />
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-md-4"><span class="has-error">*</span>用户名 </label>
				<div class="col-md-5">
					<input type="text" value="@if(!empty($user)){{$user['account']}}@endif" id="account" name="account" placeholder="用户名" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4">手机 </label>
				<div class="col-md-5">
					<input type="text" value="@if(!empty($user)){{$user['phone']}}@endif" id="phone" name="phone" placeholder="手机" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4">姓名 </label>
				<div class="col-md-5">
					<input type="text" value="@if(!empty($user)){{$user['user_name']}}@endif" id="user_name" name="user_name" placeholder="姓名" class="form-control" />
				</div>
			</div>
			@if(empty($user))
			<div class="form-group">
				<label class="control-label col-md-4"><span class="has-error">*</span>密码 </label>
				<div class="col-md-5">
					<input type="password" id="password" name="password" placeholder="密码" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4"><span class="has-error">*</span>确认密码 </label>
				<div class="col-md-5">
					<input type="password" name="confirm_password" placeholder="确认密码" class="form-control" />
				</div>
			</div>
			@endif
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">保存</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	</div>
</form>

<script>
	$(function() {
		//isValid
		$('.form-horizontal').bootstrapValidator({
			fields: {
				account: {
					validators: {
						notEmpty: {
							message: '请输入用户名'
						},
						stringLength: {
							min: 4,
							max: 16,
							message: '用户名长度位 4到16位'
						},
						remote: {
							type: 'POST',
							url: '/admin/auth/user/validataName',
							data:{
								'id':$('#user_id').val(),
								'account':function(){//不能写'account':$('#account').val() account请求的值会一直不变的
									return $('#account').val();
								}
							},
							message: '用户名已经存在',
							delay: 1000
						}
					}
				},
                phone: {
                    validators: {
                        regexp: {
                            regexp:  /(^0{0,1}1[3|4|5|6|7|8|9][0-9]{9}$)/,
        					message: '手机号不正确'
                        },
                        remote: {
                            type: 'POST',
                            url: '/admin/auth/user/validataPhone',
                            data:{
                                'id':$('#user_id').val(),
                                'phone':function(){//不能写'account':$('#account').val() account请求的值会一直不变的
                                    return $('#phone').val();
                                }
                            },
                            message: '手机号码已存在',
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
				user_name: {
					validators: {
						notEmpty: {
							message: '请输入姓名'
						}
					}

				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: '请输入密码'
						},
						stringLength: {
							min: 6,
							max: 10,
							message: '密码长度位 6到30位'
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
			$.ajax({
				url:'/admin/auth/user/doEdit',
				type:'post',
				async:false,
				data:$form.serialize(),
				success:function(data){
					xval = null;
					if(data == 'true'){
						$('.modal').modal('hide');
						table.ajax.reload();
						$.msgbox({msg:"操作成功",icon:"success"});
					}else
						$.msgbox({msg:"操作失败",icon:"error"});
				},
				error:function(){
					alert('与服务器通信失败，请稍后再试！');
				}
			});
		})
	});
</script>
