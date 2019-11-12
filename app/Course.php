<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'title', 'credits', 'bm1_hours', 'bm2_hours'
    ];

    public $incrementing = false;
    public $timestamps = false;
}
