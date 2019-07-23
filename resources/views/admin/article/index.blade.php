@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
	<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
	<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部文章
</div>
<!--面包屑导航 结束-->

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
	.tc{
		display: inline-block;
		width: 84px;
		height: 40px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	.tc_title{
		width: 120px;
	}
	.tc_des{
		width: 200px;
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
<form action="#" method="post">
	<div class="result_wrap">
		<!--快捷导航 开始-->
		<div class="result_title">
			<h3>文章管理</h3>
		</div>
		<div class="result_content">
			<div class="short_wrap">
				<a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
				<a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
			</div>
		</div>
		<!--快捷导航 结束-->
	</div>

	<div class="result_wrap">
		<div class="result_content">
			<table class="list_tab">
				<tr>

					<th class="tc">预览图</th>
					<th class="tc" width="5%">ID</th>
					<th class="tc tc_title">标题</th>
					<th class="tc">文章类型</th>
					<th class="tc tc_des">文章描述</th>
					<th class="tc">查看次数</th>
					<th class="tc">发布人</th>
					<th class="tc tc_time">发布时间</th>
					<th class="tc tc_time">更新时间</th>
					<th class="tc">操作</th>
				</tr>
				@foreach($data as $value)
				<tr>
					<td class="tc" >
						<img src="{{$value->art_thumb}}" alt="无" style="height: 30px;">
					</td>
					<td class="tc">{{$value->art_id}}</td>
					<td class="tc tc_title"><a href="#">{{$value->art_title}}</a></td>
					<td class="tc">
						@foreach($cate as $n)
							@if($n->cate_id == $value->cate_id)
								{{$n->cate_name}}
							@endif
						@endforeach
					</td>
					<td class="tc tc_des">{{$value->art_description}}</td>
					<td class="tc">{{$value->art_view}}</td>
					<td class="tc">{{$value->art_editor}}</td>
					<td class="tc tc_time">{{Date('Y-m-d H:i:s', $value->art_time)}}</td>
					<td class="tc tc_time">{{$value->updated_at}}</td>
					<td class="tc">
						<a href="{{url('admin/category/'.$value->cate_id.'/edit')}}">修改</a>
						<a href="javascript:;" onclick="cateDel({{$value->cate_id}})">删除</a>
					</td>
				</tr>
				@endforeach
			</table>
			<div class="page_list">
				{{$data->links()}}
			</div>
		</div>
	</div>
</form>
<script>
	function cateDel(cate_id) {
        layer.confirm('您确定要删除该分类？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/category/')}}/" + cate_id, {'_method':'delete','_token':"{{csrf_token()}}"}, function (data) {
                if(data.status == 0){
                    window.location.href = window.location.href;
                    layer.msg(data.msg, {icon : 6});
                }else {
                    layer.msg(data.msg, {icon: 5});
                }
            });
            //layer.msg();
        }, function(){

        });
    }
</script>
<!--搜索结果页面 列表 结束-->
@endsection

