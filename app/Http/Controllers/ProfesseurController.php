<?php

namespace App\Http\Controllers;

use App\Professeur;
use App\Utilitaries\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('professeurs.index', [
            'professeurs' => Professeur::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('professeurs.create');
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

        Professeur::create([
            'acronyme' => $validatedData['acronyme'],
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
        ]);

        return redirect()->route('professeurs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function show(Professeur $professeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function edit(Professeur $professeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professeur $professeur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Professeur  $professeur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professeur $professeur)
    {
        //
    }

    public function uploadFileProfessor(Request $request)
    {
        Util::handleCSVInsertion($request, [
            "acronyme", "nom", "prenom",
        ], Professeur::class, $request->has('check_delete_table'));

        return redirect('professeurs');
    }

    public function rules(Request $request)
    {
        return [
            'acronyme' => [
                'required', 'size:3',
                Rule::unique('professeurs', 'acronyme')->where(function ($query) use ($request) {
                    return $query->where('acronyme', $request->acronyme);
                })],
            'nom' => [
                'required',
            ],
            'prenom' => [
                'required',
            ],
        ];
    }

    public static function errorMessages()
    {
        return [
            'acronyme.required' => 'Le champ :acronyme est obligatoire.',
            'unique' => 'Le professeur :input existe déjà.',
            'size' => 'Le champ acronyme doit être de taille :size.',
            'nom.required' => 'Le champ :nom est obligatoire',
        ];
    }
}
