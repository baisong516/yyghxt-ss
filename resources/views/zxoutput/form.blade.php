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
        <label for="user" class="col-sm-2 control-label">咨询员</label>
        <div class="col-sm-8">
            <select name="user_id" id="user" class="form-control">
                <option value="">--选择咨询员--</option>
                @foreach($zxusers as $k=>$user)
                    <option value="{{$k}}">{{$user}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('swt_zixun_count'))?'':'has-error'}}">
        <label for="swt_zixun_count" class="col-sm-2 control-label">(商务通)咨询量</label>
        <div class="col-sm-8">
            <input type="number" id="swt_zixun_count" name="swt_zixun_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->swt_zixun_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('swt_yuyue_count'))?'':'has-error'}}">
        <label for="swt_yuyue_count" class="col-sm-2 control-label">(商务通)预约量</label>
        <div class="col-sm-8">
            <input type="number" id="swt_yuyue_count" name="swt_yuyue_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->swt_yuyue_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('swt_contact_count'))?'':'has-error'}}">
        <label for="swt_contact_count" class="col-sm-2 control-label">(商务通)留联系</label>
        <div class="col-sm-8">
            <input type="number" id="swt_contact_count" name="swt_contact_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->swt_contact_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('swt_arrive_count'))?'':'has-error'}}">
        <label for="swt_arrive_count" class="col-sm-2 control-label">(商务通)到院量</label>
        <div class="col-sm-8">
            <input type="number" id="swt_arrive_count" name="swt_arrive_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->swt_arrive_count:''}}">
        </div>
    </div>
    {{--电话--}}
    <div class="form-group {{empty($errors->first('tel_zixun_count'))?'':'has-error'}}">
        <label for="tel_zixun_count" class="col-sm-2 control-label">(电话)电话量</label>
        <div class="col-sm-8">
            <input type="number" id="tel_zixun_count" name="tel_zixun_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->tel_zixun_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('tel_yuyue_count'))?'':'has-error'}}">
        <label for="tel_yuyue_count" class="col-sm-2 control-label">(电话)预约量</label>
        <div class="col-sm-8">
            <input type="number" id="tel_yuyue_count" name="tel_yuyue_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->tel_yuyue_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('tel_arrive_count'))?'':'has-error'}}">
        <label for="tel_arrive_count" class="col-sm-2 control-label">(电话)到院量</label>
        <div class="col-sm-8">
            <input type="number" id="swt_arrive_count" name="tel_arrive_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->tel_arrive_count:''}}">
        </div>
    </div>
    {{--回访--}}
    <div class="form-group {{empty($errors->first('hf_zixun_count'))?'':'has-error'}}">
        <label for="hf_zixun_count" class="col-sm-2 control-label">(回访)回访量</label>
        <div class="col-sm-8">
            <input type="number" id="hf_zixun_count" name="hf_zixun_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->hf_zixun_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('hf_yuyue_count'))?'':'has-error'}}">
        <label for="hf_yuyue_count" class="col-sm-2 control-label">(回访)预约量</label>
        <div class="col-sm-8">
            <input type="number" id="hf_yuyue_count" name="hf_yuyue_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->hf_yuyue_count:''}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('hf_arrive_count'))?'':'has-error'}}">
        <label for="hf_arrive_count" class="col-sm-2 control-label">(回访)到院量</label>
        <div class="col-sm-8">
            <input type="number" id="hf_arrive_count" name="hf_arrive_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->hf_arrive_count:''}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('total_jiuzhen_count'))?'':'has-error'}}">
        <label for="total_jiuzhen_count" class="col-sm-2 control-label">就诊量</label>
        <div class="col-sm-8">
            <input type="number" id="total_jiuzhen_count" name="total_jiuzhen_count" class="form-control" value="{{isset($zxoutput)?$zxoutput->total_jiuzhen_count:''}}">
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