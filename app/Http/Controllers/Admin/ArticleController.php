<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //
    //get.admin/article        全部文章列表
    public function index()
    {
        $data = Article::orderBy('art_id', 'DESC')->paginate(2);
        $cate = Category::all();
        echo view('admin.article.index', compact('data', 'cate'));
    }

    //get.admin/article/create            //添加文章
    public function create()
    {
        $data = (new Category)->tree(session_destroy());
        return view('admin.article.add', compact('data'));
    }
    //post.admin/article                   //添加文章提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'art_title'=>'required',
                'art_content'=>'required',
            ];
            $message = [
                'art_title.required'=>'文章标题不能为空',
                'art_content.required'=>'文章内容不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                date_default_timezone_set('PRC');
                $input['art_time'] = time();
                $input['art_view'] = 0;
                $re = Article::create($input);
                if($re){
                    return redirect('admin/article');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.article.add');
        }

    }
    //get.admin/article/{article}/edit  编辑文章
    public function edit()
    {
        
    }
    //put|patch.admin/article/{article}   更新文章
    public function update()
    {
        
    }
    //delete.admin/article/{article}  删除单个文章
    public function destroy()
    {
        
    }
    //get.admin/article/{article}
    public function show()
    {

    }
}
