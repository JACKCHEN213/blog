@extends('layouts.home')
@section('info')
  <title>{{Config::get('web.web_title')}}　-　{{Config::get('web.seo_title')}}</title>
  <meta name="keywords" content="{{Config::get('web.keywords')}}">
  <meta name="description" content="{{Config::get('web.description')}}">
@endsection
@section('content')
<div class="banner">
  <section class="box">
    <ul class="texts">
      <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
      <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
      <p>加了锁的青春，不会再因谁而推开心门。</p>
    </ul>
    <div class="avatar"><a href="#"><span>JackC</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>站长</span>推荐 Recommend</p>
    </h3>
    <ul>
      @foreach($hotArt as $key => $value)
      <li><a href="{{url('a/'.$value->art_id)}}"  target="_blank"><img src="{{asset($value->art_thumb)}}"></a><span>{{$value->art_title}}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
    @foreach($picArt as $key => $value)
    <h3>{{$value->art_title}}</h3>
    <figure><img src="{{asset($value->art_thumb)}}" height="100"></figure>
    <ul>
      <p>{{$value->art_description}}...</p>
      <a title="{{$value->art_title}}" href="{{url('a/'.$value->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span>　{{date('Y-m-d', $value->art_time)}}</span><span>作者：{{$value->art_editor}}</span></p>
    @endforeach
    <div class="page">
      {{$picArt->links()}}
    </div>
  </div>

  <aside class="right">
  @parent
  </aside>
</article>
@endsection
