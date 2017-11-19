@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="row">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">新增排班</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="{{route('arrangements.store')}}">
                {{csrf_field()}}
                @include('arrangement.form')
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/laydate/laydate.js"></script>
    <script type="text/javascript">
        laydate.render({
            elem: '#rank_date',
            type: 'date'
        });
    </script>
@endsection



