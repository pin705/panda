function uploadFile(){
	$.ajaxFileUpload({
		url:'/admin/setting/web/upload',
		secureuri:false,
		fileElementId:'upload-file',//文件选择框的id属性
		type: 'post',
		dataType:'json',
		data:{
			folder:'member'
		},
		success: function(data){
			$('.img-value').val(data.url);
			$('#upload-img').attr('src',data.url);
		},
		error: function (data, status, e){
			alert(e);
		}
	});
}

$('.form-horizontal').bootstrapValidator({
	fields: {
	}
}).on('success.form.bv', function (e) {
	e.preventDefault();
	var $form = $(e.target);
	var bv = $form.data('bootstrapValidator');
	$.ajax({
		url: '/admin/setting/web/doEdit',
		type: 'post',
		async: false,
		data: $form.serialize(),
		success: function (data) {
			xval = null;
			if (data == 'true') {
				$.msgbox({msg: "操作成功", icon: "success"});
				location.reload();
			} else
				$.msgbox({msg: "操作失败", icon: "error"});
		},
		error: function () {
			alert('与服务器通信失败，请稍后再试！');
		}
	});
});

