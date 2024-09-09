@extends('admin.base.doom')

{{--页面名,统一名可在doom中修改，此处不引用--}}
@section('title','二维码修改')

{{--页面css--}}
@section('css')
    @parent
    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/fileupload/fileUpload.css" rel="stylesheet">

@stop

{{--页面标题,统一标题可在doom中修改，此处不引用--}}
@section('titlename','二维码修改')

{{--面包屑部分--}}
@section('crumbs')
    <ol class="breadcrumb">
        <li>
            <a>二维码管理</a>
        </li>
        <li class="active">
            <strong>二维码界面</strong>
        </li>
    </ol>
@stop

{{--页面内容--}}
@section('content')
    @parent
    <!-- BEGIN 表单-->
    <form id="validation-form" class="form-horizontal">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-body">
                        <div class="alert alert-danger" role="alert" style="display: none"></div>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" id="id" value="@if(!empty($data)){{$data->id}}@endif"/>
                        <div class="form-group">
                            <label class="control-label col-md-4">个人收益： </label>
                            <!-- 上传图片 -->
                            <div class="col-md-5">
                                <input type="hidden" class="img-value img-value1" id="photo" name="person_img"
                                       value="@if(!empty($data)){{$data->person_img}}@endif"/>
                                <img style="width: 200px;height: 180px" id="upload-img1"
                                     @if(!empty($data)) src="@if(!empty($data)){{$data->person_img}}@endif" @endif>
                                <div class="upload-btn">
                                    <div class="upload-new upload-new1">
                                        <span>添加图片</span>
                                        <input type="file" name="file" class="upload-file" id="upload-file1"
                                               onChange="uploadFile(1)"/>
                                    </div>
                                    <span class="upload-remove upload-remove1">移除图片</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">直推收益： </label>
                            <!-- 上传图片 -->
                            <div class="col-md-5">
                                <input type="hidden" class="img-value img-value2" id="photo1" name="direct_img"
                                       value="@if(!empty($data)){{$data->direct_img}}@endif"/>
                                <img style="width: 200px;height: 180px" id="upload-img2"
                                     @if(!empty($data)) src="@if(!empty($data)){{$data->direct_img}}@endif" @endif>
                                <div class="upload-btn">
                                    <div class="upload-new upload-new2">
                                        <span>添加图片</span>
                                        <input type="file" name="file" class="upload-file" id="upload-file2"
                                               onChange="uploadFile(2)"/>
                                    </div>
                                    <span class="upload-remove upload-remove2">移除图片</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-body">
                        <div class="alert alert-danger" role="alert" style="display: none"></div>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" id="id" value="@if(!empty($data)){{$data->id}}@endif"/>
                        <div class="form-group">
                            <label class="control-label col-md-4">团队收益： </label>
                            <!-- 上传图片 -->
                            <div class="col-md-5">
                                <input type="hidden" class="img-value img-value3" id="photo2" name="team_img"
                                       value="@if(!empty($data)){{$data->team_img}}@endif"/>
                                <img style="width: 200px;height: 180px" id="upload-img3"
                                     @if(!empty($data)) src="@if(!empty($data)){{$data->team_img}}@endif" @endif>
                                <div class="upload-btn">
                                    <div class="upload-new upload-new3">
                                        <span>添加图片</span>
                                        <input type="file" name="file" class="upload-file" id="upload-file3"
                                               onChange="uploadFile(3)"/>
                                    </div>
                                    <span class="upload-remove upload-remove3">移除图片</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">分红收益： </label>
                            <!-- 上传图片 -->
                            <div class="col-md-5">
                                <input type="hidden" class="img-value img-value4" id="photo3" name="profit_img"
                                       value="@if(!empty($data)){{$data->profit_img}}@endif"/>
                                <img style="width: 200px;height: 180px" id="upload-img4"
                                     @if(!empty($data)) src="@if(!empty($data)){{$data->profit_img}}@endif" @endif>
                                <div class="upload-btn">
                                    <div class="upload-new upload-new4">
                                        <span>添加图片</span>
                                        <input type="file" name="file" class="upload-file" id="upload-file4"
                                               onChange="uploadFile(4)"/>
                                    </div>
                                    <span class="upload-remove upload-remove3">移除图片</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">收益对比表： </label>
                            <!-- 上传图片 -->
                            <div class="col-md-5">
                                <input type="hidden" class="img-value img-value5" id="photo4" name="other_img"
                                       value="@if(!empty($data)){{$data->other_img}}@endif"/>
                                <img style="width: 200px;height: 180px" id="upload-img5"
                                     @if(!empty($data)) src="@if(!empty($data)){{$data->other_img}}@endif" @endif>
                                <div class="upload-btn">
                                    <div class="upload-new upload-new5">
                                        <span>添加图片</span>
                                        <input type="file" name="file" class="upload-file" id="upload-file5"
                                               onChange="uploadFile(5)"/>
                                    </div>
                                    <span class="upload-remove upload-remove3">移除图片</span>
                                </div>
                            </div>
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
@stop


{{--页面使用的js--}}
@section('js')
    @parent
    <script src="{{ config('oss.AdminOssUrl') }}/doom/js/fileupload/ajaxfileupload.js"></script>

    <script>
        function uploadFile(id) {
            console.log(id)
            $.ajaxFileUpload({
                url: '/admin/explain/upload',            //需要链接到服务器地址
                secureuri: false,
                fileElementId: 'upload-file' + id,//文件选择框的id属性
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    $('.img-value' + id).val(data.url);
                    $('#upload-img' + id).attr('src', data.url);
                    //图片移除
                    $('.upload-new' + id + ' span').text('重新上传');
                    $('.upload-remove' + id).show();
                    $('.upload-remove' + id).on('click', function () {
                        $('.img-value' + id).val('');
                        $('#upload-img' + id).attr('src', '');
                        $(this).hide();
                        $('.upload-new' + id + ' span').text('上传图片');
                    });
                },
                error: function (data, status, e) {
                    alert(e);
                }
            });
        }

        $(function () {
            //isValid
            $('.form-horizontal').bootstrapValidator({
                fields: {
                    // wx_num: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: '请输入财务微信'
                    //         }
                    //     }
                    // },
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
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');
                $.ajax({
                    url: '/admin/explain/doEdit',
                    type: 'post',
                    async: false,
                    data: $form.serialize(),
                    success: function (data) {
                        xval = null;
                        if (data == 'true') {
                            $.msgbox({msg: "操作成功", icon: "success"});
                            window.location.href = "/admin/explain/index"
                        } else {
                            $.msgbox({msg: "操作失败", icon: "error"});
                            $('#submit').removeAttr('disabled');
                        }
                    },
                    error: function () {
                        alert('与服务器通信失败，请稍后再试！');
                    }
                });
            })
        });
    </script>
@stop

