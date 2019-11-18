<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribution extends Model
{
    protected $fillable = [
        'professor_acronyme', 'course_id', 'group_id', 'quadrimester',
    ];

    public $timestamps = false;

    function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function professeur() 
    {
        return $this->belongsTo('App\Professeur');
    }

    public function groupe() 
    {
        return $this->belongsTo('App\Groupe');
    }

}
