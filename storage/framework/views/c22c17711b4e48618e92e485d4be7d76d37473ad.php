<!--
*
*  INSPINIA - Responsive Admin Theme
*  version 2.6
*
-->

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>   <?php if(config('backInfo.IS_WEB_TITLE_UNIFIED') == 0): ?> <?php $__env->startSection('title'); ?> <?php echo e(config('backInfo.WEB_TITLE')); ?> <?php echo $__env->yieldSection(); ?> <?php else: ?> <?php echo e(config('backInfo.WEB_TITLE')); ?> <?php endif; ?> </title>
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/font-awesome/css/font-awesome.css" rel="stylesheet">
    <?php echo $__env->yieldContent('middle_css'); ?>

    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/animate.css" rel="stylesheet">
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/style.css" rel="stylesheet">
    <link href="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/css/plugins/message/msgbox/msgbox.css" rel="stylesheet" />
    <?php echo $__env->yieldContent('css'); ?>
    <style>
        .dataTables_filter .input-sm {
            font-size: 12px;
        }
    </style>
</head>

<body>
<div id="wrapper">
    <!-- 左边菜单 -->
    <?php echo $__env->make('admin.base.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div id="page-wrapper" class="gray-bg">
        <?php echo $__env->make('admin.base.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row  border-bottom white-bg dashboard-header">

            <div class="col-sm-5">
                <h2>
                    <?php if(config('backInfo.IS_WEB_TOP_TITLE_UNIFIED') == 0): ?>
                        <?php $__env->startSection('titlename'); ?> <?php echo e(config('backInfo.WEB_TOP_TITLE')); ?> <?php echo $__env->yieldSection(); ?>
                    <?php else: ?>
                        <?php echo e(Session::get('config(\'custom.AdminUser\')')['title']); ?>


                    <?php endif; ?>
                </h2>
                <!-- 面包屑 -->
                <?php echo $__env->yieldContent('crumbs'); ?>

            </div>

        </div>
        <?php echo $__env->yieldContent('content'); ?>

        <div style="height: 30px"></div>
        <?php echo $__env->make('admin.base.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    </div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/jquery-2.1.1.js"></script>
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/bootstrap.min.js"></script>
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/message/message.min.js"></script>
<!-- 验证框架 -->
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/bootstrap-validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/bootstrap-validator/language/zh_CN.js" type="text/javascript"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/inspinia.js"></script>
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/doom/js/plugins/pace/pace.min.js"></script>
<script src="<?php echo e(config('oss.AdminOssUrl')); ?>/admin/js/auth/base.js"></script>


<?php echo $__env->yieldContent('js'); ?>



</body>
</html>
