//单选验证-------------begin----------------
$(document).ready(function () {
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green'
	});

});
$('input[type=radio]').on('ifChecked', function(event){
	$('[data-bv-for=radio]').parents('.form-group').removeClass('has-error');
	$('[data-bv-for=radio]').hide();
	var is_bp = $('#IS_BACK_PASSWORD_DIV input[name="IS_BACK_PASSWORD"]:checked ').val();
	var is_wtu = $('#IS_WEB_TITLE_UNIFIED_DIV input[name="IS_WEB_TITLE_UNIFIED"]:checked ').val();
	var is_wtt = $('#IS_WEB_TOP_TITLE_UNIFIED_DIV input[name="IS_WEB_TOP_TITLE_UNIFIED"]:checked ').val();
	if(is_bp == 1) {
		$('#BACK_PASSWORD_BUTTON_TITLE_DIV').show();
	}else{
		$('#BACK_PASSWORD_BUTTON_TITLE_DIV').hide();
	}
	if(is_wtu == 1) {
		$('#WEB_TITLE_DIV').show();
	}else{
		$('#WEB_TITLE_DIV').hide();
	}
	if(is_wtt == 1) {
		$('#WEB_TOP_TITLE_DIV').show();
	}else{
		$('#WEB_TOP_TITLE_DIV').hide();
	}
	$('#submit').removeAttr('disabled');
});
//单选验证-------------end----------------


$(function() {
	//isValid
	$('.form-horizontal').bootstrapValidator({
		fields: {
		}
	}).on('success.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target);
		var bv = $form.data('bootstrapValidator');
		console.log($form.serialize())
		$.ajax({
			url:'/admin/setting/back/doEdit',
			type:'post',
			async:false,
			data:$form.serialize(),
			success:function(data){
				console.log(data);
				xval = null;
				if(data == 'true'){
                    window.location.href="/admin/setting/back/index";
                    // $.msgbox({msg:"操作成功",icon:"success"});
                }else{
					$.msgbox({msg:"操作失败",icon:"error"});
				}
			},
			error:function(){
				alert('与服务器通信失败，请稍后再试！');
			}
		});
	})
});

function doInit(){
	$.ajax({
		url:'/admin/setting/back/backDoInit',
		type:'post',
		async:false,
		data:{
			_token:$('#_token').val()
		},
		success:function(data){
			console.log(data);
			if(data == 'true'){
                // $.msgbox({msg:"操作成功",icon:"success"});
                window.location.href="/admin/setting/back/index"
            }else{
				$.msgbox({msg:"操作失败",icon:"error"});
			}
		},
		error:function(){
			alert('与服务器通信失败，请稍后再试！');
		}
	});

}