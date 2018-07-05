@extends('layouts.base')
@section('css')
    <link href="https://cdn.bootcss.com/select2/4.0.4/css/select2.min.css" rel="stylesheet">
@endsection
@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">

                </div>
            </div>
        </div>
        <form action="{{route('specialtrans.store')}}" method="post" class="specialtrans-form form-horizontal">
            {{csrf_field()}}
            @include('specialtran.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/select2/4.0.4/js/select2.full.min.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#special').select2();
            //data item
            lay('.item-date').each(function(){
                laydate.render({
                    elem: this,
                    trigger: 'click',
                    type:'date'
                    // value: new Date()
                });
            });
        });
    </script>
@endsection




