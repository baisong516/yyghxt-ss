<div class="box-body">

    <div class="form-group {{empty($errors->first('change_date'))?'':'has-error'}}">
        <label for="change_date" class="col-sm-2 control-label">时间</label>
        <div class="col-sm-8">
            <input type="text" id="change_date" name="change_date" class="form-control item-date" value="{{isset($special)?$special->change_date:\Carbon\Carbon::now()->toDateString()}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}">
        <label for="office_id" class="col-sm-2 control-label">(科室)项目</label>
        <div class="col-sm-8">
            <select name="office_id" id="office" class="form-control">
                <option value="">--选择科室--</option>
                @foreach($offices as $k=>$office)
                    <option value="{{$k}}">{{$office}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label">页面名称</label>
        <div class="col-sm-8">
            <input type="text" id="name" name="name" class="form-control" value="{{isset($special)?$special->name:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('url'))?'':'has-error'}}">
        <label for="url" class="col-sm-2 control-label">页面路径</label>
        <div class="col-sm-8">
            <input type="text" id="url" name="url" class="form-control" value="{{isset($special)?$special->url:''}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('disease_id'))?'':'has-error'}}">
        <label for="disease" class="col-sm-2 control-label">病种</label>
        <div class="col-sm-8">
            <select name="disease_id" id="disease" multiple="multiple" class="form-control" style="width: 100%;"></select>
        </div>
    </div>



</div>

<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-info pull-right">提交</button>
        </div>
    </div>
</div>