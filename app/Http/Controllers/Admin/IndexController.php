<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Dotenv\Validator;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    //
    public function index()
    {
       return view('admin.index');
    }
    public function info()
    {
        return view('admin.info');
    }
    public function quit()
    {
        session('user', null);
        return redirect('admin/login');
    }
    //修改密码
    public function pass()
    {
        if($input = Input::all()){
            $user = User::find(1);
            $_password = Crypt::decrypt($user->user_pass);
            if($input['password_o'] == $_password){
                $user->user_pass = Crypt::encrypt($input['password']);
                $user->update();
                session('user')->password = $input['password'];
                return back()->with('changed', '密码修改成功');
            }else{
                return back()->with('errors', '原密码输入错误');
            }
        }else{
            session('changed', null);
            return view('admin.pass');
        }
    }
    public function pass_backup()
    {
        if($input = Input::all()){
            $rules = [
                'password'=>'required|between:6, 20|confirmed',
            ];
            $message = [
                'password.required'=>'密码不能为空',
                'password.between'=>'密码在6-20之间',
                'password.confirmed'=>'两次密码不一致',
            ];
            $validater = Validator::make($input, $rules, $message);
            if($validater->passes()){
                $user = User::find(1);
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o'] == $_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return redirect('admin/info');
                }else{
                    return back()->with('errors', '原密码输入错误');
                }
            }else{
                return back()->withErrors($validater);
            }
        }else{
            return view('admin.pass');
        }
    }
}
