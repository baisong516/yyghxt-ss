<div class="box-body">
    <div class="form-group {{empty($errors->first('realname'))?'':'has-error'}}">
        <label for="realName" class="col-sm-2 control-label"><span class="text-red">*</span>姓名</label>
        <div class="col-sm-8">
            <input type="text" id="realName" name="realname" class="form-control" placeholder="{{empty($errors->first('realname'))?'名称':$errors->first('realname')}}" value="{{isset($user)?$user->realname:old('realname')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('password'))?'':'has-error'}}">
        <label for="password" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-8">
            <input type="password" id="password" name="password" class="form-control">
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