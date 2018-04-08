@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('outputszx.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="searchDate">日期：</label>
                    <input type="text" class="form-control date-item" name="searchMonth" id="searchMonth" required value="{{isset($year)&&isset($month)?($year.'-'.$month):null}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
                <hr>
                <input type="hidden" id="monthSub" name="monthSub" value="">

            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 280px;">

                </div>
            </div>
        </div>
        <form action="" method="post" class="outputszx-form">
        {{method_field('DELETE')}}
        {{csrf_field()}}
        <div class="box-body" id="table-content">
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong>本月数据({{(isset($year)?$year:'') . '年'.(isset($month)?$month:'') . '月'}})</strong></h5>
                <table id="table-month" class="table text-center table-bordered" style="background: #C7EDCC;">
                <thead>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="5">商务通</th>
                        <th colspan="4">电话</th>
                        <th colspan="4">自媒体</th>
                        <th colspan="4">手机抓取</th>
                        <th colspan="10">合计</th>
                    </tr>
                    <tr>
                        <th>项目</th>
                        <th>咨询员</th>

                        <th>咨询</th>
                        <th>留联</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>
                        {{--合计--}}
                        <th>咨询量</th>
                        <th>留联</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>就诊量</th>
                        <th>留联率</th>
                        <th>预约率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                        <th>咨询转化率</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($monthOutputs)
                    @foreach($monthOutputs['outputs'] as $office_id=>$outputs)
                    @foreach($outputs as $user_id=>$output)
                    <tr>
                        @if($loop->first)
                        <td rowspan="{{$loop->count+1}}" style="vertical-align: middle;">{{isset($offices[$office_id])?$offices[$office_id]:''}}</td>
                        @endif
                        <td class="progress-btn" style="cursor: pointer;" data-office="{{$office_id}}" data-toggle="modal" data-target="#progressModel" data-month="{{isset($month)?$month:\Carbon\Carbon::now()->month}}" data-year="{{isset($year)?$year:\Carbon\Carbon::now()->year}}" data-user="{{$user_id}}">{{isset($users[$user_id])?$users[$user_id]:''}}</td>
                        <td>{{isset($output['swt']['zixun'])?$output['swt']['zixun']:0}}</td>
                        <td>{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                        <td>{{isset($output['swt']['yuyue'])?$output['swt']['yuyue']:0}}</td>
                        <td>{{isset($output['swt']['arrive'])?$output['swt']['arrive']:0}}</td>
                        <td>{{isset($output['swt']['jiuzhen'])?$output['swt']['jiuzhen']:0}}</td>

                        <td>{{isset($output['tel']['zixun'])?$output['tel']['zixun']:0}}</td>
                        <td>{{isset($output['tel']['yuyue'])?$output['tel']['yuyue']:0}}</td>
                        <td>{{isset($output['tel']['arrive'])?$output['tel']['arrive']:0}}</td>
                        <td>{{isset($output['tel']['jiuzhen'])?$output['tel']['jiuzhen']:0}}</td>

                        <td>{{isset($output['zmt']['zixun'])?$output['zmt']['zixun']:0}}</td>
                        <td>{{isset($output['zmt']['yuyue'])?$output['zmt']['yuyue']:0}}</td>
                        <td>{{isset($output['zmt']['arrive'])?$output['zmt']['arrive']:0}}</td>
                        <td>{{isset($output['zmt']['jiuzhen'])?$output['zmt']['jiuzhen']:0}}</td>

                        <td>{{isset($output['catch']['zixun'])?$output['catch']['zixun']:0}}</td>
                        <td>{{isset($output['catch']['yuyue'])?$output['catch']['yuyue']:0}}</td>
                        <td>{{isset($output['catch']['arrive'])?$output['catch']['arrive']:0}}</td>
                        <td>{{isset($output['catch']['jiuzhen'])?$output['catch']['jiuzhen']:0}}</td>

                        <td>{{isset($output['total']['zixun'])?$output['total']['zixun']:0}}</td>
                        <td>{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                        <td>{{isset($output['total']['yuyue'])?$output['total']['yuyue']:0}}</td>
                        <td>{{isset($output['total']['arrive'])?$output['total']['arrive']:0}}</td>
                        <td>{{isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0}}</td>
                        <td>{{(isset($output['swt']['zixun'])&&$output['swt']['zixun']>0)?sprintf('%.4f',((isset($output['swt']['contact'])?$output['swt']['contact']:0)/$output['swt']['zixun']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['yuyue'])?$output['total']['yuyue']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['yuyue'])&&$output['total']['yuyue']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['yuyue']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['arrive'])&&$output['total']['arrive']>0)?sprintf('%.4f',((isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0)/$output['total']['arrive']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                    </tr>
                    @endforeach
                    <tr class="text-red" style="font-weight: bold;">
                        <td class="progress-btn" style="cursor: pointer;" data-office="{{$office_id}}" data-toggle="modal" data-target="#progressModel" data-month="{{isset($month)?$month:\Carbon\Carbon::now()->month}}" data-year="{{isset($year)?$year:\Carbon\Carbon::now()->year}}">合计</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['swt']['zixun'])?$monthOutputs['totaloutputs'][$office_id]['swt']['zixun']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['swt']['contact'])?$monthOutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['swt']['yuyue'])?$monthOutputs['totaloutputs'][$office_id]['swt']['yuyue']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['swt']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['swt']['arrive']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['swt']['jiuzhen'])?$monthOutputs['totaloutputs'][$office_id]['swt']['jiuzhen']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['tel']['zixun'])?$monthOutputs['totaloutputs'][$office_id]['tel']['zixun']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['tel']['yuyue'])?$monthOutputs['totaloutputs'][$office_id]['tel']['yuyue']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['tel']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['tel']['arrive']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['tel']['jiuzhen'])?$monthOutputs['totaloutputs'][$office_id]['tel']['jiuzhen']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['zmt']['zixun'])?$monthOutputs['totaloutputs'][$office_id]['zmt']['zixun']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['zmt']['yuyue'])?$monthOutputs['totaloutputs'][$office_id]['zmt']['yuyue']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['zmt']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['zmt']['arrive']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['zmt']['jiuzhen'])?$monthOutputs['totaloutputs'][$office_id]['zmt']['jiuzhen']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['catch']['zixun'])?$monthOutputs['totaloutputs'][$office_id]['catch']['zixun']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['catch']['yuyue'])?$monthOutputs['totaloutputs'][$office_id]['catch']['yuyue']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['catch']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['catch']['arrive']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['catch']['jiuzhen'])?$monthOutputs['totaloutputs'][$office_id]['catch']['jiuzhen']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['total']['zixun'])?$monthOutputs['totaloutputs'][$office_id]['total']['zixun']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['swt']['contact'])?$monthOutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['total']['yuyue'])?$monthOutputs['totaloutputs'][$office_id]['total']['yuyue']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['total']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['total']['arrive']:0}}</td>
                        <td>{{isset($monthOutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$monthOutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0}}</td>
                        <td>{{(isset($monthOutputs['totaloutputs'][$office_id]['swt']['zixun'])&&$monthOutputs['totaloutputs'][$office_id]['swt']['zixun']>0)?sprintf('%.4f',(isset($monthOutputs['totaloutputs'][$office_id]['swt']['contact'])?$monthOutputs['totaloutputs'][$office_id]['swt']['contact']:0)/$monthOutputs['totaloutputs'][$office_id]['swt']['zixun'])*100 . '%':0}}</td>
                        <td>{{(isset($monthOutputs['totaloutputs'][$office_id]['total']['zixun'])&&$monthOutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($monthOutputs['totaloutputs'][$office_id]['total']['yuyue'])?$monthOutputs['totaloutputs'][$office_id]['total']['yuyue']:0)/$monthOutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                        <td>{{(isset($monthOutputs['totaloutputs'][$office_id]['total']['yuyue'])&&$monthOutputs['totaloutputs'][$office_id]['total']['yuyue']>0)?sprintf('%.4f',(isset($monthOutputs['totaloutputs'][$office_id]['total']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$monthOutputs['totaloutputs'][$office_id]['total']['yuyue'])*100 . '%':0}}</td>
                        <td>{{(isset($monthOutputs['totaloutputs'][$office_id]['total']['arrive'])&&$monthOutputs['totaloutputs'][$office_id]['total']['arrive']>0)?sprintf('%.4f',(isset($monthOutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$monthOutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0)/$monthOutputs['totaloutputs'][$office_id]['total']['arrive'])*100 . '%':0}}</td>
                        <td>{{(isset($monthOutputs['totaloutputs'][$office_id]['total']['zixun'])&&$monthOutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($monthOutputs['totaloutputs'][$office_id]['total']['arrive'])?$monthOutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$monthOutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
                </table>
            </div>
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong>上月数据({{((isset($year)&&isset($month))?\Carbon\Carbon::createFromFormat('Y-m',$year.'-'.$month)->subMonth(1)->year:'') . '年'.((isset($year)&&isset($month))?\Carbon\Carbon::createFromFormat('Y-m',$year.'-'.$month)->subMonth(1)->month:'') . '月'}})</strong></h5>
                <table id="table-lastmonth" class="table text-center table-bordered" style="background: #C7EDCC;">
                    <thead>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="5">商务通</th>
                        <th colspan="4">电话</th>
                        <th colspan="4">自媒体</th>
                        <th colspan="4">手机抓取</th>
                        <th colspan="10">合计</th>
                    </tr>
                    <tr>
                        <th>项目</th>
                        <th>咨询员</th>

                        <th>咨询</th>
                        <th>留联</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>
                        {{--合计--}}
                        <th>咨询量</th>
                        <th>留联</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>就诊量</th>
                        <th>留联率</th>
                        <th>预约率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                        <th>咨询转化率</th>
                    </tr>
                    </thead>
                    <tbody>
                    @isset($lastMonthOutputs)
                        @foreach($lastMonthOutputs['outputs'] as $office_id=>$outputs)
                            @foreach($outputs as $user_id=>$output)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{$loop->count+1}}" style="vertical-align: middle;">{{isset($offices[$office_id])?$offices[$office_id]:''}}</td>
                                    @endif
                                    <td class="progress-btn" style="cursor: pointer;" data-toggle="modal" data-office="{{$office_id}}" data-target="#progressModel" data-toggle="modal" data-target="#progressModel" data-month="{{(isset($month)&&isset($year))?\Carbon\Carbon::createFromFormat('Y-m',$year.'-'.$month)->subMonth(1)->month:\Carbon\Carbon::now()->month}}" data-year="{{(isset($year)&&isset($month))?\Carbon\Carbon::createFromFormat('Y-m',$year.'-'.$month)->subMonth(1)->year:\Carbon\Carbon::now()->year}}" data-user="{{$user_id}}">{{isset($users[$user_id])?$users[$user_id]:''}}</td>
                                    <td>{{isset($output['swt']['zixun'])?$output['swt']['zixun']:0}}</td>
                                    <td>{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                                    <td>{{isset($output['swt']['yuyue'])?$output['swt']['yuyue']:0}}</td>
                                    <td>{{isset($output['swt']['arrive'])?$output['swt']['arrive']:0}}</td>
                                    <td>{{isset($output['swt']['jiuzhen'])?$output['swt']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['tel']['zixun'])?$output['tel']['zixun']:0}}</td>
                                    <td>{{isset($output['tel']['yuyue'])?$output['tel']['yuyue']:0}}</td>
                                    <td>{{isset($output['tel']['arrive'])?$output['tel']['arrive']:0}}</td>
                                    <td>{{isset($output['tel']['jiuzhen'])?$output['tel']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['zmt']['zixun'])?$output['zmt']['zixun']:0}}</td>
                                    <td>{{isset($output['zmt']['yuyue'])?$output['zmt']['yuyue']:0}}</td>
                                    <td>{{isset($output['zmt']['arrive'])?$output['zmt']['arrive']:0}}</td>
                                    <td>{{isset($output['zmt']['jiuzhen'])?$output['zmt']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['catch']['zixun'])?$output['catch']['zixun']:0}}</td>
                                    <td>{{isset($output['catch']['yuyue'])?$output['catch']['yuyue']:0}}</td>
                                    <td>{{isset($output['catch']['arrive'])?$output['catch']['arrive']:0}}</td>
                                    <td>{{isset($output['catch']['jiuzhen'])?$output['catch']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['total']['zixun'])?$output['total']['zixun']:0}}</td>
                                    <td>{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                                    <td>{{isset($output['total']['yuyue'])?$output['total']['yuyue']:0}}</td>
                                    <td>{{isset($output['total']['arrive'])?$output['total']['arrive']:0}}</td>
                                    <td>{{isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0}}</td>
                                    <td>{{(isset($output['swt']['zixun'])&&$output['swt']['zixun']>0)?sprintf('%.4f',((isset($output['swt']['contact'])?$output['swt']['contact']:0)/$output['swt']['zixun']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['yuyue'])?$output['total']['yuyue']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['yuyue'])&&$output['total']['yuyue']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['yuyue']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['arrive'])&&$output['total']['arrive']>0)?sprintf('%.4f',((isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0)/$output['total']['arrive']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                                </tr>
                            @endforeach
                            <tr class="text-red" style="font-weight: bold;">
                                <td class="progress-btn" style="cursor: pointer;" data-office="{{$office_id}}" data-toggle="modal" data-target="#progressModel" data-month="{{(isset($month)&&isset($year))?\Carbon\Carbon::createFromFormat('Y-m',$year.'-'.$month)->subMonth(1)->month:\Carbon\Carbon::now()->month}}" data-year="{{(isset($year)&&isset($month))?\Carbon\Carbon::createFromFormat('Y-m',$year.'-'.$month)->subMonth(1)->year:\Carbon\Carbon::now()->year}}">合计</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['zixun'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['zixun']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['contact'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['yuyue'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['yuyue']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['arrive']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['jiuzhen'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['jiuzhen']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['tel']['zixun'])?$lastMonthOutputs['totaloutputs'][$office_id]['tel']['zixun']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['tel']['yuyue'])?$lastMonthOutputs['totaloutputs'][$office_id]['tel']['yuyue']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['tel']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['tel']['arrive']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['tel']['jiuzhen'])?$lastMonthOutputs['totaloutputs'][$office_id]['tel']['jiuzhen']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['zmt']['zixun'])?$lastMonthOutputs['totaloutputs'][$office_id]['zmt']['zixun']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['zmt']['yuyue'])?$lastMonthOutputs['totaloutputs'][$office_id]['zmt']['yuyue']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['zmt']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['zmt']['arrive']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['zmt']['jiuzhen'])?$lastMonthOutputs['totaloutputs'][$office_id]['zmt']['jiuzhen']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['catch']['zixun'])?$lastMonthOutputs['totaloutputs'][$office_id]['catch']['zixun']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['catch']['yuyue'])?$lastMonthOutputs['totaloutputs'][$office_id]['catch']['yuyue']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['catch']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['catch']['arrive']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['catch']['jiuzhen'])?$lastMonthOutputs['totaloutputs'][$office_id]['catch']['jiuzhen']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['contact'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive']:0}}</td>
                                <td>{{isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0}}</td>
                                <td>{{(isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['zixun'])&&$lastMonthOutputs['totaloutputs'][$office_id]['swt']['zixun']>0)?sprintf('%.4f',(isset($lastMonthOutputs['totaloutputs'][$office_id]['swt']['contact'])?$lastMonthOutputs['totaloutputs'][$office_id]['swt']['contact']:0)/$lastMonthOutputs['totaloutputs'][$office_id]['swt']['zixun'])*100 . '%':0}}</td>
                                <td>{{(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun'])&&$lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue']:0)/$lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                                <td>{{(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue'])&&$lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue']>0)?sprintf('%.4f',(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$lastMonthOutputs['totaloutputs'][$office_id]['total']['yuyue'])*100 . '%':0}}</td>
                                <td>{{(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive'])&&$lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive']>0)?sprintf('%.4f',(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0)/$lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive'])*100 . '%':0}}</td>
                                <td>{{(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun'])&&$lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive'])?$lastMonthOutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$lastMonthOutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong>本年数据({{(isset($year)?$year:'') . '年'}})</strong></h5>
                <table id="table-year" class="table text-center table-bordered" style="background: #C7EDCC;">
                    <thead>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="5">商务通</th>
                        <th colspan="4">电话</th>
                        <th colspan="4">自媒体</th>
                        <th colspan="4">手机抓取</th>
                        <th colspan="10">合计</th>
                    </tr>
                    <tr>
                        <th>项目</th>
                        <th>咨询员</th>

                        <th>咨询</th>
                        <th>留联</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>
                        {{--合计--}}
                        <th>咨询量</th>
                        <th>留联</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>就诊量</th>
                        <th>留联率</th>
                        <th>预约率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                        <th>咨询转化率</th>
                    </tr>
                    </thead>
                    <tbody>
                    @isset($yearOutputs)
                        @foreach($yearOutputs['outputs'] as $office_id=>$outputs)
                            @foreach($outputs as $user_id=>$output)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{$loop->count+1}}" style="vertical-align: middle;">{{isset($offices[$office_id])?$offices[$office_id]:''}}</td>
                                    @endif
                                    <td class="progress-btn" style="cursor: pointer;" data-month="fullyear" data-year="{{isset($year)?$year:\Carbon\Carbon::now()->year}}" data-user="{{$user_id}}" data-office="{{$office_id}}">{{isset($users[$user_id])?$users[$user_id]:''}}</td>
                                    <td>{{isset($output['swt']['zixun'])?$output['swt']['zixun']:0}}</td>
                                    <td>{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                                    <td>{{isset($output['swt']['yuyue'])?$output['swt']['yuyue']:0}}</td>
                                    <td>{{isset($output['swt']['arrive'])?$output['swt']['arrive']:0}}</td>
                                    <td>{{isset($output['swt']['jiuzhen'])?$output['swt']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['tel']['zixun'])?$output['tel']['zixun']:0}}</td>
                                    <td>{{isset($output['tel']['yuyue'])?$output['tel']['yuyue']:0}}</td>
                                    <td>{{isset($output['tel']['arrive'])?$output['tel']['arrive']:0}}</td>
                                    <td>{{isset($output['tel']['jiuzhen'])?$output['tel']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['zmt']['zixun'])?$output['zmt']['zixun']:0}}</td>
                                    <td>{{isset($output['zmt']['yuyue'])?$output['zmt']['yuyue']:0}}</td>
                                    <td>{{isset($output['zmt']['arrive'])?$output['zmt']['arrive']:0}}</td>
                                    <td>{{isset($output['zmt']['jiuzhen'])?$output['zmt']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['catch']['zixun'])?$output['catch']['zixun']:0}}</td>
                                    <td>{{isset($output['catch']['yuyue'])?$output['catch']['yuyue']:0}}</td>
                                    <td>{{isset($output['catch']['arrive'])?$output['catch']['arrive']:0}}</td>
                                    <td>{{isset($output['catch']['jiuzhen'])?$output['catch']['jiuzhen']:0}}</td>

                                    <td>{{isset($output['total']['zixun'])?$output['total']['zixun']:0}}</td>
                                    <td>{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                                    <td>{{isset($output['total']['yuyue'])?$output['total']['yuyue']:0}}</td>
                                    <td>{{isset($output['total']['arrive'])?$output['total']['arrive']:0}}</td>
                                    <td>{{isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0}}</td>
                                    <td>{{(isset($output['swt']['zixun'])&&$output['swt']['zixun']>0)?sprintf('%.4f',((isset($output['swt']['contact'])?$output['swt']['contact']:0)/$output['swt']['zixun']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['yuyue'])?$output['total']['yuyue']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['yuyue'])&&$output['total']['yuyue']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['yuyue']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['arrive'])&&$output['total']['arrive']>0)?sprintf('%.4f',((isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0)/$output['total']['arrive']))*100 . '%':0}}</td>
                                    <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                                </tr>
                            @endforeach
                            <tr class="text-red" style="font-weight: bold;">
                                <td class="progress-btn" style="cursor: pointer;" data-month="fullyear" data-year="{{isset($year)?$year:\Carbon\Carbon::now()->year}}" data-office="{{$office_id}}">合计</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['swt']['zixun'])?$yearOutputs['totaloutputs'][$office_id]['swt']['zixun']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['swt']['contact'])?$yearOutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['swt']['yuyue'])?$yearOutputs['totaloutputs'][$office_id]['swt']['yuyue']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['swt']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['swt']['arrive']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['swt']['jiuzhen'])?$yearOutputs['totaloutputs'][$office_id]['swt']['jiuzhen']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['tel']['zixun'])?$yearOutputs['totaloutputs'][$office_id]['tel']['zixun']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['tel']['yuyue'])?$yearOutputs['totaloutputs'][$office_id]['tel']['yuyue']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['tel']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['tel']['arrive']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['tel']['jiuzhen'])?$yearOutputs['totaloutputs'][$office_id]['tel']['jiuzhen']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['zmt']['zixun'])?$yearOutputs['totaloutputs'][$office_id]['zmt']['zixun']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['zmt']['yuyue'])?$yearOutputs['totaloutputs'][$office_id]['zmt']['yuyue']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['zmt']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['zmt']['arrive']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['zmt']['jiuzhen'])?$yearOutputs['totaloutputs'][$office_id]['zmt']['jiuzhen']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['catch']['zixun'])?$yearOutputs['totaloutputs'][$office_id]['catch']['zixun']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['catch']['yuyue'])?$yearOutputs['totaloutputs'][$office_id]['catch']['yuyue']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['catch']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['catch']['arrive']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['catch']['jiuzhen'])?$yearOutputs['totaloutputs'][$office_id]['catch']['jiuzhen']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['total']['zixun'])?$yearOutputs['totaloutputs'][$office_id]['total']['zixun']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['swt']['contact'])?$yearOutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['total']['yuyue'])?$yearOutputs['totaloutputs'][$office_id]['total']['yuyue']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['total']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['total']['arrive']:0}}</td>
                                <td>{{isset($yearOutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$yearOutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0}}</td>
                                <td>{{(isset($yearOutputs['totaloutputs'][$office_id]['swt']['zixun'])&&$yearOutputs['totaloutputs'][$office_id]['swt']['zixun']>0)?sprintf('%.4f',(isset($yearOutputs['totaloutputs'][$office_id]['swt']['contact'])?$yearOutputs['totaloutputs'][$office_id]['swt']['contact']:0)/$yearOutputs['totaloutputs'][$office_id]['swt']['zixun'])*100 . '%':0}}</td>
                                <td>{{(isset($yearOutputs['totaloutputs'][$office_id]['total']['zixun'])&&$yearOutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($yearOutputs['totaloutputs'][$office_id]['total']['yuyue'])?$yearOutputs['totaloutputs'][$office_id]['total']['yuyue']:0)/$yearOutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                                <td>{{(isset($yearOutputs['totaloutputs'][$office_id]['total']['yuyue'])&&$yearOutputs['totaloutputs'][$office_id]['total']['yuyue']>0)?sprintf('%.4f',(isset($yearOutputs['totaloutputs'][$office_id]['total']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$yearOutputs['totaloutputs'][$office_id]['total']['yuyue'])*100 . '%':0}}</td>
                                <td>{{(isset($yearOutputs['totaloutputs'][$office_id]['total']['arrive'])&&$yearOutputs['totaloutputs'][$office_id]['total']['arrive']>0)?sprintf('%.4f',(isset($yearOutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$yearOutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0)/$yearOutputs['totaloutputs'][$office_id]['total']['arrive'])*100 . '%':0}}</td>
                                <td>{{(isset($yearOutputs['totaloutputs'][$office_id]['total']['zixun'])&&$yearOutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($yearOutputs['totaloutputs'][$office_id]['total']['arrive'])?$yearOutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$yearOutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                            </tr>
                        @endforeach
                    @endisset
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        </form>
    </div>
    <div class="modal fade" id="progressModel" tabindex="-1" role="dialog" aria-labelledby="myProgressModelLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        lay('.date-item').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'month'
                // value: new Date()
            });
        });
        //progress-btn
        $(".progress-btn").click(function () {
            var year=$(this).data('year');
            var month=$(this).data('month');
            var office_id=$(this).data('office');
            var user_id=$(this).data('user');
            if (typeof(user_id) == "undefined"){
                user_id='';
            }
            $.ajax({
                url: '/api/get-zx-user-progress',
                type: "post",
                data: {'office_id':office_id,'year':year,'month':month,'user_id':user_id,'_token': $('input[name=_token]').val()},
                success: function(data){
                    console.log(data);
                }
            });
        });
        $(".month-sub-option").click(function () {
            var monthSub=$(this).data('month');
            $("input:hidden[name=monthSub]").val(monthSub);
            $("form#search-form").submit();
        });
    </script>
@endsection
