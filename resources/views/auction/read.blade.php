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
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$k]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($auctions))
                        @foreach($auctions as $k=>$v)
                            <div class="tab-pane {{$loop->first?'active':''}}" id="tab_{{$k}}">
                                @isset($v['platform'])
                                <table class="table table-bordered">
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
                                @endisset
                                @isset($v['area'])
                                <table class="table table-bordered">
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
                                @endisset
                                @isset($v['disease'])
                                <table class="table table-bordered">
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
        });

    </script>
@endsection
