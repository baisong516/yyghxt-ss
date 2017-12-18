<div class="box-body">
    <div class="form-group {{empty($errors->first('platform_id'))?'':'has-error'}}">
        <label for="platform" class="col-sm-2 control-label">平台渠道</label>
        <div class="col-sm-8">
            <select name="platform_id" id="platform" class="form-control">
                <option value="">--选择平台--</option>
                @foreach($platforms as $platform)
                    <option value="{{$platform->id}}">{{$platform->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('area_id'))?'':'has-error'}}">
        <label for="area" class="col-sm-2 control-label">地域</label>
        <div class="col-sm-8">
            <select name="area_id" id="area" class="form-control">
                <option value="">--选择地域--</option>
                @foreach($areas as $area)
                    <option value="{{$area->id}}">{{$area->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('disease_id'))?'':'has-error'}}">
        <label for="disease" class="col-sm-2 control-label">病种</label>
        <div class="col-sm-8">
            <select name="disease_id" id="disease" class="form-control">
                @foreach($diseases as $g)
                    <optgroup label="{{$g['name']}}">
                    @foreach($g['diseases'] as $id=>$disease)
                        <option value="{{$id}}">{{$disease}}</option>
                    @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('budget'))?'':'has-error'}}">
        <label for="budget" class="col-sm-2 control-label">预算</label>
        <div class="col-sm-8">
            <input type="text" id="budget" name="budget" class="form-control" placeholder="{{empty($errors->first('budget'))?'预算':$errors->first('budget')}}" value="{{isset($auction)?$auction->budget:old('budget')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('cost'))?'':'has-error'}}">
        <label for="cost" class="col-sm-2 control-label">消费</label>
        <div class="col-sm-8">
            <input type="text" id="cost" name="cost" class="form-control" placeholder="{{empty($errors->first('cost'))?'消费':$errors->first('cost')}}" value="{{isset($auction)?$auction->cost:old('cost')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('click'))?'':'has-error'}}">
        <label for="click" class="col-sm-2 control-label">点击</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="click" name="click" class="form-control" placeholder="{{empty($errors->first('click'))?'点击':$errors->first('click')}}" value="{{isset($auction)?$auction->click:old('click')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('zixun'))?'':'has-error'}}">
        <label for="zixun" class="col-sm-2 control-label">咨询量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="zixun" name="zixun" class="form-control" placeholder="{{empty($errors->first('zixun'))?'咨询量':$errors->first('zixun')}}" value="{{isset($auction)?$auction->zixun:old('zixun')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('yuyue'))?'':'has-error'}}">
        <label for="yuyue" class="col-sm-2 control-label">预约量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="yuyue" name="yuyue" class="form-control" placeholder="{{empty($errors->first('yuyue'))?'预约量':$errors->first('yuyue')}}" value="{{isset($auction)?$auction->yuyue:old('yuyue')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('arrive'))?'':'has-error'}}">
        <label for="arrive" class="col-sm-2 control-label">总到院</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="arrive" name="arrive" class="form-control" placeholder="{{empty($errors->first('arrive'))?'总到院':$errors->first('arrive')}}" value="{{isset($auction)?$auction->arrive:old('arrive')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('date_tag'))?'':'has-error'}}">
        <label for="date_tag" class="col-sm-2 control-label">日期</label>
        <div class="col-sm-8">
            <input type="text"  id="date_tag" name="date_tag" class="form-control item-date" value="{{isset($auction)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$auction->date_tag)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
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