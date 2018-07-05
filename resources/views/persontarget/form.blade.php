<div class="box-body">
    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}">
        <label for="office_id" class="col-sm-2 control-label">科室</label>
        <div class="col-sm-8">
            <select name="office_id" id="office_id" class="form-control">
                @isset($offices)
                    @foreach($offices as $k=>$v)
                        <option value="{{$k}}" {{isset($target)&&$target->office_id==$k?'selected':''}}>{{$v}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('user_id'))?'':'has-error'}}">
        <label for="user_id" class="col-sm-2 control-label">咨询员</label>
        <div class="col-sm-8">
            <select name="user_id" id="user_id" class="form-control">
                @isset($users)
                    @foreach($users as $k=>$v)
                        <option value="{{$k}}" {{isset($target)&&$target->user_id==$k?'selected':''}}>{{$v}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('year'))?'':'has-error'}}">
        <label for="year" class="col-sm-2 control-label">年度</label>
        <div class="col-sm-8">
            <input type="text" id="year" name="year" maxlength="4" class="form-control" placeholder="{{empty($errors->first('year'))?'2018':$errors->first('year')}}" value="{{isset($target)?$target->year:old('year')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('month'))?'':'has-error'}}">
        <label for="month" class="col-sm-2 control-label">月份</label>
        <div class="col-sm-8">
            <input type="text" id="month" name="month" maxlength="2" class="form-control" placeholder="{{empty($errors->first('month'))?'1':$errors->first('month')}}" value="{{isset($target)?$target->month:old('month')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('chat'))?'':'has-error'}}">
        <label for="chat" class="col-sm-2 control-label">有效对话量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="chat" name="chat" class="form-control" placeholder="{{empty($errors->first('chat'))?'有效对话量':$errors->first('chat')}}" value="{{isset($target)?$target->chat:old('chat')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('contact'))?'':'has-error'}}">
        <label for="contact" class="col-sm-2 control-label">留联量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="contact" name="contact" class="form-control" placeholder="{{empty($errors->first('contact'))?'留联量':$errors->first('contact')}}" value="{{isset($target)?$target->contact:old('contact')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('yuyue'))?'':'has-error'}}">
        <label for="yuyue" class="col-sm-2 control-label">总预约</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="yuyue" name="yuyue" class="form-control" placeholder="{{empty($errors->first('yuyue'))?'总预约':$errors->first('yuyue')}}" value="{{isset($target)?$target->yuyue:old('yuyue')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('arrive'))?'':'has-error'}}">
        <label for="arrive" class="col-sm-2 control-label">总到院</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="arrive" name="arrive" class="form-control" placeholder="{{empty($errors->first('arrive'))?'总到院':$errors->first('arrive')}}" value="{{isset($target)?$target->arrive:old('arrive')}}">
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