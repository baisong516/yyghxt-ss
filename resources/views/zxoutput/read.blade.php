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
                <hr>
                <input type="hidden" id="monthSub" name="monthSub" value="">
                @for ($i = 0; $i < 5; $i++)
                    <button type="button" class="btn btn-success month-sub-option" style="margin-bottom: 5px;" data-month="{{$i}}">{{\Carbon\Carbon::now()->subMonth($i)->year}}-{{\Carbon\Carbon::now()->subMonth($i)->month}}</button>
                @endfor
            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 280px;">
                    @ability('superadministrator', 'create-zxoutputs')
                        <a href="{{route('zxoutputs.create')}}" class="btn-sm btn-info" style="margin-right: 20px;">录入</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 20px;">导入</a>
                        <a href="/template/zixun.xlsx" class="btn-sm btn-danger">模板</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="" method="post" class="zxoutputs-form">
        {{method_field('DELETE')}}
        {{csrf_field()}}
        <div class="box-body" id="table-content">
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong></strong></h5>
                <table id="table-today" class="table text-center table-bordered">
                <thead class="bg-info">
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="4">商务通</th>
                        <th colspan="3">电话</th>
                        <th colspan="3">回访</th>
                        <th colspan="9">合计</th>
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
                        <th>留联率</th>
                        <th>预约率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                        <th>咨询转化率</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($outputs)
                        @foreach($outputs['outputs'] as $d)
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
                            <td>{{$output['contact_rate']}}</td>
                            <td>{{$output['yuyue_rate']}}</td>
                            <td>{{$output['arrive_rate']}}</td>
                            <td>{{$output['jiuzhen_rate']}}</td>
                            <td>{{$output['trans_rate']}}</td>
                        </tr>
                        @endforeach
                        @endforeach
                        @if(isset($outputs['total'])&&!empty($outputs['total']))
                        <tr>
                            <td></td>
                            <td>合计</td>
                            <td>{{$outputs['total']['swt_zixun_count']}}</td>
                            <td>{{$outputs['total']['swt_yuyue_count']}}</td>
                            <td>{{$outputs['total']['swt_contact_count']}}</td>
                            <td>{{$outputs['total']['swt_arrive_count']}}</td>
                            <td>{{$outputs['total']['tel_zixun_count']}}</td>
                            <td>{{$outputs['total']['tel_yuyue_count']}}</td>
                            <td>{{$outputs['total']['tel_arrive_count']}}</td>
                            <td>{{$outputs['total']['hf_zixun_count']}}</td>
                            <td>{{$outputs['total']['hf_yuyue_count']}}</td>
                            <td>{{$outputs['total']['hf_arrive_count']}}</td>
                            <td>{{$outputs['total']['total_zixun_count']}}</td>
                            <td>{{$outputs['total']['total_yuyue_count']}}</td>
                            <td>{{$outputs['total']['total_arrive_count']}}</td>
                            <td>{{$outputs['total']['total_jiuzhen_count']}}</td>
                            <td>{{$outputs['total']['contact_rate']}}</td>
                            <td>{{$outputs['total']['yuyue_rate']}}</td>
                            <td>{{$outputs['total']['arrive_rate']}}</td>
                            <td>{{$outputs['total']['jiuzhen_rate']}}</td>
                            <td>{{$outputs['total']['trans_rate']}}</td>
                        </tr>
                        @endif
                    @endisset
                </tbody>
            </table>
            </div>
            <hr>
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong>上月({{\Carbon\Carbon::now()->subMonth()->year}}-{{\Carbon\Carbon::now()->subMonth()->month}})数据</strong></h5>
                <table id="table-lastmonth" class="table text-center table-bordered">
                <thead class="bg-info">
                <tr>
                    <th colspan="2"></th>
                    <th colspan="4">商务通</th>
                    <th colspan="3">电话</th>
                    <th colspan="3">回访</th>
                    <th colspan="9">合计</th>
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
                    <th>留联率</th>
                    <th>预约率</th>
                    <th>到院率</th>
                    <th>就诊率</th>
                    <th>咨询转化率</th>
                </tr>
                </thead>
                <tbody>
                @isset($lastMonthOutputs)
                    @foreach($lastMonthOutputs['outputs'] as $d)
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
                                <td>{{$output['contact_rate']}}</td>
                                <td>{{$output['yuyue_rate']}}</td>
                                <td>{{$output['arrive_rate']}}</td>
                                <td>{{$output['jiuzhen_rate']}}</td>
                                <td>{{$output['trans_rate']}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    @if(isset($lastMonthOutputs['total'])&&!empty($lastMonthOutputs['total']))
                        <tr>
                            <td></td>
                            <td>合计</td>
                            <td>{{$lastMonthOutputs['total']['swt_zixun_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['swt_yuyue_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['swt_contact_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['swt_arrive_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['tel_zixun_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['tel_yuyue_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['tel_arrive_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['hf_zixun_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['hf_yuyue_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['hf_arrive_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['total_zixun_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['total_yuyue_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['total_arrive_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['total_jiuzhen_count']}}</td>
                            <td>{{$lastMonthOutputs['total']['contact_rate']}}</td>
                            <td>{{$lastMonthOutputs['total']['yuyue_rate']}}</td>
                            <td>{{$lastMonthOutputs['total']['arrive_rate']}}</td>
                            <td>{{$lastMonthOutputs['total']['jiuzhen_rate']}}</td>
                            <td>{{$lastMonthOutputs['total']['trans_rate']}}</td>
                        </tr>
                    @endif
                @endisset
                </tbody>
            </table>
            </div>
            <hr>
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong>{{\Carbon\Carbon::now()->year}}年数据</strong></h5>
                <table id="table-thisyear" class="table text-center table-bordered">
                <thead class="bg-info">
                <tr>
                    <th colspan="2"></th>
                    <th colspan="4">商务通</th>
                    <th colspan="3">电话</th>
                    <th colspan="3">回访</th>
                    <th colspan="9">合计</th>
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
                    <th>留联率</th>
                    <th>预约率</th>
                    <th>到院率</th>
                    <th>就诊率</th>
                    <th>咨询转化率</th>
                </tr>
                </thead>
                <tbody>
                @isset($yearOutputs)
                    @foreach($yearOutputs['outputs'] as $d)
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
                                <td>{{$output['contact_rate']}}</td>
                                <td>{{$output['yuyue_rate']}}</td>
                                <td>{{$output['arrive_rate']}}</td>
                                <td>{{$output['jiuzhen_rate']}}</td>
                                <td>{{$output['trans_rate']}}</td>
                            </tr>
                        @endforeach
                    @endforeach
                    @if(isset($yearOutputs['total'])&&!empty($yearOutputs['total']))
                        <tr>
                            <td></td>
                            <td>合计</td>
                            <td>{{$yearOutputs['total']['swt_zixun_count']}}</td>
                            <td>{{$yearOutputs['total']['swt_yuyue_count']}}</td>
                            <td>{{$yearOutputs['total']['swt_contact_count']}}</td>
                            <td>{{$yearOutputs['total']['swt_arrive_count']}}</td>
                            <td>{{$yearOutputs['total']['tel_zixun_count']}}</td>
                            <td>{{$yearOutputs['total']['tel_yuyue_count']}}</td>
                            <td>{{$yearOutputs['total']['tel_arrive_count']}}</td>
                            <td>{{$yearOutputs['total']['hf_zixun_count']}}</td>
                            <td>{{$yearOutputs['total']['hf_yuyue_count']}}</td>
                            <td>{{$yearOutputs['total']['hf_arrive_count']}}</td>
                            <td>{{$yearOutputs['total']['total_zixun_count']}}</td>
                            <td>{{$yearOutputs['total']['total_yuyue_count']}}</td>
                            <td>{{$yearOutputs['total']['total_arrive_count']}}</td>
                            <td>{{$yearOutputs['total']['total_jiuzhen_count']}}</td>
                            <td>{{$yearOutputs['total']['contact_rate']}}</td>
                            <td>{{$yearOutputs['total']['yuyue_rate']}}</td>
                            <td>{{$yearOutputs['total']['arrive_rate']}}</td>
                            <td>{{$yearOutputs['total']['jiuzhen_rate']}}</td>
                            <td>{{$yearOutputs['total']['trans_rate']}}</td>
                        </tr>
                    @endif
                @endisset
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.box-body -->
        </form>
    </div>
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('zxoutputs.import')}}" enctype="multipart/form-data">
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
        $(document).ready(function () {
            // 0
            var nodeId0=$(".table-item").eq(0).children('table').attr('id');
            var node0 = document.getElementById(nodeId0);
            domtoimage.toSvg(node0,{bgcolor: '#fff'})
                .then(function (dataUrl) {
                    var img = new Image();
                    img.src = dataUrl;
                    img.className= 'img-responsive';
                    node0.remove();
                    $(".table-item").eq(0).append(img);
                });
            // 1
            var nodeId1=$(".table-item").eq(1).children('table').attr('id');
            var node1 = document.getElementById(nodeId1);
            domtoimage.toSvg(node1,{bgcolor: '#fff'})
                .then(function (dataUrl) {
                    var img = new Image();
                    img.src = dataUrl;
                    img.className= 'img-responsive';
                    node1.remove();
                    $(".table-item").eq(1).append(img);
                });
            // 2
            var nodeId2=$(".table-item").eq(2).children('table').attr('id');
            var node2 = document.getElementById(nodeId2);
            domtoimage.toSvg(node2,{bgcolor: '#fff'})
                .then(function (dataUrl) {
                    var img = new Image();
                    img.src = dataUrl;
                    img.className= 'img-responsive';
                    node2.remove();
                    $(".table-item").eq(2).append(img);
                });
        });
        $(".month-sub-option").click(function () {
            var monthSub=$(this).data('month');
            $("input:hidden[name=monthSub]").val(monthSub);
            $("form#search-form").submit();
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
