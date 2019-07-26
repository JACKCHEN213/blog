<?php

namespace App\Http\Controllers\Home;


use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;

class IndexController extends CommonController
{
    //
    public function index()
    {
        $hotArt = Article::orderBy('art_view', 'DESC')->take(6)->get();
        $picArt = Article::orderBy('art_time', 'DESC')->paginate(5);

        return view('home.index', compact('hotArt', 'picArt'));
    }
    public function cate($cate_id)
    {
        $cate = Category::find($cate_id);
        Category::where('cate_id', $cate_id)->increment('cate_view');
        $picArt = Article::where('cate_id', $cate_id)->orderBy('art_time', 'DESC')->paginate(4);
        //当前分类的的子分类
        $subCate = Category::where('cate_pid', $cate_id)->get();

        return view('home.list', compact('cate', 'picArt', 'subCate'));
    }
    public function article($art_id)
    {
        $art = Article::find($art_id);
        Article::where('art_id', $art_id)->increment('art_view');
        $cate = Category::where('cate_id', $art->cate_id)->first();
        $article['pre'] = Article::where('art_id', '<', $art_id)->orderBy('art_id', 'DESC')->first();
        $article['re'] = Article::where('art_id', '>', $art_id)->orderBy('art_id', 'ASC')->first();

        $data = Article::where('cate_id', $art->cate_id)->orderBy('art_time', 'DESC')->take(6)->get();
        return view('home.new', compact('art', 'cate', 'article', 'data'));
    }
}
