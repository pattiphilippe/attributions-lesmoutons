<?php

namespace App\Http\Controllers;
use App\Groupe;
use App\Course;
use Illuminate\Http\Request;
use App\Utilitaries\Util;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['filter'])) {
            $select = $_GET['filter'];
            if($select == 'coursesAttributed') {
                $count = Groupe::count();
                return view('courses.index', [
                    'courses' => Course::has('attributions')
                    ->groupBy('courses.id')
                    ->get()
                ]);
            }else if($select == 'coursesNonAttributed') {
                return view('courses.index', [
                    'courses' => Course::doesntHave('attributions')->get()
                ]);
            }else {
                return view('courses.index', [
                    'courses' => Course::all()
                ]);
            }
        }
        return view('courses.index', [
            'courses' => Course::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadFileCourse(Request $request)
    {
        Util::handleCSVInsertion($request, [
            "id", "title", "credits","BM1_hours","BM2_hours",
        ], Course::class);

        return redirect('courses');
    }
}
