@extends('layouts.base')

@section('content')
    @include('layouts.tip')
    <link type="text/css" href="https://cdn.bootcss.com/datatables/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <div class="box box-info">
        <div class="box-header">
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 280px;">
                    {{--<a href="#" class="btn-sm btn-info" style="margin-right: 20px;">创建目录</a>--}}
                    {{--<a href="#" class="btn-sm btn-success" style="margin-right: 20px;">上传</a>--}}
                    {{--<a href="#" class="btn-sm btn-danger">模板</a>--}}
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <form action="{{route('resources.search')}}" method="post" id="resources-form">
                {{csrf_field()}}
                <input type="hidden" name="searchdir" value="{{$upleveldir}}">
            <table id="resources-list-table" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>名称</th>
                        <th>类型/大小</th>
                        <th>最后修改时间</th>
                        <th>操作</th>
                    </tr>
                    <tr>
                        <td colspan="4"><a href="javascript:;" style="display: block;width: 100%;" id="to-up-level"><i class="fa fa-level-up" aria-hidden="true" style="margin-right: 1rem;"></i><span>返回上一级 {{$upleveldir}}</span></a></td>
                    </tr>
                    </thead>
                <tbody id="resources-table-body">
                    @if(!empty($lists['dirs']))
                        @foreach($lists['dirs'] as $dir)
                            <tr>
                                <td><a href="javascript:;" class="dir-item" data-dir="{{$dir}}"><i class="fa fa-folder" style="margin-right: 1rem;color: #f39c12;"></i>{{$dir}}</a></td>
                                <td>目录</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endif
                    @if(!empty($lists['files']))
                        @foreach($lists['files'] as $file)
                            <tr>
                                <td><a href="javascript:;" data-url="{{$file['url']}}" data-name="{{$file['name']}}" data-toggle="modal" data-target="#previewModal" class="file-item"><i class="fa fa-file" style="margin-right: 1rem;"></i>{{$file['name']}}</a></td>
                                <td>{{$file['size']>= 1048576?round($file['size']/1048576*100)/100 . 'M':round($file['size']/1024*100)/100 . 'K'}}</td>
                                <td>{{$file['lastModified']}}</td>
                                <td><a href="{{$file['url']}}" class="download-btn" download="{{$file['name']}}">下载</a></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </form>
        </div>
        <!-- /.box-body -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="previewModalLabel">预览区</h4>
                    <p class="text-center" id="previewTitle">title</p>
                </div>
                <div class="modal-body text-center" id="previewModalBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <a type="button" class="btn btn-primary download-btn" href="" download="">下载</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {{--<script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>--}}
    {{--<script type="text/javascript" src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>--}}
    <script type="text/javascript" src="/asset/layer/layer.js"></script>
    <script type="text/javascript" src="/asset/laydate/laydate.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("form#resources-form .dir-item").click(function () {
                var searchdir=$(this).data('dir');
                console.log(searchdir);
                $("form#resources-form input:hidden[name='searchdir']").val(searchdir);
                $("form#resources-form").submit();

            });
            $("#to-up-level").click(function () {
                $("form#resources-form").submit();

            });
            $("#resources-table-body .file-item").click(function () {
                var url=$(this).data('url');
                var name=$(this).data('name');
                var html='';
                if (/\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(url)) {
                    html='<img src="'+url+'" class="img-responsive" style="margin: 0 auto;">';
                }else{
                    html='<p>此格式不支持预览</p>';
                }
                $("#previewModalBody").empty();
                $("#previewModalBody").html(html);
                $("#previewTitle").html(name);
                $("#previewModal .download-btn").attr('href',url);
                $("#previewModal .download-btn").attr('download',name);
            });
            {{--$(".download-btn").click(function () {--}}
                {{--var objname=$(this).data('download');--}}
                {{--$.ajax({--}}
                    {{--url: '}}',--}}
                    {{--type: "post",--}}
                    {{--data: {'objname':objname,'_token': $('input[name=_token]').val()},--}}
                    {{--success: function(data){--}}
                        {{--console.log(data);--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
           // $('#buttons-list-table').DataTable({
           //     "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
           //     "language": {
           //         "url": "/datables-language-zh-CN.json"
           //     }
           // });
            //日期
            // lay('.date-item').each(function(){
            //     laydate.render({
            //         elem: this
            //         ,trigger: 'click'
            //     });
            // });
            {{--$(".delete-operation").on('click',function(){--}}
                {{--var id=$(this).attr('data-id');--}}
                {{--layer.open({--}}
                    {{--content: '你确定要删除吗？',--}}
                    {{--btn: ['确定', '关闭'],--}}
                    {{--yes: function(index, layero){--}}
                        {{--$('form.hospitals-form').attr('action',"{{route('hospitals.index')}}/"+id);--}}
                        {{--$('form.hospitals-form').submit();--}}
                    {{--},--}}
                    {{--btn2: function(index, layero){--}}
                        {{--//按钮【按钮二】的回调--}}
                        {{--//return false 开启该代码可禁止点击该按钮关闭--}}
                    {{--},--}}
                    {{--cancel: function(){--}}
                        {{--//右上角关闭回调--}}
                        {{--//return false; 开启该代码可禁止点击该按钮关闭--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        });
    </script>
@endsection
