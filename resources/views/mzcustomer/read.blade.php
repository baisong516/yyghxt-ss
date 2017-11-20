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
            <form class="form-inline" action="{{route('mzcustomers.search')}}"  id="search-form" name="search-form" method="POST">
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
                    <label for="searchOfficeId">科室：</label>
                    <select name="searchOfficeId" id="searchOfficeId" class="form-control">
                        <option value="">--科室--</option>
                        @foreach(Auth::user()->offices as $office)
                            <option value="{{$office->id}}">{{$office->display_name}}</option>
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
            </div>
        </div>
        <div class="box-body">
            <form action="" method="post" class="zxcustomers-form">
                {{method_field('DELETE')}}
                {{csrf_field()}}
                <table id="mzcustomers-list-table" class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th><i class="fa fa-level-down" aria-hidden="true"></i></th>
                        <th>患者</th>
                        <th>年龄</th>
                        <th>性别</th>
                        <th>联系</th>
                        <th>微信</th>
                        <th>QQ</th>
                        <th>科室</th>
                        <th>病种</th>
                        <th>状态</th>
                        <th>咨询</th>
                        <th>预约</th>
                        <th>到院</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($customers))
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
                            {{--科室--}}
                            <td>{{$customer->office_id?$offices[$customer->office_id]:''}}</td>
                            {{--病种--}}
                            <td>{{$customer->disease_id?$diseases[$customer->disease_id]:''}}</td>
                            {{--状态--}}
                            <td>{{$customer->customer_condition_id?$customerconditions[$customer->customer_condition_id]:''}}</td>
                            <td>{{$customer->zixun_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->zixun_at)->toDateString():''}}</td>
                            <td>{{$customer->yuyue_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->yuyue_at)->toDateString():''}}</td>
                            <td>{{$customer->arrive_at?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$customer->arrive_at)->toDateString():''}}</td>
                            <td>
                                @if($enableRead)
                                <a href="{{route('menzhens.show',$customer->id)}}"  alt="查看" title="查看"><i class="fa fa-eye"></i></a>
                                @endif
                                @if($enableUpdate)
                                    <a href="{{route('menzhens.edit',$customer->id)}}"  alt="编辑" title="编辑"><i class="fa fa-edit"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @endif
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
    <script type="text/javascript" src="http://yygh.oss-cn-shenzhen.aliyuncs.com/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mzcustomers-list-table').DataTable({
                "order": [[ 0, "desc" ]],
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
                "language": {
                    "url": "/datables-language-zh-CN.json"
                }
            });
            lay('.date-item').each(function(){
                laydate.render({
                    elem: this
                    ,trigger: 'click'
                });
            });
        } );
    </script>
@endsection
