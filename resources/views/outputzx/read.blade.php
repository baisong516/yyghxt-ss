@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    {{--<link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">--}}
    <div class="box box-info">
        <div class="box-header">
            <form class="form-inline" action="{{route('outputszx.search')}}"  id="search-form" name="search-form" method="POST">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="searchDate">日期：</label>
                    <input type="text" class="form-control date-item" name="searchMonth" id="searchMonth" required value="{{isset($year)&&isset($month)&&$month>0?($year.'-'.$month):null}}">
                </div>
                <button type="submit" class="btn btn-success">搜索</button>
                <hr>
                <input type="hidden" id="quickSearch" name="quickSearch" value="">
                <button type="button" class="btn btn-success quick-search-option" data-type="thisMonth">本月</button>
                <button type="button" class="btn btn-success quick-search-option" data-type="lastMonth">上月</button>
                <button type="button" class="btn btn-success quick-search-option" data-type="thisYear">本年</button>
            </form>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 280px;">

                </div>
            </div>
        </div>
        <form action="" method="post" class="outputszx-form">
        {{method_field('DELETE')}}
        {{csrf_field()}}
        <div class="box-body" id="table-content">
            <div class="table-item table-responsive">
                <h5 class="text-center"><strong>({{(isset($year)?$year:'') . '年'.(isset($month)&&$month>0?$month.'月':'')}})</strong></h5>
                <table id="table-month" class="table text-center table-bordered" style="background: #C7EDCC;">
                <thead>
                    <tr>
                        <th colspan="2"></th>
                        <th colspan="5">商务通</th>
                        <th colspan="4">电话</th>
                        <th colspan="4">自媒体</th>
                        <th colspan="4">手机抓取</th>
                        <th colspan="10">合计</th>
                    </tr>
                    <tr>
                        <th>项目</th>
                        <th>咨询员</th>

                        <th>咨询</th>
                        <th>留联</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>

                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>就诊</th>
                        {{--合计--}}
                        <th>咨询量</th>
                        <th>留联</th>
                        <th>预约量</th>
                        <th>到院量</th>
                        <th>就诊量</th>
                        <th>留联率</th>
                        <th>预约率</th>
                        <th>到院率</th>
                        <th>就诊率</th>
                        <th>咨询转化率</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($toutputs)
                    @foreach($toutputs['outputs'] as $office_id=>$outputs)
                    @foreach($outputs as $user_id=>$output)
                    <tr>
                        @if($loop->first)
                        <td rowspan="{{$loop->count+1}}" style="vertical-align: middle;">{{isset($offices[$office_id])?$offices[$office_id]:''}}</td>
                        @endif
                        <td class="progress-btn" style="cursor: pointer;" data-office="{{$office_id}}" data-toggle="modal" data-target="#progressModel" data-month="{{isset($month)&&$month>0?$month:'fullyear'}}" data-year="{{isset($year)?$year:\Carbon\Carbon::now()->year}}" data-user="{{$user_id}}">{{isset($users[$user_id])?$users[$user_id]:''}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-swtzixun'}}">{{isset($output['swt']['zixun'])?$output['swt']['zixun']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-swtcontact'}}">{{isset($output['swt']['contact'])?$output['swt']['contact']:0}}</td>
                        <td>{{isset($output['swt']['yuyue'])?$output['swt']['yuyue']:0}}</td>
                        <td>{{isset($output['swt']['arrive'])?$output['swt']['arrive']:0}}</td>
                        <td>{{isset($output['swt']['jiuzhen'])?$output['swt']['jiuzhen']:0}}</td>

                        <td>{{isset($output['tel']['zixun'])?$output['tel']['zixun']:0}}</td>
                        <td>{{isset($output['tel']['yuyue'])?$output['tel']['yuyue']:0}}</td>
                        <td>{{isset($output['tel']['arrive'])?$output['tel']['arrive']:0}}</td>
                        <td>{{isset($output['tel']['jiuzhen'])?$output['tel']['jiuzhen']:0}}</td>

                        <td>{{isset($output['zmt']['zixun'])?$output['zmt']['zixun']:0}}</td>
                        <td>{{isset($output['zmt']['yuyue'])?$output['zmt']['yuyue']:0}}</td>
                        <td>{{isset($output['zmt']['arrive'])?$output['zmt']['arrive']:0}}</td>
                        <td>{{isset($output['zmt']['jiuzhen'])?$output['zmt']['jiuzhen']:0}}</td>

                        <td>{{isset($output['catch']['zixun'])?$output['catch']['zixun']:0}}</td>
                        <td>{{isset($output['catch']['yuyue'])?$output['catch']['yuyue']:0}}</td>
                        <td>{{isset($output['catch']['arrive'])?$output['catch']['arrive']:0}}</td>
                        <td>{{isset($output['catch']['jiuzhen'])?$output['catch']['jiuzhen']:0}}</td>

                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-zixun'}}">{{isset($output['total']['zixun'])?$output['total']['zixun']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-contact'}}">{{isset($output['total']['contact'])?$output['total']['contact']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-yuyue'}}">{{isset($output['total']['yuyue'])?$output['total']['yuyue']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-arrive'}}">{{isset($output['total']['arrive'])?$output['total']['arrive']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-'.$user_id.'-jiuzhen'}}">{{isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0}}</td>
                        <td>{{(isset($output['swt']['zixun'])&&$output['swt']['zixun']>0)?sprintf('%.4f',((isset($output['swt']['contact'])?$output['swt']['contact']:0)/$output['swt']['zixun']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['yuyue'])?$output['total']['yuyue']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['yuyue'])&&$output['total']['yuyue']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['yuyue']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['arrive'])&&$output['total']['arrive']>0)?sprintf('%.4f',((isset($output['total']['jiuzhen'])?$output['total']['jiuzhen']:0)/$output['total']['arrive']))*100 . '%':0}}</td>
                        <td>{{(isset($output['total']['zixun'])&&$output['total']['zixun']>0)?sprintf('%.4f',((isset($output['total']['arrive'])?$output['total']['arrive']:0)/$output['total']['zixun']))*100 . '%':0}}</td>
                    </tr>
                    @endforeach
                    <tr class="text-red" style="font-weight: bold;">
                        <td class="progress-btn" style="cursor: pointer;" data-office="{{$office_id}}" data-toggle="modal" data-target="#progressModel" data-month="{{isset($month)&&$month>0?$month:'fullyear'}}" data-year="{{isset($year)?$year:\Carbon\Carbon::now()->year}}">合计</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totalswtzixun'}}">{{isset($toutputs['totaloutputs'][$office_id]['swt']['zixun'])?$toutputs['totaloutputs'][$office_id]['swt']['zixun']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totalswtcontact'}}">{{isset($toutputs['totaloutputs'][$office_id]['swt']['contact'])?$toutputs['totaloutputs'][$office_id]['swt']['contact']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['swt']['yuyue'])?$toutputs['totaloutputs'][$office_id]['swt']['yuyue']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['swt']['arrive'])?$toutputs['totaloutputs'][$office_id]['swt']['arrive']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['swt']['jiuzhen'])?$toutputs['totaloutputs'][$office_id]['swt']['jiuzhen']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['tel']['zixun'])?$toutputs['totaloutputs'][$office_id]['tel']['zixun']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['tel']['yuyue'])?$toutputs['totaloutputs'][$office_id]['tel']['yuyue']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['tel']['arrive'])?$toutputs['totaloutputs'][$office_id]['tel']['arrive']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['tel']['jiuzhen'])?$toutputs['totaloutputs'][$office_id]['tel']['jiuzhen']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['zmt']['zixun'])?$toutputs['totaloutputs'][$office_id]['zmt']['zixun']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['zmt']['yuyue'])?$toutputs['totaloutputs'][$office_id]['zmt']['yuyue']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['zmt']['arrive'])?$toutputs['totaloutputs'][$office_id]['zmt']['arrive']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['zmt']['jiuzhen'])?$toutputs['totaloutputs'][$office_id]['zmt']['jiuzhen']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['catch']['zixun'])?$toutputs['totaloutputs'][$office_id]['catch']['zixun']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['catch']['yuyue'])?$toutputs['totaloutputs'][$office_id]['catch']['yuyue']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['catch']['arrive'])?$toutputs['totaloutputs'][$office_id]['catch']['arrive']:0}}</td>
                        <td>{{isset($toutputs['totaloutputs'][$office_id]['catch']['jiuzhen'])?$toutputs['totaloutputs'][$office_id]['catch']['jiuzhen']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totalzixun'}}">{{isset($toutputs['totaloutputs'][$office_id]['total']['zixun'])?$toutputs['totaloutputs'][$office_id]['total']['zixun']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totalcontact'}}">{{isset($toutputs['totaloutputs'][$office_id]['total']['contact'])?$toutputs['totaloutputs'][$office_id]['total']['contact']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totalyuyue'}}">{{isset($toutputs['totaloutputs'][$office_id]['total']['yuyue'])?$toutputs['totaloutputs'][$office_id]['total']['yuyue']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totalarrive'}}">{{isset($toutputs['totaloutputs'][$office_id]['total']['arrive'])?$toutputs['totaloutputs'][$office_id]['total']['arrive']:0}}</td>
                        <td id="{{$year.'-'.$month.'-'.$office_id.'-totaljiuzhen'}}">{{isset($toutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$toutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0}}</td>
                        <td>{{(isset($toutputs['totaloutputs'][$office_id]['swt']['zixun'])&&$toutputs['totaloutputs'][$office_id]['swt']['zixun']>0)?sprintf('%.4f',(isset($toutputs['totaloutputs'][$office_id]['swt']['contact'])?$toutputs['totaloutputs'][$office_id]['swt']['contact']:0)/$toutputs['totaloutputs'][$office_id]['swt']['zixun'])*100 . '%':0}}</td>
                        <td>{{(isset($toutputs['totaloutputs'][$office_id]['total']['zixun'])&&$toutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($toutputs['totaloutputs'][$office_id]['total']['yuyue'])?$toutputs['totaloutputs'][$office_id]['total']['yuyue']:0)/$toutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                        <td>{{(isset($toutputs['totaloutputs'][$office_id]['total']['yuyue'])&&$toutputs['totaloutputs'][$office_id]['total']['yuyue']>0)?sprintf('%.4f',(isset($toutputs['totaloutputs'][$office_id]['total']['arrive'])?$toutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$toutputs['totaloutputs'][$office_id]['total']['yuyue'])*100 . '%':0}}</td>
                        <td>{{(isset($toutputs['totaloutputs'][$office_id]['total']['arrive'])&&$toutputs['totaloutputs'][$office_id]['total']['arrive']>0)?sprintf('%.4f',(isset($toutputs['totaloutputs'][$office_id]['total']['jiuzhen'])?$toutputs['totaloutputs'][$office_id]['total']['jiuzhen']:0)/$toutputs['totaloutputs'][$office_id]['total']['arrive'])*100 . '%':0}}</td>
                        <td>{{(isset($toutputs['totaloutputs'][$office_id]['total']['zixun'])&&$toutputs['totaloutputs'][$office_id]['total']['zixun']>0)?sprintf('%.4f',(isset($toutputs['totaloutputs'][$office_id]['total']['arrive'])?$toutputs['totaloutputs'][$office_id]['total']['arrive']:0)/$toutputs['totaloutputs'][$office_id]['total']['zixun'])*100 . '%':0}}</td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
                </table>
            </div>

        </div>
        <!-- /.box-body -->
        </form>
    </div>
    <div class="modal fade" id="progressModel" tabindex="-1" role="dialog" aria-labelledby="myProgressModelLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">项目完成进度</h4>
                </div>
                <div class="modal-body" id="target-and-progress-table">
                    <table class="table table-responsive table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center"></th>
                                <th class="text-center">咨询量</th>
                                <th class="text-center">留联</th>
                                <th class="text-center">预约量</th>
                                <th class="text-center">到院量</th>
                                <th class="text-center">就诊量</th>
                                <th class="text-center">留联率</th>
                                <th class="text-center">预约率</th>
                                <th class="text-center">到院率</th>
                                <th class="text-center">就诊率</th>
                                <th class="text-center">咨询转化率</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td id="result-type"></td>
                                <td id="result-zixun"></td>
                                <td id="result-contact"></td>
                                <td id="result-yuyue"></td>
                                <td id="result-arrive"></td>
                                <td id="result-jiuzhen"></td>
                                <td id="result-contact-rate"></td>
                                <td id="result-yuyue-rate"></td>
                                <td id="result-arrive-rate"></td>
                                <td id="result-jiuzhen-rate"></td>
                                <td id="result-trans-rate"></td>
                            </tr>
                            <tr class="text-center">
                                <td id="target-type"></td>
                                <td id="target-zixun"></td>
                                <td id="target-contact"></td>
                                <td id="target-yuyue"></td>
                                <td id="target-arrive"></td>
                                <td id="target-jiuzhen"></td>
                                <td id="target-contact-rate"></td>
                                <td id="target-yuyue-rate"></td>
                                <td id="target-arrive-rate"></td>
                                <td id="target-jiuzhen-rate"></td>
                                <td id="target-trans-rate"></td>
                            </tr>
                            <tr class="text-center">
                                <td id="progress-type"></td>
                                <td id="progress-zixun"></td>
                                <td id="progress-contact"></td>
                                <td id="progress-yuyue"></td>
                                <td id="progress-arrive"></td>
                                <td id="progress-jiuzhen"></td>
                                <td id="progress-contact-rate"></td>
                                <td id="progress-yuyue-rate"></td>
                                <td id="progress-arrive-rate"></td>
                                <td id="progress-jiuzhen-rate"></td>
                                <td id="progress-trans-rate"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.bootcss.com/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        lay('.date-item').each(function(){
         laydate.render({
                elem: this,
                trigger: 'click',
                type:'month'
                // value: new Date()
            });
        });
        //progress-btn
        $(".progress-btn").click(function () {
            var year=$(this).data('year');
            var month=$(this).data('month');
            var office_id=$(this).data('office');
            var user_id=$(this).data('user');
            if (typeof(user_id) == "undefined"){
                user_id='';
            }
            console.log(year);
            console.log(month);
            console.log(office_id);
            console.log(user_id);
            $.ajax({
                url: '/api/get-zx-user-progress',
                type: "post",
                data: {'office_id':office_id,'year':year,'month':month,'user_id':user_id,'_token': $('input[name=_token]').val()},
                success: function(data){
                    console.log(data);
                    if (data.user!=''){
                        $("#result-type").html(data.user);
                        var swtzixun=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-swtzixun').html());
                        var swtcontact=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-swtcontact').html());
                        var zixun=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-zixun').html());
                        var contact=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-contact').html());
                        var yuyue=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-yuyue').html());
                        var arrive=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-arrive').html());
                        var jiuzhen=Number($("#"+year+'-'+month+'-'+office_id+'-'+user_id+'-jiuzhen').html());
                    }else{
                        $("#result-type").html('合计');
                        var swtzixun=Number($("#"+year+'-'+month+'-'+office_id+'-totalswtzixun').html());
                        var swtcontact=Number($("#"+year+'-'+month+'-'+office_id+'-totalswtcontact').html());
                        var zixun=Number($("#"+year+'-'+month+'-'+office_id+'-totalzixun').html());
                        var contact=Number($("#"+year+'-'+month+'-'+office_id+'-totalcontact').html());
                        var yuyue=Number($("#"+year+'-'+month+'-'+office_id+'-totalyuyue').html());
                        var arrive=Number($("#"+year+'-'+month+'-'+office_id+'-totalarrive').html());
                        var jiuzhen=Number($("#"+year+'-'+month+'-'+office_id+'-totaljiuzhen').html());
                    }
                    //完成结果
                    var contact_rate=swtzixun>0?((swtcontact/swtzixun)*100).toFixed(2) +'%':0;
                    var yuyue_rate=zixun>0?((yuyue/zixun)*100).toFixed(2) +'%':0;
                    var arrive_rate=yuyue>0?((arrive/yuyue)*100).toFixed(2) +'%':0;
                    var jiuzhen_rate=arrive>0?((jiuzhen/arrive)*100).toFixed(2) +'%':0;
                    var trans_rate=zixun>0?((arrive/zixun)*100).toFixed(2) +'%':0;
                    $("#result-zixun").html(zixun);
                    $("#result-contact").html(contact);
                    $("#result-yuyue").html(yuyue);
                    $("#result-arrive").html(arrive);
                    $("#result-jiuzhen").html(jiuzhen);
                    $("#result-contact-rate").html(contact_rate);
                    $("#result-yuyue-rate").html(yuyue_rate);
                    $("#result-arrive-rate").html(arrive_rate);
                    $("#result-jiuzhen-rate").html(jiuzhen_rate);
                    $("#result-trans-rate").html(trans_rate);
                    //目标
                    var targetZixun=data.targets.chat>0?data.targets.chat:0;
                    var targetContact=data.targets.contact>0?data.targets.contact:0;
                    var targetYuyue=data.targets.yuyue>0?data.targets.yuyue:0;
                    var targetArrive=data.targets.arrive>0?data.targets.arrive:0;
                    var targetJiuzhen=data.targets.arrive>0?data.targets.arrive:0;//目标中就诊与到院相同
                    var targetContactRate=targetZixun>0?((targetContact/targetZixun)*100).toFixed(2)+'%':0;
                    var targetYuyueRate=targetZixun>0?((targetYuyue/targetZixun)*100).toFixed(2)+'%':0;
                    var targetArriveRate=targetYuyue>0?((targetArrive/targetYuyue)*100).toFixed(2)+'%':0;
                    var targetJiuzhenRate=targetArrive>0?((targetJiuzhen/targetArrive)*100).toFixed(2)+'%':0;
                    var targetTransRate=targetArrive>0?((targetArrive/targetZixun)*100).toFixed(2)+'%':0;
                    $("#target-type").html('目标');
                    $("#target-zixun").html(targetZixun);
                    $("#target-contact").html(targetContact);
                    $("#target-yuyue").html(targetYuyue);
                    $("#target-arrive").html(targetArrive);
                    $("#target-jiuzhen").html(targetJiuzhen);
                    $("#target-contact-rate").html(targetContactRate);
                    $("#target-yuyue-rate").html(targetYuyueRate);
                    $("#target-arrive-rate").html(targetArriveRate);
                    $("#target-jiuzhen-rate").html(targetJiuzhenRate);
                    $("#target-trans-rate").html(targetTransRate);
                    //进度
                    var progressZixun=targetZixun>0?((zixun/targetZixun)*100).toFixed(2)+'%':0;
                    var progressContact=targetContact>0?((contact/targetContact)*100).toFixed(2)+'%':0;
                    var progressYuyue=targetYuyue>0?((yuyue/targetYuyue)*100).toFixed(2)+'%':0;
                    var progressArrive=targetArrive>0?((arrive/targetArrive)*100).toFixed(2)+'%':0;
                    var progressJiuzhen=targetJiuzhen>0?((jiuzhen/targetJiuzhen)*100).toFixed(2)+'%':0;
                    var progressContactRate=targetZixun>0&&swtzixun>0?(((swtcontact/swtzixun)/(targetContact/targetZixun))*100).toFixed(2)+'%':0;
                    var progressYuyueRate=zixun>0&&targetZixun>0?(((yuyue/zixun)/(targetYuyue/targetZixun))*100).toFixed(2)+'%':0;
                    var progressArriveRate=yuyue>0&&targetYuyue>0?(((arrive/yuyue)/(targetArrive/targetYuyue))*100).toFixed(2)+'%':0;
                    var progressJiuzhenRate=arrive>0&&targetArrive>0?(((jiuzhen/arrive)/(targetJiuzhen/targetArrive))*100).toFixed(2)+'%':0;
                    var progressTransRate=zixun>0&&targetZixun>0?(((arrive/zixun)/(targetArrive/targetZixun))*100).toFixed(2)+'%':0;
                    $("#progress-type").html('进度');
                    $("#progress-zixun").html(progressZixun);
                    $("#progress-contact").html(progressContact);
                    $("#progress-yuyue").html(progressYuyue);
                    $("#progress-arrive").html(progressArrive);
                    $("#progress-jiuzhen").html(progressJiuzhen);
                    $("#progress-contact-rate").html(progressContactRate);
                    $("#progress-yuyue-rate").html(progressYuyueRate);
                    $("#progress-arrive-rate").html(progressArriveRate);
                    $("#progress-jiuzhen-rate").html(progressJiuzhenRate);
                    $("#progress-trans-rate").html(progressTransRate);
                }
            });
        });
        $(".quick-search-option").click(function () {
            var searchOption=$(this).data('type');
            $("input:hidden[name=quickSearch]").val(searchOption);
            $("form#search-form").submit();
        });
    </script>
@endsection
