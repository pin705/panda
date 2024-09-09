<!-- 表单验证 -->
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/fileupload/fileUpload.css" rel="stylesheet">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"
		aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">编辑用户头像</h4>
</div>
<!-- BEGIN 表单-->
<form action="/admin/auth/user/doEdit" id="validation-form" class="form-horizontal">
	<div class="modal-body">
		<input type="hidden" name="id" id="user_id" value="@if(!empty($data)){{$data->id}}@endif" />
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-md-4">用户头像头像 </label>
				<!-- 上传图片 -->
				<div class="col-md-5">
					<input type="hidden"  class="img-value img-value1" id="photo" name="photo" value="@if(!empty($data)){{$data->head}}@endif" />
					<img style="width: 200px;height: 180px" id="upload-img1" @if(!empty($data)) src="@if(!empty($data)){{$data->head}}@endif" @endif>
					<div class="upload-btn">
						<div class="upload-new upload-new2">
							<span>添加图片</span>
							<input type="file" name="file" class="upload-file" id="upload-file1" onChange="uploadFile(1)"/>
						</div>
						<span class="upload-remove upload-remove1">移除图片</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">保存</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	</div>
</form>
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/fileupload/ajaxfileupload.js"></script>
<script>
    function uploadFile(id){
        console.log(id)
        $.ajaxFileUpload({
            url:'/admin/head/upload',            //需要链接到服务器地址
            secureuri:false,
            fileElementId:'upload-file'+id,//文件选择框的id属性
            type: 'post',
            dataType:'json',
            success: function(data){
                $('.img-value'+id).val(data.url);
                $('#upload-img'+id).attr('src',data.url);
                //图片移除
                $('.upload-new'+id+' span').text('重新上传');
                $('.upload-remove'+id).show();
                $('.upload-remove'+id).on('click', function(){
                    $('.img-value'+id).val('');
                    $('#upload-img'+id).attr('src','');
                    $(this).hide();
                    $('.upload-new'+id+' span').text('上传图片');
                });
            },
            error: function (data, status, e){
                alert(e);
            }
        });
    }


    $(function() {
        //isValid
        $('.form-horizontal').bootstrapValidator({
            fields: {
                // name: {
                //     validators: {
                //         notEmpty: {
                //             message: '请输入礼包名称'
                //         }
                //     }
                // },
                // stock: {
                //     validators: {
                //         notEmpty: {
                //             message: '请输入礼包库存'
                //         }
                //     }
                // },
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            $.ajax({
                url:'/admin/head/doEdit',
                type:'post',
                async:false,
                data:$form.serialize(),
                success:function(data){
                    xval = null;
                    if(data == 'true'){
                        $.msgbox({msg:"操作成功",icon:"success"});
                        window.location.href="/admin/head/index"
                    }else {
                        $.msgbox({msg: "操作失败", icon: "error"});
                        $('#submit').removeAttr('disabled');
                    }
                },
                error:function(){
                    alert('与服务器通信失败，请稍后再试！');
                }
            });
        })
    });




</script>
