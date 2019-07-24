<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //
    public function changeOrder()
    {
        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        if($nav->update()){
            $data = [
                'status' => 0,
                'msg' => '自定义导航排序更新成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '自定义导航排序更新失败,请稍后重试',
            ];
        }
        return $data;
    }
    //get.admin/navs        全部自定义导航列表
    public function index()
    {
        $data = Navs::orderBy('nav_order', 'ASC')->get();
        return view('admin.navs.index',compact('data'));
    }

    //get.admin/navs/create            //添加自定义导航
    public function create()
    {
        return view('admin.navs.add');
    }
    //post.admin/navs                   //添加自定义导航提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'nav_name'=>'required',
                'nav_url'=>'required',
            ];
            $message = [
                'nav_name.required'=>'导航名称不能为空',
                'nav_url.required'=>'导航地址不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $input['nav_order'] = $input['nav_order']? $input['nav_order']: 0;
                $re = Navs::create($input);
                if($re){
                    return redirect('admin/navs');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.navs.add');
        }

    }
    //get.admin/navs/{Navs}/edit  编辑自定义导航
    public function edit($nav_id)
    {
        $data = Navs::find($nav_id);
        return view('admin.navs.edit', compact('data'));
    }
    //put|patch.admin/navs/{Navs}   更新自定义导航
    public function update($navst_id)
    {
        if($input = Input::except('_token', '_method')){
            $rules = [
                'nav_name'=>'required',
                'nav_url'=>'required',
            ];
            $message = [
                'nav_name.required'=>'自定义导航不能为空',
                'nav_url.required'=>'自定义导航地址不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $res = Navs::where('nav_id', $navst_id)->update($input);
                if($res){
                    return redirect('admin/navs');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.navs.index');
        }
    }
    //delete.admin/navs/{Navs}  删除单个自定义导航
    public function destroy($nav_id)
    {
        $field = Navs::find($nav_id);
        $disk = Storage::disk('local');
        $disk->delete($field['nav_logo']);
        $res = Navs::where('nav_id', $nav_id)->delete();
        if($res){
            $data = [
                'msg' => '自定义导航删除成功',
                'status' => '0',
            ];
            DB::statement('ALTER TABLE blog_Navs DROP nav_id');
            DB::statement('ALTER TABLE blog_Navs ADD nav_id INT(11) NOT NULL FIRST');
            DB::statement('ALTER TABLE blog_Navs MODIFY COLUMN nav_id INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY(nav_id)');
        }else{
            $data = [
                'msg'=>'自定义导航删除失败， 请稍后重试',
                'status'=>'1',
            ];
        }
        return $data;
    }
    //get.admin/navs/{Navs}
    public function show()
    {

    }
}
