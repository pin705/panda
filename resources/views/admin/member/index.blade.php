@extends('admin.base.doom')

{{--页面名,统一名可在doom中修改，此处不引用--}}
@section('title','用户管理')

{{--页面css--}}
@section('css')
    @parent
    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
@stop

{{--页面标题,统一标题可在doom中修改，此处不引用--}}
@section('titlename','用户列表')

{{--面包屑部分--}}
@section('crumbs')
    <ol class="breadcrumb">
        <li>
            <a href="/admin/index/index">首页</a>
        </li>
        <li>
            <a>用户管理</a>
        </li>
        <li class="active">
            <strong>用户列表</strong>
        </li>
    </ol>
@stop

{{--页面内容--}}
@section('content')
    @parent
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-lg-11">
                            </div>
                            {{--<div class="col-lg-1">--}}
                                {{--<div class="col-lg-1">--}}
                                    {{--<button onclick="getExcel()" class="btn btn-success">导出Excel</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!-- 表格 -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="memberTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>用户ID</th>
                                    <th>昵称</th>
                                    <th>姓名</th>
                                    <th>头像</th>
                                    <th>金币</th>
                                    <th>累计鲜果</th>
                                    <th>现有鲜果</th>
                                    <th>手机号</th>
                                    <th>微信号</th>
                                    <th>QQ号</th>
                                    <th>微信收款码</th>
                                    <th>支付宝收款码</th>
                                    <th>层级</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 模态框 -->
    <div class="modal fade" id="baseModal">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
@stop


{{--页面使用的js--}}
@section('js')
    @parent
    <script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/dataTables/datatables.min.js"></script>
    <script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/message/message.min.js"></script>
    <script src="{{ config('oss.AdminOssUrl') }}/doom/js/api/upood.js"></script>
    <script src="{{ config('oss.AdminOssUrl') }}/admin/js/member/index.js"></script>
    
@stop

