@extends('layouts.home')
@section('info')
    <title>{{$cate->cate_name}}　-　{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$cate->cate_keywords}}">
    <meta name="description" content="{{$cate->cate_description}}">
@endsection
@section('content')
    <article class="blogs">
        <h1 class="t_nav"><span>{{$cate->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('/cate/'.$cate->cate_id)}}" class="n2">{{$cate->cate_name}}</a> </h1>
        <div class="newblog left">
            @if($picArt->all())
                @foreach($picArt as $key => $value)
                    <h2>{{$value->art_title}}</h2>
                    <p class="dateview"><span>　发布时间：{{date('Y-d-m', $value->art_time)}}</span><span>作者：{{$value->art_editor}}</span><span>分类：[<a href="{{url('/cate'.$cate->cate_id)}}">{{$cate->cate_name}}</a>]</span></p>
                    <figure><img src="{{asset($value->art_thumb)}}"></figure>
                    <ul class="nlist">
                        <p>{{$value->art_description}}...</p>
                        <a title="{{$value->art_title}}" href="{{url('/cate/'.$value->cate_id)}}" target="_blank" class="readmore">阅读全文>></a>
                    </ul>
                    <div class="line"></div>
                @endforeach
            @else
                <p>一条数据都没找到థ౪థ..........</p>
            @endif
            <div class="page">
                {{$picArt->links()}}
            </div>
        </div>
        <aside class="right">
            @if($subCate->all())
            <div class="rnav">
                <ul>
                    @foreach($subCate as $key => $value)
                        <li class="{{'rnav'.($key % 4 + 1)}}"><a href="{{url('/cate/'.$value->cate_id)}}" target="_blank" style="">{{$value->cate_name}}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
        @parent
        </aside>
    </article>
@endsection