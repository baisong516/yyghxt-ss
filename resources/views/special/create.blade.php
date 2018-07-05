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

            </div>
        </div>
        <form action="{{route('specials.store')}}" method="post" class="specials-form form-horizontal">
            {{csrf_field()}}
            @include('special.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/select2/4.0.4/js/select2.full.min.js"></script>
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
        var diseases=[];
        $("#office").on('change',function(){
            var officeId=$(this).val();
            $.ajax({
                url: '/api/get-diseases-from-office',
                type: "post",
                data: {'office_id':officeId,'_token': $('input[name=_token]').val()},
                success: function(data){
                    $("#disease").empty();
                    if (data.status){
                        var html='';
                        if (data.data['diseases'].length>0){
                            for (var i=0;i<data.data['diseases'].length;i++){
                                diseases[data.data['diseases'][i]['id']]=data.data['diseases'][i]['display_name'];
                                html+='<option value="'+data.data['diseases'][i]['id']+'">'+data.data['diseases'][i]['display_name']+'</option>';
                            }
                        }
                        $("#disease").html(html);
                    }
                }
            });
        });
        $("#disease").on('change',function () {
            var diseaseIds=$(this).val();
            $("#options").empty();
            if (diseaseIds!=null&&diseaseIds.length>0&&diseaseIds!=''){
                for (var i=0;i<diseaseIds.length;i++){
                    var child="<div class=\"form-group\" id=\"option-"+diseaseIds[i]+"\" data-disease=\""+diseaseIds[i]+"\"><label for=\"type\" class=\"col-sm-2 control-label\">"+diseases[diseaseIds[i]]+"</label>"+
                        "<div class=\"col-sm-8\"><input type=\"text\"  name=\"types["+diseaseIds[i]+"]\" class=\"form-control\"></div></div>";
                    $("#options").append(child);
                }
            }

        });
        $(document).ready(function() {
            $('#disease').select2();
        });
    </script>
@endsection



