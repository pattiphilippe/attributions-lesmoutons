<?php

namespace App\Http\Controllers;

use App\Attribution;
use App\Course;
use App\Groupe;
use App\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PDF;

class AttributionsController extends Controller
{
    /**
     * Display a listing of the resource
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
        $validatedData = Validator::make(
            $request->all(),
            $this->rules($request),
            $this->errorMessages())
            ->validate();

        Attribution::create([
            'professor_acronyme' => $validatedData['professor'],
            'course_id' => $validatedData['course'],
            'group_id' => $validatedData['group'],
            'quadrimester' => 2, //TODO change this value, it's only here for debugging before schema change
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
        $attribution = Attribution::find($id);
        return view('attributions.edit', [
            'attribution' => $attribution,
            'professors' => Professeur::all(),
            'courses' => Course::all(),
            'groupes' => Groupe::all(),
        ]);

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
        $validatedData = Validator::make(
            $request->all(),
            $this->rules($request),
            $this->errorMessages())
            ->validate();

        $attribution = Attribution::find($id);
        $attribution->update(['professor_acronyme' => $validatedData['professor'],
        'course_id' => $validatedData['course'],
        'group_id' => $validatedData['group'],
        'quadrimester' => 2, 
        ]);
        return redirect()->route('attributions.index')
        ->with('success','Attribution mise à jour avec succès !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribution = Attribution::find($id);
        $attribution->delete();
        return redirect()->route('attributions.index')->with('success','Attribution supprimée avec succès !');
    }

    public function rules(Request $request)
    {
        return [
            'professor' => [
                'required', 'size:3', 'exists:professeurs,acronyme',
                Rule::unique('attributions', 'professor_acronyme')->where(function ($query) use ($request) {
                    return $query->where('professor_acronyme', $request->professor)
                        ->where('course_id', $request->course)
                        ->where('group_id', $request->group);
                })],
            'course' => [
                'required', 'exists:courses,id',
                Rule::unique('attributions', 'course_id')->where(function ($query) use ($request) {
                    return $query->where('professor_acronyme', '!=', $request->professor)
                        ->where('course_id', $request->course)
                        ->where('group_id', $request->group);
                })],
            'group' => ['required', 'exists:groupes,nom'],
        ];
    }

    public static function errorMessages()
    {
        return [
            'required' => 'Le champ :attribute est obligatoire.',
            'professor.exists' => 'Le professeur :input n\'existe pas !',
            'professor.unique' => 'Le professeur :input donne déjà ce cours à ce groupe.',
            'course.unique' => 'Un professeur est déjà attribué à ce cours et ce groupe.',
            'course.exists' => 'Le cours :input n\'existe pas !',
            'group.exists' => 'Le groupe :input n\'existe pas !',
            'size' => 'Le champ :attribute doit être de taille :size.',
            'between' => 'Le valeur :input du champ :attribute n\'est pas de longueur :min - :max.',
        ];
    }

    public function downloadFileAttribution() 
    {
        $attributions = Attribution::all();
        $pdf = PDF::loadView('attributions.pdf', compact('attributions'));
        return $pdf->download('attributions.pdf');
    }
}
