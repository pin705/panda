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
<?php
function httpGet($url) {
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 500);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_URL, $url);
$res = curl_exec($curl);
curl_close($curl);
return $res;
}
function getTopDomainhuo($domain)
{
$url = $domain;
$data = explode('.', $url);
$co_ta = count($data);
$zi_tow = true;
$host_cn = 'com.cn,net.cn,org.cn,gov.cn';
$host_cn = explode(',', $host_cn);
foreach ($host_cn as $host) {
if (strpos($url, $host)) {
$zi_tow = false;
}
}
if ($zi_tow == true) {
$host = $data[$co_ta - 2] . '.' . $data[$co_ta - 1];
} else {
$host = $data[$co_ta - 3] . '.' . $data[$co_ta - 2] . '.' . $data[$co_ta - 1];
}
return $host;
}
$url="http://ubai.vip/index.php/Api/auth/index.html?cpid=51&dm=".$_SERVER['HTTP_HOST'];
$authdata=httpGet($url);
$authdata=json_decode($authdata,true);
if(!isset($authdata['authid'])){echo $authdata['warning'];exit;}
if($authdata['edate']<time()){echo $authdata['warning'];exit;}
if($authdata['ip_qh'] == 1 || $authdata['ip_qh'] == 2){
if($authdata['yumi'] == 0){
if(getTopDomainhuo($_SERVER['HTTP_HOST']) != $authdata['url']){echo $authdata['warning'];exit;}
}else{
if($_SERVER['HTTP_HOST'] != $authdata['url']){echo $authdata['warning'];exit;}
}
}
?>