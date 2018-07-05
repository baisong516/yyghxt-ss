@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('auctions.search')}}"  id="search-form" name="search-form" method="POST">
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
                        <a href="{{route('auctions.create')}}" class="btn-sm btn-info" style="margin-right: 10px;">录入</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 10px;">导入</a>
                        <a href="/template/auction.xlsx" class="btn-sm btn-danger">导入模板</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <form action="" method="post" class="auctions-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if(!empty($auctions))
                        @foreach($auctions as $k=>$v)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$k}}" id="tab-switch-{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$k]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($auctions))
                        @foreach($auctions as $k=>$v)
                            <div class="tab-pane {{$loop->first?'active':''}}" id="tab_{{$k}}">
                                @isset($v['platform'])
                                <div class="table-item table-responsive">
                                <table class="table table-bordered" id="table-platform-{{$k}}">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="9%"></th>
                                            <th width="9%" class="text-center">平台</th>
                                            <th width="9%" class="text-center">预算</th>
                                            <th width="9%" class="text-center">消费</th>
                                            <th width="9%" class="text-center">点击</th>
                                            <th width="9%" class="text-center">咨询量</th>
                                            <th width="9%" class="text-center">预约量</th>
                                            <th width="9%" class="text-center">总到院</th>
                                            <th width="9%" class="text-center">咨询成本</th>
                                            <th width="9%" class="text-center">到院成本</th>
                                            @if(isset($start)&&isset($end)&&\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()==\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString())
                                            <th width="9%" class="text-center">OP</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($v['platform']['auctions'] as $typeId=>$auction)
                                            <tr class="text-center">
                                                @if($loop->first)
                                                    <td rowspan="{{$loop->count}}" style="vertical-align: middle;" class="bg-tree"><strong>渠道</strong></td>
                                                @endif
                                                <td>{{$typeId?$platforms[$typeId]:''}}</td>
                                                <td>{{$auction['budget']}}</td>
                                                <td>{{sprintf('%.2f',$auction['cost'])}}</td>
                                                <td>{{$auction['click']}}</td>
                                                <td>{{$auction['zixun']}}</td>
                                                <td>{{$auction['yuyue']}}</td>
                                                <td>{{$auction['arrive']}}</td>
                                                <td>{{$auction['zixun_cost']}}</td>
                                                <td>{{$auction['arrive_cost']}}</td>
                                                @if(isset($start)&&isset($end)&&\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()==\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString())
                                                <td>
                                                    @if($enableUpdate)
                                                        <a href="{{route('auctions.edit',$auction['id'])}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                    @if($enableDelete)
                                                        <a href="javascript:void(0);" data-id="{{$auction['id']}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td class="bg-tree"></td>
                                            <td>合计汇总</td>
                                            <td>{{$v['platform']['budget']}}</td>
                                            <td>{{sprintf('%.2f',$v['platform']['cost'])}}</td>
                                            <td>{{$v['platform']['click']}}</td>
                                            <td>{{$v['platform']['zixun']}}</td>
                                            <td>{{$v['platform']['yuyue']}}</td>
                                            <td>{{$v['platform']['arrive']}}</td>
                                            <td>{{$v['platform']['zixun_cost']}}</td>
                                            <td>{{$v['platform']['arrive_cost']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                @endisset
                                @isset($v['area'])
                                <div class="table-item table-responsive">
                                <table class="table table-bordered" id="table-area-{{$k}}">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="9%"></th>
                                            <th width="9%" class="text-center">地域</th>
                                            <th width="9%" class="text-center">预算</th>
                                            <th width="9%" class="text-center">消费</th>
                                            <th width="9%" class="text-center">点击</th>
                                            <th width="9%" class="text-center">咨询量</th>
                                            <th width="9%" class="text-center">预约量</th>
                                            <th width="9%" class="text-center">总到院</th>
                                            <th width="9%" class="text-center">咨询成本</th>
                                            <th width="9%" class="text-center">到院成本</th>
                                            @if(isset($start)&&isset($end)&&\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()==\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString())
                                                <th width="9%" class="text-center">OP</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($v['area']['auctions'] as $typeId=>$auction)
                                            <tr class="text-center">
                                                @if($loop->first)
                                                <td rowspan="{{$loop->count}}" style="vertical-align: middle" class="bg-tree"><strong>地区</strong></td>
                                                @endif
                                                <td>{{$typeId?$areas[$typeId]:''}}</td>
                                                <td>{{$auction['budget']}}</td>
                                                <td>{{sprintf('%.2f',$auction['cost'])}}</td>
                                                <td>{{$auction['click']}}</td>
                                                <td>{{$auction['zixun']}}</td>
                                                <td>{{$auction['yuyue']}}</td>
                                                <td>{{$auction['arrive']}}</td>
                                                <td>{{$auction['zixun_cost']}}</td>
                                                <td>{{$auction['arrive_cost']}}</td>
                                                @if(isset($start)&&isset($end)&&\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()==\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString())
                                                    <td>
                                                        @if($enableUpdate)
                                                            <a href="{{route('auctions.edit',$auction['id'])}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if($enableDelete)
                                                            <a href="javascript:void(0);" data-id="{{$auction['id']}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td class="bg-tree"></td>
                                            <td>合计汇总</td>
                                            <td>{{$v['area']['budget']}}</td>
                                            <td>{{sprintf('%.2f',$v['area']['cost'])}}</td>
                                            <td>{{$v['area']['click']}}</td>
                                            <td>{{$v['area']['zixun']}}</td>
                                            <td>{{$v['area']['yuyue']}}</td>
                                            <td>{{$v['area']['arrive']}}</td>
                                            <td>{{$v['area']['zixun_cost']}}</td>
                                            <td>{{$v['area']['arrive_cost']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                @endisset
                                @isset($v['disease'])
                                <div class="table-item table-responsive">
                                <table class="table table-bordered" id="table-disease-{{$k}}">
                                    <thead class="text-center">
                                        <tr>
                                            <th width="9%"></th>
                                            <th width="9%" class="text-center">病种</th>
                                            <th width="9%" class="text-center">预算</th>
                                            <th width="9%" class="text-center">消费</th>
                                            <th width="9%" class="text-center">点击</th>
                                            <th width="9%" class="text-center">咨询量</th>
                                            <th width="9%" class="text-center">预约量</th>
                                            <th width="9%" class="text-center">总到院</th>
                                            <th width="9%" class="text-center">咨询成本</th>
                                            <th width="9%" class="text-center">到院成本</th>
                                            @if(isset($start)&&isset($end)&&\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()==\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString())
                                                <th width="9%" class="text-center">OP</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($v['disease']['auctions'] as $typeId=>$auction)
                                            <tr class="text-center">
                                                @if($loop->first)
                                                <td  rowspan="{{$loop->count}}" style="vertical-align: middle" class="bg-tree"><strong>病种</strong></td>
                                                @endif
                                                <td>{{$typeId?$diseases[$typeId]:''}}</td>
                                                <td>{{$auction['budget']}}</td>
                                                <td>{{sprintf('%.2f',$auction['cost'])}}</td>
                                                <td>{{$auction['click']}}</td>
                                                <td>{{$auction['zixun']}}</td>
                                                <td>{{$auction['yuyue']}}</td>
                                                <td>{{$auction['arrive']}}</td>
                                                <td>{{$auction['zixun_cost']}}</td>
                                                <td>{{$auction['arrive_cost']}}</td>
                                                @if(isset($start)&&isset($end)&&\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()==\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString())
                                                    <td>
                                                        @if($enableUpdate)
                                                            <a href="{{route('auctions.edit',$auction['id'])}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                                        @endif
                                                        @if($enableDelete)
                                                            <a href="javascript:void(0);" data-id="{{$auction['id']}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr class="text-center">
                                            <td  class="bg-tree"></td>
                                            <td>合计汇总</td>
                                            <td>{{$v['disease']['budget']}}</td>
                                            <td>{{sprintf('%.2f',$v['disease']['cost'])}}</td>
                                            <td>{{$v['disease']['click']}}</td>
                                            <td>{{$v['disease']['zixun']}}</td>
                                            <td>{{$v['disease']['yuyue']}}</td>
                                            <td>{{$v['disease']['arrive']}}</td>
                                            <td>{{$v['disease']['zixun_cost']}}</td>
                                            <td>{{$v['disease']['arrive_cost']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                @endisset
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- /.tab-content -->
            </div>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('auctions.import')}}" enctype="multipart/form-data">
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
            var nodeId1=$(".table-item").eq(1).children('table').attr('id');
            if (typeof(nodeId1)!='undefined'){
                var node1 = document.getElementById(nodeId1);
                domtoimage.toSvg(node1,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node1.remove();
                        $(".table-item").eq(1).append(img);
                    });
            }
            // 2
            var nodeId2=$(".table-item").eq(2).children('table').attr('id');
            if (typeof(nodeId2)!='undefined'){
                var node2 = document.getElementById(nodeId2);
                domtoimage.toSvg(node2,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node2.remove();
                        $(".table-item").eq(2).append(img);
                    });
            }
        });
        $("#tab-switch-2").click(function () {
            // 3
            var nodeId3=$(".table-item").eq(3).children('table').attr('id');
            console.log(nodeId3);
            if (typeof(nodeId3)!='undefined'){
                var node3 = document.getElementById(nodeId3);
                console.log(node3);
                domtoimage.toSvg(node3,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        console.log(dataUrl)
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node3.remove();
                        $(".table-item").eq(3).append(img);
                    });
            }
            // 4
            var nodeId4=$(".table-item").eq(4).children('table').attr('id');
            if (typeof(nodeId4)!='undefined'){
                var node4 = document.getElementById(nodeId4);
                domtoimage.toSvg(node4,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node4.remove();
                        $(".table-item").eq(4).append(img);
                    });
            }
            // 5
            var nodeId5=$(".table-item").eq(5).children('table').attr('id');
            if (typeof(nodeId5)!='undefined'){
                var node5 = document.getElementById(nodeId5);
                domtoimage.toSvg(node5,{bgcolor: '#fff'})
                    .then(function (dataUrl) {
                        var img = new Image();
                        img.src = dataUrl;
                        img.className= 'img-responsive';
                        node5.remove();
                        $(".table-item").eq(5).append(img);
                    });
            }
        });
        $(".month-sub-option").click(function () {
            var monthSub=$(this).data('month');
            $("input:hidden[name=monthSub]").val(monthSub);
            $("form#search-form").submit();
        });
    </script>
@endsection
