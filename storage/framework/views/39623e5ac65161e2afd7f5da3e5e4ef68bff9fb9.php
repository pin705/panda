<?php $__env->startSection('title','用户头像管理'); ?>


<?php $__env->startSection('css'); ?>
    ##parent-placeholder-2f84417a9e73cead4d5c99e05daff2a534b30132##
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="<?php echo e(Config::get('oss.AdminOssUrl')); ?>/doom/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('titlename','用户头像列表'); ?>


<?php $__env->startSection('crumbs'); ?>
    <ol class="breadcrumb">
        <li>
            <a>用户头像管理</a>
        </li>
        <li class="active">
            <strong>用户头像列表</strong>
        </li>
    </ol>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    ##parent-placeholder-040f06fd774092478d450774f5ba30c5da78acc8##
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-lg-11">
                                <h3>用户头像列表</h3>
                            </div>
                            <div class="col-lg-1">
                                <a href="javascript:" onclick="update('/admin/head/update?id=');return false;" class="btn btn-success">添加头像</a>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <!-- 表格 -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="headTable">
                                <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>头像</th>
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo e(Config::get('oss.AdminOssUrl')); ?>/doom/js/plugins/fullcalendar/moment.min.js"></script>
    <!-- Date range picker：参考：http://www.daterangepicker.com/-->
    <script src="<?php echo e(Config::get('oss.AdminOssUrl')); ?>/doom/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/message/message.min.js"></script>
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/admin/js/head/index.js"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.base.doom', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>