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
        if(request()->has('deleteGroup')) {
            $name = request('deleteGroup');
            $this->removeGroup($name);
        }
        return view('groupes.index', [
            'groupes' => Groupe::all(),
        ]);
    }

    public function removeGroup($group_name) {
        $group = new Groupe;
        $group->remove($group_name);
    }

    public function uploadFileGroup(Request $request)
    {
        Util::handleCSVInsertion($request, [
            "nom",
        ], Groupe::class);

        return redirect('groupes');
    }
}
