
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="name">姓名：</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="{{empty($errors->first('name'))?'姓名':$errors->first('name')}}" value="{{isset($customer)?$customer->name:old('name')}}">
    </div>
    <div class="form-group {{empty($errors->first('age'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="age" class="control-label">年龄：</label>
        <input type="number" name="age" class="form-control" id="age" placeholder="{{empty($errors->first('age'))?'年龄':$errors->first('age')}}" value="{{isset($customer)?$customer->age:old('age')}}">
    </div>

    <div class="form-group {{empty($errors->first('sex'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="sex" class="control-label">性别：</label>
        <label class="radio-inline">
            <input type="radio" name="sex"  value="male" {{old('sex')=='male'?'checked':''}} {{isset($customer)&&$customer->sex=='male'?'checked':''}}>男
        </label>
        <label class="radio-inline">
            <input type="radio" name="sex"  value="female"  {{old('sex')=='female'?'checked':''}} {{isset($customer)&&$customer->sex=='female'?'checked':''}}>女
        </label>
    </div>
    <div></div>
    <div class="form-group {{empty($errors->first('tel'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="tel" class="control-label">电话：</label>
        {{--<input type="text" name="tel" maxlength="11" value="{{isset($customer)?($enableViewPhone||$customer->user_id==$userid?$customer->tel:\App\Aiden::phoneHide($customer->tel)):old('tel')}}" class="form-control" id="tel" placeholder="{{empty($errors->first('tel'))?'电话':$errors->first('tel')}}">--}}
        <input type="text" name="tel" maxlength="11" value="@if(isset($customer))
            @if(in_array($customer->customer_condition_id,[1,2,5]))
                @if($isAdmin){{$enableViewPhone||$customer->user_id==$userid?$customer->tel:\App\Aiden::phoneHide($customer->tel)}}
                @else{{\App\Aiden::phoneHide($customer->tel)}}
                @endif
            @else{{$enableViewPhone||$customer->user_id==$userid?$customer->tel:\App\Aiden::phoneHide($customer->tel)}}
            @endif
        @else{{old('tel')}}
        @endif"
       class="form-control" id="tel" placeholder="{{empty($errors->first('tel'))?'电话':$errors->first('tel')}}"
        @if(isset($customer))
            @if(!$isAdmin)
                @if(in_array($customer->customer_condition_id,[1,2,5])||$customer->user_id!=$userid)
                    disabled
                @endif
            @endif
        @endif
        >
    </div>

    <div class="form-group {{empty($errors->first('qq'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="qq" class="control-label">QQ：</label>
        <input type="text" name="qq" class="form-control" value="{{isset($customer)?$customer->qq:old('qq')}}" id="qq" placeholder="{{empty($errors->first('qq'))?'qq':$errors->first('qq')}}">
    </div>

    <div class="form-group {{empty($errors->first('wechat'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="wechat" class="control-label">微信：</label>
        {{--<input type="text" name="wechat" class="form-control" value="{{isset($customer)?($enableViewWechat||$customer->user_id==$userid?$customer->wechat:\App\Aiden::wechatHide($customer->wechat)):old('wechat')}}" id="qq" placeholder="{{empty($errors->first('wechat'))?'微信':$errors->first('wechat')}}">--}}
        <input type="text" name="wechat" class="form-control" value="@if(isset($customer))
            @if(in_array($customer->customer_condition_id,[1,2,5]))
                @if($isAdmin){{$enableViewWechat||$customer->user_id==$userid?$customer->wechat:\App\Aiden::wechatHide($customer->wechat)}}
                @else{{\App\Aiden::wechatHide($customer->wechat)}}
                @endif
            @else{{$enableViewWechat||$customer->user_id==$userid?$customer->wechat:\App\Aiden::wechatHide($customer->wechat)}}
            @endif
        @else
            {{old('wechat')}}
        @endif" id="qq" placeholder="{{empty($errors->first('wechat'))?'微信':$errors->first('wechat')}}"
        @if(isset($customer))
             @if(!$isAdmin)
                @if(in_array($customer->customer_condition_id,[1,2,5])||$customer->user_id!=$userid)
                    disabled
                @endif
             @endif
        @endif
        >
    </div>
    <div></div>
    <div class="form-group {{empty($errors->first('idcard'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="idcard" class="control-label">身份id：</label>
        <input type="text" name="idcard" class="form-control" id="idcard" value="{{isset($customer)?$customer->idcard:old('idcard')}}" placeholder="{{empty($errors->first('idcard'))?'商务通身份id':$errors->first('idcard')}}">
    </div>

    @ability('superadministrator', 'change-user')
    <div class="form-group {{empty($errors->first('user_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="user" class="control-label">咨询员：</label>
        <select name="user_id" id="zx-user" class="form-control">
            <option value="">--选择(默认本人)--</option>
            @foreach($activeZxUsers as $k=>$v)
                <option value="{{$k}}" {{old('user_id')==$k?'selected':''}} {{isset($customer)&&$customer->user_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>
    @endability
    <div></div>

    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="office" class="control-label">科室：</label>
        <select name="office_id" id="office" class="form-control select2" style="">
            <option value="">--选择科室--</option>
                @foreach($offices as $k=>$v)
                    <option value="{{$k}}" {{old('office_id')==$k?'selected':''}} {{isset($customer)&&$customer->office_id==$k?'selected':''}}>{{$v}}</option>
                @endforeach
        </select>
    </div>

    <div class="form-group {{empty($errors->first('disease_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="disease" class="control-label">病种：</label>
        <select name="disease_id" id="disease" class="form-control select2" style="">
            <option value="">--选择--</option>
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

    <div class="form-group" style="margin-left: 20px;">
        <label for="doctor" class="control-label">预约医生：</label>
        <select name="doctor_id" id="doctor" class="form-control select2">
            <option value="">--选择医生--</option>
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
    <div></div>
    <div class="form-group {{empty($errors->first('city'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="city" class="control-label">城市：</label>
        <input type="text" name="city" class="form-control" value="{{isset($customer)?$customer->city:old('city')}}" id="city" placeholder="{{empty($errors->first('city'))?'城市':$errors->first('city')}}">
    </div>

    <div class="form-group {{empty($errors->first('media_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="media" class="control-label">媒体来源：</label>
        <select name="media_id" id="media" class="form-control">
            <option value="" >--选择媒体--</option>
            @foreach($medias as $k=>$v)
                <option value="{{$k}}" {{old('media_id')==$k?'selected':''}} {{isset($customer)&&$customer->media_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group {{empty($errors->first('media'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="webtype" class="control-label">网站类型：</label>
        <select name="webtype_id" id="webtype" class="form-control">
            <option value="">--选择网站类型--</option>
            @foreach($webtypes as $k=>$v)
                <option value="{{$k}}" {{old('webtype_id')==$k?'selected':''}} {{isset($customer)&&$customer->webtype_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group {{empty($errors->first('jingjia_user_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="trans-user" class="control-label">当班竞价员：</label>
        <select name="jingjia_user_id" id="jingjia-user" class="form-control">
            <option value="">--选择--</option>
            @foreach($activeJingjiaUsers as $k=>$v)
                <option value="{{$k}}" {{old('jingjia_user_id')==$k?'selected':''}} {{isset($customer)&&$customer->jingjia_user_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div></div>
    <div class="form-group {{empty($errors->first('cause_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="trans-user" class="control-label">未预约原因：</label>
        <select name="cause_id" id="cause_id" class="form-control">
            <option value="">--选择--</option>
            @foreach($causes as $k=>$v)
                <option value="{{$k}}" {{old('cause_id')==$k?'selected':''}} {{isset($customer)&&$customer->cause_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group {{empty($errors->first('zixun_at'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="zixuntime" class="control-label">咨询时间：</label>
        <input type="text" class="form-control item-date" name="zixun_at"  id="zixuntime" value="{{isset($customer)?$customer->zixun_at:\Carbon\Carbon::now()->toDateTimeString()}}">
    </div>

    <div class="form-group {{empty($errors->first('yuyue_at'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="yuyuetime" class="control-label">预约时间：</label>
        <input type="text" class="form-control item-date" name="yuyue_at" id="yuyuetime" value="{{isset($customer)?$customer->yuyue_at:old('yuyue_at')}}">
    </div>
    <div class="form-group {{empty($errors->first('time_slot'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="time_slot" class="control-label">时段：</label>
        <input type="text" class="form-control" maxlength="191" name="time_slot" id="time_slot" value="{{isset($customer)?$customer->time_slot:old('time_slot')}}">
    </div>
    <div></div>
    <div class="form-group {{empty($errors->first('arrive_at'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="arrivetime" class="control-label">到院时间：</label>
        <input type="text" class="form-control item-date" name="arrive_at" id="arrivetime" value="{{isset($customer)?$customer->arrive_at:old('arrive_at')}}">
    </div>

    <div class="form-group {{empty($errors->first('customer_type_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="customertype" class="control-label">患者类型：</label>
        <select name="customer_type_id" id="customertype" class="form-control"style="margin-left: 20px;">
            <option value="">--选择患者类型--</option>
            @foreach($customertypes as $k=>$v)
                <option value="{{$k}}" {{old('customer_type_id')==$k?'selected':''}} {{isset($customer)&&$customer->customer_type_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group {{empty($errors->first('customer_condition_id'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="customercondition" class="control-label">状态：</label>
        <select name="customer_condition_id" id="customercondition" class="form-control">
            <option value="">--选择患者状态--</option>
            @foreach($customerconditions as $k=>$v)
                <option value="{{$k}}" {{old('customer_condition_id')==$k?'selected':''}} {{isset($customer)&&$customer->customer_condition_id==$k?'selected':''}}>{{$v}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group {{empty($errors->first('fuzhen'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="fuzhen" class="control-label">状态：</label>
        <select name="fuzhen" id="fuzhen" class="form-control">
            <option value="0" {{old('fuzhen')==0?'selected':''}} {{isset($customer)&&$customer->fuzhen==0?'selected':''}}>初诊</option>
            <option value="1" {{old('fuzhen')==1?'selected':''}} {{isset($customer)&&$customer->fuzhen==1?'selected':''}}>复诊</option>
        </select>
    </div>
    <div class="row {{empty($errors->first('keywords'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="keywords" class="col-sm-1 control-label" style="margin-top: 20px;">搜索关键词：</label>
        <div class="col-sm-11">
            <input style="width: 100%;" type="text" name="keywords" class="form-control" id="keywords" value="{{isset($customer)?$customer->keywords:old('keywords')}}" placeholder="{{empty($errors->first('keywords'))?'搜索关键词':$errors->first('keywords')}}">
        </div>
    </div>
    <div class="row {{empty($errors->first('addons'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="addons" class="col-sm-1 control-label" style="margin-top: 10px;">备注：</label>
        <div class="col-sm-11">
            <textarea name="addons" id="addons" class="form-control"  rows="1" style="width: 100%;">{{isset($customer)?$customer->addons:old('addons')}}</textarea>
        </div>
    </div>
    <hr>
    <div class="row {{empty($errors->first('description'))?'':'has-error'}}" style="margin-left: 20px;">
        <label for="description" class="col-sm-1 control-label">咨询内容</label>
        <div class="col-sm-11">
            <textarea name="description" id="description" class="form-control"  rows="3" placeholder="咨询聊天内容（可直接从商务通复制）" style="width: 100%;">{{isset($customer)?$customer->description:old('description')}}</textarea>
        </div>
    </div>
    <hr>


