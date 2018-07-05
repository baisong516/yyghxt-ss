<div class="box-body">
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label">标识</label>
        <div class="col-sm-8">
            <input type="text" id="name" name="name" class="form-control" {{isset($role)?'disabled':''}} placeholder="{{empty($errors->first('name'))?'英文或拼音 eg:slug':$errors->first('name')}}" value="{{isset($role)?$role->name:old('name')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('display_name'))?'':'has-error'}}">
        <label for="displayName" class="col-sm-2 control-label">名称</label>
        <div class="col-sm-8">
            <input type="text" id="displayName" name="display_name" class="form-control" placeholder="{{empty($errors->first('display_name'))?'名称':$errors->first('display_name')}}" value="{{isset($role)?$role->display_name:old('display_name')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('description'))?'':'has-error'}}">
        <label for="description" class="col-sm-2 control-label">描述</label>
        <div class="col-sm-8">
            <textarea id="description" name="description" class="form-control" rows="3">{{isset($role)?$role->description:old('description')}}</textarea>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('permission'))?'':'has-error'}}">
        <label for="roles" class="col-sm-2 control-label">权限</label>
        <div class="col-sm-8">
            @foreach($permissions as $permission)
            <label class="checkbox-inline">
                <input type="checkbox" name="permissions[]" value="{{$permission->id}}" {{isset($role)&&$role->hasPermission($permission->name)?'checked':''}}> {{$permission->display_name}}
            </label>
            @endforeach
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