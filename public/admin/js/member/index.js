var table = null;
$(function () {
    table = $('#memberTable').DataTable({
        serverSide: true, // 服务器 模式
        processing: true,
        pagingType: "full_numbers",//full_numbers ,numbers ,simple,simple_numbers
        sort: false,
        start: 0,  //起始数
        ajax: {
            "url": "/admin/member/searchPage",
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
        initComplete: function() {
            var $filter = $('#memberTable_filter');
            var $search1Label = $('<label>搜索上级ID：</label>');

            var $search1 = $('<input id="search1" class="form-control input-sm" />');
            $filter.append($search1Label.append($search1.on("input", function() {
                table.ajax.reload();
            })))
        },
        "columns": [
            {"data": null, "sClass": "text-center", "width": "5%"},
            {"data": "id", "sClass": "text-center", "width": "5%"},
            {"data": "nickname", "sClass": "text-center", "width": "5%"},
            {"data": "name", "sClass": "text-center", "width": "3%"},
            {
                "data": "head", "sClass": "text-center", "width": "5%",
                "render": function (data, type, full) {
                    return "<img src='" + data + "' style='width: 50px;height: 50px'/>";
                },
            },
            {"data": "gold","sClass" : "text-center","width":"8%",
                "render":function( data, type, full) {
                    // return data/100
                    return '<div class="input-group"><input value="' + data/1000 + '" type="text" style="width:100%" class="form-control">' +
                        '<span class="input-group-btn" onclick="setBalance(\'' + full['id'] + '\',this)"> <button type="button"  class="btn btn-primary"><i class="fa fa-check"></i></button> </span></div>';
                }
            },
            {"data": "all_fruit_num", "sClass": "text-center", "width": "10%",
                "render":function(data,type,full){
                    return data /1000;
                }
            },
            {"data": "fruit_num", "sClass": "text-center", "width": "8%",
                "render":function(data,type,full){
                    return data /1000;
                }
            },
            {"data": "tel", "sClass": "text-center", "width": "6%"},
            {"data": "wx_num", "sClass": "text-center", "width": "6%"},
            {"data": "qq_num", "sClass": "text-center", "width": "6%"},
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
            {"data": "ceng","sClass" : "text-center","width":"4%"},
            {"data": "status","sClass" : "text-center","width":"3%",
                "render":function( data, type, full){
                    if(data == 2)
                        return ' <span class="label label-sm label-danger"> 禁用 </span>';
                    else if(data == 1)
                        return '<span class="label label-sm label-success"> 启用 </span>';
                    return "";
                },
            },
            {
                "data": "id", "sClass": "text-center", "width": "5%",
                "render": function (data, type, full) {
                    var btns = [];
                    var editBtn ='<a href="javascript:;"  onclick="update(\'/admin/member/update?id='+data+'\');return false;" title="编辑" class="btn default btn-xs"><i class="fa fa-edit"></i>查看收款码</a>';
                    btns.push(editBtn);
                    var uditBtn ='<a href="javascript:;"  onclick="update(\'/admin/member/update1?id='+data+'\');return false;" title="修改昵称" class="btn default btn-xs"><i class="fa fa-edit"></i>修改信息</a>';
                    btns.push(uditBtn);
                    var uditBtn ='<a href="javascript:;"  onclick="update(\'/admin/member/update2?id='+data+'\');return false;" title="我的团队" class="btn default btn-xs"><i class="fa fa-edit"></i>我的团队</a>';
                    btns.push(uditBtn);
                    var islockBtn = '';
                    if(full["status"] == 2)
                        islockBtn = '<a href="javascript:;" title="启用" onclick="isOpen(\''+data+'\',\'1\');return false;" class="btn default btn-xs" ><i class="fa fa-minus-circle"></i>启用</a>';
                    else
                        islockBtn = '<a href="javascript:;" title="禁用" onclick="isOpen(\''+data+'\',\'2\');return false;" class="btn default btn-xs"><i class="fa fa-check-circle"></i>禁用</a>';
                    btns.push(islockBtn);
                    return btns.join('');
                },
            }
        ],
        dom: 'flrtip',
        "oLanguage": {
            'sSearch': '搜索用户ID、昵称、手机号、微信号、QQ号:',
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

//启用/禁用
function isOpen(id,status){
    $.ajax({
        url:'/admin/member/isOpen',
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


function setBalance(id,dom){
    var num = $(dom).prev().val();
    $.ajax({
        url:'/admin/member/balance',
        type:'post',
        async:false,
        data:{
            'id':id,
            'num':num
        },
        success:function(data){
            if(data == 'true') {
                window.location.reload();
                $.msgbox({msg: "修改成功", icon: "success"});
            } else
                $.msgbox({msg:"修改失败",icon:"error"});

        },
        error:function(){
            alert('与服务器通信失败，请稍后再试！');
        }
    });
}
function getExcel(){
    window.location.href="/admin/member/getExcel"
}
