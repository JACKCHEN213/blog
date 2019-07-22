<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get.admin/category        全部分类列表
    public function index()
    {
        return view('admin.category.index')->with('data', (new Category)->tree());
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        if($cate->update()){
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败,请稍后重试s',
            ];
        }
        return $data;
    }

    //get.admin/category/create            //添加分类
    public function create()
    {
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.add')->with('data', $data);
    } //post.admin/category                   //添加分类提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'cate_name'=>'required',
            ];
            $message = [
                'cate_name.required'=>'分类名称不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $re = Category::create($input);
                if($re){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.category.add');
        }
    }
    //get.admin/category/{category}/edit  编辑分类
    public function edit($cate_id)
    {
        $field = Category::find($cate_id);
        $data = Category::where('cate_pid', 0)->get();
        return view('admin.category.edit', compact('field', 'data'));
    }
    //put|patch.admin/category/{category}   更新分类
    public function update($cate_id)
    {
        if($input = Input::except('_token', '_method')){
            $rules = [
                'cate_name'=>'required',
            ];
            $message = [
                'cate_name.required'=>'分类名称不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $res = Category::where('cate_id', $cate_id)->update($input);
                if($res){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.category.edit');
        }
    }
    //delete.admin/category/{category}  删除单个分类
    public function destroy($cate_id)
    {
        $res = Category::where('cate_id', $cate_id)->delete();
        if($res){
            $data = [
                'msg' => '分类删除成功',
                'status' => '0',
            ];
            Category::where('cate_pid', $cate_id)->update(['cate_pid'=>0]);
            DB::statement('ALTER TABLE blog_category DROP cate_id');
            DB::statement('ALTER TABLE blog_category ADD cate_id INT(11) NOT NULL FIRST');
            DB::statement('ALTER TABLE blog_category MODIFY COLUMN cate_id INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY(cate_id)');
        }else{
            $data = [
                'msg'=>'分类删除失败， 请稍后重试',
                'status'=>'1',
            ];
        }
        return $data;
    }
    //get.admin/category/{category}
    public function show()
    {

    }
}
