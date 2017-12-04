<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="wap-font-scale" content="no">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- plugs -->
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.11.1/umd/popper.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    {{--<script src="https://cdn.bootcss.com/hammer.js/2.0.8/hammer.min.js"></script>--}}
    <title>预约缴费</title>
    <meta name="keywords" content="keywords">
    <meta name="description" content="description">
</head>
<body style="max-width: 640px;" class="mx-auto">
    <h5 class="title text-center mt-3 font-weight-bold">预约缴费</h5>
    <form name="pay_form">
        <input type="hidden" name="pay" value="0.01">
        <div class="form-group row mt-5 mx-3">
            <label for="count" class="col-3 px-0 col-form-label text-right font-weight-bold">金额</label>
            <div class="input-group col-9">
                <div class="input-group-addon border-0">￥</div>
                <input type="text" disabled class="form-control border-0" id="count" value="10.00">
            </div>
        </div>
        <div class="form-group row mt-3 mx-3">
            <label for="addons" class="col-3 px-0 col-form-label text-right font-weight-bold">备注</label>
            <div class="col-9">
                <input type="text" class="form-control border-0" name="addons" disabled id="addons" value="预约挂号">
            </div>
        </div>
        <div class="form-group row mx-3">
            <div class="col-12">
                <input type="submit" class="btn btn-primary btn-block" name="submit" value="微信支付">
            </div>
        </div>
    </form>
    {{--<form class="form-horizontal">--}}
        {{--<input type="hidden" name="pay" value="0.01">--}}
        {{--<div class="form-group">--}}
            {{--<label for="pay" class="col-2 control-label">金额</label>--}}
            {{--<div class="col-10">--}}
                {{--<span class="form-control">￥10.00</span>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label for="pay" class="col-2 control-label">备注</label>--}}
            {{--<div class="col-10">--}}
                {{--<span class="form-control">预约挂号</span>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<div class="col-12">--}}
                {{--<button type="submit" class="btn btn-primary btn-block">微信支付</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</form>--}}
</body>
</html>