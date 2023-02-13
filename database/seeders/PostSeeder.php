<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('posts')->insert([
            'title' => '京都旅行',
            'content' =>'京都に旅行にいった話',
            'prefecture' =>'京都',
            'user_id' => '18',
            'created_at' => now(),
            'updated_at'=> now()
        ]);
    }
}
