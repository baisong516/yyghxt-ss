@extends('layouts.base')

@section('content')
    <div class="box">
        <div class="box-header text-center">
            {{--区域头部标题--}}
            <h3 class="box-title">{{$customer->name}}</h3>
            {{--区域右侧工具--}}
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <h3 class="text-center text-danger">客户详细</h3>
            <table class="table table-bordered table-hover">
                <tr>
                    <td style="width: 20%"><b>姓名</b></td>
                    <td style="width: 80%">{{$customer->name}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>性别</b></td>
                    <td style="width: 80%">
                        @if($customer->sex=='male')
                            男
                        @elseif($customer->sex=='female')
                            女
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>年龄</b></td>
                    <td style="width: 80%">{{$customer->age}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>电话</b></td>
                    <td style="width: 80%">{{$customer->tel}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>QQ</b></td>
                    <td style="width: 80%">{{$customer->qq}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>微信</b></td>
                    <td style="width: 80%">{{$customer->wechat}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>商务通id</b></td>
                    <td style="width: 80%">{{$customer->idcard}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>搜索关键词</b></td>
                    <td style="width: 80%">{{$customer->keywords}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>所在城市</b></td>
                    <td style="width: 80%">{{$customer->city}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>媒体来源</b></td>
                    <td style="width: 80%">{{\App\Media::find($customer->media_id)?\App\Media::find($customer->media_id)->display_name:''}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>网站类型</b></td>
                    <td style="width: 80%">
                        @if(!empty($customer->webtype_id)&&\App\WebType::find($customer->webtype_id))
                            {{\App\WebType::find($customer->webtype_id)->display_name}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>当班竞价</b></td>
                    <td style="width: 80%">{{\App\User::find($customer->jingjia_user_id)?\App\User::find($customer->jingjia_user_id)->realname:''}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>未预约原因</b></td>
                    <td style="width: 80%">{{\App\Cause::find($customer->cause_id)?\App\Cause::find($customer->cause_id)->display_name:''}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>咨询病种</b></td>
                    <td style="width: 80%">{{$customer->disease->display_name}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>预约医生</b></td>
                    <td style="width: 80%">{{\App\Doctor::find($customer->doctor_id)?\App\Doctor::find($customer->doctor_id)->display_name:''}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>咨询时间</b></td>
                    <td style="width: 80%">{{$customer->zixun_at}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>预约时间</b></td>
                    <td style="width: 80%">{{$customer->yuyue_at}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>时段</b></td>
                    <td style="width: 80%">{{$customer->time_slot}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>到院时间</b></td>
                    <td style="width: 80%">{{$customer->arrive_at}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>客户类型</b></td>
                    <td style="width: 80%">
                        @if(!empty($customer->customer_type_id)&&\App\CustomerType::find($customer->customer_type_id))
                            {{\App\CustomerType::find($customer->customer_type_id)->display_name}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>状态</b></td>
                    <td style="width: 80%">
                        @if(!empty($customer->customer_condition_id)&&\App\CustomerCondition::find($customer->customer_condition_id))
                            {{\App\CustomerCondition::find($customer->customer_condition_id)->display_name}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>备注</b></td>
                    <td style="width: 80%">{{$customer->addons}}</td>
                </tr>
                <tr>
                    <td style="width: 20%"><b>咨询内容</b></td>
                    <td style="width: 80%">{!! $customer->description !!}</td>
                </tr>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@endsection



