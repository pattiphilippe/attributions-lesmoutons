<?php

namespace App\Http\Controllers;

use App\Attribution;

// The commits controller does not query a model because the commits table has
// been manually added to the database.
class ServiceController extends Controller
{

    public function attributions()
    {
        return Attribution::all();
    }

}
