<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedCategoriesData extends Migration
{
    public function up()
    {
        $categories = [
            [
                'name'        => '编程',
                'description' => '我们不生产代码，我们只是代码的搬运工',
            ],
            [
                'name'        => '算法',
                'description' => '解决问题的方法不止一种，但用算法解决往往会比较简单',
            ],
            [
                'name'        => '随笔',
                'description' => '分享自己的一些对这个世界的理解',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    public function down()
    {
        DB::table('categories')->truncate();
    }
}
