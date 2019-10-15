<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $primaryKey = "name";
    protected $keyType = 'string';
    public $incrementing = false;
}
