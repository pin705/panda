var table = null;
$(function () {
    table = $('#orderTable').DataTable({
        serverSide: true, // 服务器 模式
        processing: true,
        pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
        sort: false,
        start: 0,  //起始数
        ajax: {
            "url": "/admin/order/searchPage",
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
            {"data": "id", "sClass": "text-center", "width": "10%"},
            {"data": "nickname", "sClass": "text-center", "width": "10%"},
            {"data": "name", "sClass": "text-center", "width": "10%"},
            {"data": "tel", "sClass": "text-center", "width": "10%"},
            {"data": "price", "sClass": "text-center", "width": "10%",
                "render":function(data, type, full){
                    return data / 1000;
                }
            },
            {"data": "status","sClass" : "text-center","width":"3%",
                "render":function( data, type, full){
                    if(data == 2)
                        return ' <span class="label label-sm label-danger"> 未充值 </span>';
                    else if(data == 1)
                        return '<span class="label label-sm label-success"> 已充值 </span>';
                    return "";
                },
            },
            {"data": "update_date", "sClass": "text-center", "width": "10%"},
            // {
            //     "data": "id", "sClass": "text-center", "width": "10%",
            //     "render": function (data, type, full) {
            //         var btns = [];
            //         // var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/rewards/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>编辑</a>';
            //         // btns.push(editBtn);
            //         var delBtn = '<a href="javascript:;" title="删除" onclick="del(\''+data+'\');return false;" class="btn default btn-xs"><i class="fa fa-times"></i>删除</a>';
            //         btns.push(delBtn);
            //         return btns.join('');
            //     },
            // }
        ],
        // bFilter: false,
        dom: 'flrtip',
        "oLanguage": {
            'sSearch': '搜索用户ID、微信昵称、姓名、手机号:',
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
            url: '/admin/order/delete',
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

function getExcel(){
    window.location.href="/admin/order/getExcel";
}
