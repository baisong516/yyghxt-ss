@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">列表</h3>
            <div class="box-tools">

            </div>
        </div>
        <form action="" method="post" class="reports-form">
            {{method_field('DELETE')}}
            {{csrf_field()}}
        <div class="box-body table-responsive">
            <table id="user-list-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>科室</th>
                    <th>网站来源</th>
                    <th>类型</th>
                    <th>类型值</th>
                    <th>消费</th>
                    <th>展现</th>
                    <th>点击</th>
                    <th>总对话</th>
                    <th>有效对话</th>
                    <th>留联系</th>
                    <th>总预约</th>
                    <th>总到院</th>
                    <th>日期</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{$report->id}}</td>
                        <td>{{$report->office_id&&isset($offices[$report->office_id])?$offices[$report->office_id]:''}}</td>
                        <td>{{$report->source_id&&isset($sources[$report->source_id])?$sources[$report->source_id]:''}}</td>
                        @if($report->type=='disease')
                            <td>病种</td>
                            <td>{{isset($diseases[$report->type_id])?$diseases[$report->type_id]:''}}</td>
                        @endif
                        @if($report->type=='platform')
                            <td>平台</td>
                            <td>{{isset($platforms[$report->type_id])?$platforms[$report->type_id]:''}}</td>
                        @endif
                        @if($report->type=='area')
                            <td>地域</td>
                            <td>{{isset($areas[$report->type_id])?$areas[$report->type_id]:''}}</td>
                        @endif
                        <td>{{$report->cost}}</td>
                        <td>{{$report->show}}</td>
                        <td>{{$report->click}}</td>
                        <td>{{$report->achat}}</td>
                        <td>{{$report->chat}}</td>
                        <td>{{$report->contact}}</td>
                        <td>{{$report->yuyue}}</td>
                        <td>{{$report->arrive}}</td>
                        <td>{{$report->date_tag}}</td>
                        <td>
                            @if($enableUpdate)
                                <a href="{{route('reports.edit',$report->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                            @endif
                            @if($enableDelete)
                                <a href="javascript:void(0);" data-id="{{$report->id}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#user-list-table').DataTable({
                "order": [[ 0, "desc" ]],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "url": "/datables-language-zh-CN.json"
                }
            });
            $(".delete-operation").on('click',function(){
                var id=$(this).attr('data-id');
                layer.open({
                    content: '你确定要删除吗？',
                    btn: ['确定', '关闭'],
                    yes: function(index, layero){
                        $('form.reports-form').attr('action',"{{route('reports.index')}}/"+id);
                        $('form.reports-form').submit();
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
