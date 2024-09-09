var table = null;
$(function () {
    table = $('#xnorderTable').DataTable({
        serverSide: true, // 服务器 模式
        processing: true,
        pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
        sort: false,
        start: 0,  //起始数
        ajax: {
            "url": "/admin/xnorder/searchPage",
            type: 'GET', // 默认get吧
            "data": function (data) {

            }
        },
        "lengthMenu": [[10, 20, 30, 50], [10, 20, 30, 50]],
        responsive: true,
        autoWidth: false,
        "fnDrawCallback": function () {
            this.api().column(0).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        },
        "columns": [
            {"data": null, "sClass": "text-center", "width": "10%"},
            {"data": "m_id", "sClass": "text-center", "width": "10%"},
            {"data": "nickname", "sClass": "text-center", "width": "10%"},
            {"data": "name", "sClass": "text-center", "width": "10%"},
            {"data": "title", "sClass": "text-center", "width": "10%"},
            {"data": "desc", "sClass": "text-center", "width": "10%"},
            {"data": "num", "sClass": "text-center", "width": "10%"},
            {"data": "status","sClass" : "text-center","width":"3%",
                "render":function( data, type, full){
                    if(data == 2)
                        return ' <span class="label label-sm label-danger"> 未发货 </span>';
                    else if(data == 1)
                        return '<span class="label label-sm label-success"> 已发货 </span>';
                    else if(data == 3)
                        return '<span class="label label-sm label-success"> 已拒绝 </span>';
                    return "";
                },
            },
            {
                "data": "wx", "sClass": "text-center", "width": "5%",
                "render": function (data, type, full) {
                    return "<img src='" + data + "' style='width: 50px;height: 50px'/>";
                },
            },
            {
                "data": "zfb", "sClass": "text-center", "width": "5%",
                "render": function (data, type, full) {
                    return "<img src='" + data + "' style='width: 50px;height: 50px'/>";
                },
            },
            {"data": "create_date", "sClass": "text-center", "width": "10%"},
            {"data": "update_date", "sClass": "text-center", "width": "10%"},
            {
                "data": "id", "sClass": "text-center", "width": "10%",
                "render": function (data, type, full) {
                    var btns = [];
                    var islockBtn = '';
                    if(full["status"] == 2)
                        islockBtn = '<a href="javascript:;" title="点击打款" onclick="isOpen(\''+data+'\',\'2\');return false;" class="btn default btn-xs label-danger"><i class="fa fa-check-circle"></i>立即发货</a>';
                    else if(full["status"] == 1)
                        islockBtn = '<a href="javascript:;" title="已打款"  class="btn default btn-xs" >已发货</a>';
                    btns.push(islockBtn);
                    if(full["status"] == 2)
                        islockBtn = '<a href="javascript:;" title="" onclick="isRefuse(\''+data+'\',\'2\');return false;" class="btn default btn-xs label-danger"><i class="fa fa-check-circle"></i>拒绝</a>';
                    else if(full["status"] == 3)
                        islockBtn = '<a href="javascript:;" title=""  class="btn default btn-xs" >已拒绝</a>';
                    btns.push(islockBtn);
                    var delBtn = '<a href="javascript:;" title="删除" onclick="del(\''+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-times"></i>删除</a>';
                    btns.push(delBtn);
                    var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/xnorder/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>查看收款码</a>';
                    btns.push(editBtn);
                    return btns.join('');
                },
            }
        ],
        // bFilter: false,
        dom: 'flrtip',
        "oLanguage": {
            'sSearch': '搜索用户ID、微信昵称、姓名：',
            'sSearchPlaceholder': '请输入关键字',
            "sLengthMenu": "每页显示 _MENU_ 项记录",
            "sZeroRecords": "没有符合项件的数据...",
            "sInfo": "当前数据为 _START_ - _END_ 条数据；总共 _TOTAL_ 项记录",
            "sInfoEmpty": "显示 0 至 0 共 0 项",
            "sInfoFiltered": "(_MAX_)",
            "oPaginate": {
                "sFirst": "首页",
                "sPrevious": "上一页",
                "sNext": "下一页",
                "sLast": "末页"
            },
        },

    });

});

// 模态框
function update(url) {
    $('#baseModal').modal({
        remote: url,
        show: false
    }).on('loaded.bs.modal', function (e) {
        $(this).modal('show');
    });
}

//删除
function del(id) {
    if (confirm('您确定要删除吗？')) {
        $.ajax({
            url: '/admin/xnorder/delete',
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



//启用/禁用
function isOpen(id,status){
    $.ajax({
        url:'/admin/xnorder/isOpen',
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

//启用/禁用
function isRefuse(id,status){
    $.ajax({
        url:'/admin/xnorder/isRefuse',
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
