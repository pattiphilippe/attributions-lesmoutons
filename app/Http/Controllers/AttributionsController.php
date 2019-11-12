<?php

namespace App\Http\Controllers;

use App\Attribution;
use App\Course;
use App\Groupe;
use App\Professeur;
use Illuminate\Http\Request;

class AttributionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('attributions.index', [
            'attributions' => Attribution::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attributions.create', [
            'professors' => Professeur::all(),
            'courses' => Course::all(),
            'groupes' => Groupe::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'professor' => 'required|min:3|max:3',
            'course' => 'required',
            'group' => 'required',
        ]);

        $course_id = Course::where('title', $request->course)->firstOrFail()->id;

        Attribution::create([
            'professor_acronyme' => $validatedData['professor'],
            'course_id' => $course_id,
            'group_id' => $validatedData['group'],
            'quadrimester' => 2,
        ]);

        return redirect()->route('attributions.index');
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
}
