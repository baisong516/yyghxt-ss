@extends('layouts.base')
@section('css')
    <link href="/css/select2.min.css" rel="stylesheet">
@endsection
@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">选项</h3>
        </div>
        <form action="{{route('excel.export')}}" method="post" id="option-form" class="option-form form-horizontal">
            {{csrf_field()}}
            @include('excel.form')
        </form>
    </div>
@endsection
@section('javascript')
    <script src="/js/select2.full.min.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $('#offices').select2();
        $('#customerCondition').select2();
        $("#select-all").click(function () {
            $("#option-form :checkbox").prop('checked',true);
        });
        $("#unselect-all").click(function () {
            $("#option-form :checkbox").removeAttr('checked');
        });
        lay('.date-item').each(function(){
            laydate.render({
                elem: this
                ,trigger: 'click'
            });
        });
    </script>
@endsection


