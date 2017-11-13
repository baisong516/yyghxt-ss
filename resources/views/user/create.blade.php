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
                    @ability('superadministrator', 'create-users')
                        <a href="{{route('users.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('users.store')}}" method="post" class="users-form form-horizontal">
            {{csrf_field()}}
            @include('user.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/select2/4.0.4/js/select2.full.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#hospitals').select2();
        });
    </script>
@endsection


