<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
    //post.admin/category
    public function restore()
    {

    }//get.admin/category/create
    public function create()
    {

    }
    //delete.admin/category/{category} y
    public function destroy()
    {

    }
    //get.admin/category/{category}
    public function show()
    {

    }
    //put|patch.admin/category/{category}
    public function update()
    {

    }
    //get.admin/category/{category}/edit
    public function edit()
    {

    }
}
