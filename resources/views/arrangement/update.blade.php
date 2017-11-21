@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'update-arrangements')
                        <a href="{{route('arrangements.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('arrangements.update',$arrangement->id)}}" method="post" class="arrangements-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('arrangement.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        laydate.render({
            elem: '#rank_date',
            type: 'date'
        });
    </script>
@endsection


