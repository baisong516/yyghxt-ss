@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">添加</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    <a href="javascript:history.go(-1);" class="btn-sm btn-info">返回</a>
                </div>
            </div>
        </div>
        {{--<form class="form-inline">--}}
            {{--<div class="form-group">--}}
                {{--<label for="exampleInputName2">Name</label>--}}
                {{--<input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="exampleInputEmail2">Email</label>--}}
                {{--<input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">--}}
            {{--</div>--}}
            {{--<button type="submit" class="btn btn-default">Send invitation</button>--}}
        {{--</form>--}}


            <div class="box-body">
                <style>
                    form.zxcustomers-form input,form.zxcustomers-form select{margin-bottom: 10px;margin-top: 10px;}
                </style>
                <form action="{{route('zxcustomers.store')}}" method="post" class="zxcustomers-form form-inline">
                    {{csrf_field()}}
                @include('zxcustomer.form')
                <div class="row {{empty($errors->first('next_at'))?'':'has-error'}}" >
                    <label for="next_at" class="col-sm-2 control-label text-right">下次回访时间</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control item-date" name="next_at" style="width: 100%;"  id="next_at" value="{{isset($customer)&&isset($customer->huifangs->last()->next_at)?$customer->huifangs->last()->next_at:\Carbon\Carbon::now()->toDateTimeString()}}">
                    </div>
                </div>
                </form>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-10">
                        <button type="button" class="btn btn-info pull-right submit-operation">提交</button>
                    </div>
                </div>
            </div>

    </div>
@endsection

@section('javascript')
    <script src="/asset/ckeditor/ckeditor.js"></script>
    <script src="/asset/ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
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
        //提交检测系统已有数据
        $(".submit-operation").on('click',function(){
            var wechat=$("form.zxcustomers-form input[name=wechat]").val();
            console.log(wechat);
            var tel=$("form.zxcustomers-form input[name=tel]").val();
            console.log(tel);
            $.ajax({
                url: '/api/check-exist-customer/',
                type: "post",
                data: {'wechat':wechat,'tel':tel,'_token': $('input[name=_token]').val()},
                success: function(data){
                    // console.log(data.num);
                    if (data.num>0){
                        layer.open({
                            content: data.tip,
                            btn: ['确定', '关闭'],
                            yes: function(index, layero){
                                $("form.zxcustomers-form").submit();
                            },
                            btn2: function(index, layero){
                                //按钮【按钮二】的回调
                                //return false 开启该代码可禁止点击该按钮关闭
                            },
                            cancel: function(){
                                //右上角关闭回调
                                //return false; 开启该代码可禁止点击该按钮关闭
                            }
                        });
                    }else{
                        $("form.zxcustomers-form").submit();
                    }
                }
            });

        });
    </script>
@endsection



