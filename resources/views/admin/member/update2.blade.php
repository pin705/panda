<!-- 表单验证 -->
<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"
            aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">编辑</h4>
</div>
<!-- BEGIN 表单-->
<form action="/admin/auth/user/doEdit" id="validation-form" class="form-horizontal">
    <div class="modal-body">
        <input type="hidden" name="id" id="user_id" value="@if(!empty($data)){{$data->id}}@endif" />
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-4">我的上级ID： {{$first}}</label>
            </div>
        </div>
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-4">我的团队人数： {{$num}}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">保存</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    </div>
</form>

<script>
    $(function() {
        //isValid
        $('.form-horizontal').bootstrapValidator({
            fields: {
                nickname: {
                    validators: {
                        notEmpty: {
                            message: '请输入昵称'
                        }
                    }
                }
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            $.ajax({
                url:'/admin/member/doEdit',
                type:'post',
                async:false,
                data:$form.serialize(),
                success:function(data){
                    xval = null;
                    if(data == 'true'){
                        $('.modal').modal('hide');
                        table.ajax.reload();
                        $.msgbox({msg:"操作成功",icon:"success"});
                    }else
                        $.msgbox({msg:"操作失败",icon:"error"});
                },
                error:function(){
                    alert('与服务器通信失败，请稍后再试！');
                }
            });
        })
    });
</script>
