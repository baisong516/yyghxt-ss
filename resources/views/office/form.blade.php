<div class="box-body">
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span> 标识</label>
        <div class="col-sm-8">
            <input type="text" id="name" name="name" class="form-control" {{isset($office)?'disabled':''}} placeholder="{{empty($errors->first('name'))?'英文或拼音 eg:slug':$errors->first('name')}}" value="{{isset($office)?$office->name:old('name')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('display_name'))?'':'has-error'}}">
        <label for="displayName" class="col-sm-2 control-label"><span class="text-red">*</span> 名称</label>
        <div class="col-sm-8">
            <input type="text" id="displayName" name="display_name" class="form-control" placeholder="{{empty($errors->first('display_name'))?'名称':$errors->first('display_name')}}" value="{{isset($office)?$office->display_name:old('display_name')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('hospital_id'))?'':'has-error'}}">
        <label for="hospital" class="col-sm-2 control-label"><span class="text-red">*</span> 医院</label>
        <div class="col-sm-8">
            <select name="hospital_id" id="hospital" class="form-control">
                <option value="">--选择医院--</option>
                @foreach($hospitals as $hospital)
                    <option value="{{$hospital->id}}" {{old('hospital_id')==$hospital->id?'selected':''}} {{isset($office)&&$office->hospital_id==$hospital->id?'selected':''}}>{{$hospital->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('description'))?'':'has-error'}}">
        <label for="description" class="col-sm-2 control-label">描述</label>
        <div class="col-sm-8">
            <textarea id="description" name="description" class="form-control" rows="3">{{isset($department)?$department->description:old('description')}}</textarea>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('tel'))?'':'has-error'}}">
        <label for="tel" class="col-sm-2 control-label">电话</label>
        <div class="col-sm-8">
            <input type="text" id="tel" name="tel" class="form-control" placeholder="{{empty($errors->first('tel'))?'电话':$errors->first('tel')}}" value="{{isset($office)?$office->tel:old('tel')}}">
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