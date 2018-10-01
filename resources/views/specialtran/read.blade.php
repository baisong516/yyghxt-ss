@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('specialtrans.search')}}"  id="search-form" name="search-form" method="POST">
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
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 280px;">
                    <a href="{{route('specialtrans.create')}}" class="btn-sm btn-info" style="margin-right: 20px;">录入</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 20px;">导入</a>
                    <a href="/template/specialtrans.xlsx" class="btn-sm btn-danger">模板下载</a>
                </div>
            </div>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body table-responsive">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs switch-nav-tables">
                    @if(isset($specialtrans)&&!empty($specialtrans))
                        @foreach($specialtrans as $officeid=>$s)
                        <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$officeid}}" data-id="tab_{{$officeid}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$officeid]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(isset($specialtrans)&&!empty($specialtrans))
                        @foreach($specialtrans as $officeid=>$s)
                        <div class="tab-pane table-responsive {{$loop->first?'active':''}}" id="tab_{{$officeid}}">
                            <table id="talbe-today-tab-{{$officeid}}" class="table table-bordered" style="font-size: 12px;">
                                <thead class="text-center">
                                    <tr>
                                        <th class="text-center">页面名称</th>
                                        <th class="text-center">现URL</th>
                                        <th class="text-center">病种</th>
                                        <th class="text-center">类别(词性)</th>
                                        <th class="text-center">消费</th>
                                        <th class="text-center">点击</th>
                                        <th class="text-center">展现</th>
                                        <th class="text-center">唯一身份浏览量</th>
                                        <th class="text-center">跳出率</th>
                                        <th class="text-center">商务通大于等于1</th>
                                        <th class="text-center">商务通大于等于3</th>
                                        <th class="text-center">点击转化率</th>
                                        <th class="text-center">预约</th>
                                        <th class="text-center">到院</th>
                                        <th class="text-center">更换时间</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($s as $specialId=>$special)
                                    @if(!empty($special['type']))
                                    @foreach($special['type'] as $diseaseId=>$type)
                                    <tr>
                                        @if($loop->first)
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['name']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}"><small>{{$special['url']}}</small></td>
                                        @endif
                                        <td>{{isset($diseaseId)?$diseases[$diseaseId]:''}}</td>
                                        <td>{{isset($type)?$type:''}}</td>
                                        @if($loop->first)
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{sprintf('%.2f',$special['cost'])}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['show']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['view']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['skip_rate']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_one']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_three']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click_trans_rate']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['yuyue']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['arrive']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['change_date']}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td style="vertical-align: middle;">{{$special['name']}}</td>
                                            <td style="vertical-align: middle;">{{$special['url']}}</td>
                                            <td></td>
                                            <td></td>
                                            <td style="vertical-align: middle;">{{sprintf('%.2f',$special['cost'])}}</td>
                                            <td style="vertical-align: middle;">{{$special['click']}}</td>
                                            <td style="vertical-align: middle;">{{$special['show']}}</td>
                                            <td style="vertical-align: middle;">{{$special['view']}}</td>
                                            <td style="vertical-align: middle;">{{$special['skip_rate']}}</td>
                                            <td style="vertical-align: middle;" >{{$special['swt_lg_one']}}</td>
                                            <td style="vertical-align: middle;" >{{$special['swt_lg_three']}}</td>
                                            <td style="vertical-align: middle;" >{{$special['click_trans_rate']}}</td>
                                            <td style="vertical-align: middle;" >{{$special['yuyue']}}</td>
                                            <td style="vertical-align: middle;" >{{$special['arrive']}}</td>
                                            <td style="vertical-align: middle;" >{{$special['change_date']}}</td>
                                        </tr>
                                    @endif
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
                    @if(isset($monthspecialtrans)&&!empty($monthspecialtrans))
                        @foreach($monthspecialtrans as $officeid=>$s)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_month_{{$officeid}}" data-id="tab_month_{{$officeid}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$officeid]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(isset($monthspecialtrans)&&!empty($monthspecialtrans))
                        @foreach($monthspecialtrans as $officeid=>$s)
                            <div class="tab-pane table-responsive {{$loop->first?'active':''}}" id="tab_month_{{$officeid}}">
                                <table id="talbe-tab-month-{{$officeid}}" class="table table-bordered" style="font-size: 12px;">
                                    <thead class="text-center">
                                    <tr>
                                        <th class="text-center">页面名称</th>
                                        <th class="text-center">现URL</th>
                                        <th class="text-center">病种</th>
                                        <th class="text-center">类别(词性)</th>
                                        <th class="text-center">消费</th>
                                        <th class="text-center">点击</th>
                                        <th class="text-center">展现</th>
                                        <th class="text-center">唯一身份浏览量</th>
                                        <th class="text-center">跳出率</th>
                                        <th class="text-center">商务通大于等于1</th>
                                        <th class="text-center">商务通大于等于3</th>
                                        <th class="text-center">点击转化率</th>
                                        <th class="text-center">预约</th>
                                        <th class="text-center">到院</th>
                                        <th class="text-center">更换时间</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    @foreach($s as $specialId=>$special)
                                        @if(!empty($special['type']))
                                            @foreach($special['type'] as $diseaseId=>$type)
                                                <tr>
                                                    @if($loop->first)
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['name']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}"><small>{{$special['url']}}</small></td>
                                                    @endif
                                                    <td>{{isset($diseaseId)?$diseases[$diseaseId]:''}}</td>
                                                    <td>{{isset($type)?$type:''}}</td>
                                                    @if($loop->first)
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{sprintf('%.2f',$special['cost'])}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['show']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['view']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['skip_rate']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_one']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_three']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click_trans_rate']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['yuyue']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['arrive']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['change_date']}}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="vertical-align: middle;">{{$special['name']}}</td>
                                                <td style="vertical-align: middle;">{{$special['url']}}</td>
                                                <td></td>
                                                <td></td>
                                                <td style="vertical-align: middle;">{{sprintf('%.2f',$special['cost'])}}</td>
                                                <td style="vertical-align: middle;">{{$special['click']}}</td>
                                                <td style="vertical-align: middle;">{{$special['show']}}</td>
                                                <td style="vertical-align: middle;">{{$special['view']}}</td>
                                                <td style="vertical-align: middle;">{{$special['skip_rate']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['swt_lg_one']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['swt_lg_three']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['click_trans_rate']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['yuyue']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['arrive']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['change_date']}}</td>
                                            </tr>
                                        @endif
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
                    @if(isset($yearspecialtrans)&&!empty($yearspecialtrans))
                        @foreach($yearspecialtrans as $officeid=>$s)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_year_{{$officeid}}" data-id="tab_year_{{$officeid}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$officeid]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(isset($yearspecialtrans)&&!empty($yearspecialtrans))
                        @foreach($yearspecialtrans as $officeid=>$s)
                            <div class="tab-pane table-responsive {{$loop->first?'active':''}}" id="tab_year_{{$officeid}}">
                                <table id="talbe-tab-year-{{$officeid}}" class="table table-bordered" style="font-size: 12px;">
                                    <thead class="text-center">
                                    <tr>
                                        <th class="text-center">页面名称</th>
                                        <th class="text-center">现URL</th>
                                        <th class="text-center">病种</th>
                                        <th class="text-center">类别(词性)</th>
                                        <th class="text-center">消费</th>
                                        <th class="text-center">点击</th>
                                        <th class="text-center">展现</th>
                                        <th class="text-center">唯一身份浏览量</th>
                                        <th class="text-center">跳出率</th>
                                        <th class="text-center">商务通大于等于1</th>
                                        <th class="text-center">商务通大于等于3</th>
                                        <th class="text-center">点击转化率</th>
                                        <th class="text-center">预约</th>
                                        <th class="text-center">到院</th>
                                        <th class="text-center">更换时间</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    @foreach($s as $specialId=>$special)
                                        @if(!empty($special['type']))
                                            @foreach($special['type'] as $diseaseId=>$type)
                                                <tr>
                                                    @if($loop->first)
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['name']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}"><small>{{$special['url']}}</small></td>
                                                    @endif
                                                    <td>{{isset($diseaseId)?$diseases[$diseaseId]:''}}</td>
                                                    <td>{{isset($type)?$type:''}}</td>
                                                    @if($loop->first)
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{sprintf('%.2f',$special['cost'])}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['show']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['view']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['skip_rate']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_one']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_three']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click_trans_rate']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['yuyue']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['arrive']}}</td>
                                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['change_date']}}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td style="vertical-align: middle;">{{$special['name']}}</td>
                                                <td style="vertical-align: middle;">{{$special['url']}}</td>
                                                <td></td>
                                                <td></td>
                                                <td style="vertical-align: middle;">{{sprintf('%.2f',$special['cost'])}}</td>
                                                <td style="vertical-align: middle;">{{$special['click']}}</td>
                                                <td style="vertical-align: middle;">{{$special['show']}}</td>
                                                <td style="vertical-align: middle;">{{$special['view']}}</td>
                                                <td style="vertical-align: middle;">{{$special['skip_rate']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['swt_lg_one']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['swt_lg_three']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['click_trans_rate']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['yuyue']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['arrive']}}</td>
                                                <td style="vertical-align: middle;" >{{$special['change_date']}}</td>
                                            </tr>
                                        @endif
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
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('specialtrans.import')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="importModalLabel">文件选择</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inInputFile" class="col-sm-2 control-label">文件</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="file" id="inInputFile" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dateTag" class="col-sm-2 control-label">日期</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control date-item" name="date_tag" id="dateTag" value="{{\Carbon\Carbon::now()->toDateString()}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">开始导入</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#specialtrans-list-talbe').DataTable({
            //     "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
            //     "language": {
            //         "url": "/datables-language-zh-CN.json"
            //     }
            // });
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
            //todo 6张表 for循环参数覆盖未解 暂时单写
            // 0
            var cid0=$("ul.switch-nav-tables li.active a").eq(0).data('id');
            console.log(cid0);
            var nodeId0=$("#"+cid0).children('table').attr('id');
            if (typeof(nodeId0)!='undefined'){
                var node0 = document.getElementById(nodeId0);
                domtoimage.toSvg(node0,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node0.remove();
                        $("#"+cid0).append(img);
                    });
            }
            // 1
            var cid1=$("ul.switch-nav-tables li.active a").eq(1).data('id');
            console.log(cid1);
            var nodeId1=$("#"+cid1).children('table').attr('id');
            if (typeof(nodeId1)!='undefined'){
                var node1 = document.getElementById(nodeId1);
                domtoimage.toSvg(node1,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node1.remove();
                        $("#"+cid1).append(img);
                    });
            }
            // 2
            var cid2=$("ul.switch-nav-tables li.active a").eq(2).data('id');
            console.log(cid2);
            var nodeId2=$("#"+cid2).children('table').attr('id');
            if (typeof(nodeId2)!='undefined'){
                var node2 = document.getElementById(nodeId2);
                domtoimage.toSvg(node2,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node2.remove();
                        $("#"+cid2).append(img);
                    });
            }
            $(".switch-nav-tables li a").click(function () {
                var cid=$(this).data('id');
                var nodeId=$("#"+cid).children('table').attr('id');
                if (typeof(nodeId)!='undefined'){
                    var node = document.getElementById(nodeId);
                    domtoimage.toSvg(node,{bgcolor: '#fff'})
                        .then(function (dataUrl) {
                            var img = new Image();
                            img.src = dataUrl;
                            img.className= 'img-responsive';
                            node.remove();
                            $("#"+cid).append(img);
                        });
                }
            });
            $(".delete-operation").on('click',function(){
                var id=$(this).attr('data-id');
                layer.open({
                    content: '你确定要删除吗？',
                    btn: ['确定', '关闭'],
                    yes: function(index, layero){
                        $('form.specialtrans-form').attr('action',"{{route('specialtrans.index')}}/"+id);
                        $('form.specialtrans-form').submit();
                    },
                    btn2: function(index, layero){
                        //按钮【按钮二】的回调
                        //return false 开启该代码可禁止点击该按钮关闭
                    },
                    cancel: function(){
                        //右上角关闭回调
                        //return false; 开启该代码可禁止点击该按钮关闭
                    }
                });
            });
        } );
    </script>
@endsection
