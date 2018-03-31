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
        <form action="" method="post" class="targets-form">
            {{method_field('DELETE')}}
            {{csrf_field()}}
        <div class="box-body table-responsive">
            <table id="user-list-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>科室</th>
                    <th>年度</th>
                    <th>月份</th>
                    <th>广告宣传</th>
                    <th>展现</th>
                    <th>点击</th>
                    <th>总对话</th>
                    <th>有效对话</th>
                    <th>留联量</th>
                    <th>总预约</th>
                    <th>总到院</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($targets as $target)
                    <tr>
                        <td>{{$target->office_id&&isset($offices[$target->office_id])?$offices[$target->office_id]:''}}</td>
                        <td>{{$target->year}}</td>
                        <td>{{$target->month}}</td>
                        <td>{{$target->cost}}</td>
                        <td>{{$target->show}}</td>
                        <td>{{$target->click}}</td>
                        <td>{{$target->achat}}</td>
                        <td>{{$target->chat}}</td>
                        <td>{{$target->contact}}</td>
                        <td>{{$target->yuyue}}</td>
                        <td>{{$target->arrive}}</td>
                        <td>
                            @if($enableUpdate)
                                <a href="{{route('targets.edit',$target->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                            @endif
                            @if($enableDelete)
                                <a href="javascript:void(0);" data-id="{{$target->id}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
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
                        $('form.targets-form').attr('action',"{{route('targets.index')}}/"+id);
                        $('form.targets-form').submit();
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
