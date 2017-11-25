<div class="box-body">
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