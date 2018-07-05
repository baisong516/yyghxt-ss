@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-diseases')
                        <a href="{{route('diseases.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('diseases.store')}}" method="post" class="diseases-form form-horizontal">
            {{csrf_field()}}
            @include('disease.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        $("#hospital").on('change',function(){
            $("#office").empty();
            $("#office").append("<option selected=\"selected\" disabled=\"disabled\" hidden=\"hidden\">--选择科室--</option>");
            $.ajax({
                url: '/api/get-offices-from-hospital',
                type: "post",
                data: {'hospital_id':$(this).find("option:selected").val(),'_token': $('input[name=_token]').val()},
                success: function(data){
                    if(data.status){
                        for (var i=0;i<data.data.length;i++){
                            $("#office").append("<option value=\""+data.data[i].id+"\">"+data.data[i].display_name+"</option>");
                        }
                    }
                }
            });
        });
    </script>
@endsection



