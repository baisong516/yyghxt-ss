@extends('layouts.base')

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
    <script type="text/javascript">
        $("#select-all").click(function () {
            $("#option-form :checkbox").prop('checked',true);
        });
        $("#unselect-all").click(function () {
            $("#option-form :checkbox").removeAttr('checked');
        });
    </script>
@endsection


