@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('progress.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="searchDate">日期：</label>
                    <input type="text" class="form-control date-item" name="searchDate" id="searchDate" required value="{{(isset($year)&&isset($month))?$year.'-'.$month:\Carbon\Carbon::now()->year.'-'.\Carbon\Carbon::now()->month}}">
                    </div>
                <button type="submit" class="btn btn-success">搜索</button>
                <hr>
                <input type="hidden" id="monthSub" name="monthSub" value="">
                @for ($i = 1; $i <= 12; $i++)
                <button type="button" class="btn btn-success month-sub-option" style="margin-bottom: 5px;" data-month="{{(isset($year)?$year:\Carbon\Carbon::now()->year) . '-' . $i}}">{{(isset($year)?$year:\Carbon\Carbon::now()->year) . '-' .$i}}</button>
                @endfor
            </form>
            <div class="box-tools"></div>
        </div>
        <div class="box-body table-responsive">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if(!empty($complete))
                        @foreach($complete as $office_id=>$v)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$office_id}}" class="tab-switch" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$office_id]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($complete))
                        @foreach($complete as $office_id=>$v)
                            <div class="tab-pane {{$loop->first?'active':''}}" id="tab_{{$office_id}}">
                                @isset($v['month_complete'])
                                <div class="table-item table-responsive">
                                    <h5 class="text-center"><b class="text-primary">月任务完成进度</b></h5>
                                    <table class="table table-bordered" id="table-month-{{$office_id}}">
                                        <thead class="text-center">
                                        <tr>
                                            <th class="text-center" colspan="3">总目标</th>
                                            <th class="text-center" colspan="10">竞价</th>
                                            <th class="text-center">策划转化率</th>
                                            <th class="text-center" colspan="5">咨询目标</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">{{isset($year)?$year:''}}年度</th>
                                            <th class="text-center">广告宣传</th>
                                            <th class="text-center">到院量</th>
                                            <th class="text-center">展现量</th>
                                            <th class="text-center">点击</th>
                                            <th class="text-center">点击率</th>
                                            <th class="text-center">总对话</th>
                                            <th class="text-center">有效对话</th>
                                            <th class="text-center">留联量</th>
                                            <th class="text-center">总预约</th>
                                            <th class="text-center">总到院</th>
                                            <th class="text-center">咨询成本</th>
                                            <th class="text-center">到院成本</th>
                                            <th class="text-center">点效比</th>
                                            <th class="text-center">有效对话率</th>
                                            <th class="text-center">留联率</th>
                                            <th class="text-center">预约率</th>
                                            <th class="text-center">到院率</th>
                                            <th class="text-center">咨询转化率</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($target[$office_id]['targets'][$month]))
                                        <tr class="text-center">
                                            <td>{{$month}}月任务</td>
                                            <td>{{$target[$office_id]['targets'][$month]->cost}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->arrive}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->show}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->click}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->show>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->click / $target[$office_id]['targets'][$month]->show)*100 . '%':''}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->achat}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->chat}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->contact}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->yuyue}}</td>
                                            <td>{{$target[$office_id]['targets'][$month]->arrive}}</td>
                                            {{--咨询成本--}}
                                            <td>{{$target[$office_id]['targets'][$month]->chat>0?sprintf('%.2f',$target[$office_id]['targets'][$month]->cost / $target[$office_id]['targets'][$month]->chat):''}}</td>
                                            {{--到院成本--}}
                                            <td>{{$target[$office_id]['targets'][$month]->arrive>0?sprintf('%.2f',$target[$office_id]['targets'][$month]->cost / $target[$office_id]['targets'][$month]->arrive):''}}</td>
                                            {{--点效比--}}
                                            <td>{{$target[$office_id]['targets'][$month]->click>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->chat / $target[$office_id]['targets'][$month]->click)*100 . '%':''}}</td>
                                            {{--有效对话率--}}
                                            <td>{{$target[$office_id]['targets'][$month]->achat>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->chat / $target[$office_id]['targets'][$month]->achat)*100 . '%':''}}</td>
                                            {{--留联率--}}
                                            <td>{{$target[$office_id]['targets'][$month]->chat>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->contact / $target[$office_id]['targets'][$month]->chat)*100 . '%':''}}</td>
                                            {{--预约率--}}
                                            <td>{{$target[$office_id]['targets'][$month]->chat>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->yuyue / $target[$office_id]['targets'][$month]->chat)*100 . '%':''}}</td>
                                            {{--到院率--}}
                                            <td>{{$target[$office_id]['targets'][$month]->yuyue>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->arrive / $target[$office_id]['targets'][$month]->yuyue)*100 . '%':''}}</td>
                                            {{--咨询转化率--}}
                                            <td>{{$target[$office_id]['targets'][$month]->chat>0?sprintf('%.4f',$target[$office_id]['targets'][$month]->arrive / $target[$office_id]['targets'][$month]->chat)*100 . '%':''}}</td>
                                        </tr>
                                        @endif
                                        @if(isset($v['month_complete'][$month]))
                                        <tr class="text-center">
                                            <td>{{$month}}月完成</td>
                                            <td>{{sprintf('%.2f',$v['month_complete'][$month]['cost'])}}</td>
                                            <td>{{$v['month_complete'][$month]['arrive']}}</td>
                                            <td>{{$v['month_complete'][$month]['show']}}</td>
                                            <td>{{$v['month_complete'][$month]['click']}}</td>
                                            <td>{{$v['month_complete'][$month]['show']>0?sprintf('%.4f',$v['month_complete'][$month]['click']/$v['month_complete'][$month]['show'])*100 . '%':''}}</td>
                                            <td>{{$v['month_complete'][$month]['achat']}}</td>
                                            <td>{{$v['month_complete'][$month]['chat']}}</td>
                                            <td>{{$v['month_complete'][$month]['contact']}}</td>
                                            <td>{{$v['month_complete'][$month]['yuyue']}}</td>
                                            <td>{{$v['month_complete'][$month]['arrive']}}</td>
                                            {{--咨询成本--}}
                                            <td>{{$v['month_complete'][$month]['chat']>0?sprintf('%.2f',$v['month_complete'][$month]['cost']/$v['month_complete'][$month]['chat']):''}}</td>
                                            {{--到院成本--}}
                                            <td>{{$v['month_complete'][$month]['arrive']>0?sprintf('%.2f',$v['month_complete'][$month]['cost']/$v['month_complete'][$month]['arrive']):''}}</td>
                                            {{--点效比--}}
                                            <td>{{$v['month_complete'][$month]['click']>0?sprintf('%.4f',$v['month_complete'][$month]['chat']/$v['month_complete'][$month]['click'])*100 . '%':''}}</td>
                                            {{--有效对话率--}}
                                            <td>{{$v['month_complete'][$month]['achat']>0?sprintf('%.4f',$v['month_complete'][$month]['chat']/$v['month_complete'][$month]['achat'])*100 . '%':''}}</td>
                                            {{--留联率--}}
                                            <td>{{$v['month_complete'][$month]['chat']>0?sprintf('%.4f',$v['month_complete'][$month]['contact']/$v['month_complete'][$month]['chat'])*100 . '%':''}}</td>
                                            {{--预约率--}}
                                            <td>{{$v['month_complete'][$month]['chat']>0?sprintf('%.4f',$v['month_complete'][$month]['yuyue']/$v['month_complete'][$month]['chat'])*100 . '%':''}}</td>
                                            {{--到院率--}}
                                            <td>{{$v['month_complete'][$month]['yuyue']>0?sprintf('%.4f',$v['month_complete'][$month]['arrive']/$v['month_complete'][$month]['yuyue'])*100 . '%':''}}</td>
                                            {{--咨询转化率--}}
                                            <td>{{$v['month_complete'][$month]['chat']>0?sprintf('%.4f',$v['month_complete'][$month]['arrive']/$v['month_complete'][$month]['chat'])*100 . '%':''}}</td>
                                        </tr>
                                        @endif
                                        @if(isset($v['month_complete'][$month])&&isset($target[$office_id]['targets'][$month]))
                                        <tr class="text-center">
                                            <td class="bg-tree">月完成进度</td>
                                            {{--消费--}}
                                            <td>{{$target[$office_id]['targets'][$month]->cost>0?sprintf('%.4f',$v['month_complete'][$month]['cost']/$target[$office_id]['targets'][$month]->cost)*100 . '%':''}}</td>
                                            {{--到院--}}
                                            <td>{{$target[$office_id]['targets'][$month]->arrive>0?sprintf('%.4f',$v['month_complete'][$month]['arrive']/$target[$office_id]['targets'][$month]->arrive)*100 . '%':''}}</td>
                                            {{--展现--}}
                                            <td>{{$target[$office_id]['targets'][$month]->show>0?sprintf('%.4f',$v['month_complete'][$month]['show']/$target[$office_id]['targets'][$month]->show)*100 . '%':''}}</td>
                                            {{--点击--}}
                                            <td>{{$target[$office_id]['targets'][$month]->click>0?sprintf('%.4f',$v['month_complete'][$month]['click']/$target[$office_id]['targets'][$month]->click)*100 . '%':''}}</td>
                                            {{--点击率--}}
                                            <td>{{($v['month_complete'][$month]['show']>0&&$target[$office_id]['targets'][$month]->click>0&&$target[$office_id]['targets'][$month]->show>0)?sprintf('%.4f',($v['month_complete'][$month]['click']/$v['month_complete'][$month]['show'])/($target[$office_id]['targets'][$month]->click / $target[$office_id]['targets'][$month]->show))*100 . '%':''}}</td>
                                            {{--总对话--}}
                                            <td>{{$target[$office_id]['targets'][$month]->achat>0?sprintf('%.4f',$v['month_complete'][$month]['achat']/$target[$office_id]['targets'][$month]->achat)*100 . '%':''}}</td>
                                            {{--有效对话--}}
                                            <td>{{$target[$office_id]['targets'][$month]->chat>0?sprintf('%.4f',$v['month_complete'][$month]['chat']/$target[$office_id]['targets'][$month]->chat)*100 . '%':''}}</td>
                                            {{--留联量--}}
                                            <td>{{$target[$office_id]['targets'][$month]->contact>0?sprintf('%.4f',$v['month_complete'][$month]['contact']/$target[$office_id]['targets'][$month]->contact)*100 . '%':''}}</td>
                                            {{--总预约--}}
                                            <td>{{$target[$office_id]['targets'][$month]->yuyue>0?sprintf('%.4f',$v['month_complete'][$month]['yuyue']/$target[$office_id]['targets'][$month]->yuyue)*100 . '%':''}}</td>
                                            {{--总到院--}}
                                            <td>{{$target[$office_id]['targets'][$month]->arrive>0?sprintf('%.4f',$v['month_complete'][$month]['arrive']/$target[$office_id]['targets'][$month]->arrive)*100 . '%':''}}</td>
                                            {{--咨询成本--}}
                                            <td>{{($v['month_complete'][$month]['chat']>0&&$target[$office_id]['targets'][$month]->cost>0&&$target[$office_id]['targets'][$month]->chat>0)?sprintf('%.4f',($v['month_complete'][$month]['cost']/$v['month_complete'][$month]['chat'])/($target[$office_id]['targets'][$month]->cost / $target[$office_id]['targets'][$month]->chat))*100 . '%':''}}</td>
                                            {{--到院成本--}}
                                            <td>{{($target[$office_id]['targets'][$month]->arrive>0&&$v['month_complete'][$month]['cost']>0&&$v['month_complete'][$month]['arrive']>0)?sprintf('%.4f',($target[$office_id]['targets'][$month]->cost / $target[$office_id]['targets'][$month]->arrive)/($v['month_complete'][$month]['cost']/$v['month_complete'][$month]['arrive']))*100 . '%':''}}</td>
                                            {{--点效比--}}
                                            <td>{{($v['month_complete'][$month]['click']>0&&$target[$office_id]['targets'][$month]->chat>0&&$target[$office_id]['targets'][$month]->click>0)?sprintf('%.4f',($v['month_complete'][$month]['chat']/$v['month_complete'][$month]['click'])/($target[$office_id]['targets'][$month]->chat / $target[$office_id]['targets'][$month]->click))*100 . '%':''}}</td>
                                            {{--有效对话率--}}
                                            <td>{{($v['month_complete'][$month]['achat']>0&&$target[$office_id]['targets'][$month]->chat>0&&$target[$office_id]['targets'][$month]->achat>0)?sprintf('%.4f',($v['month_complete'][$month]['chat']/$v['month_complete'][$month]['achat'])/($target[$office_id]['targets'][$month]->chat / $target[$office_id]['targets'][$month]->achat))*100 . '%':''}}</td>
                                            {{--留联率--}}
                                            <td>{{($v['month_complete'][$month]['chat']>0&&$target[$office_id]['targets'][$month]->contact>0&&$target[$office_id]['targets'][$month]->chat>0)?sprintf('%.4f',($v['month_complete'][$month]['contact']/$v['month_complete'][$month]['chat'])/($target[$office_id]['targets'][$month]->contact / $target[$office_id]['targets'][$month]->chat))*100 . '%':''}}</td>
                                            {{--预约率--}}
                                            <td>{{($v['month_complete'][$month]['chat']>0&&$target[$office_id]['targets'][$month]->yuyue>0&&$target[$office_id]['targets'][$month]->chat>0)?sprintf('%.4f',($v['month_complete'][$month]['yuyue']/$v['month_complete'][$month]['chat'])/($target[$office_id]['targets'][$month]->yuyue / $target[$office_id]['targets'][$month]->chat))*100 . '%':''}}</td>
                                            {{--到院率--}}
                                            <td>{{($v['month_complete'][$month]['arrive']>0&&$target[$office_id]['targets'][$month]->arrive>0&&$target[$office_id]['targets'][$month]->yuyue>0)?sprintf('%.4f',($v['month_complete'][$month]['arrive']/$v['month_complete'][$month]['yuyue'])/($target[$office_id]['targets'][$month]->arrive / $target[$office_id]['targets'][$month]->yuyue))*100 . '%':''}}</td>
                                            {{--咨询转化率--}}
                                            <td>{{($v['month_complete'][$month]['arrive']>0&&$target[$office_id]['targets'][$month]->arrive>0&&$target[$office_id]['targets'][$month]->chat>0)?sprintf('%.4f',($v['month_complete'][$month]['arrive']/$v['month_complete'][$month]['chat'])/($target[$office_id]['targets'][$month]->arrive / $target[$office_id]['targets'][$month]->chat))*100 . '%':''}}</td>
                                        </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                @endisset
                                @isset($v['year_complete'])
                                    <div class="table-item table-responsive">
                                        <h5 class="text-center"><b class="text-primary">年任务完成进度</b></h5>
                                        <table class="table table-bordered" id="table-year-{{$office_id}}">
                                            <thead class="text-center">
                                            <tr>
                                                <th class="text-center" colspan="3">总目标</th>
                                                <th class="text-center" colspan="10">竞价</th>
                                                <th class="text-center">策划转化率</th>
                                                <th class="text-center" colspan="5">咨询目标</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">{{isset($year)?$year:''}}年度</th>
                                                <th class="text-center">广告宣传</th>
                                                <th class="text-center">到院量</th>
                                                <th class="text-center">展现量</th>
                                                <th class="text-center">点击</th>
                                                <th class="text-center">点击率</th>
                                                <th class="text-center">总对话</th>
                                                <th class="text-center">有效对话</th>
                                                <th class="text-center">留联量</th>
                                                <th class="text-center">总预约</th>
                                                <th class="text-center">总到院</th>
                                                <th class="text-center">咨询成本</th>
                                                <th class="text-center">到院成本</th>
                                                <th class="text-center">点效比</th>
                                                <th class="text-center">有效对话率</th>
                                                <th class="text-center">留联率</th>
                                                <th class="text-center">预约率</th>
                                                <th class="text-center">到院率</th>
                                                <th class="text-center">咨询转化率</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(isset($target[$office_id]['total']))
                                                <tr class="text-center">
                                                    <td>{{$year}}年任务</td>
                                                    <td>{{$target[$office_id]['total']['cost']}}</td>
                                                    <td>{{$target[$office_id]['total']['arrive']}}</td>
                                                    <td>{{$target[$office_id]['total']['show']}}</td>
                                                    <td>{{$target[$office_id]['total']['click']}}</td>
                                                    <td>{{$target[$office_id]['total']['show']>0?sprintf('%.4f',$target[$office_id]['total']['click'] / $target[$office_id]['total']['show'])*100 . '%':''}}</td>
                                                    <td>{{$target[$office_id]['total']['achat']}}</td>
                                                    <td>{{$target[$office_id]['total']['chat']}}</td>
                                                    <td>{{$target[$office_id]['total']['contact']}}</td>
                                                    <td>{{$target[$office_id]['total']['yuyue']}}</td>
                                                    <td>{{$target[$office_id]['total']['arrive']}}</td>
                                                    {{--咨询成本--}}
                                                    <td>{{$target[$office_id]['total']['chat']>0?sprintf('%.2f',$target[$office_id]['total']['cost'] / $target[$office_id]['total']['chat']):''}}</td>
                                                    {{--到院成本--}}
                                                    <td>{{$target[$office_id]['total']['arrive']>0?sprintf('%.2f',$target[$office_id]['total']['cost'] / $target[$office_id]['total']['arrive']):''}}</td>
                                                    {{--点效比--}}
                                                    <td>{{$target[$office_id]['total']['click']>0?sprintf('%.4f',$target[$office_id]['total']['chat'] / $target[$office_id]['total']['click'])*100 . '%':''}}</td>
                                                    {{--有效对话率--}}
                                                    <td>{{$target[$office_id]['total']['achat']>0?sprintf('%.4f',$target[$office_id]['total']['chat'] / $target[$office_id]['total']['achat'])*100 . '%':''}}</td>
                                                    {{--留联率--}}
                                                    <td>{{$target[$office_id]['total']['chat']>0?sprintf('%.4f',$target[$office_id]['total']['contact'] / $target[$office_id]['total']['chat'])*100 . '%':''}}</td>
                                                    {{--预约率--}}
                                                    <td>{{$target[$office_id]['total']['chat']>0?sprintf('%.4f',$target[$office_id]['total']['yuyue'] / $target[$office_id]['total']['chat'])*100 . '%':''}}</td>
                                                    {{--到院率--}}
                                                    <td>{{$target[$office_id]['total']['yuyue']>0?sprintf('%.4f',$target[$office_id]['total']['arrive'] / $target[$office_id]['total']['yuyue'])*100 . '%':''}}</td>
                                                    {{--咨询转化率--}}
                                                    <td>{{$target[$office_id]['total']['chat']>0?sprintf('%.4f',$target[$office_id]['total']['arrive'] / $target[$office_id]['total']['chat'])*100 . '%':''}}</td>
                                                </tr>
                                            @endif
                                            @if(isset($v['year_complete']))
                                                <tr class="text-center">
                                                    <td>{{$year}}年完成</td>
                                                    <td>{{sprintf('%.2f',$v['year_complete']['cost'])}}</td>
                                                    <td>{{$v['year_complete']['arrive']}}</td>
                                                    <td>{{$v['year_complete']['show']}}</td>
                                                    <td>{{$v['year_complete']['click']}}</td>
                                                    <td>{{$v['year_complete']['show']>0?sprintf('%.4f',$v['year_complete']['click']/$v['year_complete']['show'])*100 . '%':''}}</td>
                                                    <td>{{$v['year_complete']['achat']}}</td>
                                                    <td>{{$v['year_complete']['chat']}}</td>
                                                    <td>{{$v['year_complete']['contact']}}</td>
                                                    <td>{{$v['year_complete']['yuyue']}}</td>
                                                    <td>{{$v['year_complete']['arrive']}}</td>
                                                    {{--咨询成本--}}
                                                    <td>{{$v['year_complete']['chat']>0?sprintf('%.2f',$v['year_complete']['cost']/$v['year_complete']['chat']):''}}</td>
                                                    {{--到院成本--}}
                                                    <td>{{$v['year_complete']['arrive']>0?sprintf('%.2f',$v['year_complete']['cost']/$v['year_complete']['arrive']):''}}</td>
                                                    {{--点效比--}}
                                                    <td>{{$v['year_complete']['click']>0?sprintf('%.4f',$v['year_complete']['chat']/$v['year_complete']['click'])*100 . '%':''}}</td>
                                                    {{--有效对话率--}}
                                                    <td>{{$v['year_complete']['achat']>0?sprintf('%.4f',$v['year_complete']['chat']/$v['year_complete']['achat'])*100 . '%':''}}</td>
                                                    {{--留联率--}}
                                                    <td>{{$v['year_complete']['chat']>0?sprintf('%.4f',$v['year_complete']['contact']/$v['year_complete']['chat'])*100 . '%':''}}</td>
                                                    {{--预约率--}}
                                                    <td>{{$v['year_complete']['chat']>0?sprintf('%.4f',$v['year_complete']['yuyue']/$v['year_complete']['chat'])*100 . '%':''}}</td>
                                                    {{--到院率--}}
                                                    <td>{{$v['year_complete']['yuyue']>0?sprintf('%.4f',$v['year_complete']['arrive']/$v['year_complete']['yuyue'])*100 . '%':''}}</td>
                                                    {{--咨询转化率--}}
                                                    <td>{{$v['year_complete']['chat']>0?sprintf('%.4f',$v['year_complete']['arrive']/$v['year_complete']['chat'])*100 . '%':''}}</td>
                                                </tr>
                                            @endif
                                            @if(isset($v['year_complete'])&&isset($target[$office_id]['total']))
                                                <tr class="text-center">
                                                    <td class="bg-tree">年完成进度</td>
                                                    {{--消费--}}
                                                    <td>{{$target[$office_id]['total']['cost']>0?sprintf('%.4f',$v['year_complete']['cost']/$target[$office_id]['total']['cost'])*100 . '%':''}}</td>
                                                    {{--到院--}}
                                                    <td>{{$target[$office_id]['total']['arrive']>0?sprintf('%.4f',$v['year_complete']['arrive']/$target[$office_id]['total']['arrive'])*100 . '%':''}}</td>
                                                    {{--展现--}}
                                                    <td>{{$target[$office_id]['total']['show']>0?sprintf('%.4f',$v['year_complete']['show']/$target[$office_id]['total']['show'])*100 . '%':''}}</td>
                                                    {{--点击--}}
                                                    <td>{{$target[$office_id]['total']['click']>0?sprintf('%.4f',$v['year_complete']['click']/$target[$office_id]['total']['click'])*100 . '%':''}}</td>
                                                    {{--点击率--}}
                                                    <td>{{($v['year_complete']['show']>0&&$target[$office_id]['total']['click']>0&&$target[$office_id]['total']['show']>0)?sprintf('%.4f',($v['year_complete']['click']/$v['year_complete']['show'])/($target[$office_id]['total']['click'] / $target[$office_id]['total']['show']))*100 . '%':''}}</td>
                                                    {{--总对话--}}
                                                    <td>{{$target[$office_id]['total']['achat']>0?sprintf('%.4f',$v['year_complete']['achat']/$target[$office_id]['total']['achat'])*100 . '%':''}}</td>
                                                    {{--有效对话--}}
                                                    <td>{{$target[$office_id]['total']['chat']>0?sprintf('%.4f',$v['year_complete']['chat']/$target[$office_id]['total']['chat'])*100 . '%':''}}</td>
                                                    {{--留联--}}
                                                    <td>{{$target[$office_id]['total']['contact']>0?sprintf('%.4f',$v['year_complete']['contact']/$target[$office_id]['total']['contact'])*100 . '%':''}}</td>
                                                    {{--总预约--}}
                                                    <td>{{$target[$office_id]['total']['yuyue']>0?sprintf('%.4f',$v['year_complete']['yuyue']/$target[$office_id]['total']['yuyue'])*100 . '%':''}}</td>
                                                    {{--总到院--}}
                                                    <td>{{$target[$office_id]['total']['arrive']>0?sprintf('%.4f',$v['year_complete']['arrive']/$target[$office_id]['total']['arrive'])*100 . '%':''}}</td>
                                                    {{--咨询成本--}}
                                                    <td>{{($v['year_complete']['chat']>0&&$target[$office_id]['total']['cost']>0&&$target[$office_id]['total']['chat']>0)?sprintf('%.4f',($v['year_complete']['cost']/$v['year_complete']['chat'])/($target[$office_id]['total']['cost'] / $target[$office_id]['total']['chat']))*100 . '%':''}}</td>
                                                    {{--到院成本--}}
                                                    <td>{{($target[$office_id]['total']['arrive']>0&&$v['year_complete']['cost']>0&&$v['year_complete']['arrive']>0)?sprintf('%.4f',($target[$office_id]['total']['cost'] / $target[$office_id]['total']['arrive'])/($v['year_complete']['cost']/$v['year_complete']['arrive']))*100 . '%':''}}</td>
                                                    {{--点效比--}}
                                                    <td>{{($v['year_complete']['click']>0&&$target[$office_id]['total']['chat']>0&&$target[$office_id]['total']['click']>0)?sprintf('%.4f',($v['year_complete']['chat']/$v['year_complete']['click'])/($target[$office_id]['total']['chat'] / $target[$office_id]['total']['click']))*100 . '%':''}}</td>
                                                    {{--有效对话率--}}
                                                    <td>{{($v['year_complete']['achat']>0&&$target[$office_id]['total']['chat']>0&&$target[$office_id]['total']['achat']>0)?sprintf('%.4f',($v['year_complete']['chat']/$v['year_complete']['achat'])/($target[$office_id]['total']['chat'] / $target[$office_id]['total']['achat']))*100 . '%':''}}</td>
                                                    {{--留联率--}}
                                                    <td>{{($v['year_complete']['chat']>0&&$target[$office_id]['total']['contact']>0&&$target[$office_id]['total']['chat']>0)?sprintf('%.4f',($v['year_complete']['contact']/$v['year_complete']['chat'])/($target[$office_id]['total']['contact'] / $target[$office_id]['total']['chat']))*100 . '%':''}}</td>
                                                    {{--预约率--}}
                                                    <td>{{($v['year_complete']['chat']>0&&$target[$office_id]['total']['yuyue']>0&&$target[$office_id]['total']['chat']>0)?sprintf('%.4f',($v['year_complete']['yuyue']/$v['year_complete']['chat'])/($target[$office_id]['total']['yuyue'] / $target[$office_id]['total']['chat']))*100 . '%':''}}</td>
                                                    {{--到院率--}}
                                                    <td>{{($v['year_complete']['arrive']>0&&$target[$office_id]['total']['arrive']>0&&$target[$office_id]['total']['yuyue']>0)?sprintf('%.4f',($v['year_complete']['arrive']/$v['year_complete']['yuyue'])/($target[$office_id]['total']['arrive'] / $target[$office_id]['total']['yuyue']))*100 . '%':''}}</td>
                                                    {{--咨询转化率--}}
                                                    <td>{{($v['year_complete']['arrive']>0&&$target[$office_id]['total']['arrive']>0&&$target[$office_id]['total']['chat']>0)?sprintf('%.4f',($v['year_complete']['arrive']/$v['year_complete']['chat'])/($target[$office_id]['total']['arrive'] / $target[$office_id]['total']['chat']))*100 . '%':''}}</td>
                                                </tr>
                                            @endif
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
        </div>
        <!-- /.box-body -->
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
                type:'month'
                // value: new Date()
            });
        });

        $(".box-body li.active a").each(function () {
            var tabId=$(this).attr('href');
            $(tabId+" .table-item").each(function () {
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
            $(tabId+" .table-item").each(function () {
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
        $(".month-sub-option").click(function () {
            var monthSub=$(this).data('month');
            $("input:hidden[name=monthSub]").val(monthSub);
            $("form#search-form").submit();
        });
    </script>
@endsection
