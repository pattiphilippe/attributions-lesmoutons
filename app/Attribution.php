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


    public function professeur() 
    {
        return $this->belongsTo('App\Professeur');
    }

    public function course() 
    {
        return $this->belongsTo('App\Course');
    }

    public function groupe() 
    {
        return $this->belongsTo('App\Groupe');
    }
}
