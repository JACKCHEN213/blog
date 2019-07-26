<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'link_name' => 'QQ',
                'link_title' => '国内最大的社交软件',
                'link_url' => 'https://im.qq.com/',
                'link_order' => 1,
            ],
            [
                'link_name' => '百度',
                'link_title' => '国内使用最多的搜索引擎',
                'link_url' => 'https://www.baidu.com/',
                'link_order' => 2,
            ],
            [
                'link_name' => '支付宝',
                'link_title' => '国内口碑最好的支付平台',
                'link_url' => 'https://www.alipay.com/',
                'link_order' => 3,
            ],
        ];
        DB::table('links')->insert($data);
    }
}
