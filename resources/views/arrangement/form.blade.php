<div class="box-body">
    <div class="form-group {{empty($errors->first('user_id'))?'':'has-error'}}">
        <label for="user" class="col-sm-2 control-label">姓名<span class="text-red">*</span></label>
        <div class="col-sm-10">
            <select name="user_id" id="user" {{isset($arrangement)?'disabled':''}} class="form-control">
                <option  selected value="">--选择排班人员--</option>
                @foreach($arrangeUsers as $v)
                    <optgroup label="{{$v['department']}}">
                        @if(!empty($v['users']))
                            @foreach($v['users'] as $arrangeUser)
                            <option value="{{$arrangeUser->id}}" {{isset($arrangement)&&$arrangement->user_id==$arrangeUser->id?'selected':''}}>{{$arrangeUser->realname}} @foreach($arrangeUser->offices as $office)【{{$office->display_name}}】 @endforeach</option>
                            @endforeach
                        @endif
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('rank'))?'':'has-error'}}">
        <label for="rank" class="col-sm-2 control-label">班次<span class="text-red">*</span></label>
        <div class="col-sm-10">
            <label class="radio-inline">
                <input type="radio" name="rank" value="0" {{old('rank')=='0'?'checked':''}} {{isset($arrangement)&&$arrangement->rank=='0'?'checked':''}}>早班
            </label>
            <label class="radio-inline">
                <input type="radio" name="rank" value="1" {{old('rank')=='1'?'checked':''}} {{isset($arrangement)&&$arrangement->rank=='1'?'checked':''}}>晚班
            </label>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('rank_date'))?'':'has-error'}}">
        <label for="rank_date" class="col-sm-2 control-label">排班日期<span class="text-red">*</span></label>
        <div class="col-sm-10">
            <input type="text" name="rank_date" id="rank_date" class="form-control" value="{{isset($arrangement)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$arrangement->rank_date)->toDateString():''}}">
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