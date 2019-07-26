<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    //
    public function __construct()
    {
        $navs = Navs::all();
        $clickArt = Article::orderBy('art_view', 'DESC')->take(5)->get();
        $newArt = Article::orderBy('art_time', 'DESC')->take(8)->get();
        $links = Links::orderBy('link_order', 'ASC')->get();
        View::share(['navs'=>$navs, 'clickArt'=>$clickArt, 'newArt'=>$newArt, 'links'=>$links]);
    }
}
