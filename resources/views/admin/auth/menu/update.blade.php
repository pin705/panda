<!-- 表单验证 -->
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
			aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">更新权限</h4>
</div>
<form action="/admin/auth/menu/doEdit" id="validation-form" class="form-horizontal" method="post">
	<!-- BEGIN 表单-->
	<div class="modal-body">
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-md-4">上级权限</label>
				<div class="col-md-5">
					<input type="hidden" name="id" value="@if(!empty($menu)){{$menu['id']}}@endif" />
					<select class="form-control select2" name="parent_id">
						<option value="0">--- 无 ---</option>
						@if (count($menuList) > 0)
							@foreach ($menuList as $vo)
								<option value="{{$vo['id']}}" @if(!empty($menu) && $menu['parent_id'] == $vo['id'])selected='selectd'@endif>{{$vo['menu_name']}}</option>
							@endforeach
						@endif
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4"><span class="has-error">*</span>权限名称 </label>
				<div class="col-md-5">
					<input type="text" value="@if(!empty($menu)){{$menu['menu_name']}}@endif" name="menu_name" placeholder="权限名称" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4"><span class="has-error">*</span>请求路径 </label>
				<div class="col-md-5">
					<input type="text" value="@if(!empty($menu)){{$menu['url']}}@endif" name="url" placeholder="/" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4"> 排序 </label>
				<div class="col-md-5">
					<input type="text" value="@if(!empty($menu)){{$menu['sort']}}@endif" name="sort" placeholder="排序" class="form-control" />
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
		//isValid
		$('.form-horizontal').bootstrapValidator({
			fields: {
				menu_name: {
					validators: {
						notEmpty: {
							message: '请输入权限名称'
						},
						stringLength: {
							min: 1,
							max: 10,
							message: '权限名称长度位 6到10位'
						}
					}
				},
				url: {
					validators: {
						notEmpty: {
							message: '请输入请求地址'
						},
						stringLength: {
							min: 1,
							max: 50,
							message: '请求地址长度为 6到50位'
						}
					}

				},
				sort: {
					validators: {
						digits: {
							message: '请输入整数'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
			e.preventDefault();
			var $form = $(e.target);
			var bv = $form.data('bootstrapValidator');
			$.ajax({
				url:'/admin/auth/menu/doEdit',
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