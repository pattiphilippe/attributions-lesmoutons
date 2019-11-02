<?php

namespace App\Http\Controllers;

use App\Professeur;
use Exception;
use Illuminate\Http\Request;
use Session;

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

    public function uploadFile(Request $request)
    {
        if ($request->file == null) {
            Session::flash('warning', 'Please choose a file');
        } else {
            $file = $request->file('file');

            // File details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // File extension
            $valid_extension = array("csv");

            // 2MB in bytes
            $maxFileSize = 2097152;

            // Check file extension
            if (in_array(strtolower($extension), $valid_extension)) {

                // Check file size
                if ($fileSize <= $maxFileSize) {
                    try {
                        $location = 'uploads';
                        $file->move($location, $filename);
                        $filepath = public_path($location . "/" . $filename);
                        $file = fopen($filepath, "r");
                        $importData_arr = array();
                        $i = 0;

                        while (($filedata = fgetcsv($file, 1000, ",")) !== false) {
                            $num = count($filedata);

                            if ($i == 0) {
                                $i++;
                                continue;
                            }
                            for ($c = 0; $c < $num; $c++) {
                                $importData_arr[$i][] = $filedata[$c];
                            }
                            $i++;
                        }

                        fclose($file);

                        foreach ($importData_arr as $importData) {
                            $insertData = array(
                                "acronyme" => $importData[0],
                                "nom" => $importData[1],
                                "prenom" => $importData[2]);

                            Professeur::insertData($insertData);
                        }

                        Session::flash('success', 'Import Successful');
                    } catch (Exception $e) {
                        // return back()->withError($e->getMessage())->withInput();
                        Session::flash('warning', 'The content of the file is inappropriate and cannot be processed. Check if it\'s well formated and the data is correct');
                    }
                } else {
                    Session::flash('warning', 'File too large. File must be less than 2MB');
                }
            } else {
                Session::flash('warning', 'Invalid File Extension');
            }
        }

        return redirect('professeurs');
    }
}
