@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">病种列表</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-diseases')
                        <a href="{{route('diseases.create')}}" class="btn-sm btn-info">新增病种</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body">
            <form action="" method="post" class="diseases-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @if(!empty($diseasesGroup))
                            @foreach($diseasesGroup  as $office_id=>$diseases)
                                <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$office_id}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$offices[$office_id]}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if(!empty($diseasesGroup))
                            @foreach($diseasesGroup as $office_id=>$diseases)
                                <div class="tab-pane {{$loop->first?'active':''}}" id="tab_{{$office_id}}">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">病种</th>
                                            <th class="text-center">科室</th>
                                            <th class="text-center">医院</th>
                                            <th class="text-center">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody style="text-align: center">
                                        @foreach($diseases as $disease)
                                            <tr>
                                                <td>{{$disease->id}}</td>
                                                <td>{{$disease->display_name}}</td>
                                                <td>{{$disease->office->display_name}}</td>
                                                <td>{{$disease->hospital->display_name}}</td>
                                                <td>
                                                @if($enableUpdate)
                                                <a href="{{route('diseases.edit',$disease->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if($enableDelete)
                                                <a href="javascript:void(0);" data-id="{{$disease->id}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- /.tab-content -->
                </div>
            {{--<table id="disease-list-table" class="table table-striped table-bordered table-hover">--}}
                {{--<thead>--}}
                {{--<tr>--}}
                    {{--<th>ID</th>--}}
                    {{--<th>病种</th>--}}
                    {{--<th>科室</th>--}}
                    {{--<th>医院</th>--}}
                    {{--<th>操作</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--<tbody>--}}
                {{--@foreach($diseases as $disease)--}}
                    {{--<tr>--}}
                        {{--<td>{{$disease->id}}</td>--}}
                        {{--<td>{{$disease->display_name}}</td>--}}
                        {{--<td>{{$disease->office->display_name}}</td>--}}
                        {{--<td>{{$disease->hospital->display_name}}</td>--}}
                        {{--<td>--}}
                            {{--@if($enableUpdate)--}}
                                {{--<a href="{{route('diseases.edit',$disease->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>--}}
                            {{--@endif--}}
                            {{--@if($enableDelete)--}}
                                {{--<a href="javascript:void(0);" data-id="{{$disease->id}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>--}}
                            {{--@endif--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}
            </form>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#disease-list-table').DataTable({
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
                        $('form.diseases-form').attr('action',"{{route('diseases.index')}}/"+id);
                        $('form.diseases-form').submit();
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
