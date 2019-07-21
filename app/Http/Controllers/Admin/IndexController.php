<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
