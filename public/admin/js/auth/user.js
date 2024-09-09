var table = null;
$(function(){
	table = $('#userTable').DataTable({
		serverSide: true, // 服务器 模式
		processing: true,
		pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
		sort:false,
		start:0,  //起始数
		ajax: {
			"url": "/admin/auth/user/searchPage",
			type: 'GET', // 默认get吧
			"data": function ( data ) {
				data.role_id = $('#role_id').val();
			}
		},
		"lengthMenu": [ [10, 20,30, 50],[10, 20,30, 50]],
		responsive: true,
		autoWidth: false,
		"fnDrawCallback": function(){
			this.api().column(0).nodes().each(function(cell, i) {
				cell.innerHTML =  i + 1;
			});
		},

		initComplete: function() {
			var $filter = $('#userTable_filter');
			var $roleLabel = $('<label></label>');
			$.ajax({
				url:'/admin/auth/user/getInfo',
				type:'post',
				async:false,
				data:{},
				success: function(data){
					var $roles = $('<select id="role_id" class="form-control input-sm" name="role_id"><option value="0">请选择用户组</option></select>');
					for (var i = 0; i < data.length; i++) {
						$roles.append('<option value="' + data[i].id + '">' + data[i].role_name + '</option>')
					}
					$filter.append($roleLabel.append($roles.on("change", function() {
						table.ajax.reload();
					})))
				},
				error:function(){
					alert('与服务器通信失败，请稍后再试！');
				}
			});
		},
    	"columns": [
    	      {"data": null,"sClass" : "text-center","width":"10%"},
              {"data": "account","sClass" : "text-center","width":"15%"},
			{"data": "user_name","sClass" : "text-center","width":"15%"},
			{"data": "phone","sClass" : "text-center","width":"15%"},
              {"data": "roles","sClass" : "text-center","width":"20%",
								"render":function( data, type, full, meta) {
									var result = ''

									$.each(data, function(index, value) {
										if (index === data.length - 1) {
											result += value.role_name
										}
										else {
											result += value.role_name + ','
										}
									});

									return result
								},
							},
              {"data": "status","sClass" : "text-center","width":"10%",
            	  "render":function( data, type, full, meta){
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
					  var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/auth/user/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>编辑</a>';
            		  btns.push(editBtn);
            		  var islockBtn = '';
            		  if(full["status"] == 1)
						  islockBtn = '<a href="javascript:;" title="禁用" onclick="isOpen(\''+data+'\',\'2\');return false;" class="btn default btn-xs"><i class="fa fa-minus-circle"></i>禁用</a>';
            		  else
						  islockBtn = '<a href="javascript:;" title="启用" onclick="isOpen(\''+data+'\',\'1\');return false;" class="btn default btn-xs"><i class="fa fa-check-circle"></i>启用</a>';
            		  btns.push(islockBtn);
								  var roleBtn = '<a href="javascript:;" title="分配用户组" onclick="update(\'/admin/auth/user/choose?id='+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-check-circle"></i>分配用户组</a>';
								  btns.push(roleBtn);
								  var delBtn = '<a href="javascript:;" title="删除" onclick="del(\''+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-times"></i>删除</a>';
            		  btns.push(delBtn);
            		  return btns.join(' ');
            	  },
              }
          ],
		dom: 'flrtip',
		"oLanguage": {
			'sSearch': '搜索用户名/手机:',
			'sSearchPlaceholder': '请输入关键字',
			"sLengthMenu": "每页显示 _MENU_ 项记录",
			"sZeroRecords": "没有符合项件的数据...",
			"sInfo": "当前数据为 _START_ - _END_ 条数据；总共 _TOTAL_ 项记录",
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
// 模态框
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
		url:'/admin/auth/user/isOpen',
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
			else if(data == 'notnone') {
				$.msgbox({msg:"请选择用户组",icon:"error"});
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
	function del(id) {
	if (confirm('您确定要删除吗？')) {
		$.ajax({
			url: '/admin/auth/user/delete',
			type: 'post',
			async: false,
			data: {
				'id': id
			},
			success: function (data) {
				if (data == 'true') {
					table.ajax.reload();
					$.msgbox({msg: "操作成功", icon: "success"});
				}
				else
					$.msgbox({msg: "操作失败", icon: "error"});
			},
			error: function () {
				alert('与服务器通信失败，请稍后再试！');
			}
		});
	}
}
