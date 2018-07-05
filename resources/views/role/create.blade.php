@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-permissions')
                        <a href="{{route('roles.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('roles.store')}}" method="post" class="roles-form form-horizontal">
            {{csrf_field()}}
            @include('role.form')
        </form>
    </div>
@endsection



