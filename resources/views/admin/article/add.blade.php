@extends('layouts.admin')
@section('content')
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
    <form action="{{url('admin/category')}}" method="post">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
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
                        <input type="file" class="lg" name="art_thumb" accept="image/*">
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
                        <textarea name="art_content"></textarea>
                    </td>
                </tr>
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
@endsection