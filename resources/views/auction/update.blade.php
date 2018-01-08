@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">更新</h3>
            <div class="box-tools">
                {{--<div class="input-group input-group-sm" style="width: 80px;">--}}
                    {{--@ability('superadministrator', 'create-areas')--}}
                        {{--<a href="{{route('areas.index')}}" class="btn-sm btn-info">返回</a>--}}
                    {{--@endability--}}
                {{--</div>--}}
            </div>
        </div>
        <form action="{{route('auctions.update',$auction->id)}}" method="post" class="auction-form form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            @include('auction.form')
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
        $("#type").on('change',function(){
            var type=$(this).val();
            $.ajax({
                url: '/api/get-values-from-type',
                type: "post",
                data: {'type':type,'_token': $('input[name=_token]').val()},
                success: function(data){
                    $("#type_id").empty();
                    var html='';
                    if (data.type == 'disease'){
                        for (var i in data.data){
                            html += "<optgroup label=\""+data.data[i]['name']+"\">";
                            for (var j in data.data[i]['diseases']){
                                html += "<option value=\""+j+"\">"+data.data[i]['diseases'][j]+"</option>";
                            }
                            html += "</optgroup>";
                        }
                    }else{
                        for (var i in data.data){
                            html += "<option value=\""+i+"\">"+data.data[i]+"</option>";
                        }
                    }
                    $("#type_id").html(html);
                }
            });
        });
    </script>
@endsection



