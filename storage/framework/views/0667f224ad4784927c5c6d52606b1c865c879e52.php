<?php $__env->startSection('title','客服管理'); ?>


<?php $__env->startSection('css'); ?>
    ##parent-placeholder-2f84417a9e73cead4d5c99e05daff2a534b30132##
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/fileupload/fileUpload.css" rel="stylesheet">

<?php $__env->stopSection(); ?>


<?php $__env->startSection('titlename','客服修改'); ?>


<?php $__env->startSection('crumbs'); ?>
    <ol class="breadcrumb">
        <li>
            <a>客服管理</a>
        </li>
        <li class="active">
            <strong>客服修改</strong>
        </li>
    </ol>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    ##parent-placeholder-040f06fd774092478d450774f5ba30c5da78acc8##
    <!-- BEGIN 表单-->
    <form id="validation-form" class="form-horizontal">
        <div class="modal-body">
            <div class="form-body">
                <div class="alert alert-danger" role="alert" style="display: none"></div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" id="id" value="<?php if(!empty($data)): ?><?php echo e($data->id); ?><?php endif; ?>"/>
                <div class="form-group">
                    <label class="control-label col-md-4">客服二维码： </label>
                    <!-- 上传图片 -->
                    <div class="col-md-5">
                        <input type="hidden"  class="img-value img-value1" id="photo" name="img" value="<?php if(!empty($data)): ?><?php echo e($data->img); ?><?php endif; ?>" />
                        <img style="width: 200px;height: 180px" id="upload-img1" <?php if(!empty($data)): ?> src="<?php if(!empty($data)): ?><?php echo e($data->img); ?><?php endif; ?>" <?php endif; ?>>
                        <div class="upload-btn">
                            <div class="upload-new upload-new1">
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
            <button type="submit" id="submit" class="btn btn-primary" style="margin-bottom: 50px">提交</button>
        </div>
    </form>
    <!-- 模态框 -->
    <div class="modal inmodal fade" id="baseModal">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 750px">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/fileupload/ajaxfileupload.js"></script>

    <script>
        function uploadFile(id){
            console.log(id)
            $.ajaxFileUpload({
                url:'/admin/customer/upload',            //需要链接到服务器地址
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
                    // start_time: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: '请输入开始时间'
                    //         }
                    //     }
                    // },
                    // end_time: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: '请输入结束时间'
                    //         }
                    //     }
                    // },
                }
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');
                $.ajax({
                    url:'/admin/customer/doEdit',
                    type:'post',
                    async:false,
                    data:$form.serialize(),
                    success:function(data){
                        xval = null;
                        if(data == 'true'){
                            $.msgbox({msg:"操作成功",icon:"success"});
                            window.location.href="/admin/customer/index"
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.base.doom', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>