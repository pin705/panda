<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">分配角色</h4>
</div>
<!-- BEGIN 表单-->
<form action="/admin/auth/user/doChooseRole" id="choose-form" class="form-horizontal">
	<input type="hidden" name="userId" value="{{$userId}}"/>
	<div class="modal-body row">

		@if (count($roleList) > 0)
			@for ($i = 0; $i < count($roleList); $i++)
			<div class="col-md-4" style="overflow:hidden;white-space: nowrap;text-overflow: ellipsis;">
				<input type="checkbox" name="roleId[]" value="{{$roleList[$i]['id']}}"/><strong> {{$roleList[$i]['role_name']}}</strong>　
			</div>
			@endfor

		@endif


	</div>
	<div class="modal-footer">
		<button type="button" id="choose_btn" class="btn btn-primary">保存</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	</div>
</form>
<script>
	var roleIds = '{{$roleIds}}';
	$(function(){
		var roleArr = [];
		//绑定选中状态
		if(typeof(roleIds) != 'undefined' && roleIds.length > 0){
			roleArr = roleIds.split("-");
		}
		$("input[name='roleId[]']").each(function(){
			if(roleArr.length > 0){
				for(var i=0;i<roleArr.length;i++){
					if($(this).val() == roleArr[i]){
						$(this).prop("checked","checked");
					}
				}
			}
		});
		$('#choose_btn').click(function(){
			$.ajax({
				url:$('#choose-form').attr('action'),
				type:'post',
				async:false,
				data:$('#choose-form').serialize(),
				success:function(data){


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
		});
	});
</script>