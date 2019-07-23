<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\In;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $input = Input::file('file');
        if($input->isValid()){
            $extension = $input->getClientOriginalExtension();
            $newName = date('YmdHis').mt_rand(100, 999).'.'.$extension;
            $input->move(base_path().'\storage\images', $newName);
            $pathAbs = '/storage/images/'.$newName;
            $data = [
                'pathAbs' => $pathAbs,
                'msg' => '上传成功',
            ];
        }else{
            $data = [
                'msg' => '发生未知错误，上传失败',
            ];
        }
        return $data;
    }


}
