var table = null;
$(function(){

	table = $('#menuTable').DataTable({
		serverSide: true, // 服务器 模式
		processing: true,
		sort:false,
		pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
		start:0,  //起始数
		ajax: {
			"url": "/admin/auth/menu/searchPage",
			type: 'get', // 默认get吧
			"data": function ( d ) {
				  // 打印看看 结果
			}
		},
		lengthMenu: [ [10, 20,40,80],[10, 20,40,80]],
		responsive: true,
		autoWidth: false,
		"columns": [
			{"data": "id","sClass" : "text-center","width":"8%"
			},
			{"data": "menu_name","width":"15%","sClass" : "text-center",},
			{"data": "parent_name","width":"15%","sClass" : "text-center",},
			{"data": "url","width":"15%","sClass" : "text-center",},
			{"data": "sort","sClass" : "text-center","width":"10%","bSortable":false,
                "render":function( data, type, full){
					return '<input type="text" style="width:100%" class="col-lg-6" value="'+data+'" onblur="sortupdate(\''+full.id+'\',this,'+data+')"/>';
                }
			},

			{"data": "status","sClass" : "text-center","width":"8%",
				"render":function( data, type, full){
					if(data == 2)
						return ' <span class="label label-sm label-danger"> 禁用 </span>';
					else if(data == 1)
						return '<span class="label label-sm label-success"> 启用 </span>';
					return "";
				},
			},
			{"data": "id","sClass" : "text-center","width":"30%",
				"render":function( data, type, full){
					//obj.aData["ACCOUNT"];获取其他列的值
					var btns = [];
					var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/auth/menu/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>编辑</a>';
					btns.push(editBtn);
					if(full.level == 1)
						btns.push('<a class="btn default btn-xs" href="javascript:;" onclick="nextLevel(\''+full.id+'\');return false;">下一级</a>');
					else
						btns.push('<a class="btn default btn-xs" href="javascript:;" onclick="nextLevel(\'0\');return false;">上一级</a>');
					var islockBtn = '';
					if(full["status"] == 1)
						islockBtn = '<a href="javascript:;" title="禁用" onclick="isOpen(\''+data+'\',\'2\');return false;" class="btn default btn-xs" ><i class="fa fa-minus-circle"></i>禁用</a>';
					else
						islockBtn = '<a href="javascript:;" title="启用" onclick="isOpen(\''+data+'\',\'1\');return false;" class="btn default btn-xs"><i class="fa fa-check-circle"></i>启用</a>';
					btns.push(islockBtn);
					var delBtn = '<a href="javascript:;" title="删除" onclick="del(\''+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-times"></i>删除</a>';
					btns.push(delBtn);
					return btns.join(' ');
				},
			}
		],

		dom: 'flrtip',
		"oLanguage": {
			'sSearch': '菜单名称查找:',
			"sLengthMenu": "每页显示 _MENU_ 项记录",
			"sZeroRecords": "没有符合项件的数据...",
			"sInfo": "这是第 _START_ — _END_ 条；总共有 _TOTAL_ 条",
			"sInfoEmpty": "显示 0 至 0 共 0 项",
			"sInfoFiltered": "(_MAX_)",
			"oPaginate" : {
				"sFirst" : "首页",
				"sPrevious" : "上一页",
				"sNext" : "下一页",
				"sLast" : "末页"
			},
		},

	});

});

//查看下一级
function nextLevel(parent_id){
	table.ajax.url( '/admin/auth/menu/searchPage?parent_id='+parent_id).load();
}
//修改排序
function sortupdate(id,dom,sort){
	var num = $(dom).val();
	if(num == sort){
		return;
	}
	$.ajax({
		url:'/admin/auth/menu/sortUpdate',
		type:'post',
		async:false,
		data:{
			'id':id,
            'sort':$(dom).val()
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


//启用/禁用
function isOpen(id,status){
	$.ajax({
		url:'/admin/auth/menu/isOpen',
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

function update(url){
	$('#baseModal').modal({
		remote: url,
		show:false
	}).on('loaded.bs.modal', function (e) {
		$(this).modal('show');
	});
}
//删除
function del(id){
	if(confirm('您确定要删除吗？')){
		$.ajax({
			url:'/admin/auth/menu/del',
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