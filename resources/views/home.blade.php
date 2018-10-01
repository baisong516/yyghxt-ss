@extends('layouts.base')

@section('content')
    {{--<link href="https://cdn.bootcss.com/photoswipe/4.1.2/photoswipe.min.css" rel="stylesheet">--}}
    {{--<link href="https://cdn.bootcss.com/photoswipe/4.1.2/default-skin/default-skin.min.css" rel="stylesheet">--}}
    {{--<script src="https://cdn.bootcss.com/photoswipe/4.1.2/photoswipe.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/photoswipe/4.1.2/photoswipe-ui-default.min.js"></script>--}}

    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-header">
                <form class="form-inline" action="{{route('home.search')}}"  id="search-form" name="search-form" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="searchDate">日期：</label>
                        <input type="text" class="form-control date-item" name="searchDateStart" id="searchDateStart" required value="{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()}}">
                        到
                        <input type="text" class="form-control date-item" name="searchDateEnd" id="searchDateEnd" required value="{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString()}}">
                        <input type="hidden" name="flag" value="">
                    </div>
                    <button type="submit" class="btn btn-success">搜索</button>
                </form>
            </div>
            <div class="box-body" id="table-sum-box-body">
                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;" id="today-pro" class="img-dom table-head"  data-id="tab-sum">
                    项目情况表(<a href="javascript:;" data-flag="t" class="data-flush">刷新</a>)
                </h4>
                <div class="box">
                    <div class="box-body table-item table-responsive table-bordered">
                        <style type="text/css">
                            table.tab-sum tr,table.tab-sum th,table.tab-sum td{border: solid 1px #666;}
                        </style>
                        <table class="table table-hover text-center tab-sum table-dom" id="tab-sum">
                            <thead>
                            <tr style="background: #66d7ea;">
                                <th>项目</th>
                                <th>咨询量</th>
                                <th>留联系</th>
                                <th>电话量</th>
                                <th>总咨询量</th>
                                <th>预约量</th>
                                <th>应到院</th>
                                <th>到院量</th>
                                <th>就诊量</th>
                                <th>预约率</th>
                                <th>留联率</th>
                                <th>到院率</th>
                                <th>就诊率</th>
                                <th>咨询转化率</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $office_id=>$v)
                                <tr id="todayListData">
                                <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'a','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['name']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'zixun','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['zixun_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'contact','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['contact_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'tel','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['tel_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'total','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['total_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'yuyue','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['yuyue_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'should','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['should_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'arrive','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['arrive_count']}}</a></td>
                                    <td><a href="{{route('zxcustomers.search',['ref'=>'index','office'=>$office_id,'q'=>'jiuzhen','start'=>urlencode($start),'end'=>urlencode($end)])}}" class="text-black">{{$v['jiuzhen_count']}}</a></td>
                                    <td>{{$v['yuyue_rate']}}</td>
                                    <td>{{$v['contact_rate']}}</td>
                                    <td>{{$v['arrive_rate']}}</td>
                                    <td>{{$v['jiuzhen_rate']}}</td>
                                    <td>{{$v['zhuanhua_rate']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-body" id="month-data-box-body">
                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;" id="month-data-head" class="table-head" data-id="month-data">
                    上月数据({{\Carbon\Carbon::now()->subMonth()->year}}-{{\Carbon\Carbon::now()->subMonth()->month}})(<a href="javascript:;" data-flag="m" class="data-flush">刷新</a>)
                </h4>
                <div class="box">
                    <div class="box-body table-item table-responsive table-bordered">
                        <style type="text/css">
                            table.tab-sum tr,table.tab-sum th,table.tab-sum td{border: solid 1px #666;}
                        </style>
                        <table class="table table-hover text-center tab-sum" id="month-data">
                            <thead>
                            <tr style="background: #66d7ea;">
                                <th>项目</th>
                                <th>咨询量</th>
                                <th>留联系</th>
                                <th>电话量</th>
                                <th>总咨询量</th>
                                <th>预约量</th>
                                <th>应到院</th>
                                <th>到院量</th>
                                <th>就诊量</th>
                                <th>预约率</th>
                                <th>留联率</th>
                                <th>到院率</th>
                                <th>就诊率</th>
                                <th>咨询转化率</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($monthData as $v)
                                <tr>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['zixun_count']}}</td>
                                    <td>{{$v['contact_count']}}</td>
                                    <td>{{$v['tel_count']}}</td>
                                    <td>{{$v['total_count']}}</td>
                                    <td>{{$v['yuyue_count']}}</td>
                                    <td>{{$v['should_count']}}</td>
                                    <td>{{$v['arrive_count']}}</td>
                                    <td>{{$v['jiuzhen_count']}}</td>
                                    <td>{{$v['yuyue_rate']}}</td>
                                    <td>{{$v['contact_rate']}}</td>
                                    <td>{{$v['arrive_rate']}}</td>
                                    <td>{{$v['jiuzhen_rate']}}</td>
                                    <td>{{$v['zhuanhua_rate']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-body" id="year-data-box-body">
                <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;" class="table-head" data-id="year-data">
                    {{\Carbon\Carbon::now()->year}}年汇总数据(<a href="javascript:;" data-flag="y" class="data-flush">刷新</a>)
                </h4>
                <div class="box">
                    <div class="box-body table-item table-responsive table-bordered">
                        <style type="text/css">
                            table.tab-sum tr,table.tab-sum th,table.tab-sum td{border: solid 1px #666;}
                        </style>
                        <table class="table table-hover text-center tab-sum" id="year-data">
                            <thead>
                            <tr style="background: #66d7ea;">
                                <th>项目</th>
                                <th>咨询量</th>
                                <th>留联系</th>
                                <th>电话量</th>
                                <th>总咨询量</th>
                                <th>预约量</th>
                                <th>应到院</th>
                                <th>到院量</th>
                                <th>就诊量</th>
                                <th>预约率</th>
                                <th>留联率</th>
                                <th>到院率</th>
                                <th>就诊率</th>
                                <th>咨询转化率</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($yearData as $v)
                                <tr>
                                    <td>{{$v['name']}}</td>
                                    <td>{{$v['zixun_count']}}</td>
                                    <td>{{$v['contact_count']}}</td>
                                    <td>{{$v['tel_count']}}</td>
                                    <td>{{$v['total_count']}}</td>
                                    <td>{{$v['yuyue_count']}}</td>
                                    <td>{{$v['should_count']}}</td>
                                    <td>{{$v['arrive_count']}}</td>
                                    <td>{{$v['jiuzhen_count']}}</td>
                                    <td>{{$v['yuyue_rate']}}</td>
                                    <td>{{$v['contact_rate']}}</td>
                                    <td>{{$v['arrive_rate']}}</td>
                                    <td>{{$v['jiuzhen_rate']}}</td>
                                    <td>{{$v['zhuanhua_rate']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    {{--<div class="col-sm-12">--}}
        {{--<div class="box box-solid">--}}
            {{--<div class="box-body" id="table-range-box-body">--}}
                {{--<h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;" id="todayRange" class="table-head" data-id="table-range">--}}
                    {{--今日排班--}}
                {{--</h4>--}}
                {{--<div class="box">--}}
                    {{--<div class="box-body table-item table-responsive table-bordered">--}}
                        {{--<style type="text/css">--}}
                            {{--table.table-arrangement tr,table.table-arrangement th,table.table-arrangement td{border: solid 1px #666;}--}}
                        {{--</style>--}}
                        {{--<table class="table table-hover text-center table-arrangement" id="table-range">--}}
                            {{--<thead>--}}
                            {{--<tr style="background: #66d7ea;">--}}
                                {{--<th>项目</th>--}}
                                {{--<th>班次</th>--}}
                                {{--<th>咨询</th>--}}
                                {{--<th>竞价</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--@if(!empty($arrangements))--}}
                                {{--@foreach($arrangements as $officesort)--}}
                                    {{--@foreach($officesort['ranks'] as $ranksort)--}}
                                        {{--<tr>--}}
                                            {{--@if($loop->first)--}}
                                                {{--<td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$officesort['office']}}</td>--}}
                                            {{--@endif--}}
                                            {{--<td>{{$ranksort['rank']}}</td>--}}
                                            {{--<td>--}}
                                                {{--@if(!empty($ranksort['departments']))--}}
                                                    {{--@foreach($ranksort['departments'] as $v)--}}
                                                        {{--@if($v['department']=='zixun')--}}
                                                            {{--@if(!empty($v['users']))--}}
                                                                {{--@foreach($v['users'] as $user)--}}
                                                                    {{--{{$user}}--}}
                                                                {{--@endforeach--}}
                                                            {{--@endif--}}
                                                        {{--@endif--}}
                                                    {{--@endforeach--}}
                                                {{--@endif--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--@if(!empty($ranksort['departments']))--}}
                                                    {{--@foreach($ranksort['departments'] as $v)--}}
                                                        {{--@if($v['department']=='jingjia')--}}
                                                            {{--@if(!empty($v['users']))--}}
                                                                {{--@foreach($v['users'] as $user)--}}
                                                                    {{--{{$user}}--}}
                                                                {{--@endforeach--}}
                                                            {{--@endif--}}
                                                        {{--@endif--}}
                                                    {{--@endforeach--}}
                                                {{--@endif--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                    {{--<!-- /.box-body -->--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<button id="btn">Open PhotoSwipe</button>--}}

@endsection

@section('javascript')
    {{--<script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>--}}
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript" src="/js/current-device.min.js"></script>
    <script type="text/javascript">
        lay('.date-item').each(function(){
            laydate.render({
                elem: this
                ,trigger: 'click'
            });
        });
        // if (device.mobile()){
        //     $(".table-item").each(function () {
        //         var nodeId=$(this).children('table').attr('id');
        //         if (typeof(nodeId)!='undefined'){
        //             var node = document.getElementById(nodeId);
        //             var that=this;
        //             domtoimage.toSvg(node,{bgcolor: '#fff'},that)
        //                 .then(function (dataUrl) {
        //                     var img = new Image();
        //                     img.src = dataUrl;
        //                     img.className= 'img-responsive';
        //                     node.remove();
        //                     $(that).append(img);
        //                 });
        //         }
        //     });
        // }
        $(".data-flush").click(function () {
            $('input[name=flag]').val($(this).data('flag'));
            $('#search-form').submit();
        });
    </script>
@endsection
