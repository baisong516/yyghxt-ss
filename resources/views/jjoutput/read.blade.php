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
                    <input type="text" class="form-control date-item" name="searchDate" id="searchDateStart" required value="{{isset($start)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$start)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-jjoutputs')
                        <a href="{{route('jjoutputs.create')}}" class="btn-sm btn-info">录入</a>
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