<?php require base_path('/resources/views/admin/base/auid.php'); ?>
<nav class="navbar-default navbar-static-side" role="navigation" style="display:none">
    <div class="sidebar-collapse" >
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element" >
                    <span>
                        
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo e(Session::get(config('custom.AdminUser'))['account']); ?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo e(config('backInfo.IS_MENU_SETTING_TITLE')); ?><b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="javascript:;" onclick="editPassword('/admin/auth/user/password');return false;"><?php echo e(config('backInfo.IS_MENU_SETTING_PASSWORD_TITLE')); ?></a></li>
                        <?php if(config('backInfo.IS_CLEAR_SESSION') == 1): ?>
                            <li><a href="/admin/index/index/clearSession" >清除个人缓存</a></li>
                            <li><a href="/admin/index/index/clearCache" >清除全部缓存</a></li>
                        <?php endif; ?>
                        <li class="divider"></li>
                        <li><a href="/admin/sign/logout"><?php echo e(config('backInfo.IS_MENU_SETTING_LOGOUT_TITLE')); ?></a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    +
                </div>
            </li>
            <li class="first-page">
                <a href="/admin/index/index"><i class="fa fa-table"></i> 首页</a>
            </li>
            <?php $__currentLoopData = session(config('custom.AdminMenu')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($menu1['level'] == 1): ?>
                    <li>
                        <a href="javascript:;"><i class="fa fa-table"></i> <span class="nav-label"><?php echo e($menu1['menu_name']); ?></span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <?php $__currentLoopData = session(config('custom.AdminMenu')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if( $menu2['parent_id'] == $menu1['id'] ): ?>
                                    <li class=""><a href="<?php echo e($menu2['url']); ?>"><?php echo e($menu2['menu_name']); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</nav>