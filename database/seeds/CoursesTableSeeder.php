<?php

use App\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Course::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('courses')->insert([
            [
                'id' => 'MOBG5',
                'title' => 'Développement Mobile',
                'credits' => '5',
                'bm1_hours' => '24',
                'bm2_hours' => '24',
            ],
            [
                'id' => 'PRJG5',
                'title' => 'Gestion de projet',
                'credits' => '6',
                'bm1_hours' => '36',
                'bm2_hours' => '36',
            ],
            [
                'id' => 'WEBG5',
                'title' => 'Débeloppement web III',
                'credits' => '3',
                'bm1_hours' => '24',
                'bm2_hours' => '24',
            ],
            [
                'id' => 'DONG5',
                'title' => 'Persistance de données IV',
                'credits' => '2',
                'bm1_hours' => '12',
                'bm2_hours' => '12',
            ],
            [
                'id' => 'ERPG5',
                'title' => 'Progiciel de gestion intégrée',
                'credits' => '5',
                'bm1_hours' => '24',
                'bm2_hours' => '24',
            ],
        ]);
    }
}
