<!-- 表单验证 -->
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">修改密码</h4>
</div>
<form action="/admin/auth/user/editPassword" class="form-horizontal">
	<!-- BEGIN 表单-->
	<div class="modal-body">
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-md-4">密码 </label>
				<div class="col-md-4">
					<input type="password" id="password" class="form-control" name="password"/> 
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4">
					确认密码
				</label>
				<div class="col-md-4">
					<input type="password" class="form-control" name="confirm_password"> 
				</div>
			</div>
		</div>
		<!-- END 提交按钮 -->
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">保存</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	</div>
</form>


<script>
	$(function() {
		$('.form-horizontal').bootstrapValidator({
			fields: {
				password: {
					validators: {
						notEmpty: {
							message: '请输入密码'
						},
						stringLength: {
							min: 6,
							max: 20,
							message: '密码长度位 6到20位'
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
			$.ajax({
				url:$form.attr('action'),
				type:'post',
				async:false,
				data:$form.serialize(),
				success:function(data){
					if(data == 'true'){
						$('.modal').modal('hide');
						$.msgbox({msg:"操作成功",icon:"success"});
						window.location.href='/admin/sign'
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