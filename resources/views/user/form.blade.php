<div class="box-body">
    <div class="form-group {{empty($errors->first('name'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label">登录ID</label>
        <div class="col-sm-8">
            <input type="text" id="name" name="name" class="form-control" {{isset($user)?'disabled':''}} placeholder="{{empty($errors->first('name'))?'英文或拼音 eg:slug':$errors->first('name')}}" value="{{isset($user)?$user->name:old('name')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('realname'))?'':'has-error'}}">
        <label for="realname" class="col-sm-2 control-label">姓名</label>
        <div class="col-sm-8">
            <input type="text" id="realname" name="realname" class="form-control" placeholder="{{empty($errors->first('realname'))?'姓名':$errors->first('realname')}}" value="{{isset($user)?$user->realname:old('realname')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('password'))?'':'has-error'}}">
        <label for="password" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-8">
            <input type="password" id="password" name="password" class="form-control" placeholder="{{empty($errors->first('password'))?'密码':$errors->first('password')}}" value="{{old('password')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('department_id'))?'':'has-error'}}">
        <label for="department" class="col-sm-2 control-label">部门</label>
        <div class="col-sm-8">
            <select name="department_id" id="department" class="form-control">
                <option value="" selected>--选择部门--</option>
                @foreach($departments as $department)
                    <option value="{{$department->id}}" {{old('department_id')==$department->id?'selected':''}} {{isset($user)&&$user->department_id==$department->id?'selected':''}}>{{$department->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('hospitals'))?'':'has-error'}}">
        <label for="hospital" class="col-sm-2 control-label">负责医院</label>
        <div class="col-sm-8">
            <select class="form-control" name="hospitals[]" id="hospital" multiple="multiple" style="width: 100%;">
                @foreach($hospitals as $hospital)
                <option value="{{$hospital->id}}" {{isset($user)&&$user->hasHospital($hospital->id)?'selected':''}}>{{$hospital->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('offices'))?'':'has-error'}}">
        <label for="office" class="col-sm-2 control-label">负责科室（项目）</label>
        <div class="col-sm-8">
            <select class="form-control" name="offices[]" id="office" multiple="multiple" style="width: 100%;">
                @isset($user)
                    @foreach($user->hospitals as $hospital)
                        <optgroup label="{{$hospital->display_name}}">
                            @foreach($hospital->offices as $office)
                                <option value="{{$office->id}}" {{$user->hasOffice($office->id)?'selected':''}}>{{$office->display_name}}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('roles'))?'':'has-error'}}">
        <label for="role" class="col-sm-2 control-label">角色</label>
        <div class="col-sm-8">
            <select class="form-control" name="roles[]" id="role" multiple="multiple" style="width: 100%;">
                @foreach($roles as $role)
                    <option value="{{$role->id}}" {{isset($user)&&$user->hasRole($role->name)?'selected':''}}>{{$role->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @isset($user)
        <div class="form-group {{empty($errors->first('is_active'))?'':'has-error'}}">
            <label for="is_active" class="col-sm-2 control-label">账户状态</label>
            <div class="col-sm-8">
                <label class="radio-inline">
                    <input type="radio" name="is_active" value="1" {{$user->is_active==1?'checked':''}}>正常
                </label>
                <label class="radio-inline">
                    <input type="radio" name="is_active" value="0" {{$user->is_active==0?'checked':''}}>禁用
                </label>
            </div>
        </div>
    @endisset

</div>
<div class="box-footer">
    <div class="form-group">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-info pull-right">提交</button>
        </div>
    </div>
</div>