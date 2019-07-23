@extends('layouts.admin')
@section('content')
<style>
    #img_thumb_btn{
        display: inline-block;
        width: 80px;
        height: 30px;
        color: white;
        background: green;
        border-radius: 20%;
    }
    #img_thumb_btn:hover{
        box-shadow: 0 2px 3px 0 rgba(80, 80, 80, 0.2), 0 4px 5px 0 rgba(80, 80, 80, 0.15);
    }
    .edui-default{line-height: 28px;}
    div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
    {overflow: hidden; height:20px;}
    div.edui-box{overflow: hidden; height:22px;}
</style>
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  添加文章
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>文章管理</h3>
        @if(count($errors)>0)
            <div class="mark">
                @if(is_object($errors))
                    @foreach($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                @else
                    <p>{{$errors}}</p>
                @endif
            </div>
        @endif
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
            </div>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/article')}}" method="post" >
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
                <tr>
                    <th width="120">分类：</th>
                    <td>
                        <select name="cate_id">
                            @foreach($data as $value)
                                <option value="{{$value->cate_id}}">{{$value->_cate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title">
                    </td>
                </tr>
                <tr>
                    <th>作者：</th>
                    <td>
                        <input type="text" class="sm" name="art_editor">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="file" id="img_thumb" class="lg" style="display: none" onchange="fileLoad(this)" accept="image/*">
                        <input type="text" id="img_thumb_text" name="art_thumb" hidden>
                        <input id="img_thumb_path" readonly>
                        <button type="button" id="img_thumb_btn" onclick="document.getElementById('img_thumb').click()">上传图片</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="" alt="预览图" id="img_thumb_img" style="height: 100px;">
                    </td>
                </tr>
                <tr>
                    <th>关键字：</th>
                    <td>
                        <input type="text" class="lg" name="art_tag">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="art_description"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>内容：</th>
                    <td>
                        <script type="text/javascript" src="{{url('resources/org/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" src="{{url('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" src="{{url('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="art_content" type="text/plain" style="width: 860px; height: 500px;"></script></script>
                        <script>
                            var ue = UE.getEditor('editor');
                        </script>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    function fileLoad(obj) {
        if (!/\.(gif|jpg|jpeg|png|GIF|JPG|PNG|bmp|tif|pcx|tga|exif|fpx|svg|psd|cdr|pcd|dxf|ufo|eps|ai|raw|WMF|webp|JPEG|BMP|TIF|PCX|TGA|EXIF|FPX|SVG|PSD|CDR|PCD|DXF|UFO|EPS|AI|RAW|WEBP)$/.test($("#img_thumb").val())){
            alert("上传图片格式错误，请重新上传");
            obj.value = null;
            obj.value = null;
        }else{
            document.getElementById('img_thumb_path').value = obj.value;
            let data = new FormData();
            data.append('_token', "{{csrf_token()}}");
            data.append("file", obj.files[0]);
            data.append("url", obj.value);
            $.ajax({
                url:'{{url("admin/upload")}}',
                data: data,
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                success: function(res){
                    document.getElementById('img_thumb_img').src = res["pathAbs"];
                    document.getElementById('img_thumb_text').value = res["pathAbs"];
                    layer.msg(res['msg'], {icon : 6});
                },
                error: function(res){
                    layer.msg(res['msg'], {icon : 5});
                }
            });
        }
    }
</script>
@endsection