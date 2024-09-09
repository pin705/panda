@extends('admin.base.doom')

{{--页面名,统一名可在doom中修改，此处不引用--}}
@section('title','商城管理')

{{--页面css--}}
@section('css')
    @parent
    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="{{Config::get('oss.AdminOssUrl')}}/doom/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
@stop

{{--页面标题,统一标题可在doom中修改，此处不引用--}}
@section('titlename','商城列表')

{{--面包屑部分--}}
@section('crumbs')
    <ol class="breadcrumb">
        <li>
            <a>商城管理</a>
        </li>
        <li class="active">
            <strong>商品列表</strong>
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
                                <h3>商品列表</h3>
                            </div>
                            <div class="col-lg-1">
                                <a href="javascript:" onclick="update('/admin/goods/update?id=');return false;" class="btn btn-success">添加商品</a>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!-- 表格 -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="goodsTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>名称</th>
                                    <th>描述</th>
                                    <th>数量</th>
                                    <th>金币</th>
                                    <th>图片</th>
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
    <!-- 底部 -->
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
    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{Config::get('oss.AdminOssUrl')}}/doom/js/plugins/fullcalendar/moment.min.js"></script>
    <!-- Date range picker：参考：http://www.daterangepicker.com/-->
    <script src="{{Config::get('oss.AdminOssUrl')}}/doom/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/message/message.min.js"></script>
    <script src="{{ config('oss.AdminOssUrl') }}/admin/js/goods/index.js"></script>
@stop

