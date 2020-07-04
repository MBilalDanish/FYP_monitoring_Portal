<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isStudent');
        $id = auth('api')->user()->id;
        $users = DB::table('documents')->where('student_id', $id)->get();
        return response()->json([
            'data' => $users,
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
        $this->authorize('isStudent');
        $id = auth('api')->user()->id;
        if ($request->isupdate =='1') { 
            $request->validate([
                'title' => 'required|string',
                'file' => 'required',
                'description' => 'required|string',
                'document_type' => 'required|string',
                'isupdate' => 'required',
                'id' => 'required'
            ]);
            
            $currentFile=DB::table('documents')->select('file')->where('id','=',$request->id)->first();
            if($request->file!=$currentFile->file){
                $filename = $request->title . '_' . $request->document_type . '_' . (date('Y-m-d') . '_' . date('h-i-sa') . '.pdf');
                $filename = strval($filename);
                // return ['message'=>$filename];
                $request->file->storeAs('docs', "$filename", 'public');
                $updateDetails = [
                    'title' => $request->title,
                    'file' => $filename,
                    'description' => $request->dexcription,
                    'document_type' => $request->document_type
                ];
            }
            else{
                $updateDetails = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'document_type' => $request->document_type
                ];
                
            }
            DB::table('documents')
            ->where('id', $request->id)
            ->update($updateDetails);
            return response()->json([
                'Update' => 'done',
            ]);

        } else if($request->isupdate == '0') {
            $request->validate([
                'title' => 'required|string',
                'file' => 'required',
                'description' => 'required|string',
                'document_type' => 'required|string',
                'isupdate' => 'required'
            ]);
            $filename = $request->title . '_' . $request->document_type . '_' . (date('Y-m-d') . '_' . date('h-i-sa') . '.pdf');
            $filename = strval($filename);
            $request->file->storeAs('docs', "$filename", 'public');
            DB::table('documents')->insert([
                'student_id' => $id,
                'title' => $request->title,
                'description' => $request->description,
                'document_type' =>$request->document_type,
                'file' =>$filename,
                'marks' => 1,
                'feedback' => 'sample',

             
            ]);
            // Read file contents...
            //$contents = file_get_contents($request->file->path());
            return response()->json([
                'Insert' => 'done',
            ]);
        }
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
    public function update(Request $request, $file)
    {
        $this->authorize('isStudent');
        $filename = $request->title . '_' . $request->document_type . '_' . (date('Y-m-d') . '_' . date('h-i-sa') . '.pdf');
        $filename = strval($filename);
        // return ['message'=>$filename];

        if ($file != null)
            $file->storeAs('docs', "$filename", 'public');
        return ['success'];
        if ($request->file != null)
            $request->file->storeAs('docs', "$filename", 'public');
        return [
            'ID' => $request->id,
            'Type' => $request->document_type,
            'Description' => $request->description,
            'title' => $request->title
        ];
    }
    /*
public function updateDocument(Request $request,$data){
   // return $request->all();
    $data['file']->storeAs('docs', "ooooo", 'public');
    return ['success'=>'done'];
}*/
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isStudent');
        // $user = User::findOrFail($id);
        //$user->delete();
        DB::table('documents')->where('id', '=', $id)->delete();
        return ['message' => 'User Deleted'];
    }
}
