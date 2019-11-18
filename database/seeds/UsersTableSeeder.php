<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            [
                'email' => '49877@etu.he2b.be',
                'password' => bcrypt('root'),
            ],
            [
                'email' => '42835@etu.he2b.be',
                'password' => bcrypt('root'),                
            ],
            [
                'email' => '44343@etu.he2b.be',
                'password' => bcrypt('root'),
            ],
            [
                'email' => '43197@etu.he2b.be',
                'password' => bcrypt('root'),
            ],
            [
                'email' => '47923@etu.he2b.be',
                'password' => bcrypt('root'),
            ],
            [
                'email' => '49737@etu.he2b.be',
                'password' => bcrypt('root'),
            ],
            [
                'email' => '42971@etu.he2b.be',
                'password' => bcrypt('root'),
            ],
            [
                'email' => '43256@etu.he2b.be',
                'password' => bcrypt('root'),            ],
        ]);
    }
}
