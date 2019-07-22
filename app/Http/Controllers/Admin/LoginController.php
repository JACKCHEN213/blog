<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/code.class.php';

class LoginController extends CommonController
{
    //
    public function login()
    {
        if($input = Input::all()){
            $code = new \code;
            $_code = $code->get();
            if(strtolower($input['code']) != strtolower($_code)){
                return back()->with(['msg'=>'验证码错误', 'name'=>$input['user_name'], 'pass'=>$input['user_pass']]);
            }
            $user = User::find(1);
            if($input['user_name'] != $user['user_name'] || $input['user_pass'] != Crypt::decrypt($user['user_pass'])){
                return back()->with(['msg'=>'用户名或密码错误', 'name'=>$input['user_name'], 'pass'=>$input['user_pass']]);
            }else{
                session(['user'=>$user]);
                return redirect('admin/index');
            }
        }else{
            session(['user'=>null]);
            return view('admin.login');
        }
    }
    public function code()
    {
        $code = new \code;
        $code->make();
    }
}
