@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('buttons.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="buttonDate">日期：</label>
                    <input type="text" class="form-control date-item" name="dateStart" id="dateStart" value="{{isset($start)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                    到
                    <input type="text" class="form-control date-item" name="dateEnd" id="dateEnd" value="{{isset($end)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
                <hr>
                <input type="hidden" id="monthSub" name="monthSub" value="">
                @for ($i = 0; $i < 5; $i++)
                    <button type="button" class="btn btn-success month-sub-option" style="margin-bottom: 5px;" data-month="{{$i}}">{{\Carbon\Carbon::now()->subMonth($i)->year}}-{{\Carbon\Carbon::now()->subMonth($i)->month}}</button>
                @endfor
            </form>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body table-responsive">
            <form action="" method="post" class="hospitals-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs switch-nav-tables">
                        @if(!empty($todayClick))
                            @foreach($todayClick as $k=>$d)
                                <li class="{{$loop->first?'active':''}}"><a href="#today_tab_{{$k}}" data-id="today_tab_{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$k]}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if(!empty($todayClick))
                            @foreach($todayClick as $k=>$d)
                                <div class="tab-pane table-item table-responsive {{$loop->first?'active':''}}" id="today_tab_{{$k}}">
                                    <table class="table table-bordered" id="table-today-tab-{{$k}}">
                                        <thead class="text-center">
                                        <tr>
                                            <th class="text-center">网站</th>
                                            <th class="text-center">位置</th>
                                            <th class="text-center">说明</th>
                                            <th class="text-center">点击次数</th>
                                        </tr>
                                        </thead>
                                        <tbody style="text-align: center">
                                        @foreach($d as $m=>$v)
                                            @foreach($v as $p=>$it)
                                                <tr>
                                                    @if($loop->first)
                                                        <td rowspan="{{$loop->count}}" class="text-center" style="vertical-align: middle;">{{$m}}</td>
                                                    @endif
                                                    <td class="text-center">
                                                        @foreach(array_filter(explode('_',$p)) as $e)
                                                            {{isset($clickArray[$e])?$clickArray[$e]:$e}}
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">{{isset($it['description'])?$it['description']:''}}</td>
                                                    <td class="text-center">{{$it['count']}}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- /.tab-content -->
                </div>
            </form>
        </div>
        {{--<p class="text-red">显示当天点击量总数，其它根据日期查询！</p>--}}
        <!-- /.box-body -->
    </div>
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-left: 48%;">上月数据</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs switch-nav-tables">
                    @if(!empty($monthClick))
                        @foreach($monthClick as $k=>$d)
                            <li class="{{$loop->first?'active':''}}"><a href="#month_tab_{{$k}}" data-id="month_tab_{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$k]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($monthClick))
                        @foreach($monthClick as $k=>$d)
                            <div class="tab-pane table-item table-responsive {{$loop->first?'active':''}}" id="month_tab_{{$k}}">
                                <table class="table table-bordered" id="table-month-tab-{{$k}}">
                                    <thead class="text-center">
                                    <tr>
                                        <th class="text-center">网站</th>
                                        <th class="text-center">位置</th>
                                        <th class="text-center">说明</th>
                                        <th class="text-center">点击次数</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                    @foreach($d as $m=>$v)
                                        @foreach($v as $p=>$it)
                                            <tr>
                                                @if($loop->first)
                                                    <td rowspan="{{$loop->count}}" class="text-center" style="vertical-align: middle;">{{$m}}</td>
                                                @endif
                                                <td class="text-center">
                                                    @foreach(array_filter(explode('_',$p)) as $e)
                                                        {{isset($clickArray[$e])?$clickArray[$e]:$e}}
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{isset($it['description'])?$it['description']:''}}</td>
                                                <td class="text-center">{{$it['count']}}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title" style="margin-left: 47%;">{{\Carbon\Carbon::now()->year}}年数据</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs switch-nav-tables">
                    @if(!empty($yearClick))
                        @foreach($yearClick as $k=>$d)
                            <li class="{{$loop->first?'active':''}}"><a href="#year_tab_{{$k}}" data-id="year_tab_{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$k]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($yearClick))
                        @foreach($yearClick as $k=>$d)
                            <div class="tab-pane table-item table-responsive {{$loop->first?'active':''}}" id="year_tab_{{$k}}">
                                <table class="table table-bordered" id="table-year-tab-{{$k}}">
                                    <thead class="text-center">
                                    <tr>
                                        <th class="text-center">网站</th>
                                        <th class="text-center">位置</th>
                                        <th class="text-center">说明</th>
                                        <th class="text-center">点击次数</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                    @foreach($d as $m=>$v)
                                        @foreach($v as $p=>$it)
                                            <tr>
                                                @if($loop->first)
                                                    <td rowspan="{{$loop->count}}" class="text-center" style="vertical-align: middle;">{{$m}}</td>
                                                @endif
                                                <td class="text-center">
                                                    @foreach(array_filter(explode('_',$p)) as $e)
                                                        {{isset($clickArray[$e])?$clickArray[$e]:$e}}
                                                    @endforeach
                                                </td>
                                                <td class="text-center">{{isset($it['description'])?$it['description']:''}}</td>
                                                <td class="text-center">{{$it['count']}}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>

