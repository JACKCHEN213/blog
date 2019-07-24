<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //
    public function changeOrder()
    {
        $input = Input::all();
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        if($link->update()){
            $data = [
                'status' => 0,
                'msg' => '友情链接排序更新成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '友情链接排序更新失败,请稍后重试',
            ];
        }
        return $data;
    }
    //get.admin/links        全部友情链接列表
    public function index()
    {
        $data = Links::orderBy('link_order', 'ASC')->get();
       return view('admin.links.index',compact('data'));
    }

    //get.admin/links/create            //添加友情链接
    public function create()
    {
        return view('admin.links.add');
    }
    //post.admin/links                   //添加友情链接提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'link_name'=>'required',
                'link_url'=>'required',
            ];
            $message = [
                'link_name.required'=>'友情链接不能为空',
                'link_url.required'=>'友情链接地址不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $input['link_order'] = $input['link_order']?  $input['link_order']: 0;
                $re = Links::create($input);
                if($re){
                    return redirect('admin/links');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.links.add');
        }

    }
    //get.admin/links/{links}/edit  编辑友情链接
    public function edit($link_id)
    {
        $data = Links::find($link_id);
        return view('admin.links.edit', compact('data'));
    }
    //put|patch.admin/links/{links}   更新友情链接
    public function update($linkt_id)
    {
        if($input = Input::except('_token', '_method')){
            $rules = [
                'link_name'=>'required',
                'link_url'=>'required',
            ];
            $message = [
                'link_name.required'=>'友情链接不能为空',
                'link_url.required'=>'友情链接地址不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $res = Links::where('link_id', $linkt_id)->update($input);
                if($res){
                    return redirect('admin/links');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.links.index');
        }
    }
    //delete.admin/links/{links}  删除单个友情链接
    public function destroy($link_id)
    {
        $field = Links::find($link_id);
        $disk = Storage::disk('local');
        $disk->delete($field['link_logo']);
        $res = Links::where('link_id', $link_id)->delete();
        if($res){
            $data = [
                'msg' => '友情链接删除成功',
                'status' => '0',
            ];
            DB::statement('ALTER TABLE blog_links DROP link_id');
            DB::statement('ALTER TABLE blog_links ADD link_id INT(11) NOT NULL FIRST');
            DB::statement('ALTER TABLE blog_links MODIFY COLUMN link_id INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY(link_id)');
        }else{
            $data = [
                'msg'=>'友情链接删除失败， 请稍后重试',
                'status'=>'1',
            ];
        }
        return $data;
    }
    //get.admin/links/{links}
    public function show()
    {

    }
}
