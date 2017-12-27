@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('specialtrans.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="buttonDate">日期：</label>
                    <input type="text" class="form-control date-item" name="dateStart" id="dateStart" value="{{isset($start)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                    到
                    <input type="text" class="form-control date-item" name="dateEnd" id="dateEnd" value="{{isset($end)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$end)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 280px;">
                    <a href="{{route('specialtrans.create')}}" class="btn-sm btn-info" style="margin-right: 20px;">录入</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 20px;">导入</a>
                    <a href="/template/specialtrans.xlsx" class="btn-sm btn-danger">模板下载</a>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if(isset($specialtrans)&&!empty($specialtrans))
                        @foreach($specialtrans as $officeid=>$s)
                        <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$officeid}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$officeid]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(isset($specialtrans)&&!empty($specialtrans))
                        @foreach($specialtrans as $officeid=>$s)
                        <div class="tab-pane {{$loop->first?'active':''}}" id="tab_{{$officeid}}">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <th class="text-center">页面名称</th>
                                        <th class="text-center">现URL</th>
                                        <th class="text-center">病种</th>
                                        <th class="text-center">类别(词性)</th>
                                        <th class="text-center">消费</th>
                                        <th class="text-center">点击</th>
                                        <th class="text-center">展现</th>
                                        <th class="text-center">唯一身份浏览量</th>
                                        <th class="text-center">跳出率</th>
                                        <th class="text-center">商务通大于等于1</th>
                                        <th class="text-center">商务通大于等于3</th>
                                        <th class="text-center">点击转化率</th>
                                        <th class="text-center">预约</th>
                                        <th class="text-center">到院</th>
                                        <th class="text-center">更换时间</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($s as $specialId=>$special)
                                    @foreach($special['type'] as $diseaseId=>$type)
                                    <tr>
                                        @if($loop->first)
                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['name']}}</td>
                                        <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['url']}}</td>
                                        @endif
                                        <td>{{$diseases[$diseaseId]}}</td>
                                        <td>{{$type}}</td>
                                        @if($loop->first)
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['cost']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['show']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['view']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['skip_rate']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_one']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['swt_lg_three']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['click_trans_rate']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['yuyue']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['arrive']}}</td>
                                            <td style="vertical-align: middle;" rowspan="{{$loop->count}}">{{$special['change_date']}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    @endif
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('specialtrans.import')}}" enctype="multipart/form-data">
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
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            lay('.date-item').each(function(){
                laydate.render({
                    elem: this
                    ,trigger: 'click'
                });
            });
            $(".delete-operation").on('click',function(){
                var id=$(this).attr('data-id');
                layer.open({
                    content: '你确定要删除吗？',
                    btn: ['确定', '关闭'],
                    yes: function(index, layero){
                        $('form.specialtrans-form').attr('action',"{{route('specialtrans.index')}}/"+id);
                        $('form.specialtrans-form').submit();
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
        } );
    </script>
@endsection
