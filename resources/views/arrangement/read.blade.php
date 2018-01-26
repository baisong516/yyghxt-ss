@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    {{--区域头部标题--}}
                    <h3 class="box-title">排班表</h3>
                    {{--区域右侧工具--}}
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <a href="{{route('arrangements.create')}}" class="btn-sm btn-info">排班</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <form action="" method="post" class="arrangements-form">
                    {{method_field('DELETE')}}
                    {{csrf_field()}}
                    <div class="box-body table-responsive no-padding">
                        <table id="arrangements-list-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                {{--<th>项目</th>--}}
                                {{--<th>职位</th>--}}
                                <th>日期</th>
                                <th>班次</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($arrangements as $arrangement)
                                <tr>
                                    <td>{{($arrangement->user_id)?$users[$arrangement->user_id]:''}}</td>
                                    {{--<td>{{$arrangement->office_id?$offices[$arrangement->office_id]:''}}</td>--}}
                                    {{--<td>{{$arrangement->user_id?$departments[]:''}}</td>--}}
                                    <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $arrangement->rank_date)->toDateString()}}</td>
                                    <td>{{$arrangement->rank==1?'晚班':'早班'}}</td>
                                    <td>
                                        @if($enableUpdate)
                                            <a href="{{route('arrangements.edit',$arrangement->id)}}"  alt="edit" title="edit"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if($enableDelete)
                                            <a href="javascript:void(0);"  alt="delete" data-id="{{$arrangement->id}}" title="delete" class="delete-operation"><i class="fa fa-trash"></i></a>
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
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#arrangements-list-table').DataTable({
                "order": [[ 1, "desc" ]],
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
                        $('form.arrangements-form').attr('action',"{{route('arrangements.index')}}/"+id);
                        $('form.arrangements-form').submit();
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

