@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">

            </div>
        </div>
        <form action="{{route('jjoutputs.store')}}" method="post" class="jjoutputs-form form-horizontal">
            {{csrf_field()}}
            @include('jjoutput.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        //data item
        lay('.item-date').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'date'
                // value: new Date()
            });
        });
        //change zxusers on office change
        $("#office").on('change',function(){
            var officeId=$(this).val();
            $.ajax({
                url: '/api/get-jjusers-from-office',
                type: "post",
                data: {'office_id':officeId,'_token': $('input[name=_token]').val()},
                success: function(data){
                    $("#user").empty();
                    if(data.status){
                        var html='';
                        for (var i=0;i<data.data.length;i++){
                            html += "<option value=\""+data.data[i].id+"\">"+data.data[i].name+"</option>";
                        }
                        $("#user").append(html);
                    }
                }
            });
        });
    </script>
@endsection



