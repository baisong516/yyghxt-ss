@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <h3 class="box-title">列表</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 80px;">
                    @ability('superadministrator', 'create-zx_customers')
                    <a href="{{route('zxcustomers.create')}}" class="btn-sm btn-info">新增</a>
                    @endability
                </div>
            </div>
        </div>
        <div class="box-body">
            <form action="" method="post" class="zxcustomers-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
                <table id="zxcustomers-list-table" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th>编号</th>
                        <th>姓名</th>
                        <th>年龄</th>
                        <th>性别</th>
                        <th>联系</th>
                        <th>微信</th>
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
                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>最近回访</th>
                        <th>最近回访人</th>
                        {{--<th>下次回访</th>--}}
                        {{--<th>下次回访人</th>--}}
                        {{--<th>客户类型</th>--}}
                        {{--<th>备注</th>--}}
                        <th>回访</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr id="customer-{{$customer->id}}">
                            <td>{{$customer->id}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->age}}</td>
                            <td>
                                @if(!empty($customer->sex))
                                    {{$customer->sex=='male'?'男':'女'}}
                                @endif
                            </td>
                            <td>{{$customer->tel}}</td>
                            <td>{{$customer->wechat}}</td>
                            <td>{{$customer->qq}}</td>
                            <td style="display: none;">{{$customer->idcard}}</td>
                            <td>{{$customer->keywords}}</td>
                            <td>{{$customer->city}}</td>
                            {{--媒体来源--}}
                            <td>{{$customer->media_id?$customer->media->display_name:''}}</td>
                            {{--网站类型--}}
                            <td>{{$customer->webtype_id?$customer->webtype->display_name:''}}</td>
                            {{--科室--}}
                            <td>{{$customer->office->display_name}}</td>
                            {{--病种--}}
                            <td>{{$customer->disease->display_name}}</td>
                            {{--状态--}}
                            <td>{{$customer->customertype_id?$customer->customertype->display_name:''}}</td>
                            {{--商务通转电话--}}
                            <td>{{$customer->trans_user_id?$customer->transuser->realname:''}}</td>
                            {{--咨询员--}}
                            <td>{{$customer->user->realname}}</td>
                            <td>{{$customer->zixun_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->zixun_at)->toDateString():''}}</td>
                            <td>{{$customer->yuyue_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->yuyue_at)->toDateString():''}}</td>
                            <td>{{$customer->arrive_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->arrive_at)->toDateString():''}}</td>

                            {{--最近回访日期--}}
                            <td class="created_at">{{$customer->huifangs->last()&&$customer->huifangs->last()->created_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->huifangs->last()->created_at)->toDateString():''}}</td>
                            {{--最近回访人--}}
                            <td class="now_user">{{$customer->huifangs->last()&&$customer->huifangs->last()->now_user_id?$customer->huifangs->last()->lastusername:''}}</td>
                            {{--下次回访日期--}}
                            {{--<td class="next_at">{{$customer->huifangs->last()&&$customer->huifangs->last()->next_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->huifangs->last()->next_at)->toDateString():''}}</td>--}}
                            {{--下次回访人--}}
                            {{--<td class="next_user">{{$customer->huifangs->last()&&$customer->huifangs->last()->next_user_id?\App\User::find($customer->huifangs->last()->next_user_id)->realname:''}}</td>--}}
                            {{--<客户类型--}}
                            {{--<td>--}}
                            {{--@if(!empty($customer->customer_type_id))--}}
                            {{--{{\App\CustomerType::find($customer->customer_type_id)->display_name}}--}}
                            {{--@endif--}}
                            {{--</td>--}}

                            {{--备注--}}
                            {{--<td>{{ str_limit($customer->addons,20,'...')}}</td>--}}
                            <td class="huifang-cloumn">
                                @if($customer->huifangs->count()<1)
                                    @if(Laratrust::can('create-huifangs')||Laratrust::hasRole('superadministrator|administrator'))
                                        <a href="javascript:void(0);" data-id="{{$customer->id}}" data-toggle="modal" data-target="#huifangModal"  class="hf-btn text-red" >未回访</a>
                                    @endif
                                @else
                                    @if(Laratrust::can('read-huifangs')||Laratrust::hasRole('superadministrator|administrator'))
                                        <a href="javascript:void(0);" data-id="{{$customer->id}}" data-toggle="modal" data-target="#huifangModal" class="hf-btn text-blue">已回访</a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <a href="{{route('zxcustomers.show',$customer->id)}}"  alt="查看" title="查看"><i class="fa fa-eye"></i></a>
                                @if(Laratrust::can('update-zx_customers')||Laratrust::hasRole('superadministrator|administrator'))
                                    <a href="{{route('zxcustomers.edit',$customer->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                @endif
                                @if(Laratrust::can('delete-zx_customers')||Laratrust::hasRole('superadministrator|administrator'))
                                    <a href="javascript:void(0);"  alt="编辑" data-id="{{$customer->id}}" title="删除" class="delete-operation"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
        <!-- /.box-body -->
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/layer/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#zxcustomers-list-table').DataTable({
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "url": "/datables-language-zh-CN.json"
                }
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
        } );
    </script>
@endsection
