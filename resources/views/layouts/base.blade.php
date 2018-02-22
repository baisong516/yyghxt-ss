<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('yyxt.web_name')}}</title>
    {{--Tell the browser to be responsive to screen width--}}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{config('yyxt.res.bootstrap_css')}}" rel="stylesheet">
    {{--Font Awesome--}}
    <link href="{{config('yyxt.res.font_awesome')}}" rel="stylesheet">
    @yield('css')
    {{--Theme style--}}
    <link href="{{config('yyxt.res.admin_css')}}" rel="stylesheet">
    <link href="{{config('yyxt.res.admin_skin')}}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{config('yyxt.res.html5shiv')}}"></script>
    <script src="{{config('yyxt.res.respond')}}"></script>
    <![endif]-->
</head>
{{--<!----}}
{{--BODY TAG OPTIONS:--}}
{{--=================--}}
{{--Apply one or more of the following classes to get the--}}
{{--desired effect--}}
{{--|---------------------------------------------------------|--}}
{{--| SKINS         | skin-blue                               |--}}
{{--|               | skin-black                              |--}}
{{--|               | skin-purple                             |--}}
{{--|               | skin-yellow                             |--}}
{{--|               | skin-red                                |--}}
{{--|               | skin-green                              |--}}
{{--|---------------------------------------------------------|--}}
{{--|LAYOUT OPTIONS | fixed                                   |--}}
{{--|               | layout-boxed                            |--}}
{{--|               | layout-top-nav                          |--}}
{{--|               | sidebar-collapse                        |--}}
{{--|               | sidebar-mini                            |--}}
{{--|---------------------------------------------------------|--}}
{{---->--}}
<body class="hold-transition {{config('yyxt.res.app_skin')}} sidebar-mini">
<div class="wrapper">
    {{--Main Header--}}
    <header class="main-header">
        {{--Logo--}}
        <a href="/home" class="logo" >
            {{--mini logo for sidebar mini 50x50 pixels--}}
            <span class="logo-mini"><b>{{config('yyxt.short_name')}}</b></span>
            {{--logo for regular state and mobile devices--}}
            <span class="logo-lg"><b>{{config('yyxt.web_name')}}</b></span>
        </a>
         {{--Header Navbar--}}
        <nav class="navbar navbar-static-top" role="navigation" >
            {{--Sidebar toggle button--}}
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            {{--Navbar Right Menu--}}
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    {{--用户账户菜单--}}
                    <li class="dropdown user user-menu">
                        {{--Menu Toggle Button--}}
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <p>
                                    {{ Auth::user()->realname }}
                                    <small>Since {{Auth::user()->created_at}}</small>
                                </p>
                            </li>
                            {{--Menu Footer--}}
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('profiles.edit',Auth::user()->id)}}" class="btn btn-default btn-flat">个人设置</a>
                                </div>
                                <div class="pull-right">
                                    <a href="javascript:;" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">退出</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    {{--Left side column. contains the logo and sidebar--}}
    <aside class="main-sidebar">
        {{--sidebar: style can be found in sidebar.less--}}
        <section class="sidebar">
            {{--左边栏主菜单--}}
            @include('layouts.menu')
            {{--/左边栏主菜单--}}
        </section>
        {{--/.sidebar --}}
    </aside>

    {{--Content Wrapper. Contains page content--}}
    <div class="content-wrapper">
         {{--Content Header (Page header)--}}
        <section class="content-header">
            <h1>
                {{isset($pageheader)?$pageheader:'PageHeader'}}
                <small>{{isset($pagedescription)?$pagedescription:'PageSubtitle'}}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i>Level</a></li>
                <li class="active">@yield('position')</li>
            </ol>
        </section>

         {{--Main content--}}
        <section class="content container-fluid">
            @section('content') @show
        </section>
        {{--/.content--}}
    </div>
     {{--/.content-wrapper--}}

     {{--Main Footer --}}
    <footer class="main-footer">
        {{--To the right--}}
        <div class="pull-right hidden-xs">
            {{config('yyxt.version')}}
        </div>
        {{--Default to the left--}}
        <strong>Copyright &copy; 2018 <a href="#">{{config('yyxt.short_name')}}</a>.</strong> All rights reserved.
    </footer>


    {{--Add the sidebar's background. This div must be placed--}}
    {{--immediately after the control sidebar --}}
    <div class="control-sidebar-bg"></div>
</div>
{{--./wrapper --}}

{{--REQUIRED JS SCRIPTS --}}
{{--jQuery--}}
<script src="{{config('yyxt.res.jquery')}}"></script>
{{--Bootstrap 3.3.7--}}
<script src="{{config('yyxt.res.bootstrap_js')}}"></script>
{{--AdminLTE App--}}
<script src="{{config('yyxt.res.admin_js')}}"></script>
@section('javascript') @show
<script type="text/javascript">
    // 判断是否为移动端
    function is_mobile() {
        var regex_match = /(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|jigs browser|hiptop|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220)/i;
        var u = navigator.userAgent;
        var result = regex_match.exec(u);
        if (null == result) {
            return false
        } else {
            return true
        }
    }
    if(is_mobile()){
        $("body").removeClass('sidebar-mini sidebar-collapse');
    }
</script>
</body>
</html>
