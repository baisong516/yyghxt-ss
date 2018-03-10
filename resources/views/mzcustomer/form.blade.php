<div class="box-body">
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label">姓名</label>
        <div class="col-sm-10">
            <input type="text" name="name" disabled class="form-control" id="name" placeholder="{{empty($errors->first('name'))?'姓名':$errors->first('name')}}" value="{{isset($customer)?$customer->name:old('name')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('age'))?'':'has-error'}}">
        <label for="age" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-10">
            <input disabled type="number" name="age" class="form-control" id="age" placeholder="{{empty($errors->first('age'))?'年龄':$errors->first('age')}}" value="{{isset($customer)?$customer->age:old('age')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('sex'))?'':'has-error'}}">
        <label for="sex" class="col-sm-2 control-label">性别</label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input type="radio" name="sex"  disabled value="male" {{old('sex')=='male'?'checked':''}} {{isset($customer)&&$customer->sex=='male'?'checked':''}}>男
            </label>
            <label class="radio-inline">
                <input type="radio" name="sex" disabled value="female"  {{old('sex')=='female'?'checked':''}} {{isset($customer)&&$customer->sex=='female'?'checked':''}}>女
            </label>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('tel'))?'':'has-error'}}">
        <label for="tel" class="col-sm-2 control-label">电话</label>
        <div class="col-sm-10">
            <input type="text" name="tel" disabled maxlength="11" value="{{isset($customer)?$customer->tel:old('tel')}}" class="form-control" id="tel" placeholder="{{empty($errors->first('tel'))?'电话':$errors->first('tel')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('qq'))?'':'has-error'}}">
        <label for="qq" class="col-sm-2 control-label">QQ</label>
        <div class="col-sm-10">
            <input type="text" disabled name="qq" class="form-control" value="{{isset($customer)?$customer->qq:old('qq')}}" id="qq" placeholder="{{empty($errors->first('qq'))?'qq':$errors->first('qq')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('wechat'))?'':'has-error'}}">
        <label for="wechat" class="col-sm-2 control-label">微信</label>
        <div class="col-sm-10">
            <input type="text" disabled name="wechat" class="form-control" value="{{isset($customer)?$customer->wechat:old('wechat')}}" id="qq" placeholder="{{empty($errors->first('wechat'))?'微信':$errors->first('wechat')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}">
        <label for="office" class="col-sm-2 control-label">科室</label>
        <div class="col-sm-10">
            <select name="office_id" disabled id="office" class="form-control select2" style="width:100%;">
                <option value="" selected>--选择科室--</option>
                    @foreach($offices as $k=>$v)
                        <option value="{{$k}}" {{old('office_id')==$k?'selected':''}} {{isset($customer)&&$customer->office_id==$k?'selected':''}}>{{$v}}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('disease_id'))?'':'has-error'}}">
        <label for="disease" class="col-sm-2 control-label">病种</label>
        <div class="col-sm-10">
            <select name="disease_id" disabled id="disease" class="form-control select2" style="width:100%;">
                <option  selected value="">--选择--</option>
                @foreach($diseases as $o=>$d)
                    <optgroup label="{{$d['name']}}">
                        @if(isset($d['diseases'])&&!empty($d['diseases']))
                        @foreach($d['diseases'] as $k=>$v)
                        <option  value="{{$k}}" {{old('disease_id')==$k?'selected':''}} {{isset($customer)&&$customer->disease_id==$k?'selected':''}}>{{$v}}</option>
                        @endforeach
                        @endif
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="doctor" class="col-sm-2 control-label">预约医生</label>
        <div class="col-sm-10">
            <select name="doctor_id" id="doctor" disabled class="form-control select2" style="width:100%;">
                <option selected="selected" value="">--选择医生--</option>
                @foreach($doctors as $doctor)
                    <option value="{{$doctor->id}}" {{old('doctor_id')==$doctor->id?'selected':''}} {{isset($customer)&&$customer->doctor_id==$doctor->id?'selected':''}}>{{$doctor->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('zixun_at'))?'':'has-error'}}">
        <label for="zixuntime" class="col-sm-2 control-label">咨询时间</label>
        <div class="col-sm-10">
            <input type="text" disabled class="form-control item-date" name="zixun_at"  id="zixuntime" value="{{isset($customer)?$customer->zixun_at:old('zixun_at')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('yuyue_at'))?'':'has-error'}}">
        <label for="yuyuetime" class="col-sm-2 control-label">预约时间</label>
        <div class="col-sm-10">
            <input type="text" disabled class="form-control item-date" name="yuyue_at" id="yuyuetime" value="{{isset($customer)?$customer->yuyue_at:old('yuyue_at')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('arrive_at'))?'':'has-error'}}">
        <label for="arrivetime" class="col-sm-2 control-label">到院时间</label>
        <div class="col-sm-10">
            <input type="text" class="form-control item-date" name="arrive_at" id="arrivetime" value="{{isset($customer)&&!empty($customer->arrive_at)?$customer->arrive_at:\Carbon\Carbon::now()->toDateTimeString()}}">
        </div>
    </div>


    <div class="form-group {{empty($errors->first('customer_condition_id'))?'':'has-error'}}">
        <label for="customercondition" class="col-sm-2 control-label">状态</label>
        <div class="col-sm-10">
            <select name="customer_condition_id" id="customercondition" class="form-control">
                <option value="" selected>--选择患者状态--</option>
                @foreach($customerconditions as $k=>$v)
                    <option value="{{$k}}" {{isset($customer)&&$customer->customer_condition_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('addons'))?'':'has-error'}}">
        <label for="addons" class="col-sm-2 control-label">备注</label>
        <div class="col-sm-10">
            <textarea name="addons" disabled id="addons" class="form-control"  rows="5">{{isset($customer)?$customer->addons:old('addons')}}</textarea>
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