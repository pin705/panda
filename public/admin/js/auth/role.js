var table = null;
$(function(){

	table = $('#roleTable').DataTable({
		serverSide: true, // 服务器 模式
		processing: true,
		lengthMenu: [ [10, 20,30, 50],[10, 20,30, 50]],
		pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
		sort:false,
		start:0,  //起始数
		ajax:"/admin/auth/role/searchPage",
		responsive: true,
		autoWidth: false,
		"fnDrawCallback": function(){
			this.api().column(0).nodes().each(function(cell, i) {
				cell.innerHTML =  i + 1;
			});
		},
		columns: [
			{"data": null,"sClass" : "text-center","width":"8%",
			},
			{"data": "role_name","sClass" : "text-center","width":"30%"},
			{"data": "status","sClass" : "text-center","width":"10%",
				"render":function( data, type, full){
					if(data == 2)
						return ' <span class="label label-sm label-danger"> 禁用 </span>';
					else if(data == 1)
						return '<span class="label label-sm label-success"> 启用 </span>';
					return "";
				},
			},
			{"data": "id","sClass" : "text-center","width":"25%","bSortable":false,
				"render":function( data, type, full){
					//obj.aData["ACCOUNT"];获取其他列的值
					var btns = [];
					var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/auth/role/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>编辑</a>';
					btns.push(editBtn);
					var islockBtn = '';
					if(full["status"] == 1)
						islockBtn = '<a href="javascript:;" title="禁用" onclick="isOpen(\''+data+'\',2);return false;" class="btn default btn-xs"><i class="fa fa-minus-circle"></i>禁用</a>';
					else
						islockBtn = '<a href="javascript:;" title="启用" onclick="isOpen(\''+data+'\',1);return false;" class="btn default btn-xs"><i class="fa fa-check-circle"></i>启用</a>';
					btns.push(islockBtn);
					var nodeBtn = '<a href="javascript:;" onclick="update(\'/admin/auth/role/authorize?id='+data+'\');return false;" title="分配权限" class="btn default btn-xs"><i class="fa fa-check-circle"></i>分配权限</a>';
					btns.push(nodeBtn);
					var delBtn = '<a href="javascript:;" title="删除" onclick="del(\''+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-times"></i>删除</a>';
					btns.push(delBtn);
					return btns.join(' ');
				},
			}
		],
		dom: 'flrtip',
		"oLanguage": {
			'sSearch': '搜索用户组名称:',
			'sSearchPlaceholder': '请输入关键字',
			"sLengthMenu": "每页显示 _MENU_ 项记录",
			"sZeroRecords": "没有符合项件的数据...",
			"sInfoEmpty": "显示 0 至 0 共 0 项",
			"sInfoFiltered": "(_MAX_)",
			"sInfo": "当前数据为从第 _START_ 到第 _END_ 项数据；总共有 _TOTAL_ 项记录",
			"oPaginate" : {
				"sFirst" : "首页",
				"sPrevious" : "上一页",
				"sNext" : "下一页",
				"sLast" : "末页"
			},
		}

	});

});
function update(url){
	$('#baseModal').modal({
		remote: url,
		show:false
	}).on('loaded.bs.modal', function (e) {
		$(this).modal('show');
	});
}

//启用/禁用
function isOpen(id,status){
	$.ajax({
		url:'/admin/auth/role/isOpen',
		type:'post',
		async:false,
		data:{
			'id':id,
			'status':status
		},
		success:function(data){
			if(data == 'true'){
				table.ajax.reload(null,false);
				$.msgbox({msg:"操作成功",icon:"success"});
			}else if(data == 'notnone'){
				$.msgbox({msg:"请先分配权限",icon:"error"});
			}
			else{
				$.msgbox({msg:"操作失败",icon:"error"});
			}
		},
		error:function(){
			alert('与服务器通信失败，请稍后再试！');
		}
	});
}
//删除
function del(id){
	if(confirm('您确定要删除吗？')){
		$.ajax({
			url:'/admin/auth/role/delete',
			type:'post',
			async:false,
			data:{
				'id':id
			},
			success:function(data){
				if(data == 'true'){
					table.ajax.reload(null,false);
					$.msgbox({msg:"操作成功",icon:"success"});
				}
				else
					$.msgbox({msg:"操作失败",icon:"error"});
			},
			error:function(){
				alert('与服务器通信失败，请稍后再试！');
			}
		});
	}
}

