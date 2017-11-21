@extends('layouts.base')

@section('css')
    <style type="text/css">
        table th,table td{text-align: center;}
    </style>
@endsection
@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('summaries.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="summaryDate">日期：</label>
                    <input type="text" class="form-control date-item" name="summaryDateStart" id="summaryDateStart" value="{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString()}}">
                    到
                    <input type="text" class="form-control date-item" name="summaryDateEnd" id="summaryDateEnd" value="{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString()}}">
                </div>
                <div class="form-group">
                    <label for="searchUserId">咨询员：</label>
                    <select name="searchUserId" id="searchUserId" class="form-control">
                        <option value="">--咨询员--</option>
                        @foreach($zxUsers as $user)
                            <option value="{{$user->id}}" {{$cuser==$user->id?'selected':''}}>{{$user->realname}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>咨询员</th>
                        <th>咨询量</th>
                        <th>预约量</th>
                        <th>留联系</th>
                        <th>应到院</th>
                        <th>到院量</th>
                        <th>就诊量</th>
                        <th>预约率</th>
                        <th>留联率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                    </tr>
                    @foreach($data as $k=>$v)
                    <tr>
                        <td>
                            <a class="btn btn-xs btn-default collapsed" data-toggle="collapse" data-target="#grid-collapse-{{$k}}" aria-expanded="false">
                                <i class="fa fa-caret-right"></i> {{$v['username']}}
                            </a>
                        </td>
                        <td>{{$v['summary']['zixun_count']}}</td>
                        <td>{{$v['summary']['yuyue_count']}}</td>
                        <td>{{$v['summary']['contact_count']}}</td>
                        <td>{{$v['summary']['should_count']}}</td>
                        <td>{{$v['summary']['arrive_count']}}</td>
                        <td>{{$v['summary']['jiuzhen_count']}}</td>
                        <td>{{$v['summary']['yuyue_rate']}}</td>
                        <td>{{$v['summary']['contact_rate']}}</td>
                        <td>{{$v['summary']['arrive_rate']}}</td>
                        <td>{{$v['summary']['jiuzhen_rate']}}</td>
                    </tr>
                    <tr>
                        <td colspan="11" style="padding:0 !important; border:0px;">
                            <div id="grid-collapse-{{$k}}" class="collapse" aria-expanded="false" style="height: 0px;">
                                <table class="table">
                                    <tr>
                                        <th></th>
                                        <th>项目</th>
                                        <th>咨询量</th>
                                        <th>预约量</th>
                                        <th>留联系</th>
                                        <th>应到院</th>
                                        <th>到院量</th>
                                        <th>就诊量</th>
                                        <th>预约率</th>
                                        <th>留联率</th>
                                        <th>到院率</th>
                                        <th>就诊率</th>
                                    </tr>
                                    <tbody>
                                        @foreach($v['data'] as $d)
                                        <tr>
                                            <td></td>
                                            <td>{{$d['office']}}</td>
                                            <td>{{$d['zixun_count']}}</td>
                                            <td>{{$d['yuyue_count']}}</td>
                                            <td>{{$d['contact_count']}}</td>
                                            <td>{{$d['should_count']}}</td>
                                            <td>{{$d['arrive_count']}}</td>
                                            <td>{{$d['jiuzhen_count']}}</td>
                                            <td>{{$d['yuyue_rate']}}</td>
                                            <td>{{$d['contact_rate']}}</td>
                                            <td>{{$d['arrive_rate']}}</td>
                                            <td>{{$d['jiuzhen_rate']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        lay('.date-item').each(function(){
            laydate.render({
                elem: this
                ,trigger: 'click'
            });
        });
    </script>
@endsection