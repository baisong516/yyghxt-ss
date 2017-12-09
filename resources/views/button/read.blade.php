@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('buttons.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="buttonDate">日期：</label>
                    <input type="text" class="form-control date-item" name="dateStart" id="dateStart" value="{{isset($start)?$start:\Carbon\Carbon::now()->toDateString()}}">
                    到
                    <input type="text" class="form-control date-item" name="dateEnd" id="dateEnd" value="{{isset($end)?$end:\Carbon\Carbon::now()->toDateString()}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
        </div>
        <div class="box-body">
            <form action="" method="post" class="hospitals-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
            <table id="buttons-list-table" class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">网站</th>
                    <th class="text-center">位置</th>
                    <th class="text-center">说明</th>
                    <th class="text-center">点击次数</th>
                </tr>
                </thead>
                <tbody>
                @foreach($todayClick as $k => $v)
                    @foreach($v as $d)
                    <tr>
                        @if($loop->first)
                        <td rowspan="{{$loop->count}}" class="text-center" style="vertical-align: middle;">{{$k}}</td>
                        @endif
                        <td class="text-center">
                            @foreach(array_filter(explode('_',$d['flag'])) as $e)
                                {{isset($clickArray[$e])?$clickArray[$e]:$e}}
                            @endforeach
                        </td>
                        <td class="text-center">{{isset($d['description'])?$d['description']:''}}</td>
                        <td class="text-center">{{$d['count']}}</td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>
            </form>
        </div>
        <p class="text-red">显示当天点击量总数，其它根据日期查询！</p>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
//            $('#buttons-list-table').DataTable({
//                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
//                "language": {
//                    "url": "/datables-language-zh-CN.json"
//                }
//            });
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
