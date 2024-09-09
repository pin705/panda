var table = null;
$(function () {
    table = $('#treeTable').DataTable({
        serverSide: true, // 服务器 模式
        processing: true,
        pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
        sort: false,
        start: 0,  //起始数
        ajax: {
            "url": "/admin/tree/searchPage",
            type: 'GET', // 默认get吧
            "data": function (data) {
                data.search1 = $('#search1').val();
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
            {"data": null, "sClass": "text-center", "width": "5%"},
            {"data": "name", "sClass": "text-center", "width": "8%"},
            {"data": "all_stock", "sClass": "text-center", "width": "10%"},
            {"data": "stock", "sClass": "text-center", "width": "8%"},
            {"data": "per", "sClass": "text-center", "width": "8%",
                "render":function(data,type,full){
                    return data / 10;
                }
            },
            {"data": "recycle", "sClass": "text-center", "width": "8%"},
            // {
            //     "data": "img", "sClass": "text-center", "width": "8%",
            //     "render": function (data, type, full) {
            //         return "<img src='" + data + "' style='width: 50px;height: 50px'/>";
            //     },
            // },
            {
                "data": "id", "sClass": "text-center", "width": "10%",
                "render": function (data, type, full) {
                    var btns = [];
                    var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/tree/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>编辑</a>';
                    btns.push(editBtn);
                    // var delBtn = '<a href="javascript:;" title="删除" onclick="del(\''+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-times"></i>删除</a>';
                    // btns.push(delBtn);
                    return btns.join('');
                },
            }
        ],
        bFilter: false,
        dom: 'flrtip',
        "oLanguage": {
            'sSearch': '搜索用户ID、用户账号:',
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
    // alert(111);
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
            url: '/admin/tree/delete',
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


