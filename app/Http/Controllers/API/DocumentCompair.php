<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\PdfParser;
use Illuminate\Support\Facades\DB;

class DocumentCompair extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        set_time_limit(3600);
    }


    public function multiexplode($delimiters, $string)
    {
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }

    public function compare($pathOfFile1, $pathOfFile2)
    {
        $percent = 0;
        $words1 = PdfParser::parseFile($pathOfFile1);
        $words2 = PdfParser::parseFile($pathOfFile2);
        $sep = array(' ', '. ', '\t', '\n');
        $words_ar1 = $this->multiexplode($sep, $words1);
        $words_ar2 = $this->multiexplode($sep, $words2);
        $i = 0;
        $size = sizeof($words_ar1);
        while ($i < $size) {
            $temp = $i;
            for ($j = 0; $j < sizeof($words_ar2); $j++) {
                if (!empty($words_ar1[$i]) && !empty($words_ar2[$j])) {
                    if ($words_ar1[$i] == $words_ar2[$j]) {
                        $iter = 0;
                        while (($words_ar1[$i + $iter] === $words_ar2[$j + $iter])) {
                            $iter++;
                            if (empty($words_ar1[$i + $iter]) || empty($words_ar2[$j + $iter])) break;
                        }
                        if ($iter > 3) {
                            $percent += ($iter / sizeof($words_ar1)) * 100;
                        }
                        $i = $i + $iter;
                    }
                }
            }
            if ($i == $temp) $i++;
        }
        return $percent;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $this->authorize('isTeacher');
        $docs = DB::table('documents')->where('id', '<>', $request->d_id)->select('*')->get()->toArray();
        $fileToCom = DB::table('documents')->where('id', '=', $request->d_id)->select('file')->first();
        $file = $fileToCom->file;
        $result = array();
        $path2 = storage_path('app/public/docs/') . $file;
        if (file_exists($path2)) {
            for ($i = 0; $i < count($docs); $i++) {
                $path1 = storage_path('app/public/docs/') . $docs[$i]->file;
                if (file_exists($path1)) {
                    $per = $this->compare($path1, $path2);
                    $per = ceil($per);
                    $arr = array('fileName' => $docs[$i]->file, 'percentage' => $per, 'id' => $docs[$i]->id, 'name' => $docs[$i]->title);
                    array_push($result, $arr);
                    
                } else {
                    continue;
                }
            }
        }

        return response()->json([
            'data' => $result
        ]);
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
