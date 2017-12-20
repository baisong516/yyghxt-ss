@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-specials')
                    <a href="{{route('specials.create')}}" class="btn-sm btn-info">添加专题</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">灰指甲科</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tab 2</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        T
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            lay('.date-item').each(function(){
                laydate.render({
                    elem: this
                    ,trigger: 'click'
                });
            });
        } );
    </script>
@endsection
