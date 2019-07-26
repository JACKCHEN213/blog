<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //
    //get.admin/article        全部文章列表
    public function index()
    {
        $data = Article::orderBy('art_id', 'DESC')->paginate(5);
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
                $input['art_thumb'] = $input['art_thumb']? $input['art_thumb']: '/storage/images/001.png';
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
    public function edit($art_id)
    {
        $data = (new Category)->tree(session_destroy());
        $art = Article::find($art_id);
        return view('admin.article.edit', compact('data', 'art'));
    }
    //put|patch.admin/article/{article}   更新文章
    public function update($art_id)
    {
        if($input = Input::except('_token', '_method')){
            $rules = [
                'art_title'=>'required',
                'art_content'=>'required',
            ];
            $message = [
                'art_title.required'=>'文章标题不能为空',
                'art_content.required'=>'文章标题不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $input['art_thumb'] = $input['art_thumb']? $input['art_thumb']: '/storage/images/001.png';
                $res = Article::where('art_id', $art_id)->update($input);
                if($res){
                    return redirect('admin/article');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.article.index');
        }
    }
    //delete.admin/article/{article}  删除单个文章
    public function destroy($art_id)
    {
        $field = Article::find($art_id);
        $disk = Storage::disk('local');
        $disk->delete($field['art_thumb']);
        $res = Article::where('art_id', $art_id)->delete();
        if($res){
            $data = [
                'msg' => '文章删除成功',
                'status' => '0',
            ];
            DB::statement('ALTER TABLE blog_article DROP art_id');
            DB::statement('ALTER TABLE blog_article ADD art_id INT(11) NOT NULL FIRST');
            DB::statement('ALTER TABLE blog_article MODIFY COLUMN art_id INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY(art_id)');
        }else{
            $data = [
                'msg'=>'文章删除失败， 请稍后重试',
                'status'=>'1',
            ];
        }
        return $data;
    }
    //get.admin/article/{article}
    public function show()
    {

    }
}
