@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('jjoutputs.search')}}"  id="search-form" name="search-form" method="POST">
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
                    @ability('superadministrator', 'create-jjoutputs')
                        <a href="{{route('jjoutputs.create')}}" class="btn-sm btn-info" style="margin-right: 20px;">录入</a>
                        <a href="{{route('jjoutputs.import')}}" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 20px;">导入</a>
                        <a href="/template/jingjia.xlsx" class="btn-sm btn-danger">模板</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="" method="post" class="jjoutputs-form">
        {{method_field('DELETE')}}
        {{csrf_field()}}
        <div class="box-body table-responsive">
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
                    @isset($outputs)
                        @foreach($outputs as $g)
                            @isset($g['data'])
                            @foreach($g['data'] as $userId=>$output)
                            <tr>
                                @if($loop->first)
                                <td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$g['office']}}</td>
                                @endif
                                <td>{{$userId?$users[$userId]:''}}</td>
                                <td>{{isset($output['rank_0'])?'早班：'.$output['rank_0']:''}} {{isset($output['rank_1'])?'晚班：'.$output['rank_1']:''}}</td>
                                <td>{{isset($output['budget'])?sprintf('%.2f',$output['budget']):''}}</td>
                                <td>{{isset($output['cost'])?sprintf('%.2f',$output['cost']):''}}</td>
                                <td>{{isset($output['click'])?$output['click']:''}}</td>
                                <td>{{isset($output['zixun'])?$output['zixun']:''}}</td>
                                <td>{{isset($output['yuyue'])?$output['yuyue']:''}}</td>
                                <td>{{isset($output['arrive'])?$output['arrive']:''}}</td>
                                <td>{{isset($output['zixun_cost'])?sprintf('%.2f',$output['zixun_cost']):''}}</td>
                                <td>{{isset($output['yuyue_cost'])?sprintf('%.2f',$output['yuyue_cost']):''}}</td>
                                <td>{{isset($output['arrive_cost'])?sprintf('%.2f',$output['arrive_cost']):''}}</td>
                            </tr>
                            @endforeach
                            @endisset
                        @endforeach
                    @endisset
                </tbody>
            </table>
            <hr>
            <h5 class="text-center"><strong>上月产出</strong></h5>
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
                @isset($lastMonthOutputs)
                    @foreach($lastMonthOutputs as $g)
                        @isset($g['data'])
                            @foreach($g['data'] as $userId=>$output)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$g['office']}}</td>
                                    @endif
                                    <td>{{$userId?$users[$userId]:''}}</td>
                                    <td>{{isset($output['rank_0'])?'早班：'.$output['rank_0']:''}} {{isset($output['rank_1'])?'晚班：'.$output['rank_1']:''}}</td>
                                    <td>{{isset($output['budget'])?sprintf('%.2f',$output['budget']):''}}</td>
                                    <td>{{isset($output['cost'])?sprintf('%.2f',$output['cost']):''}}</td>
                                    <td>{{isset($output['click'])?$output['click']:''}}</td>
                                    <td>{{isset($output['zixun'])?$output['zixun']:''}}</td>
                                    <td>{{isset($output['yuyue'])?$output['yuyue']:''}}</td>
                                    <td>{{isset($output['arrive'])?$output['arrive']:''}}</td>
                                    <td>{{isset($output['zixun_cost'])?sprintf('%.2f',$output['zixun_cost']):''}}</td>
                                    <td>{{isset($output['yuyue_cost'])?sprintf('%.2f',$output['yuyue_cost']):''}}</td>
                                    <td>{{isset($output['arrive_cost'])?sprintf('%.2f',$output['arrive_cost']):''}}</td>
                                </tr>
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
                </tbody>
            </table>
            <hr>
            <h5 class="text-center"><strong>{{\Carbon\Carbon::now()->year}}产出</strong></h5>
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
                @isset($yearOutputs)
                    @foreach($yearOutputs as $g)
                        @isset($g['data'])
                            @foreach($g['data'] as $userId=>$output)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{$loop->count}}" style="vertical-align: middle;">{{$g['office']}}</td>
                                    @endif
                                    <td>{{$userId?$users[$userId]:''}}</td>
                                    <td>{{isset($output['rank_0'])?'早班：'.$output['rank_0']:''}} {{isset($output['rank_1'])?'晚班：'.$output['rank_1']:''}}</td>
                                    <td>{{isset($output['budget'])?sprintf('%.2f',$output['budget']):''}}</td>
                                    <td>{{isset($output['cost'])?sprintf('%.2f',$output['cost']):''}}</td>
                                    <td>{{isset($output['click'])?$output['click']:''}}</td>
                                    <td>{{isset($output['zixun'])?$output['zixun']:''}}</td>
                                    <td>{{isset($output['yuyue'])?$output['yuyue']:''}}</td>
                                    <td>{{isset($output['arrive'])?$output['arrive']:''}}</td>
                                    <td>{{isset($output['zixun_cost'])?sprintf('%.2f',$output['zixun_cost']):''}}</td>
                                    <td>{{isset($output['yuyue_cost'])?sprintf('%.2f',$output['yuyue_cost']):''}}</td>
                                    <td>{{isset($output['arrive_cost'])?sprintf('%.2f',$output['arrive_cost']):''}}</td>
                                </tr>
                            @endforeach
                        @endisset
                    @endforeach
                @endisset
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        </form>
    </div>
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('jjoutputs.import')}}" enctype="multipart/form-data">
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
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
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
        {{--$(".delete-operation").on('click',function(){--}}
            {{--var id=$(this).attr('data-id');--}}
            {{--layer.open({--}}
                {{--content: '你确定要删除吗？',--}}
                {{--btn: ['确定', '关闭'],--}}
                {{--yes: function(index, layero){--}}
                    {{--$('form.zxoutputs-form').attr('action',"{{route('zxoutputs.index')}}/"+id);--}}
                    {{--$('form.zxoutputs-form').submit();--}}
                {{--},--}}
                {{--btn2: function(index, layero){--}}
                    {{--//按钮【按钮二】的回调--}}
                    {{--//return false 开启该代码可禁止点击该按钮关闭--}}
                {{--},--}}
                {{--cancel: function(){--}}
                    {{--//右上角关闭回调--}}
                    {{--//return false; 开启该代码可禁止点击该按钮关闭--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    </script>
@endsection
