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
    public function getdocumentsforteacher()
    {
        $this->authorize('isTeacher');
        //Get Information
        $user = auth('api')->user();
        $id = $user->id;

        $users = DB::table('students_profiles')->select('documents.*', 'students_profiles.rollno', 'users.name', 'students_profiles.semester', 'students_profiles.program')->join('documents', 'students_profiles.user_id', '=', 'documents.student_id')->join('users', 'students_profiles.user_id', '=', 'users.id')->where('students_profiles.supervisor_id', '=', $id)->get();
        /*
        $users=DB::table('documents')->select( 'students_profiles.rollno', 'students_profiles.program', 'students_profiles.semester', 'students_profiles.supervisor', 'students_profiles.cgpa' ,'documents.*')
        ->rightJoin('students_profiles', 'documents.student_id', '=', 'students_profiles.id')
        ->where('students_profiles.supervisor_id','=', $id)->orWhere('students_profiles.id','=','documents.student_id')->get();
*/
        return response()->json([
            'data' => $users,
        ]);
    }
    public function singleDocument(Request $request, $doc_id)
    {
        //$doc_id = $request->id;
        // return['Doc ID'=>$doc_id];
        $docdetail = DB::table('documents')->select('*')->where('id', '=', $doc_id)->first();
        //  $path = storage_path('app/public/docs/') . $docdetail->file;
        $path = '../storage/docs/' . $docdetail->file;
       // return ['path'=>$path];
        return response()->json([
          'data' =>   $path
        ]);
        /*$contents = [ 'data' =>   $path,];
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'text/plain');
        return $response;*/
        //return response()->file($path);
        // return ['Path:'=>$path];
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
        if ($request->isupdate == '1') {
            $request->validate([
                'title' => 'required|string',
                'file' => 'required',
                'description' => 'required|string',
                'document_type' => 'required|string',
                'isupdate' => 'required',
                'id' => 'required'
            ]);

            $currentFile = DB::table('documents')->select('file')->where('id', '=', $request->id)->first();
            if ($request->file != $currentFile->file) {
                $filename = $request->title . '_' . $request->document_type . '_' . (date('Y-m-d') . '_' . date('h-i-sa') . '.pdf');
                $filename = strval($filename);
                // return ['message'=>$filename];
                $request->file->storeAs('docs', "$filename", 'public');
                $updateDetails = [
                    'title' => $request->title,
                    'file' => $filename,
                    'description' => $request->description,
                    'document_type' => $request->document_type
                ];
                $filetodelete = storage_path('app/public/docs/') . $currentFile->file;
                if (file_exists($filetodelete)) {
                    @unlink($filetodelete);
                }
            } else {
                $updateDetails = [
                    'title' => $request->title,
                    'description' => $request->description,
                    'document_type' => $request->document_type
                ];
            }
            DB::table('documents')
                ->where('id', $request->id)
                ->update($updateDetails);
            DB::table('students_profiles')
                ->where('user_id', $id)
                ->update(['documents_uploaded' => true]);
            return response()->json([
                'Update' => 'done',
            ]);
        } else if ($request->isupdate == '0') {
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
                'document_type' => $request->document_type,
                'file' => $filename,
                'marks' => 1,
                'feedback' => 'sample',
            ]);
            DB::table('students_profiles')
                ->where('user_id', $id)
                ->update(['documents_uploaded' => true]);
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
