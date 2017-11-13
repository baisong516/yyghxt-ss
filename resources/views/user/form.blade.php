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
            <input type="text" id="password" name="password" class="form-control" placeholder="{{empty($errors->first('password'))?'密码':$errors->first('password')}}" value="{{old('password')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('department_id'))?'':'has-error'}}">
        <label for="department" class="col-sm-2 control-label">部门</label>
        <div class="col-sm-8">
            <select name="department_id" id="department" class="form-control">
                <option value="" selected>--选择部门--</option>
                @foreach(App\Department::all() as $department)
                    <option value="{{$department->id}}" {{old('department_id')==$department->id?'selected':''}} {{isset($user)&&$user->department_id==$department->id?'selected':''}}>{{$department->display_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('hospitals'))?'':'has-error'}}">
        <label for="hospitals" class="col-sm-2 control-label">负责医院</label>
        <div class="col-sm-8">
            <select class="form-control" name="hospitals[]" id="hospitals" multiple="multiple" style="width: 100%;">
                <option value="AL">Alabama</option>
                <option value="WY">Wyoming</option>
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('offices'))?'':'has-error'}}">
        <label for="offices" class="col-sm-2 control-label">负责科室（项目）</label>
        <div class="col-sm-8" id="offices">
            @foreach(App\Hospital::all() as $hospital)
                <label class="checkbox-inline">
                    <input type="checkbox" name="hospitals[]" value="{{$hospital->id}}" {{isset($user)&&$user->hasHospital($hospital->id)?'checked':''}}> {{$hospital->display_name}}
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