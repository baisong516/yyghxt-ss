<div class="box-body">
    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}">
        <label for="office_id" class="col-sm-2 control-label">科室</label>
        <div class="col-sm-8">
            <select name="office_id" id="office_id" class="form-control">
                @isset($offices)
                    @foreach($offices as $k=>$v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('type'))?'':'has-error'}}">
        <label for="type" class="col-sm-2 control-label">类型</label>
        <div class="col-sm-8">
            <select name="type" id="type" class="form-control">
                <option value="">--选择类型--</option>
                <option value="platform">渠道平台</option>
                <option value="area">地域</option>
                <option value="disease">病种</option>
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('type_id'))?'':'has-error'}}">
        <label for="type_id" class="col-sm-2 control-label">类型值</label>
        <div class="col-sm-8">
            <select name="type_id" id="type_id" class="form-control"></select>
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