@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('specials.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="buttonDate">日期：</label>
                    <input type="text" class="form-control date-item" name="dateStart" id="dateStart" value="{{isset($start)?$start:\Carbon\Carbon::now()->toDateString()}}">
                    到
                    <input type="text" class="form-control date-item" name="dateEnd" id="dateEnd" value="{{isset($end)?$end:\Carbon\Carbon::now()->toDateString()}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-specials')
                    <a href="{{route('specials.create')}}" class="btn-sm btn-info">添加专题</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">灰指甲科</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tab 2</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table id="buttons-list-table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">页面名称</th>
                                <th class="text-center">现URL</th>
                                <th class="text-center">病种</th>
                                <th class="text-center">类别(词性)</th>
                                <th class="text-center">消费</th>
                                <th class="text-center">点击</th>
                                <th class="text-center">展现</th>
                                <th class="text-center">唯一身份浏览量</th>
                                <th class="text-center">跳出率</th>
                                <th class="text-center">商务通大于等于1</th>
                                <th class="text-center">商务通大于等于3</th>
                                <th class="text-center">点击转化率</th>
                                <th class="text-center">预约</th>
                                <th class="text-center">到院</th>
                                <th class="text-center">更换时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--@foreach($todayClick as $k => $v)--}}
                            {{--@foreach($v as $d)--}}
                            {{--<tr>--}}
                            {{--@if($loop->first)--}}
                            {{--<td rowspan="{{$loop->count}}" class="text-center" style="vertical-align: middle;">{{$k}}</td>--}}
                            {{--@endif--}}
                            {{--<td class="text-center">--}}
                            {{--@foreach(array_filter(explode('_',$d['flag'])) as $e)--}}
                            {{--{{isset($clickArray[$e])?$clickArray[$e]:$e}}--}}
                            {{--@endforeach--}}
                            {{--</td>--}}
                            {{--<td class="text-center">{{isset($d['description'])?$d['description']:''}}</td>--}}
                            {{--<td class="text-center">{{$d['count']}}</td>--}}
                            {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--@endforeach--}}
                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        T
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
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
    </script>
@endsection
