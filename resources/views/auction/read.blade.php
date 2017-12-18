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
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-auctions')
                        <a href="{{route('auctions.create')}}" class="btn-sm btn-info">录入</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <style>
                .box-body>table thead tr{background: #c5be97;}
                .bg-tree{background: #c5be97;}
                /*table tr,table th,table td{border: solid 1px #000;}*/
            </style>
            <h3 class="text-center">竞价报表</h3>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th width="10%"></th>
                        <th width="10%" class="text-center">平台</th>
                        <th width="10%" class="text-center">预算</th>
                        <th width="10%" class="text-center">消费</th>
                        <th width="10%" class="text-center">点击</th>
                        <th width="10%" class="text-center">咨询量</th>
                        <th width="10%" class="text-center">预约量</th>
                        <th width="10%" class="text-center">总到院</th>
                        <th width="10%" class="text-center">咨询成本</th>
                        <th width="10%" class="text-center">到院成本</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($auctions['platform'])
                    @foreach($auctions['platform'] as $platform_id => $auction)
                    <tr class="text-center">
                        @if($loop->first)
                        <td rowspan="{{$loop->count}}" style="vertical-align: middle;" class="bg-tree"><strong>渠道</strong></td>
                        @endif
                        <td>{{$platform_id?$platforms[$platform_id]:''}}</td>
                        <td>{{$auction['budget']}}</td>
                        <td>{{$auction['cost']}}</td>
                        <td>{{$auction['click']}}</td>
                        <td>{{$auction['zixun']}}</td>
                        <td>{{$auction['yuyue']}}</td>
                        <td>{{$auction['arrive']}}</td>
                        <td>{{$auction['zixun_cost']}}</td>
                        <td>{{$auction['arrive_cost']}}</td>
                    </tr>
                    @endforeach
                    @endisset
                    <tr class="text-center">
                        <td class="bg-tree"></td>
                        <td>合计汇总</td>
                        <td>{{$total['budget']}}</td>
                        <td>{{$total['cost']}}</td>
                        <td>{{$total['click']}}</td>
                        <td>{{$total['zixun']}}</td>
                        <td>{{$total['yuyue']}}</td>
                        <td>{{$total['arrive']}}</td>
                        <td>{{$total['zixun_cost']}}</td>
                        <td>{{$total['arrive_cost']}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th width="10%"></th>
                        <th width="10%" class="text-center">地域</th>
                        <th width="10%" class="text-center">预算</th>
                        <th width="10%" class="text-center">消费</th>
                        <th width="10%" class="text-center">点击</th>
                        <th width="10%" class="text-center">咨询量</th>
                        <th width="10%" class="text-center">预约量</th>
                        <th width="10%" class="text-center">总到院</th>
                        <th width="10%" class="text-center">咨询成本</th>
                        <th width="10%" class="text-center">到院成本</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($auctions['area'])
                    @foreach($auctions['area'] as $area_id => $auction)
                    <tr class="text-center">
                        @if($loop->first)
                        <td rowspan="{{$loop->count}}" style="vertical-align: middle" class="bg-tree"><strong>地区</strong></td>
                        @endif
                        <td>{{$area_id?$areas[$area_id]:''}}</td>
                        <td>{{$auction['budget']}}</td>
                        <td>{{$auction['cost']}}</td>
                        <td>{{$auction['click']}}</td>
                        <td>{{$auction['zixun']}}</td>
                        <td>{{$auction['yuyue']}}</td>
                        <td>{{$auction['arrive']}}</td>
                        <td>{{$auction['zixun_cost']}}</td>
                        <td>{{$auction['arrive_cost']}}</td>
                    </tr>
                    @endforeach
                    @endisset
                    <tr class="text-center">
                        <td class="bg-tree"></td>
                        <td>合计汇总</td>
                        <td>{{$total['budget']}}</td>
                        <td>{{$total['cost']}}</td>
                        <td>{{$total['click']}}</td>
                        <td>{{$total['zixun']}}</td>
                        <td>{{$total['yuyue']}}</td>
                        <td>{{$total['arrive']}}</td>
                        <td>{{$total['zixun_cost']}}</td>
                        <td>{{$total['arrive_cost']}}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th width="10%"></th>
                        <th width="10%" class="text-center">病种</th>
                        <th width="10%" class="text-center">预算</th>
                        <th width="10%" class="text-center">消费</th>
                        <th width="10%" class="text-center">点击</th>
                        <th width="10%" class="text-center">咨询量</th>
                        <th width="10%" class="text-center">预约量</th>
                        <th width="10%" class="text-center">总到院</th>
                        <th width="10%" class="text-center">咨询成本</th>
                        <th width="10%" class="text-center">到院成本</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($auctions['disease'])
                    @foreach($auctions['disease'] as $disease_id => $auction)
                    <tr class="text-center">
                        @if($loop->first)
                        <td  rowspan="{{$loop->count}}" style="vertical-align: middle" class="bg-tree"><strong>病种</strong></td>
                        @endif
                        <td>{{$disease_id?$diseases[$disease_id]:''}}</td>
                        <td>{{$auction['budget']}}</td>
                        <td>{{$auction['cost']}}</td>
                        <td>{{$auction['click']}}</td>
                        <td>{{$auction['zixun']}}</td>
                        <td>{{$auction['yuyue']}}</td>
                        <td>{{$auction['arrive']}}</td>
                        <td>{{$auction['zixun_cost']}}</td>
                        <td>{{$auction['arrive_cost']}}</td>
                    </tr>
                    @endforeach
                    @endisset
                    <tr class="text-center">
                        <td  class="bg-tree"></td>
                        <td>合计汇总</td>
                        <td>{{$total['budget']}}</td>
                        <td>{{$total['cost']}}</td>
                        <td>{{$total['click']}}</td>
                        <td>{{$total['zixun']}}</td>
                        <td>{{$total['yuyue']}}</td>
                        <td>{{$total['arrive']}}</td>
                        <td>{{$total['zixun_cost']}}</td>
                        <td>{{$total['arrive_cost']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
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
    </script>
@endsection
