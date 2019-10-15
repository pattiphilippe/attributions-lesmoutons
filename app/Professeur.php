<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    protected $primaryKey = 'acronyme';
    protected $keyType = 'string';
    
    public  $timestamps = false;
    public $incrementing = false;
}
