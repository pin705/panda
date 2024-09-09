<?php require base_path('/vendor/composer/autoload_img.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('backInfo.LOGIN_WEB_TITLE')}}</title>
    <link href="{{config('oss.AdminOssUrl')}}/doom/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{config('oss.AdminOssUrl')}}/doom/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{config('oss.AdminOssUrl')}}/doom/css/animate.css" rel="stylesheet">
    <link href="{{config('oss.AdminOssUrl')}}/doom/css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">

<div class="loginColumns text-center animated fadeInDown">
    <div>
        <br><br><br><br><br><br><br>
        <h3>{{config('backInfo.LOGIN_TITLE')}}</h3>
        <div class="alert alert-danger" role="alert"> @if (count($errors) > 0){{ $errors->first() }}@endif</div>
        <form class="form-horizontal" role="form" action="/admin/signup" method="post">
            <div class="form-group">
                <label class="col-sm-3 control-label">{{config('backInfo.ACCOUNT_TITLE')}}</label>
                <div class="col-sm-6">
                    <input type="text" name="account" class="form-control" required="" placeholder="{{config('backInfo.ACCOUNT_PLACEHOLDER')}}" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{config('backInfo.PASSWORD_TITLE')}}</label>
                <div class="col-sm-6">
                    <input type="password" name="password" class="form-control" required="" placeholder="{{config('backInfo.PASSWORD_PLACEHOLDER')}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary block full-width m-b">{{config('backInfo.LOGIN_BUTTON_TITLE')}}</button>
                    @if(config('backInfo.IS_BACK_PASSWORD') == 1)
                    <a  href="/admin/sign/forgotPassword" class="btn btn-primary block full-width m-b">{{config('backInfo.BACK_PASSWORD_BUTTON_TITLE')}}</a>
                    @endif
                </div>
            </div>
        </form>
        <p class="m-t"> <small>{{config('backInfo.LOGIN_BOTTOM_TITLE')}}
                        </small> </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{Config::get('oss.AdminOssUrl')}}/doom/js/jquery-2.1.1.js"></script>
<script src="{{Config::get('oss.AdminOssUrl')}}/doom/js/bootstrap.min.js"></script>
<script>
    $(function(){
        //判断错误提示是否有内容，有内容直接显示
        var alert_text = $('.alert-danger').text();
        if(null != alert_text && alert_text != " "){
            $('.alert-danger').show();
        }else{
            $('.alert-danger').hide();
        }
    });
</script>
</body>

</html>
