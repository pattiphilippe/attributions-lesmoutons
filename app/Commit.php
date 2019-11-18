<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'message', 'author'
    ];

    public $timestamps = true;
}
