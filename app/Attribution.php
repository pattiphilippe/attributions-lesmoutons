<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribution extends Model
{
    protected $fillable = [
        'professor_acronyme', 'course_id', 'group_id', 'quadrimester'
    ];

    public $timestamps = false;
}
