<?php require base_path('/resources/views/admin/base/auid.php'); ?>
<nav class="navbar-default navbar-static-side" role="navigation" style="display:none">
    <div class="sidebar-collapse" >
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element" >
                    <span>
                        {{--<img style="width: 48px;height: 48px;" alt="image" class="img-circle" src="" />--}}
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Session::get(config('custom.AdminUser'))['account']}}</strong>
                             </span> <span class="text-muted text-xs block">{{config('backInfo.IS_MENU_SETTING_TITLE')}}<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="javascript:;" onclick="editPassword('/admin/auth/user/password');return false;">{{config('backInfo.IS_MENU_SETTING_PASSWORD_TITLE')}}</a></li>
                        @if(config('backInfo.IS_CLEAR_SESSION') == 1)
                            <li><a href="/admin/index/index/clearSession" >清除个人缓存</a></li>
                            <li><a href="/admin/index/index/clearCache" >清除全部缓存</a></li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="/admin/sign/logout">{{config('backInfo.IS_MENU_SETTING_LOGOUT_TITLE')}}</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    +
                </div>
            </li>
            <li class="first-page">
                <a href="/admin/index/index"><i class="fa fa-table"></i> 首页</a>
            </li>
            @foreach(session(config('custom.AdminMenu')) as $menu1)
                @if($menu1['level'] == 1)
                    <li>
                        <a href="javascript:;"><i class="fa fa-table"></i> <span class="nav-label">{{$menu1['menu_name']}}</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            @foreach( session(config('custom.AdminMenu')) as $menu2)
                                @if( $menu2['parent_id'] == $menu1['id'] )
                                    <li class=""><a href="{{$menu2['url']}}">{{$menu2['menu_name']}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>