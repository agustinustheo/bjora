<?php

use Illuminate\Database\Seeder;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->insert([
            ['name' => 'Life'],
            ['name' => 'Tech'],
            ['name' => 'Health'],
        ]);
    }
}
