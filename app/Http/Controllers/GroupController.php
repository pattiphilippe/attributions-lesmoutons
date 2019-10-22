<?php

namespace App\Http\Controllers;
use App\Groupe;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('groupes.index', [
            'groupes' => Groupe::all(),
        ]);
    }
}
