@extends('layouts.home')
@section('info')
  <title>{{$art->art_title}}　-　{{Config::get('web.web_title')}}</title>
  <meta name="keywords" content="{{$art->art_tag}}">
  <meta name="description" content="{{$art->art_description}}">
@endsection
@section('content')
<article class="blogs">
  <h1 class="t_nav"><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('/cate/'.$cate->cate_id)}}" class="n2">{{$cate->cate_name}}</a></h1>
  <div class="index_about">
    <h2 class="c_titile">{{$art->art_title}}</h2>
    <p class="box_c"><span class="d_time">　发布时间：{{date('Y-d-m', $art->art_time)}}</span><span>编辑：{{$art->art_editor}}</span><span>查看次数：{{$art->art_view}}</span></p>
    <p>
      {!! $art->art_content !!}
    </p>
    <div class="keybq">
      <p><span>关键字词</span>：{{$art->art_tag}}</p>
    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      @if($pre = $article['pre'])
        <p>上一篇：<a href="{{url('/a/'.$pre->art_id)}}">{{$pre->art_title}}</a></p>
      @endif
      @if($re = $article['re'])
        <p>下一篇：<a href="{{url('/a/'.$re->art_id)}}">{{$re->art_title}}</a></p>
      @endif
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        @if($data->all())
        @foreach($data as $key => $value)
          <li><a href="{{url('/a/'.$value->art_id)}}" title="{{$value->art_title}}">{{$value->art_title}}</a></li>
        @endforeach
        @endif
      </ul>
    </div>
  </div>
  <aside class="right">
    @parent
  </aside>
</article>
@endsection