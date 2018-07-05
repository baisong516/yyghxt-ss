<div class="box-body">
    <div class="form-group {{empty($errors->first('office_id'))?'':'has-error'}}">
        <label for="office_id" class="col-sm-2 control-label">科室</label>
        <div class="col-sm-8">
            <select name="office_id" id="office_id" class="form-control">
                @isset($offices)
                    @foreach($offices as $k=>$v)
                        <option value="{{$k}}" {{isset($report)&&$report->office_id==$k?'selected':''}}>{{$v}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('source_id'))?'':'has-error'}}">
        <label for="source_id" class="col-sm-2 control-label">网站来源</label>
        <div class="col-sm-8">
            <select name="source_id" id="source_id" class="form-control">
                @isset($sources)
                    @foreach($sources as $k=>$v)
                        <option value="{{$k}}" {{isset($report)&&$report->source_id==$k?'selected':''}}>{{$v}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('type'))?'':'has-error'}}">
        <label for="type" class="col-sm-2 control-label">类型</label>
        <div class="col-sm-8">
            <select name="type" id="type" class="form-control">
                <option value="">--选择类型--</option>
                <option value="platform" {{isset($report)&&$report->type=='platform'?'selected':''}}>渠道平台</option>
                <option value="area" {{isset($report)&&$report->type=='area'?'selected':''}}>地域</option>
                <option value="disease" {{isset($report)&&$report->type=='disease'?'selected':''}}>病种</option>
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('type_id'))?'':'has-error'}}">
        <label for="type_id" class="col-sm-2 control-label">类型值</label>
        <div class="col-sm-8">
            <select name="type_id" id="type_id" class="form-control">
                @isset($report)
                    @foreach($options as $k=>$v)
                        <option value="{{$k}}" {{$k==$report->type_id?'selected':''}}>{{$v}}</option>
                    @endforeach
                @endisset
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('cost'))?'':'has-error'}}">
        <label for="cost" class="col-sm-2 control-label">消费</label>
        <div class="col-sm-8">
            <input type="text" id="cost" name="cost" class="form-control" placeholder="{{empty($errors->first('cost'))?'消费':$errors->first('cost')}}" value="{{isset($report)?$report->cost:old('cost')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('show'))?'':'has-error'}}">
        <label for="show" class="col-sm-2 control-label">展现</label>
        <div class="col-sm-8">
            <input type="umber" id="show" name="show" class="form-control" placeholder="{{empty($errors->first('show'))?'展现':$errors->first('show')}}" value="{{isset($report)?$report->show:old('show')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('click'))?'':'has-error'}}">
        <label for="click" class="col-sm-2 control-label">点击</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="click" name="click" class="form-control" placeholder="{{empty($errors->first('click'))?'点击':$errors->first('click')}}" value="{{isset($report)?$report->click:old('click')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('achat'))?'':'has-error'}}">
        <label for="achat" class="col-sm-2 control-label">总对话量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="achat" name="achat" class="form-control" placeholder="{{empty($errors->first('achat'))?'总对话量':$errors->first('achat')}}" value="{{isset($report)?$report->achat:old('achat')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('chat'))?'':'has-error'}}">
        <label for="chat" class="col-sm-2 control-label">有效对话量</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="chat" name="chat" class="form-control" placeholder="{{empty($errors->first('chat'))?'有效对话量':$errors->first('chat')}}" value="{{isset($report)?$report->chat:old('chat')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('contact'))?'':'has-error'}}">
        <label for="contact" class="col-sm-2 control-label">留联系</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="contact" name="contact" class="form-control" placeholder="{{empty($errors->first('contact'))?'留联系':$errors->first('contact')}}" value="{{isset($report)?$report->contact:old('contact')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('yuyue'))?'':'has-error'}}">
        <label for="yuyue" class="col-sm-2 control-label">总预约</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="yuyue" name="yuyue" class="form-control" placeholder="{{empty($errors->first('yuyue'))?'总预约':$errors->first('yuyue')}}" value="{{isset($report)?$report->yuyue:old('yuyue')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('arrive'))?'':'has-error'}}">
        <label for="arrive" class="col-sm-2 control-label">总到院</label>
        <div class="col-sm-8">
            <input type="number" maxlength="11" id="arrive" name="arrive" class="form-control" placeholder="{{empty($errors->first('arrive'))?'总到院':$errors->first('arrive')}}" value="{{isset($report)?$report->arrive:old('arrive')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('date_tag'))?'':'has-error'}}">
        <label for="date_tag" class="col-sm-2 control-label">日期</label>
        <div class="col-sm-8">
            <input type="text"  id="date_tag" name="date_tag" class="form-control item-date" value="{{isset($report)?\Carbon\Carbon::createFromFormat('Y-m-d',$report->date_tag)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
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