@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
//            $('#buttons-list-table').DataTable({
//                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
//                "language": {
//                    "url": "/datables-language-zh-CN.json"
//                }
//            });
            lay('.date-item').each(function(){
                laydate.render({
                    elem: this
                    ,trigger: 'click'
                });
            });
            $(".month-sub-option").click(function () {
                var monthSub=$(this).data('month');
                $("input:hidden[name=monthSub]").val(monthSub);
                $("form#search-form").submit();
            });
            $(".box-body li.active a").each(function () {
                var tabId=$(this).attr('href');
                console.log(tabId);
                $(tabId+".table-item").each(function () {
                    var nodeId=$(this).children('table').attr('id');
                    if (typeof(nodeId)!='undefined'){
                        var node = document.getElementById(nodeId);
                        var that=this;
                        domtoimage.toSvg(node,{bgcolor: '#fff'},that)
                            .then(function (dataUrl) {
                                var img = new Image();
                                img.src = dataUrl;
                                img.className= 'img-responsive';
                                node.remove();
                                $(that).append(img);
                            });
                    }
                });
            });
            $(".box-body li a").click(function () {
                var tabId=$(this).attr('href');
                $(tabId+".table-item").each(function () {
                    var nodeId=$(this).children('table').attr('id');
                    if (typeof(nodeId)!='undefined'){
                        var node = document.getElementById(nodeId);
                        var that=this;
                        domtoimage.toSvg(node,{bgcolor: '#fff'},that)
                            .then(function (dataUrl) {
                                var img = new Image();
                                img.src = dataUrl;
                                img.className= 'img-responsive';
                                node.remove();
                                $(that).append(img);
                            });
                    }
                });
            });

            {{--$(".delete-operation").on('click',function(){--}}
                {{--var id=$(this).attr('data-id');--}}
                {{--layer.open({--}}
                    {{--content: '你确定要删除吗？',--}}
                    {{--btn: ['确定', '关闭'],--}}
                    {{--yes: function(index, layero){--}}
                        {{--$('form.hospitals-form').attr('action',"{{route('hospitals.index')}}/"+id);--}}
                        {{--$('form.hospitals-form').submit();--}}
                    {{--},--}}
                    {{--btn2: function(index, layero){--}}
                        {{--//按钮【按钮二】的回调--}}
                        {{--//return false 开启该代码可禁止点击该按钮关闭--}}
                    {{--},--}}
                    {{--cancel: function(){--}}
                        {{--//右上角关闭回调--}}
                        {{--//return false; 开启该代码可禁止点击该按钮关闭--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        } );
    </script>
@endsection
