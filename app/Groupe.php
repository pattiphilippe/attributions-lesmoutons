<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $primaryKey = "nom";
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
