<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'title', 'credits', 'BM1_hours', 'BM2_hours'
    ];

    public $incrementing = false;
    public $timestamps = false;
}
