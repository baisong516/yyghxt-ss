@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    {{--区域头部标题--}}
                    <h3 class="box-title">排班表</h3>
                    {{--区域右侧工具--}}
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 280px;">
                            <a href="{{route('arrangements.create')}}" class="btn-sm btn-info" style="margin-right: 20px;">排班</a>
                            <a href="javascript:;" data-toggle="modal" data-target="#importModal" class="btn-sm btn-success" style="margin-right: 20px;">导入</a>
                            <a href="/template/arrangements.xlsx" class="btn-sm btn-danger">模板</a>
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
    <!-- importModal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
        <div class="modal-dialog" role="document">
            <form method="post" class="form-horizontal" action="{{route('arrangements.import')}}" enctype="multipart/form-data">
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
                        <p class="text-danger">导入表格中的姓名与系统中的姓名要一致，不然无法导入</p>
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
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //data item
            lay('.date-item').each(function(){
                laydate.render({
                    elem: this,
                    trigger: 'click',
                    type:'date'
                    // value: new Date()
                });
            });
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

