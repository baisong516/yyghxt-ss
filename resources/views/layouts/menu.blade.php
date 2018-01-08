<ul class="sidebar-menu" data-widget="tree">
    <li class="header">菜单</li>
    <li class="{{Request::is('home')?'active':''}}"><a href="/home"><i class="fa fa-dashboard"></i> <span>首页</span></a></li>
    {{--用户管理--}}
    <li class="treeview {{Request::is('sys/*')?'active':''}}">
        <a href="#"><i class="fa fa-cogs"></i> <span>系统</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-users')
            <li class="{{Request::is('sys/users*')?'active':''}}"><a href="{{route('users.index')}}"><i class="fa fa-users"></i><span>用户</span></a></li>
            @endability
            @ability('superadministrator', 'read-roles')
            <li class="{{Request::is('sys/roles*')?'active':''}}"><a href="{{route('roles.index')}}"><i class="fa fa-vcard"></i><sapn>角色</sapn></a></li>
            @endability
            @ability('superadministrator', 'read-permissions')
            <li class="{{Request::is('sys/permissions*')?'active':''}}"><a href="{{route('permissions.index')}}"><i class="fa fa-exclamation-triangle"></i><span>权限</span></a></li>
            @endability
            @ability('superadministrator', 'read-departments')
            <li class="{{Request::is('sys/departments*')?'active':''}}"><a href="{{route('departments.index')}}"><i class="fa fa-list"></i><span>部门</span></a></li>
            @endability

            {{--个人资料--}}
            <li class="{{Request::is('sys/profiles*')?'active':''}}"><a href="{{route('profiles.edit',Auth::user()->id)}}"><i class="fa fa-user"></i><span>个人资料</span></a></li>
        </ul>
    </li>
    {{-- 系统配置 仅限系统管理员和超级管理员--}}
    @role('superadministrator|administrator')
    {{--系统配置--}}
    <li class="treeview {{Request::is('sysconf/*')?'active':''}}">
        <a href="#"><i class="fa fa-yelp"></i> <span>设置</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-hospitals')
            <li class="{{Request::is('sysconf/hospitals*')?'active':''}}"><a href="{{route('hospitals.index')}}"><i class="fa fa-hospital-o"></i><span>医院设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-offices')
            <li class="{{Request::is('sysconf/offices*')?'active':''}}"><a href="{{route('offices.index')}}"><i class="fa fa-cubes"></i><span>科室设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-diseases')
            <li class="{{Request::is('sysconf/diseases*')?'active':''}}"><a href="{{route('diseases.index')}}"><i class="fa fa-medkit"></i><span>病种设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-doctors')
            <li class="{{Request::is('sysconf/doctors*')?'active':''}}"><a href="{{route('doctors.index')}}"><i class="fa fa-user-md"></i><span>医生设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-medias')
            <li class="{{Request::is('sysconf/medias*')?'active':''}}"><a href="{{route('medias.index')}}"><i class="fa fa-medium"></i><span>媒体来源设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-web_types')
            <li class="{{Request::is('sysconf/webtypes*')?'active':''}}"><a href="{{route('webtypes.index')}}"><i class="fa fa-internet-explorer"></i><span>网站类型设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-customer_types')
            <li class="{{Request::is('sysconf/customertypes*')?'active':''}}"><a href="{{route('customertypes.index')}}"><i class="fa fa-user-plus"></i><span>客户类型设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-customer_conditions')
            <li class="{{Request::is('sysconf/customerconditions*')?'active':''}}"><a href="{{route('customerconditions.index')}}"><i class="fa fa-spinner"></i><span>客户状态设置</span></a></li>
            @endability
            @ability('superadministrator', 'read-platforms')
            <li class="{{Request::is('sysconf/platforms*')?'active':''}}"><a href="{{route('platforms.index')}}"><i class="fa fa-laptop"></i><span>平台渠道</span></a></li>
            @endability
            @ability('superadministrator', 'read-areas')
            <li class="{{Request::is('sysconf/areas*')?'active':''}}"><a href="{{route('areas.index')}}"><i class="fa fa-location-arrow"></i><span>地域</span></a></li>
            @endability
            {{--<li><a href="#"><i class="fa fa-internet-explorer"></i><span>搜索引擎设置</span></a></li>--}}
        </ul>
    </li>
    {{--域名管理--}}
    {{--<li class="treeview item-domain">--}}
    {{--<a href="#"><i class="fa fa-link"></i> <span>DomainConfig</span>--}}
    {{--<span class="pull-right-container">--}}
    {{--<i class="fa fa-angle-left pull-right"></i>--}}
    {{--</span>--}}
    {{--</a>--}}
    {{--<ul class="treeview-menu">--}}
    {{--<li><a href="#">test</a></li>--}}
    {{--</ul>--}}
    {{--</li>--}}
    @endrole
    @role('superadministrator|administrator|zixun|jingjia')
    <li class="treeview {{Request::is('zx/*')?'active':''}}">
        <a href="#"><i class="fa fa-tripadvisor"></i> <span>咨询</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-zx_customers')
            <li class="{{Request::is('zx/zxcustomers*')?'active':''}}"><a href="{{route('zxcustomers.index')}}"><i class="fa fa-user-md"></i><span>咨询详情</span></a></li>
            <li class="{{Request::is('zx/summaries*')?'active':''}}"><a href="{{route('summaries.index')}}"><i class="fa fa-list"></i><span>咨询员预约明细</span></a></li>
            @endability
            @ability('superadministrator', 'create-zx_excels')
            <li class="{{Request::is('zx/exportexcel*')?'active':''}}"><a href="{{route('excel.create')}}"><i class="fa fa-file-excel-o"></i><span>导出患者信息</span></a></li>
            @endability
            {{--<li><a href="#"><i class="fa fa-search"></i><span>病人预约搜索</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-search"></i><span>重复病人查询</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-list"></i><span>客服明细</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-list"></i><span>月趋势报表</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-list"></i><span>自定义趋势报表</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-save"></i><span>病人数据导出</span></a></li>--}}
        </ul>
    </li>
    @endrole
    @role('superadministrator|administrator|jingjia')
    <li class="treeview {{Request::is('jingjia/*')?'active':''}}">
        <a href="#"><i class="fa fa-jpy" aria-hidden="true"></i> <span>竞价</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-auctions')
            <li class="{{Request::is('jingjia/auctions*')?'active':''}}"><a href="{{route('auctions.index')}}"><i class="fa fa-th"></i><span>竞价报表</span></a></li>
            @endability
        </ul>
    </li>
    @endrole
    @role('superadministrator|administrator')
    <li class="treeview {{Request::is('qh/*')?'active':''}}">
        <a href="#"><i class="fa fa-database"></i> <span>企划</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-statistics')
            <li class="{{Request::is('qh/buttons*')?'active':''}}"><a href="{{route('buttons.index')}}"><i class="fa fa-hand-pointer-o"></i><span>按钮点击统计</span></a></li>
            @endability
            @ability('superadministrator', 'read-specialtrans')
            <li class="{{Request::is('qh/specialtrans*')?'active':''}}"><a href="{{route('specialtrans.index')}}"><i class="fa fa-table"></i><span>专题转化统计</span></a></li>
            @endability
            @ability('superadministrator', 'read-specials')
            <li class="{{Request::is('qh/specials*')?'active':''}}"><a href="{{route('specials.index')}}"><i class="fa fa-feed"></i><span>专题列表</span></a></li>
            @endability
        </ul>
    </li>
    @endrole
    @role('superadministrator|administrator|zixun|jingjia')
    <li class="treeview {{Request::is('outputs/*')?'active':''}}">
        <a href="#"><i class="fa fa-sign-out"></i> <span>产出</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{Request::is('outputs/outputs*')?'active':''}}"><a href="{{route('outputs.index')}}"><i class="fa fa-sign-out"></i><span>产出</span></a></li>
            @ability('superadministrator', 'read-zxoutputs')
            <li class="{{Request::is('outputs/zxoutputs*')?'active':''}}"><a href="{{route('zxoutputs.index')}}"><i class="fa fa-sign-out"></i><span>咨询产出</span></a></li>
            @endability
            @ability('superadministrator', 'read-jjoutputs')
            <li class="{{Request::is('outputs/jjoutputs*')?'active':''}}"><a href="{{route('jjoutputs.index')}}"><i class="fa fa-sign-out"></i><span>竞价产出</span></a></li>
            @endability
        </ul>
    </li>
    @endrole
    <li class="treeview {{Request::is('mz/*')?'active':''}}">
        <a href="#"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>门诊</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-mz_customers')
            <li class="{{Request::is('mz/mzcustomers*')?'active':''}}"><a href="{{route('menzhens.index')}}"><i class="fa fa-plus-square"></i><span>患者详情</span></a></li>
            @endability
        </ul>
    </li>
    @role('superadministrator|administrator|zixun|jingjia')
    <li class="treeview {{Request::is('gh/*')?'active':''}}">
        <a href="#"><i class="fa fa-gg"></i> <span>挂号</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            @ability('superadministrator', 'read-gh_customers')
            <li class="{{Request::is('gh/ghcustomers*')?'active':''}}"><a href="{{route('ghcustomers.index')}}"><i class="fa fa-plus-square"></i><span>挂号详情</span></a></li>
            @endability
        </ul>
    </li>
    @endrole
    @ability('superadministrator', 'read-arrangements')
    <li class="{{Request::is('arrangements*')?'active':''}}"><a href="{{route('arrangements.index')}}"><i class="fa fa-link"></i> <span>排班</span></a></li>
    @endability
</ul>