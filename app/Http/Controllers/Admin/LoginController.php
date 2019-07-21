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
        if($Input = Input::all()){
            $code = new \code;
            $_code = $code->get();
            if(strtolower($Input['code']) != strtolower($_code)){
                return back()->with(['msg'=>'验证码错误', 'name'=>$Input['user_name'], 'pass'=>$Input['user_pass']]);
            }
            $user = User::find(1);
            if($Input['user_name'] != $user['user_name'] || $Input['user_pass'] != Crypt::decrypt($user['user_pass'])){
                return back()->with(['msg'=>'用户名或密码错误', 'name'=>$Input['user_name'], 'pass'=>$Input['user_pass']]);
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
