<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">分配权限</h4>
</div>
<!-- BEGIN 表单-->
<form action="/admin/auth/role/doAuthorize" id="authorize-form" class="form-horizontal">
	<input type="hidden" name="roleId" value="{{$roleId}}"/>
	<div class="modal-body">
		<table class="table table-bordered table-hover">
			<tbody>
				@if (count($menuList) > 0)
	            	@for ($i = 0; $i < count($menuList); $i++)
						@if ($menuList[$i]->level == 1)
							<tr>
								<td><input type="checkbox" name="permissionId[]" value="{{$menuList[$i]->id}}" id="checkbox_{{$menuList[$i]->id}}"/><strong> {{$menuList[$i]->menu_name}}</strong></td>
							</tr>
							<tr>
								<td>
									@for ($j = 0; $j < count($menuList); $j++)
										@if ($menuList[$j]->parent_id == $menuList[$i]->id)
										　<input type="checkbox" name="permissionId[]" value="{{$menuList[$j]->id}}" id="checkbox_{{$menuList[$i]->id}}_{{$menuList[$j]->id}}"/> {{$menuList[$j]->menu_name}}
										@endif
									@endfor
								</td>
							</tr>
						@endif
					@endfor
				@endif
			</tbody>
		</table>
	</div>
	<div class="modal-footer">
		<button type="button" id="authorize_btn" class="btn btn-primary">保存</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	</div>
</form>
<script>
	var permissionIds = '{{$menuRoleList}}';
	$(function(){
		var permissionArr = [];
		//绑定选中状态
		if(typeof(permissionIds) != 'undefined' && permissionIds.length > 0){
			permissionArr = permissionIds.split("-");
		}
		//绑定checkbox
		$(".modal-body input[name='permissionId[]']").each(function(){
			if(permissionArr.length > 0){
				for(var i=0;i<permissionArr.length;i++){
					if($(this).val() == permissionArr[i]){
						$(this).parent().addClass('checked');
						$(this).attr('checked','checked');
					}
				}
			}
			var id = $(this).attr("id");
			//绑定click事件
			$(this).click(function(){
				//关联下级this.checked
				var chk =this.checked;
				if(!chk){
					chk=false;
				}
				$(".modal-body input[type='checkbox'][id^='"+id+"_']").each(function(){
					$(this).prop("checked",chk);
				});
				//关联上级checkbox_1_2_3_4
				var ccid = id;
				var i = "";
				if(chk){
					while( (i=ccid.lastIndexOf("_")) != -1){
						ccid = ccid.substr(0,i);
						$("input[id='"+ccid+"']").prop("checked","checked");
						$("input[id='"+ccid+"']").parent().addClass('checked');
					}
				}else{
					//循环检查本级别的所有checkbox是否选中
					while( (i=ccid.lastIndexOf("_")) != -1){
						var count = 0;
						var cl = ccid.split("_");
						var cccid = ccid.substr(0,i+1);	// checkbox_1_2_3_
						ccid = ccid.substr(0,i);	//go on
						$("input[type='checkbox'][id^='"+cccid+"']").each(function(){
							var innerl = $(this).attr("id").split("_");
							if(innerl.length==cl.length){
								if(this.checked){
									count=count+1;
								}
							}
						});
						if(count == 0){
							$('#'+ccid).parent().removeClass('checked');
							$('#'+ccid).removeAttr('checked');
						}else{
							break;
						}
					}
				}
			});
		});
		$('#authorize_btn').click(function(){
			$.ajax({
				url:$('#authorize-form').attr('action'),
				type:'post',
				async:false,
				data:$('#authorize-form').serialize(),
				success:function(data){
					if(data == 'true'){
						window.location.href = '/admin/auth/role/index'
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