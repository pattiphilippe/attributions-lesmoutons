<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Groupe extends Model
{
    protected $primaryKey = "nom";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public static function insertData($data)
    {
        $value = DB::table('groupes')->where('nom', $data['nom'])->get();

        if ($value->count() == 0) {
            DB::table('groupes')->insert([
                'nom' => $data['nom'],
            ]);
        }
    }
}
