@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('reports.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="searchDate">日期：</label>
                    <input type="text" class="form-control date-item" name="searchDateStart" id="searchDateStart" required value="{{isset($start)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                    到
                    <input type="text" class="form-control date-item" name="searchDateEnd" id="searchDateEnd" required value="{{isset($end)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
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
                    @ability('superadministrator', 'create-auctions')
                        {{--<a href="{{route('auctions.create')}}" class="btn-sm btn-info" style="margin-right: 10px;">录入</a>--}}
                        <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 10px;">导入</a>
                        <a href="/template/reports.xlsx" class="btn-sm btn-danger">导入模板</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            {{--当前数据/查询数据--}}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if(!empty($reports))
                        @foreach($reports as $k=>$v)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_now_{{$k}}" class="tab-switch" data-id="tab_now_{{$k}}" id="tab-now-switch-{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$k]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($reports))
                        @foreach($reports as $k=>$v)
                            <div class="tab-pane {{$loop->first?'active':''}}" id="tab_now_{{$k}}">
                                <div class="table-item table-responsive">
                                <table class="table table-bordered" id="table-{{$k}}">
                                    <thead>
                                        <tr>
                                            <th colspan="9" class="text-center">竞价</th>
                                            <th class="text-center">策划转化率</th>
                                            <th colspan="5" class="text-center">咨询目标</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td>展现量</td>
                                            <td>点击</td>
                                            <td>点击率</td>
                                            <td>总对话</td>
                                            <td>有效对话</td>
                                            <td>总预约</td>
                                            <td>总到院</td>
                                            <td>咨询成本</td>
                                            <td>到院成本</td>
                                            <td>点效比</td>
                                            <td>有效对话率</td>
                                            <td>留联率</td>
                                            <td>预约率</td>
                                            <td>到院率</td>
                                            <td>咨询转化率</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>{{$v['show']}}</td>
                                            <td>{{$v['click']}}</td>
                                            <td>{{$v['click_rate']}}</td>
                                            <td>{{$v['achat']}}</td>
                                            <td>{{$v['chat']}}</td>
                                            <td>{{$v['yuyue']}}</td>
                                            <td>{{$v['arrive']}}</td>
                                            <td>{{$v['zixun_cost']}}</td>
                                            <td>{{$v['arrive_cost']}}</td>
                                            <td>{{$v['active_rate']}}</td>
                                            <td>{{$v['chat_rate']}}</td>
                                            <td>{{$v['contact_rate']}}</td>
                                            <td>{{$v['yuyue_rate']}}</td>
                                            <td>{{$v['arrive_rate']}}</td>
                                            <td>{{$v['trans_rate']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
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
            <form method="post" class="form-horizontal" action="{{route('reports.import')}}" enctype="multipart/form-data">
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
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript">
        //data item
        lay('.date-item').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'date'
                // value: new Date()
            });
        });
        $(document).ready(function() {
            $(".delete-operation").on('click',function(){
                var id=$(this).attr('data-id');
                layer.open({
                    content: '你确定要删除吗？',
                    btn: ['确定', '关闭'],
                    yes: function(index, layero){
                        $('form.auctions-form').attr('action',"{{route('auctions.index')}}/"+id);
                        $('form.auctions-form').submit();
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
            //todo 6张表 for循环参数覆盖未解 暂时单写
            // 0
            var nodeId0=$(".table-item").eq(0).children('table').attr('id');
            if (typeof(nodeId0)!='undefined'){
                var node0 = document.getElementById(nodeId0);
                domtoimage.toSvg(node0,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node0.remove();
                        $(".table-item").eq(0).append(img);
                    });
            }
            // 1
            // var nodeId1=$(".table-item").eq(1).children('table').attr('id');
            // if (typeof(nodeId1)!='undefined'){
            //     var node1 = document.getElementById(nodeId1);
            //     domtoimage.toSvg(node1,{bgcolor: '#fff'})
            //         .then(function (dataUrl) {
            //             var img = new Image();
            //             img.src = dataUrl;
            //             img.className= 'img-responsive';
            //             node1.remove();
            //             $(".table-item").eq(1).append(img);
            //         });
            // }
            // 2
            // var nodeId2=$(".table-item").eq(2).children('table').attr('id');
            // if (typeof(nodeId2)!='undefined'){
            //     var node2 = document.getElementById(nodeId2);
            //     domtoimage.toSvg(node2,{bgcolor: '#fff'})
            //         .then(function (dataUrl) {
            //             var img = new Image();
            //             img.src = dataUrl;
            //             img.className= 'img-responsive';
            //             node2.remove();
            //             $(".table-item").eq(2).append(img);
            //         });
            // }
        });
        $(".tab-switch").click(function () {
            // 3 $(this).data('id')
            var nodeId=$("#"+$(this).data('id')+" .table-item").eq(0).children('table').attr('id');
            console.log(nodeId);
            // if (typeof(nodeId)!='undefined'){
            //     var node = document.getElementById(nodeId);
            //     console.log(node3);
            //     domtoimage.toSvg(node3,{bgcolor: '#fff'})
            //         .then(function (dataUrl) {
            //             console.log(dataUrl)
            //             var img = new Image();
            //             img.src = dataUrl;
            //             img.className= 'img-responsive';
            //             node3.remove();
            //             $(".table-item").eq(3).append(img);
            //         });
            // }
            // 4
            // var nodeId4=$(".table-item").eq(4).children('table').attr('id');
            // if (typeof(nodeId4)!='undefined'){
            //     var node4 = document.getElementById(nodeId4);
            //     domtoimage.toSvg(node4,{bgcolor: '#fff'})
            //         .then(function (dataUrl) {
            //             var img = new Image();
            //             img.src = dataUrl;
            //             img.className= 'img-responsive';
            //             node4.remove();
            //             $(".table-item").eq(4).append(img);
            //         });
            // }
            // 5
            // var nodeId5=$(".table-item").eq(5).children('table').attr('id');
            // if (typeof(nodeId5)!='undefined'){
            //     var node5 = document.getElementById(nodeId5);
            //     domtoimage.toSvg(node5,{bgcolor: '#fff'})
            //         .then(function (dataUrl) {
            //             var img = new Image();
            //             img.src = dataUrl;
            //             img.className= 'img-responsive';
            //             node5.remove();
            //             $(".table-item").eq(5).append(img);
            //         });
            // }
        });
        $(".month-sub-option").click(function () {
            var monthSub=$(this).data('month');
            $("input:hidden[name=monthSub]").val(monthSub);
            $("form#search-form").submit();
        });
    </script>
@endsection
