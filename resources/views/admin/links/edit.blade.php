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
</style>
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  友情链接管理
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>编辑友情链接</h3>
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
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部友情链接</a>
            </div>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/links/'.$data->link_id.'')}}" method="post" >
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <table class="add_tab">
            <tbody>
            <tr>
                <th>友情链接排序：</th>
                <td>
                    <input type="text" value="{{$data->link_order}}" class="sm" name="link_order">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>友情链接名称：</th>
                <td>
                    <input type="text" value="{{$data->link_name}}" class="lg" name="link_name">
                    <span><i class="fa fa-exclamation-circle yellow"></i>这是必填字段</span>
                </td>
            </tr>
            <tr>
                <th>友情链接标题：</th>
                <td>
                    <input type="text" value="{{$data->link_title}}" class="lg" name="link_title">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>友情链接地址(URL)：</th>
                <td>
                    <input type="text" value="{{$data->link_url}}" class="lg" name="link_url">
                </td>
            </tr>
            <tr>
                <th>logo：</th>
                <td>
                    <input type="file" id="img_thumb" class="lg" style="display: none" onchange="fileLoad(this)" accept="image/*">
                    <input type="text" id="img_thumb_text" name="link_logo" hidden>
                    <input id="img_thumb_path" value="{{$data->link_logo}}" readonly>
                    <button type="button" id="img_thumb_btn" onclick="document.getElementById('img_thumb').click()">上传图片</button>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="{{$data->link_logo}}" alt="logo" id="img_thumb_img" style="height: 100px;">
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="修改">
                    <input type="button" class="back" onclick="history.go(-1)" value="取消">
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