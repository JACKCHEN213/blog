@extends('layouts.admin')
@section('content')
<!--面包屑配置项 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;  	配置项管理
</div>
<!--面包屑配置项 结束-->

<!--结果页快捷搜索框 开始-->
{{--<div class="search_wrap">--}}
	{{--<form action="" method="post">--}}
		{{--<table class="search_tab">--}}
			{{--<tr>--}}
				{{--<th width="120">选择分类:</th>--}}
				{{--<td>--}}
					{{--<select onchange="javascript:location.href=this.value;">--}}
						{{--<option value="">全部</option>--}}
						{{--<option value="http://www.baidu.com">百度</option>--}}
						{{--<option value="http://www.sina.com">新浪</option>--}}
					{{--</select>--}}
				{{--</td>--}}
				{{--<th width="70">关键字:</th>--}}
				{{--<td><input type="text" name="keywords" placeholder="关键字"></td>--}}
				{{--<td><input type="submit" name="sub" value="查询"></td>--}}
			{{--</tr>--}}
		{{--</table>--}}
	{{--</form>--}}
{{--</div>--}}
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<style>
	/*.tc{*/
		/*display: inline-block;*/
		/*width: 80px;*/
		/*height: 40px;*/
		/*overflow: hidden;*/
		/*text-overflow: ellipsis;*/
		/*white-space: nowrap;*/
	/*}*/
	.tc_content{
		width: 200px;
		height: auto;
	}
	.tc_time{
		width: 100px;
		font-size: 15px;
		line-height: 20px;
		overflow: initial;
		white-space: normal;
	}
	.result_content ul li span {
		font-size: 15px;
		padding: 6px 12px;
	}
</style>
<div class="result_wrap">
	<!--快捷配置项 开始-->
	<div class="result_title">
		<h3>配置项列表</h3>
		@if(count($errors)>0)
				@if(is_object($errors))
					@foreach($errors->all() as $error)
						<p>{{$error}}</p>
					@endforeach
				@else
					<script>layer.msg("{{$errors}}", {icon : 6});</script>
				@endif
		@endif
	</div>
	<div class="result_content">
		<div class="short_wrap">
			<a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
			<a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
		</div>
	</div>
	<!--快捷配置项 结束-->
</div>

<div class="result_wrap">
	<div class="result_content">
		<form action="{{url('admin/config/changeContent')}}" method="post">
		{{csrf_field()}}
		<table class="list_tab">
			<tr>
				<th class="tc" width="5%">排序</th>
				<th class="tc" width="5%">ID</th>
				<th class="tc">标题</th>
				<th class="tc">名称</th>
				<th class="tc">内容</th>
				<th class="tc" style="width: 100px;">更新时间</th>
				<th class="tc">操作</th>
			</tr>
			@foreach($data as $value)
			<tr>
				<td class="tc"><input type="text" onchange="changeOrder(this, {{$value->conf_id}})" value="{{$value->conf_order}}" v-bind:width="10px"></td>
				<td class="tc">{{$value->conf_id}}</td>
				<td class="tc">{{$value->conf_title}}</td>
				<td class="tc">{{$value->conf_name}}</td>
				<td class="tc tc_content">
					<input hidden name="conf_id[]" value="{{$value->conf_id}}">
					{!! $value->_html !!}
				</td>
				<td class="tc tc_time">{{$value->updated_at}}</td>
				<td class="tc">
					<a href="{{url('admin/config/'.$value->conf_id.'/edit')}}">修改</a>
					<a href="javascript:;" onclick="confDel({{$value->conf_id}})">删除</a>
				</td>
			</tr>
			@endforeach
		</table>
			<div class="btn_group">
				<input type="submit" value="提交">
				<input type="button" class="back" onclick="history.go(-1)" value="返回" >
			</div>
		</form>
	</div>
</div>
<script>

    function changeOrder(obj, conf_id){
        let conf_order = obj.value;
        $.post("{{url('admin/config/changeOrder')}}", {'_token':"{{csrf_token()}}", 'conf_id':conf_id, 'conf_order':conf_order}, function(data){
            if(data.status == 0){
                layer.msg(data.msg, {icon : 6});
            }else{
                layer.msg(data.msg, {icon : 5});
            }
        });
    }
	function confDel(conf_id) {
        layer.confirm('您确定要删除这个配置项？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/config/')}}/" + conf_id, {'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
                if(data.status == 0){
                    location.href = window.location.href;
                    layer.msg(data.msg, {icon : 6});
                }else {
                    layer.msg(data.msg, {icon: 5});
                }
            });
            //layer.msg();
        }, function(){
				//这里是去取消按下后的操作
        });
    }
</script>
<!--搜索结果页面 列表 结束-->
@endsection

