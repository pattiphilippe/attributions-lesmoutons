<?php

namespace App\Utilitaries;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Session;

class Util
{

    /**
     * Handle the insertion from a CSV file.
     *
     * @param array $attributes Attributes of the model.
     * @param model $model Model to handle.
     */
    public static function handleCSVInsertion($request, $attributes, $model, $deleteBeforeInsert = true)
    {
        try {
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
                        $location = 'uploads';
                        $file->move($location, $filename);
                        $filepath = $location . "/" . $filename;
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

                        if ($deleteBeforeInsert) {
                            $model::deleteAll();
                        }

                        foreach ($importData_arr as $importData) {
                            $insertData = array();

                            for ($index = 0; $index < count($attributes); $index++) {
                                $insertData[$attributes[$index]] = $importData[$index];
                            }

                            $model::insertData($insertData);
                        }

                        Session::flash('success', 'Import Successful');

                    } else {
                        Session::flash('warning', 'File too large. File must be less than 2MB');
                    }
                } else {
                    Session::flash('warning', 'Invalid File Extension');
                }
            }
        } catch (Exception $e) {
            Session::flash('warning', 'The content of the file is inappropriate and cannot be processed. Check if it\'s well formated and the data is correct');

        }
    }
}
