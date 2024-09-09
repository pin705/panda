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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>   @if(config('backInfo.IS_WEB_TITLE_UNIFIED') == 0) @section('title') {{config('backInfo.WEB_TITLE')}} @show @else {{config('backInfo.WEB_TITLE')}} @endif </title>
    <link href="{{config('oss.AdminOssUrl')}}/doom/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{config('oss.AdminOssUrl')}}/doom/font-awesome/css/font-awesome.css" rel="stylesheet">
    @yield('middle_css')

    <link href="{{config('oss.AdminOssUrl')}}/doom/css/animate.css" rel="stylesheet">
    <link href="{{config('oss.AdminOssUrl')}}/doom/css/style.css" rel="stylesheet">
    <link href="{{config('oss.AdminOssUrl')}}/doom/css/plugins/message/msgbox/msgbox.css" rel="stylesheet" />
    @yield('css')
    <style>
        .dataTables_filter .input-sm {
            font-size: 12px;
        }
    </style>
</head>

<body>
<div id="wrapper">
    <!-- 左边菜单 -->
    @include('admin.base.menu')

    <div id="page-wrapper" class="gray-bg">
        @include('admin.base.header')
        <div class="row  border-bottom white-bg dashboard-header">

            <div class="col-sm-5">
                <h2>
                    @if(config('backInfo.IS_WEB_TOP_TITLE_UNIFIED') == 0)
                        @section('titlename') {{config('backInfo.WEB_TOP_TITLE')}} @show
                    @else
                        {{Session::get('config(\'custom.AdminUser\')')['title']}}
{{--                            {{config('backInfo.WEB_TOP_TITLE')}}--}}
                    @endif
                </h2>
                <!-- 面包屑 -->
                @yield('crumbs')

            </div>

        </div>
        @yield('content')

        <div style="height: 30px"></div>
        @include('admin.base.footer')


    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/jquery-2.1.1.js"></script>
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/bootstrap.min.js"></script>
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/message/message.min.js"></script>
<!-- 验证框架 -->
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/bootstrap-validator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/bootstrap-validator/language/zh_CN.js" type="text/javascript"></script>
<!-- Custom and plugin javascript -->
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/inspinia.js"></script>
<script src="{{ config('oss.AdminOssUrl') }}/doom/js/plugins/pace/pace.min.js"></script>
<script src="{{ config('oss.AdminOssUrl') }}/admin/js/auth/base.js"></script>


@yield('js')



</body>
</html>
