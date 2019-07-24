<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailController extends Controller
{
    //
    public function send() {
        $message = 'test';
        $to = 'jccc213@163.com';
        $subject = '邮件名称';
        $res = Mail::send(
            'emails.test',
            ['content' => $message],
            function ($message) use($to, $subject) {
                $message->to($to)->subject($subject);
            }
        );
        echo $res;
    }

    public function index()
    {
        $disk = Storage::disk('local');
        $disk->put('test/file.txt', 'aslhdasd');
//        $disk->delete('app/file.txt');
    }
}
