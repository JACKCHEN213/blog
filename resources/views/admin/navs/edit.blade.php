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
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  修改自定义导航
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>导航管理</h3>
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
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
            </div>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/navs/'.$data->nav_id.'')}}" method="post" >
        {{csrf_field()}}
        <input type="hidden" name="_method" value="put">
        <table class="add_tab">
            <tbody>
            <tr>
                <th>排序：</th>
                <td>
                    <input type="text" value="{{$data->nav_order}}" class="sm" name="nav_order">
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>导航名称：</th>
                <td>
                    <input type="text" value="{{$data->nav_name}}" name="nav_name">
                    <input type="text" value="{{$data->nav_alias}}" class="sm" name="nav_alias" placeholder="别名">
                    <span><i class="fa fa-exclamation-circle yellow"></i>这是必填字段</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>导航地址(URL)：</th>
                <td>
                    <input type="text" value="{{$data->nav_url}}" class="lg" name="nav_url">
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
@endsection