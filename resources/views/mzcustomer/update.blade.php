@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'update-mz_customers')
                    <a href="{{route('menzhens.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('menzhens.update',$customer->id)}}" method="post" class="mzcustomers-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('mzcustomer.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/laydate/laydate.js"></script>
    <script type="text/javascript">
        //data item
        lay('.item-date').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'datetime'
//                value: new Date()
            });
        });
    </script>
@endsection

