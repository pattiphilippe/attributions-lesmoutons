<?php

namespace App\Http\Controllers;

use App\Professeur;
use Illuminate\Http\Request;
use \PDO;

// The commits controller does not query a model because the commits table has
// been manually added to the database.
class CommitController extends Controller
{

    public static function getCommits($connection) {
        $statement = $connection->query(
            'SELECT id, message, author, insertion FROM commits ORDER BY insertion DESC'
        );
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        $commits = $this->getCommits(\DB::connection()->getPdo());
        return view('commits.index', [
            'commits' => $commits
        ]);
    }

}
