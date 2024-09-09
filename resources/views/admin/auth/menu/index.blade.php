@extends('admin.base.doom')

{{--页面名,统一名可在doom中修改，此处不引用--}}
@section('title','xx管理系统|后台菜单')

{{--页面css--}}
@section('css')
	@parent
	<link href="{{ config('oss.AdminOssUrl') }}/doom/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
@stop

{{--页面标题,统一标题可在doom中修改，此处不引用--}}
@section('titlename','xx管理系统|后台菜单')

{{--面包屑部分--}}
@section('crumbs')
	<ol class="breadcrumb">
		<li>
			<a href="/admin/index/index">首页</a>
		</li>
		<li>
			<a>权限管理</a>
		</li>
		<li class="active">
			<strong>后台菜单</strong>
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
							<div class="col-lg-1">
								<a href="javascript:" onclick="update('/admin/auth/menu/update?id=');return false;" class="btn btn-success">添加菜单</a>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<!-- 表格 -->
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="menuTable">
								<thead>
								<tr>
									<th>编号</th>
									<th>菜单名称</th>
									<th>上级菜单</th>
									<th>菜单链接</th>
									<th>排序</th>
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
	<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/message/message.min.js"></script>
	<script src="{{ config('oss.AdminOssUrl') }}/admin/js/auth/menu.js"></script>
@stop

