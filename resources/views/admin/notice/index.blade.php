@extends('admin.base.doom')

{{--页面名,统一名可在doom中修改，此处不引用--}}
@section('title','公告管理')

{{--页面css--}}
@section('css')
    @parent
    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/fileupload/fileUpload.css" rel="stylesheet">
    <link href="{{Config::get('oss.AdminOssUrl')}}/doom/css/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet">
@stop

{{--页面标题,统一标题可在doom中修改，此处不引用--}}
@section('titlename','公告修改')

{{--面包屑部分--}}
@section('crumbs')
    <ol class="breadcrumb">
        <li>
            <a>公告管理</a>
        </li>
        <li class="active">
            <strong>公告修改</strong>
        </li>
    </ol>
@stop

{{--页面内容--}}
@section('content')
    @parent
    <!-- BEGIN 表单-->
    <form id="validation-form" class="form-horizontal">
        <div class="modal-body">
            <div class="form-body">
                <div class="alert alert-danger" role="alert" style="display: none"></div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" id="id" value="@if(!empty($data)){{$data->id}}@endif"/>
                <div class="form-group">
                    <h3><label class="control-label col-md-3">公告： </label></h3>
                    <div class="col-md-2">
{{--                        <input type="text" name="notice"  value="@if(!empty($data)){{$data->notice}}@endif" class="form-control" />--}}
                        <textarea type="text" name="notice" style="width: 500px;height: 120px">@if(!empty($data)){{$data->notice}}@endif</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <h3><label class="control-label col-md-3">充值比例： </label></h3>
                    <div class="col-md-2">
                        {{--                        <input type="text" name="notice"  value="@if(!empty($data)){{$data->notice}}@endif" class="form-control" />--}}
                        <textarea type="text" name="recharge_ratio" style="width: 500px;height: 120px">@if(!empty($data)){{$data->recharge_ratio}}@endif</textarea>
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
@stop


{{--页面使用的js--}}
@section('js')
    @parent
    <script src="{{ config('oss.AdminOssUrl') }}/doom/js/fileupload/ajaxfileupload.js"></script>
    <script>
        $(function() {
            //isValid
            $('.form-horizontal').bootstrapValidator({
                fields: {
                    notice: {
                        validators: {
                            notEmpty: {
                                message: '请输入公告'
                            }
                        }
                    },
                    recharge_ratio: {
                        validators: {
                            notEmpty: {
                                message: '请输入充值比例'
                            }
                        }
                    },
                }
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');
                $.ajax({
                    url:'/admin/notice/doEdit',
                    type:'post',
                    async:false,
                    data:$form.serialize(),
                    success:function(data){
                        xval = null;
                        if(data == 'true'){
                            $.msgbox({msg:"操作成功",icon:"success"});
                            window.location.href="/admin/notice/index"
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
@stop

