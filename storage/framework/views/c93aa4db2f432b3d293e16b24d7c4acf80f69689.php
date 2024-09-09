<?php $__env->startSection('title','用户管理'); ?>


<?php $__env->startSection('css'); ?>
    ##parent-placeholder-2f84417a9e73cead4d5c99e05daff2a534b30132##
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('titlename','用户列表'); ?>


<?php $__env->startSection('crumbs'); ?>
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
                            </div>
                            
                                
                                    
                                
                            
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
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    ##parent-placeholder-93f8bb0eb2c659b85694486c41717eaf0fe23cd4##
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/dataTables/datatables.min.js"></script>
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/message/message.min.js"></script>
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/api/upood.js"></script>
    <script src="<?php echo e(config('oss.AdminOssUrl')); ?>/admin/js/member/index.js"></script>
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.base.doom', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>