@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-zx_customers')
                    <a href="{{route('zxcustomers.index')}}" class="btn-sm btn-info">返回</a>
                    @endability
                </div>
            </div>
        </div>
        <form action="{{route('zxcustomers.store')}}" method="post" class="zxcustomers-form form-horizontal">
            {{csrf_field()}}
            @include('zxcustomer.form')
        </form>
    </div>
@endsection

@section('javascript')
    <script src="/asset/ckeditor/ckeditor.js"></script>
    <script src="/asset/ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        //data item
        lay('.item-date').each(function(){
            laydate.render({
                elem: this,
                trigger: 'click',
                type:'datetime'
//                value: new Date()
            });
        });
        //咨询内容编辑器
        CKEDITOR.replace( 'description' );
        //change offices on hospital change
        $("#office").on('change',function(){
            var officeId=$(this).val();
            $.ajax({
                url: '/api/get-diseases-from-office',
                type: "post",
                data: {'office_id':officeId,'_token': $('input[name=_token]').val()},
                success: function(data){
                    $("#disease").empty();
                    if(data.status){
                        var html='';
                        html += "<optgroup label=\""+data.data['name']+"\">";
                        for (var i=0;i<data.data['diseases'].length;i++){
                            html += "<option value=\""+data.data['diseases'][i].id+"\">"+data.data['diseases'][i].display_name+"</option>";
                        }
                        html += "</optgroup>";
                        $("#disease").append(html);
                    }
                }
            });
        });
    </script>
@endsection



