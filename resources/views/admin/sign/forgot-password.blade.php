<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('backInfo.LOGIN_WEB_TITLE')}}</title>
    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/animate.css" rel="stylesheet">
    <link href="{{ config('oss.AdminOssUrl') }}/doom/css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">

<div class="loginColumns text-center animated fadeInDown">
    <div>
        <br><br><br><br><br><br><br>
        <h3>重置密码</h3>
        <div class="alert alert-danger" role="alert"> @if (count($errors) > 0){{ $errors->first() }}@endif</div>

        <form  class="form-horizontal" action="/admin/sign/updatePassword" method="post">

            <div class="form-group">
                <label class="col-sm-3 control-label">账号：</label>
                <div class="col-sm-6">
                    <input type="text" name="account" class="form-control" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">密码：</label>
                <div class="col-sm-6">
                    <input type="password" name="password" class="form-control" required="">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">绑定手机：</label>
                <div class="col-sm-6">
                    <input type="text" name="phone" class="form-control" required="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">验证码：</label>
                <div class="col-sm-4">
                    <input type="text" name="code" class="form-control" required="">
                </div>
                <a href="javascript:" id="getcode" class="btn btn-primary " style="float:left;">获取验证码</a>

            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <button type="submit" id="submit" class="btn btn-primary block full-width m-b">提交</button>
                    <a  href="/admin/sign" class="btn btn-primary block full-width m-b">登陆</a>

                </div>
            </div>

        </form>
        <p class="m-t"> <small> 一兜 &copy; {{ date('Y') }}</small> </p>
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
    $('#getcode').on('click',function(){
        var phone = $('input[name="phone"]').val();
        $.ajax({
            url:'/admin/sign/getcode',
            type:'post',
            data:{
                phone:phone
            },
            success:function(data){
                alert(data.msg)
            }
        })

    });


</script>
</body>

</html>
