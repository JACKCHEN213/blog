<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //
    public function changeContent()
    {
        $input = Input::except('_token');
        foreach($input['conf_id'] as $key => $value){
            Config::where('conf_id', $value)->update(['conf_content' => $input['conf_content'][$key]]);
        }
        $this->putFile();
        return back()->with('errors', '配置项更新成功');
    }
    public function changeOrder()
    {
        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        if($conf->update()){
            $data = [
                'status' => 0,
                'msg' => '配置项排序更新成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置项排序更新失败,请稍后重试',
            ];
        }
        return $data;
    }

    public function putFile()
    {
        $config = Config::pluck('conf_content', 'conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config, true).';';
        file_put_contents($path, $str);
    }
    //get.admin/config        全部配置项列表
    public function index()
    {
        $data = Config::orderBy('conf_order', 'ASC')->get();
        foreach($data as $key => $value){
            switch($value->field_type){
                case 'input':
                    $value->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$value->conf_content.'">';
                    break;
                case 'textarea':
                    $value->_html = '<textarea type="text" name="conf_content[]">'.$value->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr = explode(',', $value->field_value);
                    $value->_html = '';
                    foreach($arr as $m => $n){
                        $r = explode('|', $n);
                        $c = $r[0] == $value->conf_content? " checked ": "";
                        $value->_html .= '<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1].'　';
                    }
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }

    //get.admin/config/create            //添加配置项
    public function create()
    {
        return view('admin.config.add');
    }
    //post.admin/config                   //添加配置项提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'conf_name'=>'required',
                'conf_title'=>'required',
            ];
            $message = [
                'conf_name.required'=>'配置项名称不能为空',
                'conf_title.required'=>'配置标题不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $input['conf_order'] = $input['conf_order']? $input['conf_order']: 0;
                $re = Config::create($input);
                if($re){
                    return redirect('admin/config');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.config.add');
        }

    }
    //get.admin/config/{Config}/edit  编辑配置项
    public function edit($conf_id)
    {
        $data = Config::find($conf_id);
        return view('admin.config.edit', compact('data'));
    }
    //put|patch.admin/config/{Config}   更新配置项
    public function update($conf_id)
    {
        if($input = Input::except('_token', '_method')){
            $rules = [
                'conf_name'=>'required',
                'conf_title'=>'required',
            ];
            $message = [
                'conf_name.required'=>'配置项名称不能为空',
                'conf_title.required'=>'配置标题不能为空',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $res = Config::where('conf_id', $conf_id)->update($input);
                if($res){
                    $this->putFile();
                    return redirect('admin/config');
                }else{
                    return back()->with('errors', '发生未知错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.config.index');
        }
    }
    //delete.admin/config/{Config}  删除单个配置项
    public function destroy($conf_id)
    {
        $res = Config::where('conf_id', $conf_id)->delete();
        if($res){
            $this->putFile();
            $data = [
                'msg' => '配置项删除成功',
                'status' => '0',
            ];
            DB::statement('ALTER TABLE blog_Config DROP conf_id');
            DB::statement('ALTER TABLE blog_Config ADD conf_id INT(11) NOT NULL FIRST');
            DB::statement('ALTER TABLE blog_Config MODIFY COLUMN conf_id INT(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY(conf_id)');
        }else{
            $data = [
                'msg'=>'配置项删除失败， 请稍后重试',
                'status'=>'1',
            ];
        }
        return $data;
    }
    //get.admin/config/{Config}
    public function show()
    {

    }
}
