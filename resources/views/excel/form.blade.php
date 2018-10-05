<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">开始时间</label>
        <div class="col-sm-10">
                <input type="text" class="form-control date-item" name="zxStart" id="zxStart">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">结束时间</label>
        <div class="col-sm-10">
            <input type="text" class="form-control date-item" name="zxEnd" id="zxEnd">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">科室</label>
        <div class="col-sm-10">
            <select class="form-control" name="offices[]" id="offices" multiple="multiple" style="width: 100%;">
                @foreach($offices as $k=>$v)
                    <option value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">状态</label>
        <div class="col-sm-10">
            <select class="form-control" name="customerConditions[]" id="customerCondition" multiple="multiple" style="width: 100%;">
                @foreach($status as $k=>$v)
                    <option value="{{$k}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @foreach($options as $o=>$option)
    <div class="form-group">
        <label class="col-sm-2 control-label">{{$option['name']}}</label>
        <div class="col-sm-10">
            @foreach($option['data'] as $k=>$v)
                <label class="checkbox-inline">
                    <input type="checkbox" name="{{$o}}[]" value="{{$k}}"> {{$v}}
                </label>
            @endforeach
        </div>
    </div>
    @endforeach
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <p class="text-warning"><span class="text-danger">说明：</span>开始与结束时间以咨询时间为基线，留空则无时间限制，将导出全部数据！</p>
        </div>
    </div>
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-10">
            <button type="button" class="btn btn-success pull-left" id="select-all">全选</button>
            <button type="button" class="btn btn-danger pull-left" id="unselect-all" style="margin-left: 1rem;">取消全选</button>
            <button type="submit" class="btn btn-info pull-right">导出</button>
        </div>
    </div>
</div>