@extends('layouts.admin')
@section('content')
<body style="background-color: #F3F3F4;">
<div class="login_box">
	<h1>Blog</h1>
	<h2>欢迎使用博客管理平台</h2>
	<div class="form">
		@if(session('msg'))
			<p style="color:red">{{session('msg')}}</p>
		@endif
		<form action="" method="post">
			{{csrf_field()}}
			<ul>
				<li>
					@if(session('msg'))
						<input type="text" value="{{session("name")}}" name="user_name" class="text" required oninvalid="setCustomValidity('请输入您的姓名');" oninput="setCustomValidity('');"/>
					@else
						<input type="text" value="" name="user_name" class="text" required oninvalid="setCustomValidity('请输入您的姓名');" oninput="setCustomValidity('');"/>
					@endif

					<span><i class="fa fa-user"></i></span>
				</li>
				<li>
					@if(session('msg'))
						<input type="password" value="{{session('pass')}}" name="user_pass" class="text" required oninvalid="setCustomValidity('请输入您的密码');" oninput="setCustomValidity('');"/>
					@else
						<input type="password" name="user_pass" class="text" required oninvalid="setCustomValidity('请输入您的密码');" oninput="setCustomValidity('');"/>
					@endif

					<span><i class="fa fa-lock"></i></span>
				</li>
				<li>
					<input type="text" class="code" name="code" required oninvalid="setCustomValidity('请输入验证码');" oninput="setCustomValidity('');"/>
					<span><i class="fa fa-check-square-o"></i></span>
					<img src="{{url('admin/code')}}" alt="code" onclick="this.src='{{url("admin/code")}}?'+Math.random()">
				</li>
				<li>
					<input type="submit" value="立即登陆"/>
				</li>
			</ul>
		</form>
		<p><a href="#">返回首页</a> &copy; 2019 Powered by <a href="https://www.baidu/com" target="_blank">http://www.houdunwang.com</a></p>
	</div>
</div>
</body>
@endsection