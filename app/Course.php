<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'title', 'credits', 'BM1_hours', 'BM2_hours',
    ];

    public $incrementing = false;
    public $timestamps = false;

    public static function insertData($data)
    {
        $value = DB::table('courses')->where('id', $data['id'])->get();

        if ($value->count() == 0) {
            DB::table('courses')->insert([
                'id' => $data['id'],
                'title' => $data['title'],
                'credits' => $data['credits'],
                'BM1_hours' => $data['BM1_hours'],
                'BM2_hours' => $data['BM2_hours'],
            ]);
        }
    }

    public function remove($id) {
        DB::table('courses')->where('id', '=', $id)->delete();
    }

    public function attributions()
    {
        return $this->hasMany('App\Attribution');
    }
}
