<div class="box-body">
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
    <div class="form-group {{empty($errors->first('user_id'))?'':'has-error'}}">
        <label for="user" class="col-sm-2 control-label">竞价员</label>
        <div class="col-sm-8">
            <select name="user_id" id="user" class="form-control">
                <option value="">--选择竞价员--</option>
                @foreach($jjusers as $k=>$user)
                    <option value="{{$k}}">{{$user}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('rank'))?'':'has-error'}}">
        <label for="rank" class="col-sm-2 control-label">班次</label>
        <div class="col-sm-8">
            <select name="rank" id="rank" class="form-control">
                <option value="0">早班</option>
                <option value="1">晚班</option>
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('budget'))?'':'has-error'}}">
        <label for="budget" class="col-sm-2 control-label">预算</label>
        <div class="col-sm-8">
            <input type="text" id="budget" name="budget" class="form-control" value="{{isset($jjoutput)?$jjoutput->budget:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('cost'))?'':'has-error'}}">
        <label for="cost" class="col-sm-2 control-label">消费</label>
        <div class="col-sm-8">
            <input type="text" id="cost" name="cost" class="form-control" value="{{isset($jjoutput)?$jjoutput->cost:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('click'))?'':'has-error'}}">
        <label for="click" class="col-sm-2 control-label">点击</label>
        <div class="col-sm-8">
            <input type="text" id="click" name="click" class="form-control" value="{{isset($jjoutput)?$jjoutput->click:''}}">
        </div>
    </div>
    {{--电话--}}
    <div class="form-group {{empty($errors->first('zixun'))?'':'has-error'}}">
        <label for="zixun" class="col-sm-2 control-label">咨询量</label>
        <div class="col-sm-8">
            <input type="number" id="zixun" name="zixun" class="form-control" value="{{isset($jjoutput)?$jjoutput->zixun:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('yuyue'))?'':'has-error'}}">
        <label for="yuyue" class="col-sm-2 control-label">预约量</label>
        <div class="col-sm-8">
            <input type="number" id="yuyue" name="yuyue" class="form-control" value="{{isset($jjoutput)?$jjoutput->yuyue:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('arrive'))?'':'has-error'}}">
        <label for="arrive" class="col-sm-2 control-label">到院量</label>
        <div class="col-sm-8">
            <input type="number" id="arrive" name="arrive" class="form-control" value="{{isset($jjoutput)?$jjoutput->arrive:''}}">
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