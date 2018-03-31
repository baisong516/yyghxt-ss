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
    <div class="form-group {{empty($errors->first('cost'))?'':'has-error'}}">
        <label for="cost" class="col-sm-2 control-label">消费</label>
        <div class="col-sm-8">
            <input type="text" id="cost" name="cost" class="form-control" placeholder="{{empty($errors->first('cost'))?'消费':$errors->first('cost')}}" value="{{isset($target)?$target->cost:old('cost')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('show'))?'':'has-error'}}">
        <label for="show" class="col-sm-2 control-label">展现</label>
        <div class="col-sm-8">
            <input type="number" id="show" name="show" class="form-control" placeholder="{{empty($errors->first('show'))?'展现':$errors->first('show')}}" value="{{isset($target)?$target->show:old('show')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('click'))?'':'has-error'}}">
        <label for="click" class="col-sm-2 control-label">点击</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="click" name="click" class="form-control" placeholder="{{empty($errors->first('click'))?'点击':$errors->first('click')}}" value="{{isset($target)?$target->click:old('click')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('achat'))?'':'has-error'}}">
        <label for="achat" class="col-sm-2 control-label">总对话量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="achat" name="achat" class="form-control" placeholder="{{empty($errors->first('achat'))?'总对话量':$errors->first('achat')}}" value="{{isset($target)?$target->achat:old('achat')}}">
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