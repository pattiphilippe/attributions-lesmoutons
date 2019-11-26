<?php

namespace App\Http\Controllers;

use App\Commit;
use Illuminate\Http\Request;
use \PDO;

// The commits controller does not query a model because the commits table has
// been manually added to the database.
class CommitController extends Controller
{

    public function index()
    {
        $commits = \DB::table('commits')->orderBy('created_at', 'desc')->get();
        return view('commits.index', [
            'commits' => $commits
        ]);
    }

}
