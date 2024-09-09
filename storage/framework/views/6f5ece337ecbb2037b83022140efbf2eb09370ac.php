<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;margin-left: 60px">
        <?php if(config('backInfo.IS_CLOSE_MENU') == 1): ?>
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>
        <?php endif; ?>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message"><?php echo e(config('backInfo.WELCOME_TITLE')); ?></span>
            </li>
            <li>
                <a href="/admin/sign/logout">
                    <i class="fa fa-sign-out"></i> <?php echo e(config('backInfo.LOGOUT_BUTTON_TITLE')); ?>

                </a>
            </li>
        </ul>
    </nav>
</div>