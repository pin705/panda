@extends('admin.base.doom')

@section('title','育垚盛客户服务管理系统|后台菜单')

{{--页面css--}}
@section('css')
	@parent
	<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	<!-- 表单验证 -->
	<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
@stop

{{--页面内容--}}
@section('content')
	@parent
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2>育垚盛客户服务管理系统</h2>
			<ol class="breadcrumb">
				<li>
					<a href="/admin/index/index">首页</a>
				</li>
				<li>
					<a>用户管理</a>
				</li>
				<li class="active">
					<strong>修改密码</strong>
				</li>
			</ol>
		</div>
	</div>
	<form action="/admin/auth/user/editPassword" class="form-horizontal" method="post">
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
				<div class="form-group">
					<label class="control-label col-md-4">

					</label>
					<div class="col-md-4">
						<span style="margin-top: 20px">(提示：请重置密码，已确保账号安全。)</span>
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
@stop


{{--页面使用的js--}}
@section('js')
	@parent
	<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/dataTables/datatables.min.js"></script>
	<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/message/message.min.js"></script>
	<script src="{{ config('oss.AdminOssUrl') }}/admin/js/auth/menu.js"></script>
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
							window.location.href='/admin/index/index';
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
@stop