
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{config('yyxt.res.bootstrap_css')}}" rel="stylesheet">
    {{--Font Awesome--}}
    <link href="{{config('yyxt.res.font_awesome')}}" rel="stylesheet">
    <!-- Theme style -->
    {{--Theme style--}}
    <link href="{{config('yyxt.res.admin_css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{config('yyxt.res.html5shiv')}}"></script>
    <script src="{{config('yyxt.res.respond')}}"></script>
    <![endif]-->
    <style type="text/css">
        .login-page{ background: linear-gradient(#ccc, #00F7DE);}
        body{overflow-y: hidden;}
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><b>预约管理</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">登录</p>

        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" name="name" class="form-control" placeholder="{{empty($errors->first('name'))?'用户':'用户信息不匹配'}}">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
            </div>
        </form>


        <!-- /.social-auth-links -->

        <br><br>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</body>
</html>
