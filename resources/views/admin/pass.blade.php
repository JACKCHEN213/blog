@extends('layouts.admin')
@section('content')
<body  onload="checkRight()">
    <!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 修改密码
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>修改密码</h3>
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
        @if(session('changed'))
            <div class="mark">
                <p>{{session('changed')}}</p>
                <p><a href="{{url('admin/info')}}">&laquo;&laquo;&laquo;&laquo;&laquo;正在跳转&laquo;&laquo;&laquo;&laquo;&laquo;</a>&nbsp;&nbsp;&nbsp;&nbsp;<span id="changed_span" style="font-size: 20px; color: black; font-family: jokerman;">5</span></p>
            </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form method="post" action="{{url('admin/pass')}}">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>原密码：</th>
                <td>
                    <input type="password" name="password_o" id="origin_pass" required oninvalid="setCustomValidity('请输入原密码');" oninput="setCustomValidity('');" onchange="confirmOriginPass()" /> <img id="origin_pass_i"  /><span id="origin_pass_span">请输入原始密码</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>新密码：</th>
                <td>
                    <input type="password" name="password" id="new_pass" minlength="6" maxlength="20" required oninvalid="setCustomValidity('请输入新密码');" oninput="setCustomValidity(''); " onchange="checkOldSame()" /><span>新密码6-20位</span>
                    <p id="new_pass_p"></p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>确认密码：</th>
                <td>
                    <input type="password" name="password_confirmation" id="new_pass_cfm" minlength="6" maxlength="20" required oninvalid="setCustomValidity('请输入确认新密码');" oninput="setCustomValidity('');" onchange="checkNewSame()" /> <span>再次输入密码</span>
                    <p id="new_pass_cfm_p"></p>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交" id="pass_sub">
                    <input type="button" class="back" onclick="window.location.assign('{{url("admin/info")}}')" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    function checkRight(){
        setInterval(function(){
            if(document.getElementById("origin_pass").value == "<?php $user = \App\Http\Model\User::find(1); echo \Illuminate\Support\Facades\Crypt::decrypt($user['user_pass']);?>"
                && "<?php $user = \App\Http\Model\User::find(1); echo \Illuminate\Support\Facades\Crypt::decrypt($user['user_pass']);?>" != document.getElementById("new_pass").value
                && document.getElementById("new_pass").value == document.getElementById("new_pass_cfm").value
                && document.getElementById("new_pass").value.length >= 6){
                document.getElementById("new_pass_cfm_p").innerHTML = "验证通过";
                document.getElementById("new_pass_cfm_p").style.color = "green";
                document.getElementById("pass_sub").style.background = "blue";
                document.getElementById("pass_sub").style.pointerEvents = "auto";
                document.getElementById("pass_sub").style.cursor = "pointer";
            }else{
                document.getElementById("pass_sub").style.background = "lightblue";
                document.getElementById("pass_sub").style.pointerEvents = "none";
                document.getElementById("pass_sub").style.cursor = "not-allowed";
            }
        }, 50);
        if("<?php echo session('changed');?>"){
            function add(){
                document.getElementById("changed_span").innerHTML -= 1;
                if(parseInt(document.getElementById("changed_span").innerHTML) <= 0){
                    clearInterval(coc);
                    window.location.assign('{{url("admin/info")}}');
                }
            }
            var coc = setInterval(add, 1000);

        }
    }
    function confirmOriginPass(){
        if(document.getElementById("origin_pass").value == "<?php $user = \App\Http\Model\User::find(1); echo \Illuminate\Support\Facades\Crypt::decrypt($user['user_pass']);?>"){
            document.getElementById("origin_pass_i").src = "{{asset('resources/views/admin/style/img/AC.png')}}";
            document.getElementById("origin_pass_span").innerHTML = "密码正确";
        }else{
            document.getElementById("origin_pass_i").src = "{{asset('resources/views/admin/style/img/WA.png')}}";
            document.getElementById("origin_pass_span").innerHTML = "请输入正确的原密码";
        }
    }
    function checkOldSame(){
        if("<?php $user = \App\Http\Model\User::find(1); echo \Illuminate\Support\Facades\Crypt::decrypt($user['user_pass']);?>" == document.getElementById("new_pass").value){
            document.getElementById("new_pass_p").innerHTML = "与上一个密码一致";
            document.getElementById("new_pass_p").style.color = "red";
        }
    }
    function checkNewSame(){
        if(document.getElementById("new_pass").value == document.getElementById("new_pass_cfm").value && document.getElementById("new_pass").value.length >= 6){

        }else if(document.getElementById("new_pass").value.length < 6){
            document.getElementById("new_pass_cfm_p").innerHTML = "密码至少6位";
            document.getElementById("new_pass_cfm_p").style.color = "red";
        }else{
            document.getElementById("new_pass_cfm_p").innerHTML = "两次密码不一致";
            document.getElementById("new_pass_cfm_p").style.color = "red";
        }
    }
</script>
</body>
@endsection