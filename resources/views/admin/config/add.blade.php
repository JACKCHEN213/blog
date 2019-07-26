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
<!--面包屑配置项 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  配置项管理
</div>
<!--面包屑配置项 结束-->

<!--结果集标题与配置项组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加配置项</h3>
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
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
            </div>
        </div>
    </div>
</div>
<!--结果集标题与配置项组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/config')}}" method="post" >
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>

            <tr>
                <th><i class="require">*</i>标题：</th>
                <td>
                    <input type="text" name="conf_title">
                    <span><i class="fa fa-exclamation-circle yellow"></i>这是必填字段</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>名称：</th>
                <td>
                    <input type="text" name="conf_name">
                    <span><i class="fa fa-exclamation-circle yellow"></i>这是必填字段</span>
                </td>
            </tr>
            <tr>
                <th>配置项类型：</th>
                <td>
                    <input type="radio" name="field_type" value="input" checked onclick="showTr(this)">input&nbsp;&nbsp;
                    <input type="radio" name="field_type" value="textarea" onclick="showTr(this)">textarea&nbsp;&nbsp;
                    <input type="radio" name="field_type" value="radio" onclick="showTr(this)">radio
                </td>
            </tr>
            <tr>
                <th>类型值：</th>
                <td>
                    <input type="text" id="field_value_id" class="lg" name="field_value" readonly onclick="showText()">
                    <p><i class="fa fa-exclamation-circle yellow"></i>格式 1|开启， 2|关闭</p>
                    <p id="field_value_p"></p>
                </td>
            </tr>
            <tr>
                <th>排序：</th>
                <td>
                    <input type="number" class="sm" name="conf_order">
                </td>
            </tr>
            <tr>
                <th>配置项说明：</th>
                <td>
                    <textarea name="conf_tips"></textarea>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="添加">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    function showTr(obj) {
        let type = obj.value;
        if(type == 'radio'){
            document.getElementById('field_value_id').readOnly = false;
        }else{
            document.getElementById('field_value_id').readOnly = true;
        }
    }
    function showText(){
        if(document.getElementById('field_value_id').readOnly == false){
            document.getElementById('field_value_p').innerHTML = '';
        }else{
            document.getElementById('field_value_p').innerHTML = '当前类型不能进行对类型值的设置';
        }
    }
</script>
@endsection