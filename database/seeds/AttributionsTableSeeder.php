<?php

use Illuminate\Database\Seeder;
use App\Attribution;

class AttributionsTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Attribution::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('attributions')->insert([
            [
                'professor_acronyme' => 'ABS',
                'course_id' => 'PRJG5',
                'group_id' => 'A1',
                'quadrimester' => '5',
            ],
            [
                'professor_acronyme' => 'MCD',
                'course_id' => 'WEBG5',
                'group_id' => 'B1',
                'quadrimester' => '5',
            ],
        ]);
    }

}
