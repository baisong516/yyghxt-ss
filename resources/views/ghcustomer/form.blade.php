<div class="box-body">
    <div class="form-group {{empty($errors->first('gh_name'))?'':'has-error'}}">
        <label for="gh_name" class="col-sm-2 control-label">姓名</label>
        <div class="col-sm-10">
            <input type="text" name="gh_name" class="form-control" id="gh_name" disabled value="{{isset($customer)?$customer->gh_name:old('gh_name')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_age'))?'':'has-error'}}">
        <label for="gh_age" class="col-sm-2 control-label">年龄</label>
        <div class="col-sm-10">
            <input type="number" name="gh_age" class="form-control" id="gh_age" disabled placeholder="{{empty($errors->first('gh_age'))?'年龄':$errors->first('gh_age')}}" value="{{isset($customer)?$customer->gh_age:old('gh_age')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_sex'))?'':'has-error'}}">
        <label for="gh_sex" class="col-sm-2 control-label">性别</label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input type="radio" name="gh_sex" disabled  value="male" {{old('gh_sex')=='male'?'checked':''}} {{isset($customer)&&$customer->gh_sex=='male'?'checked':''}}>男
            </label>
            <label class="radio-inline">
                <input type="radio" name="gh_sex" disabled  value="female"  {{old('gh_sex')=='female'?'checked':''}} {{isset($customer)&&$customer->gh_sex=='female'?'checked':''}}>女
            </label>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_tel'))?'':'has-error'}}">
        <label for="gh_tel" class="col-sm-2 control-label">电话</label>
        <div class="col-sm-10">
            <input type="text" name="gh_tel" disabled maxlength="11" value="{{isset($customer)?$customer->gh_tel:old('gh_tel')}}" class="form-control" id="gh_tel" placeholder="{{empty($errors->first('gh_tel'))?'电话':$errors->first('gh_tel')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_description'))?'':'has-error'}}">
        <label for="gh_description" class="col-sm-2 control-label">病情描述</label>
        <div class="col-sm-10">
            <textarea name="gh_description" disabled id="gh_description" class="form-control"  rows="3" placeholder="">{{isset($customer)?$customer->gh_description:old('gh_description')}}</textarea>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_office'))?'':'has-error'}}">
        <label for="gh_office" class="col-sm-2 control-label">科室</label>
        <div class="col-sm-10">
            <select name="gh_office" id="gh_office" disabled class="form-control select2" style="width:100%;">
                <option value="" selected>--选择科室--</option>
                    @foreach($offices as $k=>$v)
                        <option value="{{$k}}" {{old('gh_office')==$k?'selected':''}} {{isset($customer)&&$customer->gh_office==$k?'selected':''}}>{{$v}}</option>
                    @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_disease'))?'':'has-error'}}">
        <label for="gh_disease" class="col-sm-2 control-label">病种</label>
        <div class="col-sm-10">
            <select name="gh_disease" disabled id="gh_disease" class="form-control select2" style="width:100%;">
                <option  selected value="">--选择--</option>
                @foreach($diseases as $o=>$d)
                    <optgroup label="{{$d['name']}}">
                        @foreach($d['diseases'] as $k=>$v)
                            <option  value="{{$k}}" {{old('gh_disease')==$k?'selected':''}} {{isset($customer)&&$customer->gh_disease==$k?'selected':''}}>{{$v}}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{empty($errors->first('gh_date'))?'':'has-error'}}">
        <label for="gh_date" class="col-sm-2 control-label">预约时间</label>
        <div class="col-sm-10">
            <input type="text" disabled class="form-control item-date" name="gh_date" id="gh_date" value="{{isset($customer)?$customer->gh_date:old('gh_date')}}">
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
</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-info pull-right">提交</button>
        </div>
    </div>
</div>