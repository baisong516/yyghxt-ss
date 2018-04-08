
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label">姓名</label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" id="name" placeholder="{{empty($errors->first('name'))?'姓名':$errors->first('name')}}" value="{{isset($customer)?$customer->name:old('name')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('age'))?'':'has-error'}}">
        <label for="age" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-10">
            <input type="number" name="age" class="form-control" id="age" placeholder="{{empty($errors->first('age'))?'年龄':$errors->first('age')}}" value="{{isset($customer)?$customer->age:old('age')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('sex'))?'':'has-error'}}">
        <label for="sex" class="col-sm-2 control-label">性别</label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input type="radio" name="sex"  value="male" {{old('sex')=='male'?'checked':''}} {{isset($customer)&&$customer->sex=='male'?'checked':''}}>男
            </label>
            <label class="radio-inline">
                <input type="radio" name="sex"  value="female"  {{old('sex')=='female'?'checked':''}} {{isset($customer)&&$customer->sex=='female'?'checked':''}}>女
            </label>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('tel'))?'':'has-error'}}">
        <label for="tel" class="col-sm-2 control-label">电话</label>
        <div class="col-sm-10">
            <input type="text" name="tel" maxlength="11" value="{{isset($customer)?$customer->tel:old('tel')}}" class="form-control" id="tel" placeholder="{{empty($errors->first('tel'))?'电话':$errors->first('tel')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('qq'))?'':'has-error'}}">
        <label for="qq" class="col-sm-2 control-label">QQ</label>
        <div class="col-sm-10">
            <input type="text" name="qq" class="form-control" value="{{isset($customer)?$customer->qq:old('qq')}}" id="qq" placeholder="{{empty($errors->first('qq'))?'qq':$errors->first('qq')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('wechat'))?'':'has-error'}}">
        <label for="wechat" class="col-sm-2 control-label">微信</label>
        <div class="col-sm-10">
            <input type="text" name="wechat" class="form-control" value="{{isset($customer)?$customer->wechat:old('wechat')}}" id="qq" placeholder="{{empty($errors->first('wechat'))?'微信':$errors->first('wechat')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('idcard'))?'':'has-error'}}">
        <label for="idcard" class="col-sm-2 control-label">身份id</label>
        <div class="col-sm-10">
            <input type="text" name="idcard" class="form-control" id="idcard" value="{{isset($customer)?$customer->idcard:old('idcard')}}" placeholder="{{empty($errors->first('idcard'))?'商务通身份id':$errors->first('idcard')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('keywords'))?'':'has-error'}}">
        <label for="keywords" class="col-sm-2 control-label">搜索关键词</label>
        <div class="col-sm-10">
            <input type="text" name="keywords" class="form-control" id="keywords" value="{{isset($customer)?$customer->keywords:old('keywords')}}" placeholder="{{empty($errors->first('keywords'))?'搜索关键词':$errors->first('keywords')}}">
        </div>
    </div>
    @ability('superadministrator', 'change-user')
    <div class="form-group {{empty($errors->first('user_id'))?'':'has-error'}}">
        <label for="user" class="col-sm-2 control-label">咨询员</label>
        <div class="col-sm-10">
            <select name="user_id" id="zx-user" class="form-control">
                <option value="" selected>--选择(默认本人)--</option>
                @foreach($activeZxUsers as $k=>$v)
                    <option value="{{$k}}" {{old('user_id')==$k?'selected':''}} {{isset($customer)&&$customer->user_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endability
    <div class="form-group {{empty($errors->first('description'))?'':'has-error'}}">
        <label for="description" class="col-sm-2 control-label">咨询内容</label>
        <div class="col-sm-10">
            <textarea name="description" id="description" class="form-control"  rows="3" placeholder="咨询聊天内容（可直接从商务通复制）">{{isset($customer)?$customer->description:old('description')}}</textarea>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}">
        <label for="office" class="col-sm-2 control-label">科室</label>
        <div class="col-sm-10">
            <select name="office_id" id="office" class="form-control select2" style="width:100%;">
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
            <select name="disease_id" id="disease" class="form-control select2" style="width:100%;">
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
            <select name="doctor_id" id="doctor" class="form-control select2" style="width:100%;">
                <option selected="selected" value="">--选择医生--</option>
                @foreach($doctors as $o=>$d)
                    <optgroup label="{{$offices[$o]}}">
                        @if(!empty($d))
                            @foreach($d as $k=>$v)
                                <option  value="{{$k}}" {{old('doctor_id')==$k?'selected':''}} {{isset($customer)&&$customer->doctor_id==$k?'selected':''}}>{{$v}}</option>
                            @endforeach
                        @endif
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('city'))?'':'has-error'}}">
        <label for="city" class="col-sm-2 control-label">城市</label>
        <div class="col-sm-10">
            <input type="text" name="city" class="form-control" value="{{isset($customer)?$customer->city:old('city')}}" id="city" placeholder="{{empty($errors->first('city'))?'城市':$errors->first('city')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('media_id'))?'':'has-error'}}">
        <label for="media" class="col-sm-2 control-label">媒体来源</label>
        <div class="col-sm-10">
            <select name="media_id" id="media" class="form-control">
                <option value=""  selected>--选择媒体--</option>
                @foreach($medias as $k=>$v)
                    <option value="{{$k}}" {{old('media_id')==$k?'selected':''}} {{isset($customer)&&$customer->media_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('media'))?'':'has-error'}}">
        <label for="webtype" class="col-sm-2 control-label">网站类型</label>
        <div class="col-sm-10">
            <select name="webtype_id" id="webtype" class="form-control">
                <option selected value="">--选择网站类型--</option>
                @foreach($webtypes as $k=>$v)
                    <option value="{{$k}}" {{old('webtype_id')==$k?'selected':''}} {{isset($customer)&&$customer->webtype_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('jingjia_user_id'))?'':'has-error'}}">
        <label for="trans-user" class="col-sm-2 control-label">当班竞价员</label>
        <div class="col-sm-10">
            <select name="jingjia_user_id" id="jingjia-user" class="form-control">
                <option value="" selected>--选择--</option>
                @foreach($activeJingjiaUsers as $k=>$v)
                    <option value="{{$k}}" {{old('jingjia_user_id')==$k?'selected':''}} {{isset($customer)&&$customer->jingjia_user_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('cause_id'))?'':'has-error'}}">
        <label for="trans-user" class="col-sm-2 control-label">未预约原因</label>
        <div class="col-sm-10">
            <select name="cause_id" id="cause_id" class="form-control">
                <option value="" selected>--选择--</option>
                @foreach($causes as $k=>$v)
                    <option value="{{$k}}" {{old('cause_id')==$k?'selected':''}} {{isset($customer)&&$customer->cause_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('zixun_at'))?'':'has-error'}}">
        <label for="zixuntime" class="col-sm-2 control-label">咨询时间</label>
        <div class="col-sm-10">
            <input type="text" class="form-control item-date" name="zixun_at"  id="zixuntime" value="{{isset($customer)?$customer->zixun_at:\Carbon\Carbon::now()->toDateTimeString()}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('yuyue_at'))?'':'has-error'}}">
        <label for="yuyuetime" class="col-sm-2 control-label">预约时间</label>
        <div class="col-sm-10">
            <input type="text" class="form-control item-date" name="yuyue_at" id="yuyuetime" value="{{isset($customer)?$customer->yuyue_at:old('yuyue_at')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('time_slot'))?'':'has-error'}}">
        <label for="time_slot" class="col-sm-2 control-label">时段</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" maxlength="191" name="time_slot" id="time_slot" value="{{isset($customer)?$customer->time_slot:old('time_slot')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('arrive_at'))?'':'has-error'}}">
        <label for="arrivetime" class="col-sm-2 control-label">到院时间</label>
        <div class="col-sm-10">
            <input type="text" class="form-control item-date" name="arrive_at" id="arrivetime" value="{{isset($customer)?$customer->arrive_at:old('arrive_at')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('customer_type_id'))?'':'has-error'}}">
        <label for="customertype" class="col-sm-2 control-label">患者类型</label>
        <div class="col-sm-10">
            <select name="customer_type_id" id="customertype" class="form-control">
                <option value="" selected>--选择患者类型--</option>
                @foreach($customertypes as $k=>$v)
                    <option value="{{$k}}" {{old('customer_type_id')==$k?'selected':''}} {{isset($customer)&&$customer->customer_type_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('customer_condition_id'))?'':'has-error'}}">
        <label for="customercondition" class="col-sm-2 control-label">状态</label>
        <div class="col-sm-10">
            <select name="customer_condition_id" id="customercondition" class="form-control">
                <option value="" selected>--选择患者状态--</option>
                @foreach($customerconditions as $k=>$v)
                    <option value="{{$k}}" {{old('customer_condition_id')==$k?'selected':''}} {{isset($customer)&&$customer->customer_condition_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('addons'))?'':'has-error'}}">
        <label for="addons" class="col-sm-2 control-label">备注</label>
        <div class="col-sm-10">
            <textarea name="addons" id="addons" class="form-control"  rows="5">{{isset($customer)?$customer->addons:old('addons')}}</textarea>
        </div>
    </div>


