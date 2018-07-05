<div class="box-body">
    <div class="form-group {{empty($errors->first('special_id'))?'':'has-error'}}">
        <label for="name" class="col-sm-2 control-label">专题</label>
        <div class="col-sm-8">
            <select name="special_id" id="special" class="form-control select2">
                @foreach($specials as $o=>$d)
                    <optgroup label="{{$offices[$o]}}">
                        @foreach($d as $special)
                        <option value ="{{$special['id']}}">{{$special['name']}}({{$special['url']}})</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group {{empty($errors->first('cost'))?'':'has-error'}}">
        <label for="cost" class="col-sm-2 control-label">消费</label>
        <div class="col-sm-8">
            <input type="text" id="cost" name="cost" class="form-control" placeholder="{{empty($errors->first('cost'))?'消费':$errors->first('cost')}}" value="{{isset($specialtran)?$specialtran->cost:old('cost')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('click'))?'':'has-error'}}">
        <label for="click" class="col-sm-2 control-label">点击</label>
        <div class="col-sm-8">
            <input type="text" id="click" name="click" class="form-control" placeholder="{{empty($errors->first('click'))?'点击':$errors->first('click')}}" value="{{isset($specialtran)?$specialtran->click:old('click')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('show'))?'':'has-error'}}">
        <label for="show" class="col-sm-2 control-label">展现</label>
        <div class="col-sm-8">
            <input type="text" id="show" name="show" class="form-control" placeholder="{{empty($errors->first('show'))?'展现':$errors->first('show')}}" value="{{isset($specialtran)?$specialtran->show:old('show')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('view'))?'':'has-error'}}">
        <label for="view" class="col-sm-2 control-label">唯一身份浏览量</label>
        <div class="col-sm-8">
            <input type="text" id="view" name="view" class="form-control" placeholder="{{empty($errors->first('view'))?'唯一身份浏览量':$errors->first('view')}}" value="{{isset($specialtran)?$specialtran->view:old('view')}}">
        </div>
    </div>

    <div class="form-group {{empty($errors->first('swt_lg_one'))?'':'has-error'}}">
        <label for="swt_lg_one" class="col-sm-2 control-label">商务通大于等于1</label>
        <div class="col-sm-8">
            <input type="text" id="swt_lg_one" name="swt_lg_one" class="form-control" placeholder="{{empty($errors->first('swt_lg_one'))?'商务通大于等于1':$errors->first('swt_lg_one')}}" value="{{isset($specialtran)?$specialtran->swt_lg_one:old('swt_lg_one')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('swt_lg_three'))?'':'has-error'}}">
        <label for="swt_lg_three" class="col-sm-2 control-label">商务通大于等于3</label>
        <div class="col-sm-8">
            <input type="text" id="swt_lg_three" name="swt_lg_three" class="form-control" placeholder="{{empty($errors->first('swt_lg_three'))?'商务通大于等于3':$errors->first('swt_lg_three')}}" value="{{isset($specialtran)?$specialtran->swt_lg_three:old('swt_lg_three')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('yuyue'))?'':'has-error'}}">
        <label for="yuyue" class="col-sm-2 control-label">预约量</label>
        <div class="col-sm-8">
            <input type="text" id="yuyue" name="yuyue" class="form-control" placeholder="{{empty($errors->first('yuyue'))?'预约':$errors->first('yuyue')}}" value="{{isset($specialtran)?$specialtran->yuyue:old('yuyue')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('arrive'))?'':'has-error'}}">
        <label for="arrive" class="col-sm-2 control-label">到院量</label>
        <div class="col-sm-8">
            <input type="text" id="arrive" name="arrive" class="form-control" placeholder="{{empty($errors->first('arrive'))?'到院':$errors->first('arrive')}}" value="{{isset($specialtran)?$specialtran->arrive:old('arrive')}}">
        </div>
    </div>
    <div class="form-group {{empty($errors->first('date_tag'))?'':'has-error'}}">
        <label for="date_tag" class="col-sm-2 control-label">日期</label>
        <div class="col-sm-8">
            <input type="text" id="date_tag" name="date_tag" class="form-control item-date" value="{{isset($specialtran)?\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$specialtran)->toDateString():\Carbon\Carbon::now()->toDateString()}}">
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