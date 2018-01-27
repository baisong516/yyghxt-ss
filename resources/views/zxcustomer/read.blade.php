@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box collapsed-box">
        <div class="box-header">
            <h3 class="box-title">高级搜索</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-plus text-success"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                    <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form class="form-inline" action="{{route('zxcustomers.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="quickSearch" value="">
                <div class="form-group">
                    <label for="searchCustomerName">姓名：</label>
                    <input type="text" class="form-control" name="searchCustomerName" id="searchCustomerName" placeholder="姓名">
                </div>
                <div class="form-group">
                    <label for="searchCustomerTel">电话：</label>
                    <input type="text" class="form-control" name="searchCustomerTel" id="searchCustomerTel" placeholder="电话">
                </div>
                <div class="form-group">
                    <label for="searchCustomerQQ">QQ：</label>
                    <input type="text" class="form-control" name="searchCustomerQQ" id="searchCustomerQQ" placeholder="QQ">
                </div>
                <div class="form-group">
                    <label for="searchCustomerWechat">微信：</label>
                    <input type="text" class="form-control" name="searchCustomerWechat" id="searchCustomerWechat" placeholder="微信">
                </div>
                <div class="form-group">
                    <label for="searchIdCard">商务通ID：</label>
                    <input type="text" class="form-control" name="searchIdCard" id="searchIdCard" placeholder="商务通ID">
                </div>
                <hr style="margin-top: 5px;margin-bottom: 5px;"/>
                <div class="form-group">
                    <label for="searchZx">咨询时间：</label>
                    <input type="text" class="form-control date-item" name="searchZxStart" id="searchZxStart">
                    到
                    <input type="text" class="form-control date-item" name="searchZxEnd" id="searchZxEnd">
                </div>
                <div class="form-group">
                    <label for="searchYuyue">预约时间：</label>
                    <input type="text" class="form-control date-item" name="searchYuyueStart" id="searchYuyueStart">
                    到
                    <input type="text" class="form-control date-item" name="searchYuyueEnd" id="searchYuyueEnd">
                </div>
                <hr style="margin-top: 5px;margin-bottom: 5px;"/>
                <div class="form-group">
                    <label for="searchArrive">到院时间：</label>
                    <input type="text" class="form-control date-item" name="searchArriveStart" id="searchArriveStart">
                    到
                    <input type="text" class="form-control date-item" name="searchArriveEnd" id="searchArriveEnd">
                </div>
                <div class="form-group">
                    <label for="searchLastHuifang">最近回访时间：</label>
                    <input type="text" class="form-control date-item" name="searchLastHuifangStart" id="searchLastHuifangStart">
                    到
                    <input type="text" class="form-control date-item" name="searchLastHuifangEnd" id="searchLastHuifangEnd">
                </div>
                <hr style="margin-top: 5px;margin-bottom: 5px;"/>
                <div class="form-group">
                    <label for="searchNextHuifang">下次回访时间：</label>
                    <input type="text" class="form-control date-item" name="searchNextHuifangStart" id="searchNextHuifangStart">
                    到
                    <input type="text" class="form-control date-item" name="searchNextHuifangEnd" id="searchNextHuifangEnd">
                </div>
                <hr style="margin-top: 5px;margin-bottom: 5px;"/>
                <div class="form-group">
                    <label for="searchOfficeId">科室：</label>
                    <select name="searchOfficeId" id="searchOfficeId" class="form-control">
                        <option value="">--科室--</option>
                        @foreach(Auth::user()->offices as $office)
                            <option value="{{$office->id}}">{{$office->display_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="searchDiseaseId">病种：</label>
                    <select name="searchDiseaseId" id="searchDiseaseId" class="form-control">
                        <option value="">--病种--</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="searchUserId">咨询员：</label>
                    <select name="searchUserId" id="searchUserId" class="form-control">
                        <option value="">--咨询员--</option>
                        @foreach($zxusers as $k=>$user)
                            <option value="{{$k}}">{{$user}}</option>
                        @endforeach
                    </select>
                </div>
                <hr style="margin-top: 5px;margin-bottom: 5px;"/>
                <button type="submit" class="btn btn-success">搜索</button>
            </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{--Footer--}}
        </div>
        <!-- /.box-footer-->
    </div>
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">列表</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm pull-right" style="">
                    @ability('superadministrator', 'create-zx_customers')
                    <a href="{{route('zxcustomers.create')}}" class="btn-sm btn-success">新增</a>
                    @endability
                </div>
                <div class="input-group input-group-sm pull-right" style="margin-right: 1rem;">
                    <a href="javascript:;" class="btn-sm btn-info" id="todayarrive">今日应到院</a>
                </div>
                <div class="input-group input-group-sm pull-right" style="margin-right: 1rem;">
                    <a href="javascript:;" class="btn-sm btn-info" id="todayhuifang">今日应回访</a>
                </div>
            </div>
        </div>
        <form action="" method="post" class="zxcustomers-form">
        <div class="box-body table-responsive">
                {{method_field('DELETE')}}
                {{csrf_field()}}
            <style>
                #zxcustomers-list-table th{padding-right: 0;}
                #zxcustomers-list-table th:after{content: '';}
            </style>
                <table id="zxcustomers-list-table" class="table table-striped table-bordered text-center" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th style="display: none;"><i class="fa fa-level-down" aria-hidden="true"></i></th>
                        <th>患者</th>
                        <th>年龄</th>
                        <th>性别</th>
                        <th width="5%">联系</th>
                        <th width="5%">微信</th>
                        <th>QQ</th>
                        <th style="display: none;">id</th>
                        <th>关键词</th>
                        <th>城市</th>
                        <th>来源</th>
                        <th>网站</th>
                        <th>科室</th>
                        <th>病种</th>
                        <th>状态</th>
                        <th>商务通转电话</th>
                        <th>咨询员</th>
                        <th>当班竞价</th>
                        <th>咨询</th>
                        <th>预约</th>
                        <th>时段</th>
                        <th>到院</th>
                        <th>最近回访</th>
                        <th>最近回访人</th>
                        <th>下次回访</th>
                        <th>下次回访人</th>
                        <th style="display: none;">类型</th>
                        <th style="display: none;">备注</th>
                        <th>回访</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($customers))
                    @foreach($customers as $customer)
                        <tr id="customer-{{$customer->id}}" class="{{isset($quicksearch)&&$quicksearch=='todayhuifang'&&$customer->huifangs->last()&&($customer->huifangs->last()->next_at>=\Carbon\Carbon::now()->endOfDay()||$customer->huifangs->last()->now_at>=\Carbon\Carbon::now()->startOfDay())?'bg-red':''}}">
                            <td style="display: none;">{{$customer->id}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->age}}</td>
                            <td>
                                @if(!empty($customer->sex))
                                    @if($customer->sex=='male')
                                        男
                                    @elseif($customer->sex=='female')
                                        女
                                    @endif
                                @endif
                            </td>
                            <td>{{$customer->tel}}</td>
                            <td>{{$customer->wechat}}</td>
                            <td>{{$customer->qq}}</td>
                            <td style="display: none;">{{$customer->idcard}}</td>
                            <td>{{$customer->keywords}}</td>
                            <td>{{$customer->city}}</td>
                            {{--媒体来源--}}
                            <td>{{$customer->media_id?$medias[$customer->media_id]:''}}</td>
                            {{--网站类型--}}
                            <td>{{$customer->webtype_id?$webtypes[$customer->webtype_id]:''}}</td>
                            {{--科室--}}
                            <td>{{$customer->office_id?$offices[$customer->office_id]:''}}</td>
                            {{--病种--}}
                            <td>{{$customer->disease_id?$diseases[$customer->disease_id]:''}}</td>
                            {{--状态--}}
                            <td>{{$customer->customer_condition_id?$customerconditions[$customer->customer_condition_id]:''}}</td>
                            {{--商务通转电话--}}
                            <td>{{$customer->trans_user_id?$users[$customer->trans_user_id]:''}}</td>
                            {{--咨询员--}}
                            <td>{{$customer->user_id?$users[$customer->user_id]:''}}</td>
                            {{--竞价员--}}
                            <td>{{$customer->jingjia_user_id?$users[$customer->jingjia_user_id]:''}}</td>

                            <td>{{$customer->zixun_at?$customer->zixun_at:''}}</td>
                            <td>{{$customer->yuyue_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->yuyue_at)->toDateString():''}}</td>
                            <td>{{$customer->time_slot?$customer->time_slot:''}}</td>
                            <td>{{$customer->arrive_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->arrive_at)->toDateString():''}}</td>

                            {{--最近回访日期--}}
                            <td class="created_at">{{$customer->huifangs->last()&&$customer->huifangs->last()->created_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->huifangs->last()->created_at)->toDateString():''}}</td>
                            {{--最近回访人--}}
                            <td class="now_user">{{$customer->huifangs->last()?$users[$customer->huifangs->last()->now_user_id]:''}}</td>
                            {{--下次回访日期--}}
                            <td class="next_at">{{$customer->huifangs->last()&&$customer->huifangs->last()->next_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->huifangs->last()->next_at)->toDateString():''}}</td>
                            {{--下次回访人--}}
                            <td class="next_user">{{$customer->huifangs->last()&&$customer->huifangs->last()->next_user_id?$users[$customer->huifangs->last()->next_user_id]:''}}</td>
                            {{--<客户类型--}}
                            <td style="display: none;">{{$customer->customer_type_id?$customertypes[$customer->customer_type_id]:''}}</td>
                            {{--备注--}}
                            <td style="display: none;">{{$customer->addons?$customer->addons:''}}</td>
                            <td class="huifang-cloumn">
                                @if($enableHuifang)
                                    @if($customer->huifangs->count()<1)
                                        <a href="javascript:void(0);" data-id="{{$customer->id}}" data-toggle="modal" data-target="#huifangModal"  class="hf-btn text-red" >未回访</a>
                                    @else
                                        <a href="javascript:void(0);" data-id="{{$customer->id}}" data-toggle="modal" data-target="#huifangModal" class="hf-btn text-blue">已回访</a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($enableRead)
                                <a href="{{route('zxcustomers.show',$customer->id)}}"  alt="查看" title="查看"><i class="fa fa-eye"></i></a>
                                @endif
                                @if($enableUpdate)
                                    <a href="{{route('zxcustomers.edit',$customer->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                @endif
                                @if($enableDelete)
                                    <a href="javascript:void(0);"  alt="删除" data-id="{{$customer->id}}" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
        </div>
        <!-- /.box-body -->
    </form>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#zxcustomers-list-table').DataTable({
                "order": [[ 0, "desc" ]],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "url": "/datables-language-zh-CN.json"
                }
            });
            $("#searchOfficeId").on('change',function(){
                var officeId=$(this).val();
                $.ajax({
                    url: '/api/get-diseases-from-office',
                    type: "post",
                    data: {'office_id':officeId,'_token': $('input[name=_token]').val()},
                    success: function(data){
                        $("#searchDiseaseId").empty();
                        if(data.status){
                            var html='<option value="">--选择病种--</option>';
                            html += "<optgroup label=\""+data.data['name']+"\">";
                            for (var i=0;i<data.data['diseases'].length;i++){
                                html += "<option value=\""+data.data['diseases'][i].id+"\">"+data.data['diseases'][i].display_name+"</option>";
                            }
                            html += "</optgroup>";
                            $("#searchDiseaseId").append(html);
                        }
                    }
                });
            });
            $(".delete-operation").on('click',function(){
                var id=$(this).attr('data-id');
                layer.open({
                    content: '你确定要删除吗？',
                    btn: ['确定', '关闭'],
                    yes: function(index, layero){
                        $('form.zxcustomers-form').attr('action',"{{route('zxcustomers.index')}}/"+id);
                        $('form.zxcustomers-form').submit();
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
            });
            //快捷查询今日应回访
            $("#todayhuifang").click(function () {
                $("#search-form :hidden[name=quickSearch]").val('todayhuifang');
                $("#search-form").submit();
            });
            $("#todayarrive").click(function () {
                $("#search-form :hidden[name=quickSearch]").val('todayarrive');
                $("#search-form").submit();
            });
        } );
        //
        @isset($todayHuifang)
        layer.msg(
            '<p>今日应回访：<span class="label bg-green">{{isset($todayHuifang)?$todayHuifang:''}}</span>人，已回访：<span class="label bg-green">{{$todayHuifangFinished}}</span>人</p><p>今日应到院：<span class="label bg-primary">{{isset($todayArrive)?$todayArrive:''}}</span>人',
            { offset:'rt',time: 5000}
            )
        @endisset
    </script>
    <!-- 回访modal -->
    <div class="modal fade" id="huifangModal" tabindex="-1" role="dialog" aria-labelledby="huifangModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="huifangModalLabel">回访记录</h4>
                </div>
                <div class="modal-body">
                    <div id="huifangrecords">
                        <p>加载中...</p>
                    </div>
                    <form class="form-horizontal">
                        <div class="huifang-add" id="huifang-add">
                            <input type="hidden" name="customer_id" value="">
                            <h3 class="text-center">本次回访</h3>
                            <div class="form-group">
                                <label for="customerId" class="col-sm-2 control-label">患者</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="customerName" value="" disabled>
                                </div>
                            </div>
                            <div class="form-group {{empty($errors->first('next_at'))?'':'has-error'}}">
                                <label for="next_at" class="col-sm-2 control-label">下次回访时间</label>
                                <div class="col-sm-10">
                                    <input type="text" name="next_at" id="next_at" class="form-control" id="next_at" >
                                </div>
                                <script type="text/javascript">
                                    laydate.render({
                                        elem: '#next_at',
                                        type: 'datetime'
                                    });
                                </script>
                            </div>
                            <div class="form-group {{empty($errors->first('next_at'))?'':'has-error'}}">
                                <label for="next_user_id" class="col-sm-2 control-label">下次回访人</label>
                                <div class="col-sm-10">
                                    <select name="next_user_id" id="next_user_id" class="form-control">
                                        <option value="" selected="selected">--选择--</option>
                                        @foreach($zxusers as $k=>$user)
                                            <option value="{{$k}}">{{$user}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group {{empty($errors->first('description'))?'':'has-error'}}">
                                <label for="next_user_id" class="col-sm-2 control-label">回访内容</label>
                                <div class="col-sm-10">
                                    <textarea name="description" id="description" class="form-control" rows="8"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="hf_submit">提交回访</button>
                </div>
            </div>
            <script type="text/javascript">
                $(".huifang-cloumn").delegate('.hf-btn','click',function () {
                    $("#huifang-add input:hidden[name=customer_id]").val('');
                    $("#huifang-add input[name=next_at]").val('');
                    $("#huifang-add select[name=next_user_id]").val('');
                    $("#huifang-add textarea[name=description]").val('');
                    var customer_id =$(this).attr('data-id');
                    $.ajax({
                        url: '/api/get-huifangs-from-customer',
                        type: "post",
                        data: {'zx_customer_id':customer_id,'_token': $('input[name=_token]').val()},
                        success: function(data){
                            $("#customerName").val(data.customer);
                            $("#huifang-add input:hidden[name=customer_id]").val(data.customer_id);
                            var html="<h3 class=\"text-center text-danger\">"+data.customer+"</h3>";
                            if(data.status){
                                for (var i=0;i<data.data.length;i++){
                                    html += "<h5 class=\"text-center text-blue\">时间："+data.data[i]['now_at']+"</h5>";
                                    html += "<table class=\"table table-bordered\">";
                                    html += "<tr>";
                                    html += "<td style=\"width: 10%;\"><b>回访人</b></td>";
                                    html += "<td  style=\"width: 90%;\">"+data.data[i]['user']+"</td>";
                                    html += "</tr>";
                                    html += "<tr>";
                                    html += "<td style=\"width: 10%;\"><b>回访内容</b></td>";
                                    html += "<td style=\"width: 90%;\">"+data.data[i]['content']+"</td>";
                                    html += "</tr>";
                                    html += "</table>";
                                }
                                $("#huifangrecords").html(html);
                            }else{
                                $("#huifangrecords").html("<p class='text-center'>无回访记录！</p>");
                            }
                        }
                    });
                });
                //提交回访
                $("#hf_submit").click(function () {
                    var customer_id =$("#huifang-add input:hidden[name=customer_id]").val();
                    var next_at =$("#huifang-add input[name=next_at]").val();
                    var next_user_id =$("#huifang-add select[name=next_user_id]").val();
                    var description =$("#huifang-add textarea[name=description]").val();
                    $.ajax({
                        url:'{{route('huifangs.store')}}',
                        type: "post",
                        data: {'zx_customer_id':customer_id,'next_at':next_at,'next_user_id':next_user_id,'description':description,'_token': $('input[name=_token]').val()},
                        success: function(data){
                            if(data.status){
                                $("#customer-"+data.customer_id+" .huifang-cloumn a").removeClass("text-red").addClass("text-blue");
                                $("#customer-"+data.customer_id+" .huifang-cloumn a").html("已回访");
                                $("#customer-"+data.customer_id+" .created_at").html(data.created_at);
                                $("#customer-"+data.customer_id+" .now_user").html(data.now_user);
                                $("#customer-"+data.customer_id+" .next_at").html(data.next_at);
                                $("#customer-"+data.customer_id+" .next_user").html(data.next_user);
                            }
                        }
                    });
                });
                lay('.date-item').each(function(){
                    laydate.render({
                        elem: this
                        ,trigger: 'click'
                    });
                });
            </script>
        </div>
    </div>
@endsection
