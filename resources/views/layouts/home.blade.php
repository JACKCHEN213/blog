<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{asset('resources/views/home/favicon.png')}}" type="image/x-icon">
    @yield('info')
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
    <script src="{{url('resources/views/home/js/modernizr.js')}}"></script>
</head>
<body>

<header>
    <div id="logo"><a href="{{url('/')}}"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $key => $value)<a href="{{url('$value->nav_url')}}"><span>{{$value->nav_name}}</span><span class="en">{{$value->nav_alias}}</span></a>@endforeach
    </nav>
</header>
@section('content')
    <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>
    <div class="news">
        <h3>
            <p>最新<span>文章</span></p>
        </h3>
        <ul class="rank">
            @foreach($newArt as $key => $value)
                <li><a href="{{url('a/'.$value->art_id)}}" title="{{$value->art_title}}" target="_blank" style="text-overflow: ellipsis;white-space: nowrap; overflow: hidden; display: block;">{{$value->art_title}}</a></li>
            @endforeach
        </ul>
        <h3 class="ph">
            <p>点击<span>排行</span></p>
        </h3>
        <ul class="paih">
            @foreach($clickArt as $key => $value)
                <li><a href="{{url('a/'.$value->art_id)}}" title="{{$value->art_title}}" target="_blank" style="text-overflow: ellipsis;white-space: nowrap; overflow: hidden; display: block;">{{$value->art_title}}</a></li>
            @endforeach
        </ul>
        <h3 class="links">
            <p>友情<span>链接</span></p>
        </h3>
        <ul class="website">
            @if($links->all())
            @foreach($links as $key => $value)
                <li><a href="{{url($value->link_url)}}" target="_blank">{{$value->link_name}}</a></li>
            @endforeach
            @else
                <p>还没有任何赞助，快来做第一个吧(。>︿<)_θ</p>
            @endif
        </ul>
    </div>
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
    </script>
    <!-- Baidu Button END -->
    @show

<footer>
    <p>{!! Config::get('web.copyright') !!}{!! Config::get('web.count_code') !!}</p>
</footer>
<script src="{{url('resources/views/home/js/silder.js')}}"></script>
</body>
</html>