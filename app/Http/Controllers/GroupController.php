<?php

namespace App\Http\Controllers;

use App\Groupe;
use App\Utilitaries\Util;
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

    public function uploadFileGroup(Request $request)
    {
        Util::handleCSVInsertion($request, [
            "nom",
        ], Groupe::class);

        return redirect('groupes');
    }
}
