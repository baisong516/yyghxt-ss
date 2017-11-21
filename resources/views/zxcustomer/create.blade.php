@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-zx_customers')
                    <a href="{{route('zxcustomers.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('zxcustomers.store')}}" method="post" class="zxcustomers-form form-horizontal">
            {{csrf_field()}}
            @include('zxcustomer.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script src="/asset/ckeditor/ckeditor.js"></script>
    <script src="/asset/ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
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
        //咨询内容编辑器
        CKEDITOR.replace( 'description' );
    </script>
@endsection



