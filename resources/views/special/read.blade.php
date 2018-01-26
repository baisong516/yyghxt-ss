@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-specials')
                    <a href="{{route('specials.create')}}" class="btn-sm btn-info">添加专题</a>
                    @endability
                </div>
            </div>
        </div>
        <form method="post" class="specials-form">
            {{method_field('DELETE')}}
            {{csrf_field()}}
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @if(!empty($specials))
                        @foreach($specials as $k=>$special)
                            <li class="{{$loop->first?'active':''}}"><a href="#tab_{{$k}}" data-toggle="tab" aria-expanded="{{$loop->first?'true':'false'}}">{{$diseases[$k]}}</a></li>
                        @endforeach
                    @endif
                </ul>
                <div class="tab-content">
                    @if(!empty($specials))
                        @foreach($specials as $k=>$special)
                        <div class="tab-pane {{$loop->first?'active':''}}" id="tab_{{$k}}">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                    <tr>
                                        <td>名称</td>
                                        <td>路径</td>
                                        <td>病种</td>
                                        <td>类别</td>
                                        <td>更换时间</td>
                                        <td>OP</td>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                @foreach($special as $v)
                                    @if(!empty($v['type']))
                                        @foreach($v['type'] as $d=>$t)
                                        <tr>
                                            @if($loop->first)
                                            <td rowspan="{{$loop->count}}" style="vertical-align: middle">{{$v['name']}}</td>
                                            <td rowspan="{{$loop->count}}" style="vertical-align: middle">{{$v['url']}}</td>
                                            @endif
                                            <td>{{$diseases[$d]}}</td>
                                            <td>{{$t}}</td>
                                            @if($loop->first)
                                                <td rowspan="{{$loop->count}}" style="vertical-align: middle">{{$v['change_date']}}</td>
                                                <td rowspan="{{$loop->count}}" style="vertical-align: middle">
                                                    @if($enableUpdate)
                                                        <a href="{{route('specials.edit',$v['id'])}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                    @if($enableDelete)
                                                        <a href="javascript:void(0);" data-id="{{$v['id']}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>{{$v['name']}}</td>
                                            <td>{{$v['url']}}</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$v['change_date']}}</td>
                                            <td>
                                                @if($enableUpdate)
                                                    <a href="{{route('specials.edit',$v['id'])}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if($enableDelete)
                                                    <a href="javascript:void(0);" data-id="{{$v['id']}}"  alt="删除" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
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
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/assset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            lay('.date-item').each(function(){
                laydate.render({
                    elem: this
                    ,trigger: 'click'
                });
            });
        } );
        $(".delete-operation").on('click',function(){
            var id=$(this).attr('data-id');
            layer.open({
                content: '你确定要删除吗？',
                btn: ['确定', '关闭'],
                yes: function(index, layero){
                    $('form.specials-form').attr('action',"{{route('specials.index')}}/"+id);
                    $('form.specials-form').submit();
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
    </script>
@endsection
