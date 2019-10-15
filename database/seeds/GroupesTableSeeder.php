<?php

use App\Groupe;
use Illuminate\Database\Seeder;

class GroupesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Groupe::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('groupes')->insert([
            [
                'nom' => 'A1'
            ],
            [
                'nom' => 'A11'

            ],
            [
                'nom' => 'A111'

            ],
            [
                'nom' => 'A1111'

            ],
            [
                'nom' => 'A11111'

            ],
        ]);
    }
}
