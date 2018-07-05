@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">
                {{--<div class="input-group input-group-sm" style="width: 80px;">--}}
                    {{--@ability('superadministrator', 'update-hospitals')--}}
                        {{--<a href="{{route('hospitals.index')}}" class="btn-sm btn-info">返回</a>--}}
                    {{--@endability--}}
                {{--</div>--}}
            </div>
        </div>
        <form action="{{route('platforms.update',$platform->id)}}" method="post" class="platforms-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('platform.form')
        </form>
    </div>
@endsection



