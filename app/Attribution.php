<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribution extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $fillable = [
        'professor_acronyme', 'course_id', 'group_id', 'quadrimester'
    ];

    public $incrementing = false;
    public $timestamps = false;
}
