<!-- 表单验证 -->
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">更新用户组</h4>
</div>
<!-- BEGIN 表单-->
<form action="/admin/auth/role/doEdit" id="validation-form" class="form-horizontal">
	<div class="modal-body">
		<input type="hidden" name="id" id="role_id" value="@if(!empty($role)){{$role['id']}}@endif" />
		<div class="form-body">
			<div class="form-group">
            	<label class="control-label col-md-4"><span class="has-error">*</span>用户组名称 </label>
            	<div class="col-md-5">
                	<input type="text" value="@if(!empty($role)){{$role['role_name']}}@endif" name="role_name" placeholder="用户组名称" class="form-control"/>
                </div>
            </div>
        	<div class="form-group">
            	<label class="control-label col-md-4">备注 </label>
             	<div class="col-md-5">
                	<textarea name="remark" class="form-control" rows="3">@if(!empty($role)){{$role['remark']}}@endif</textarea>
            	</div>
        	</div>
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
				role_name: {
					validators: {
						notEmpty: {
							message: '请输入用户组名称'
						},
						stringLength: {
							min: 2,
							max: 20,
							message: '用户组名称长度位 4到10位'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
			e.preventDefault();
			var $form = $(e.target);
			var bv = $form.data('bootstrapValidator');
			$.ajax({
				url:'/admin/auth/role/doEdit',
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