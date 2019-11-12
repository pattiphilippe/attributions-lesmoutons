<?php

use App\Attribution;
use Illuminate\Database\Seeder;

class AttributionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Attribution::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('attributions')->insert([
            [
                'id'=>'12222',
                'professor_acronyme' => 'ABS',
                'course_id' => 'PRJG5',
                'group_id' => 'A1',
                'quadrimester' => '5',
            ],
            [
                'id' => '13223',                
                'professor_acronyme' => 'MCD',
                'course_id' => 'WEBG5',
                'group_id' => 'B1',
                'quadrimester' => '5',
            ],
        ]);
    }
}
