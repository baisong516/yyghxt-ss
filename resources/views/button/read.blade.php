@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">按钮点击统计</h3>
        </div>
        <div class="box-body">
            <form action="" method="post" class="hospitals-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
            <table id="buttons-list-table" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>网站</th>
                    <th>位置</th>
                    <th>点击次数</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach()
                @endforeach
                </tbody>
            </table>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#hospital-list-table').DataTable({
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
                        $('form.hospitals-form').attr('action',"{{route('hospitals.index')}}/"+id);
                        $('form.hospitals-form').submit();
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
