@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
        </div>
        <form action="{{route('profiles.update',$user->id)}}" method="post" class="profiles-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('profile.form')
        </form>
    </div>
@endsection



