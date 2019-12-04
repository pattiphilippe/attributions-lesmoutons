<?php

namespace App\Http\Controllers;

use App\Course;
use App\Groupe;
use App\Utilitaries\Util;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('delete')) {
            $id = request('delete');
            $this->removeCourse($id);
        }
        if (request()->has('filter')) {
            switch (request('filter')) {
                case 'coursesAttributed':
                    return view('courses.index', [
                        'courses' => Course::select('attributions.*', 'courses.*')
                            ->join('attributions', 'courses.id', '=', 'attributions.course_id')
                            ->groupBy('courses.id')
                            ->havingRaw('COUNT(*) = ?', [Groupe::count()])
                            ->get(),
                    ]);
                case 'coursesNonAttributed':
                    return view('courses.index', [
                        'courses' => Course::select('attributions.*', 'courses.*')
                            ->leftJoin('attributions', 'courses.id', '=', 'attributions.course_id')
                            ->groupBy('courses.id')
                            ->havingRaw('COUNT(*) != ?', [Groupe::count()])
                            ->get(),
                    ]);
                default:
                    return view('courses.index', [
                        'courses' => Course::all(),
                    ]);
            }
        }
        return view('courses.index', [
            'courses' => Course::all(),
        ]);
    }

    public function removeCourse($course_id) {
        $course = new Course;
        $course->remove($course_id);
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
            "id", "title", "credits", "BM1_hours", "BM2_hours",
        ], Course::class);

        return redirect('courses');
    }
}
