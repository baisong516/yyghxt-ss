@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('outputs.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="searchDate">日期：</label>
                    <input type="text" class="form-control date-item" name="searchDate" id="searchDate" required value="{{isset($start)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                   </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
            <div class="box-tools">
                {{--<div class="input-group input-group-sm" style="width: 80px;">--}}
                    {{--@ability('superadministrator', 'create-zxoutputs')--}}
                        {{--<a href="{{route('zxoutputs.create')}}" class="btn-sm btn-info">录入</a>--}}
                    {{--@endability--}}
                {{--</div>--}}
            </div>
        </div>
        <form action="" method="post" class="outputs-form">
        {{method_field('DELETE')}}
        {{csrf_field()}}
        <div class="box-body table-responsive">
            <h3 class="text-center bold" style="margin-top: 3rem;">咨询产出表</h3>
            <table class="table text-center table-bordered">
                <thead>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="4">商务通</th>
                        <th colspan="3">电话</th>
                        <th colspan="3">回访</th>
                        <th colspan="8">合计</th>
                    </tr>
                    <tr>
                        <th>项目</th>
                        <th>咨询员</th>
                        <th>咨询量</th>
                        <th>预约量</th>
                        <th>留联系</th>
                        <th>到院量</th>
                        <th>电话量</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>回访量</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>咨询量</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>就诊量</th>
                        <th>预约率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                        <th>咨询转化率</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($zxoutputs)
                        @foreach($zxoutputs['outputs'] as $d)
                        @foreach($d['data'] as $u=>$output)
                        <tr>
                            @if($loop->first)
                            <td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$d['office']}}</td>
                            @endif
                            <td>{{$u?$users[$u]:''}}</td>
                            <td>{{$output['swt_zixun_count']}}</td>
                            <td>{{$output['swt_yuyue_count']}}</td>
                            <td>{{$output['swt_contact_count']}}</td>
                            <td>{{$output['swt_arrive_count']}}</td>
                            <td>{{$output['tel_zixun_count']}}</td>
                            <td>{{$output['tel_yuyue_count']}}</td>
                            <td>{{$output['tel_arrive_count']}}</td>
                            <td>{{$output['hf_zixun_count']}}</td>
                            <td>{{$output['hf_yuyue_count']}}</td>
                            <td>{{$output['hf_arrive_count']}}</td>
                            <td>{{$output['total_zixun_count']}}</td>
                            <td>{{$output['total_yuyue_count']}}</td>
                            <td>{{$output['total_arrive_count']}}</td>
                            <td>{{$output['total_jiuzhen_count']}}</td>
                            <td>{{$output['yuyue_rate']}}</td>
                            <td>{{$output['arrive_rate']}}</td>
                            <td>{{$output['jiuzhen_rate']}}</td>
                            <td>{{$output['trans_rate']}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        @if(isset($zxoutputs['total'])&&!empty($zxoutputs['total']))
                        <tr>
                            <td></td>
                            <td>合计</td>
                            <td>{{$zxoutputs['total']['swt_zixun_count']}}</td>
                            <td>{{$zxoutputs['total']['swt_yuyue_count']}}</td>
                            <td>{{$zxoutputs['total']['swt_contact_count']}}</td>
                            <td>{{$zxoutputs['total']['swt_arrive_count']}}</td>
                            <td>{{$zxoutputs['total']['tel_zixun_count']}}</td>
                            <td>{{$zxoutputs['total']['tel_yuyue_count']}}</td>
                            <td>{{$zxoutputs['total']['tel_arrive_count']}}</td>
                            <td>{{$zxoutputs['total']['hf_zixun_count']}}</td>
                            <td>{{$zxoutputs['total']['hf_yuyue_count']}}</td>
                            <td>{{$zxoutputs['total']['hf_arrive_count']}}</td>
                            <td>{{$zxoutputs['total']['total_zixun_count']}}</td>
                            <td>{{$zxoutputs['total']['total_yuyue_count']}}</td>
                            <td>{{$zxoutputs['total']['total_arrive_count']}}</td>
                            <td>{{$zxoutputs['total']['total_jiuzhen_count']}}</td>
                            <td>{{$zxoutputs['total']['yuyue_rate']}}</td>
                            <td>{{$zxoutputs['total']['arrive_rate']}}</td>
                            <td>{{$zxoutputs['total']['jiuzhen_rate']}}</td>
                            <td>{{$zxoutputs['total']['trans_rate']}}</td>
                        </tr>
                        @endif
                    @endisset
                </tbody>
            </table>
            <h3 class="text-center bold" style="margin-top: 3rem;">竞价产出表</h3>
            <table class="table text-center table-bordered">
                <thead>
                <tr>
                    <th>项目</th>
                    <th>竞价员</th>
                    <th>班次</th>
                    <th>预算</th>
                    <th>消费</th>
                    <th>点击</th>
                    <th>咨询量</th>
                    <th>预约量</th>
                    <th>到院量</th>
                    <th>咨询成本</th>
                    <th>预约成本</th>
                    <th>到院成本</th>
                </tr>
                </thead>
                <tbody>
                @isset($jjoutputs)
                    @foreach($jjoutputs as $g)
                        @foreach($g['data'] as $output)
                            <tr>
                                @if($loop->first)
                                    <td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$g['office']}}</td>
                                @endif
                                <td>{{$output->user_id?$users[$output->user_id]:''}}</td>
                                <td>{{$output->rank==1?'晚班':'早班'}}</td>
                                <td>{{$output->budget?$output->budget:''}}</td>
                                <td>{{$output->cost?$output->cost:''}}</td>
                                <td>{{$output->click?$output->click:''}}</td>
                                <td>{{$output->zixun?$output->zixun:''}}</td>
                                <td>{{$output->yuyue?$output->yuyue:''}}</td>
                                <td>{{$output->arrive?$output->arrive:''}}</td>
                                <td>{{$output->zixun_cost?$output->zixun_cost:''}}</td>
                                <td>{{$output->yuyue_cost?$output->yuyue_cost:''}}</td>
                                <td>{{$output->arrive_cost?$output->arrive_cost:''}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endisset
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/layer/layer.js"></script>
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
