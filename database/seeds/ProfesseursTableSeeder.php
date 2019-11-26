<?php

use App\Professeur;
use Illuminate\Database\Seeder;

class ProfesseursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Professeur::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('professeurs')->insert([
            [
                'acronyme' => 'NVS',
                'nom' => 'Vansteenkiste',
                'prenom' => 'Nicolas',
            ],
            [
                'acronyme' => 'ABS',
                'nom' => 'Absil',
                'prenom' => 'Romain',
            ],
            [
                'acronyme' => 'MCD',
                'nom' => 'Codutti',
                'prenom' => 'Marco',
            ],
            [
                'acronyme' => 'NPX',
                'nom' => 'Pettiaux',
                'prenom' => 'Nicolas',
            ],
            [
                'acronyme' => 'NRI',
                'nom' => 'Richard',
                'prenom' => 'Nicolas',
            ],
        ]);
    }
}
