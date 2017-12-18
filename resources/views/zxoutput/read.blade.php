@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('zxoutputs.search')}}"  id="search-form" name="search-form" method="POST">
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
                    @ability('superadministrator', 'create-zxoutputs')
                        <a href="{{route('zxoutputs.create')}}" class="btn-sm btn-info">录入</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
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
                    @isset($outputs)
                        @foreach($outputs as $d)
                        @foreach($d['data'] as $output)
                        <tr>
                            @if($loop->first)
                            <td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$d['office']}}</td>
                            @endif
                            <td>{{$output->user_id?$users[$output->user_id]:''}}</td>
                            <td>{{$output->swt_zixun_count}}</td>
                            <td>{{$output->swt_yuyue_count}}</td>
                            <td>{{$output->swt_contact_count}}</td>
                            <td>{{$output->swt_arrive_count}}</td>
                            <td>{{$output->tel_zixun_count}}</td>
                            <td>{{$output->tel_yuyue_count}}</td>
                            <td>{{$output->tel_arrive_count}}</td>
                            <td>{{$output->hf_zixun_count}}</td>
                            <td>{{$output->hf_yuyue_count}}</td>
                            <td>{{$output->hf_arrive_count}}</td>
                            <td>{{$output->total_zixun_count}}</td>
                            <td>{{$output->total_yuyue_count}}</td>
                            <td>{{$output->total_arrive_count}}</td>
                            <td>{{$output->total_jiuzhen_count}}</td>
                            <td>{{$output->yuyue_rate}}</td>
                            <td>{{$output->arrive_rate}}</td>
                            <td>{{$output->jiuzhen_rate}}</td>
                            <td>{{$output->trans_rate}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                    @endisset
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
