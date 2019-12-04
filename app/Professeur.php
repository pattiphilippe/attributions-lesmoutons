<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Professeur extends Model
{
    protected $primaryKey = 'acronyme';
    protected $keyType = 'string';
    protected $fillable = [
        'acronyme', 'nom', 'prenom',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public static function insertData($data)
    {
        $value = DB::table('professeurs')->where('acronyme', $data['acronyme'])->get();

        if ($value->count() == 0) {
            DB::table('professeurs')->insert([
                'acronyme' => $data['acronyme'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
            ]);
        }
    }

    public static function deleteAll()
    {
        DB::table('professeurs')->delete();
    }
}
