@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">

        </div>
        <div class="box-body table-responsive">
            <form action="" method="post" class="resources-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
                <table id="resources-list-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>类型 / 大小</th>
                        <th>最后修改时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@foreach($lists as $list)--}}
                        {{--<tr>--}}
                            {{--<td>{{$user->id}}</td>--}}
                            {{--<td>{{$user->name}}</td>--}}
                            {{--<td>{{$user->realname}}</td>--}}
                            {{--<td>{{$user->department_id?$user->department->display_name:''}}</td>--}}
                            {{--<td>--}}
                                {{--@if($user->is_active==1)--}}
                                    {{--<span class="label label-success">正常</span>--}}
                                {{--@else--}}
                                    {{--<span class="label label-danger">失效</span>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            {{--<td>--}}
                                {{--@if($enableUpdate)--}}
                                    {{--<a href="{{route('users.edit',$user->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>--}}
                                {{--@endif--}}
                                {{--@if($enableDelete)--}}
                                    {{--<a href="javascript:void(0);" data-id="{{$user->id}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                    </tbody>
                </table>
            </form>
        </div>
        <!-- /.box-body -->
    </div>


@endsection

@section('javascript')
    {{--<script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>--}}
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
           // $('#buttons-list-table').DataTable({
           //     "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
           //     "language": {
           //         "url": "/datables-language-zh-CN.json"
           //     }
           // });
            //日期
            // lay('.date-item').each(function(){
            //     laydate.render({
            //         elem: this
            //         ,trigger: 'click'
            //     });
            // });
            {{--$(".delete-operation").on('click',function(){--}}
                {{--var id=$(this).attr('data-id');--}}
                {{--layer.open({--}}
                    {{--content: '你确定要删除吗？',--}}
                    {{--btn: ['确定', '关闭'],--}}
                    {{--yes: function(index, layero){--}}
                        {{--$('form.hospitals-form').attr('action',"{{route('hospitals.index')}}/"+id);--}}
                        {{--$('form.hospitals-form').submit();--}}
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
        });
    </script>
@endsection
