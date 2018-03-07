<div class="box-body">
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span> 标识</label>
        <div class="col-sm-8">
            <input type="text" id="name" name="name" class="form-control" {{isset($cause)?'disabled':''}} placeholder="{{empty($errors->first('name'))?'英文或拼音 eg:slug':$errors->first('name')}}" value="{{isset($cause)?$cause->name:old('name')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('display_name'))?'':'has-error'}}">
        <label for="displayName" class="col-sm-2 control-label"><span class="text-red">*</span> 名称</label>
        <div class="col-sm-8">
            <input type="text" id="displayName" name="display_name" class="form-control" placeholder="{{empty($errors->first('display_name'))?'名称':$errors->first('display_name')}}" value="{{isset($cause)?$cause->display_name:old('display_name')}}">
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