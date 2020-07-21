<?php

namespace App\Http\Controllers\API;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Hamcrest\Arrays\IsArray;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api','verified']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        //$result =User::latest()->paginate(20);'users.*', 'fathername', 'rollno', 'program', 'semester', 'supervisor', 'cgpa', 'photo','designation', 'contact'
        $users = DB::table('users')->select('users.id', 'users.name', 'users.type', 'users.email', 'users.isapproved', 'students_profiles.fathername', 'students_profiles.rollno', 'students_profiles.program', 'students_profiles.semester', 'students_profiles.supervisor', 'students_profiles.cgpa', 'students_profiles.photo as pic', 'teachers_profiles.designation', 'teachers_profiles.contact', 'teachers_profiles.photo')
            ->leftJoin('teachers_profiles', 'users.id', '=', 'teachers_profiles.user_id')
            ->leftJoin('students_profiles', 'users.id', '=', 'students_profiles.user_id')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }
    public function teachers()
    {
        $this->authorize('isAdmin');
        //$result =User::latest()->paginate(20);'users.*', 'fathername', 'rollno', 'program', 'semester', 'supervisor', 'cgpa', 'photo','designation', 'contact'
        $users = DB::table('users')->select('users.id', 'users.name', 'users.type', 'users.email', 'users.isapproved', 'students_profiles.fathername', 'students_profiles.rollno', 'students_profiles.program', 'students_profiles.semester', 'students_profiles.supervisor', 'students_profiles.cgpa', 'students_profiles.photo as pic', 'teachers_profiles.designation', 'teachers_profiles.contact', 'teachers_profiles.photo')
            ->join('teachers_profiles', 'users.id', '=', 'teachers_profiles.user_id')
            ->leftjoin('students_profiles', 'users.id', '=', 'students_profiles.user_id')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }
    public function students()
    {
        $this->authorize('isAdmin');
        //$result =User::latest()->paginate(20);'users.*', 'fathername', 'rollno', 'program', 'semester', 'supervisor', 'cgpa', 'photo','designation', 'contact'
        $users = DB::table('users')->select('users.id', 'users.name', 'users.type', 'users.email', 'users.isapproved', 'students_profiles.fathername', 'students_profiles.rollno', 'students_profiles.program', 'students_profiles.semester', 'students_profiles.supervisor', 'students_profiles.cgpa', 'students_profiles.photo as pic', 'teachers_profiles.designation', 'teachers_profiles.contact', 'teachers_profiles.photo')
            ->leftJoin('teachers_profiles', 'users.id', '=', 'teachers_profiles.user_id')
            ->join('students_profiles', 'users.id', '=', 'students_profiles.user_id')
            ->get();

        return response()->json([
            'data' => $users,
        ]);
    }
    public function supervisors()
    {
        $users = DB::table('users')->select('users.id', 'users.name')->where('type', '=', 'supervisor')
            ->get();

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
        $this->authorize('isAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:200',
            'type' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:8'
        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'password' => Hash::make($request['password'])

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
    public function getStats()
    {
        $docs = DB::table('documents')->select('*')->get();
        $no_docs = sizeof(json_decode($docs));
        $supervisors = DB::table('users')->where('type', '=', 'supervisor')->select('*')->get();
        $no_supervisors = sizeof(json_decode($supervisors));
        $externals = DB::table('users')->where('type', '=', 'external')->select('*')->get();
        $no_externals = sizeof(json_decode($externals));
        $students = DB::table('users')->where('type', '=', 'student')->select('*')->get();
        $no_students = sizeof(json_decode($students));
        $admins = DB::table('users')->where('type', '=', 'admin')->select('*')->get();
        $no_admins = sizeof(json_decode($admins));
        $requests = DB::table('users')->where('isapproved', '=', false)->select('*')->get();
        $no_requests = sizeof(json_decode($requests));
        $stats = array(
            'no_docs' => $no_docs,
            'no_supervisors' => $no_supervisors,
            'no_externals' => $no_externals,
            'no_students' => $no_students,
            'no_admins' => $no_admins,
            'no_requests' => $no_requests,
        );
        return response()->json([
            'data' => $stats,
        ]);
    }
    public function studentprofile()
    {
        $this->authorize('isStudent');
        $id = auth('api')->user()->id;
        // $users1=Auth::user();
        //$id=Auth::user()->id;
        // $user = DB::table('students_profiles')->get();
        //$id = Auth::user()->id;
        //$user = User::findOrFail($id);
        $users = DB::table('users')->select('name', 'email', 'type', 'fathername', 'user_id', 'rollno', 'program', 'semester', 'supervisor', 'cgpa', 'photo', 'isapproved')
            ->leftJoin('students_profiles', 'users.id', '=', 'students_profiles.user_id')
            ->where('users.id', '=',  $id)
            ->get();
        $users[0]->id = $id;
        return $users;
    }
    public function teacherprofile()
    {
        $this->authorize('isTeacher');
        $id = auth('api')->user()->id;
        //$user = User::findOrFail($id);
        $users = DB::table('users')->select('name', 'email', 'type', 'user_id', 'designation', 'contact', 'photo', 'isapproved')
            ->leftJoin('teachers_profiles', 'users.id', '=', 'teachers_profiles.user_id')
            ->where('users.id', '=',  $id)
            ->get();
        $users[0]->id = $id;
        return $users;
    }


    public function updatestudentProfile(Request $request)
    {
        $this->authorize('isStudent');
        //Get Information
        $user = auth('api')->user();
        $id = $user->id;

        //Validate Request
        $this->validate($request, [
            'name' => 'required|string|max:200',
            'fathername' => 'required|string|max:200',
            'rollno' => 'required|string|max:200',
            'program' => 'required|string|max:200',
            'semester' => 'required|string|max:200',
            'cgpa' => 'required',
            'email' => 'required|string|email|max:200|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);
        $result =  DB::table('students_profiles')
            ->select('*')->where('user_id', '=', $id)
            ->first();

        if ($result == null) {
            DB::table('students_profiles')->insert([
                'user_id' => $id,
                'rollno' => 'rollno',
                'program' => 'mcs',
                'semester' => 3,
                'fathername' => 'fathername',
                'supervisor' => 'supervisor',
                'cgpa' => 3.00,
                'photo' => 'photo',
                'documents_uploaded' => 0
            ]);
        }
        //Checking For Photo
        if ($request->photo != null) {
            $result =  DB::table('students_profiles')
                ->select('photo')->where('user_id', '=', $id)
                ->first();
            $currentPhoto = $result->photo;
            if ($request->photo != $currentPhoto) {
                $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(public_path('img/profile/') . $name);
                //$request->photo=$name;
                $request->merge(['photo' => $name]);

                $userPhoto = public_path('img/profile/') . $currentPhoto;
                if (file_exists($userPhoto)) {
                    @unlink($userPhoto);
                }
            }
            $updateDetails2 = [
                'rollno' => $request->get('rollno'),
                'program' => $request->get('program'),
                'semester' => $request->get('semester'),
                'fathername' => $request->get('fathername'),
                'cgpa' => $request->get('cgpa'),
                'photo' => $request->get('photo')
            ];
        } else {

            //Defining Arrays
            $updateDetails2 = [
                'rollno' => $request->get('rollno'),
                'program' => $request->get('program'),
                'semester' => $request->get('semester'),
                'fathername' => $request->get('fathername'),
                'cgpa' => $request->get('cgpa'),

            ];
        }
        //Checking for Password
        if (!empty($request->password)) {
            $pass = Hash::make($request['password']);
            $request->merge(['password' => $pass]);
            $updateDetails1 = [
                'name' => $request->name,
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];
        } else {
            $updateDetails1 = [
                'name' => $request->name,
                'email' => $request->get('email'),
            ];
        }


        //Update Data
        DB::transaction(function () use ($id,  $updateDetails2, $updateDetails1) {
            DB::table('users')
                ->where('id', $id)
                ->update($updateDetails1);
            DB::table('students_profiles')
                ->where('user_id', $id)
                ->update($updateDetails2);
        });
    }



    public function updateteacherProfile(Request $request)
    {
        $this->authorize('isTeacher');
        //Get Information
        $user = auth('api')->user();
        $id = $user->id;

        //Validate Request
        $this->validate($request, [
            'name' => 'required|string|max:200',
            'designation' => 'required|string|max:200',
            'contact' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9',
            'email' => 'required|string|email|max:200|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
        ]);
        $result =  DB::table('teachers_profiles')
            ->select('*')->where('user_id', '=', $id)
            ->first();

        if ($result == null) {
            DB::table('teachers_profiles')->insert([
                'user_id' => $id,
                'designation' => 'designation',
                'contact' => 'contact',
                'photo' => 'photo',
            ]);
        }
        //Checking For Photo
        if ($request->photo != null) {
            $result =  DB::table('teachers_profiles')
                ->select('photo')->where('user_id', '=', $id)
                ->first();
            $currentPhoto = $result->photo;
            if ($request->photo != $currentPhoto) {
                $name = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(public_path('img/profile/') . $name);
                //$request->photo=$name;
                $request->merge(['photo' => $name]);

                $userPhoto = public_path('img/profile/') . $currentPhoto;
                if (file_exists($userPhoto)) {
                    @unlink($userPhoto);
                }
            }
            $updateDetails2 = [
                'designation' => $request->get('designation'),
                'contact' => $request->get('contact'),
                'photo' => $request->get('photo')
            ];
        } else {

            //Defining Arrays
            $updateDetails2 = [
                'designation' => $request->get('designation'),
                'contact' => $request->get('contact')

            ];
        }



        //Checking for Password
        if (!empty($request->password)) {
            $pass = Hash::make($request['password']);
            $request->merge(['password' => $pass]);
            $updateDetails1 = [
                'name' => $request->name,
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ];
        } else {
            $updateDetails1 = [
                'name' => $request->name,
                'email' => $request->get('email'),
            ];
        }


        //Update Data
        DB::transaction(function () use ($id,  $updateDetails2, $updateDetails1) {
            DB::table('users')
                ->where('id', $id)
                ->update($updateDetails1);
            DB::table('teachers_profiles')
                ->where('user_id', $id)
                ->update($updateDetails2);
        });
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
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        if (!$request->exists('supervisor_id')) {
            if (!$request->exists('isapproved')) {

                $this->validate($request, [
                    'name' => 'required|string|max:200',
                    'email' => 'required|string|email|max:200|unique:users,email,' . $user->id,
                    'password' => 'sometimes|string|min:8'
                ]);
                if (!empty($request->password)) {
                    $pass = Hash::make($request['password']);
                    $request->merge(['password' => $pass]);
                }
                $user->update($request->all());
            } else {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['isapproved' => true]);
            }
        } else {
            $this->validate($request, [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:200|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:8'
            ]);
            if (!empty($request->password)) {
                $pass = Hash::make($request['password']);
                $request->merge(['password' => $pass]);
            }
            $user->update($request->all());
            $this->validate($request, [
                'name' => 'required|string|max:200',
                'email' => 'required|string|email|max:200|unique:users,email,' . $user->id,
                'password' => 'sometimes|string|min:8'
            ]);
            if (!empty($request->password)) {
                $pass = Hash::make($request['password']);
                $request->merge(['password' => $pass]);
            }
            $user->update($request->all());
            $supervisor = User::findOrFail($request->supervisor_id);
            DB::table('students_profiles')
                ->where('user_id', $user->id)
                ->update([
                    'supervisor' => $supervisor->name,
                    'supervisor_id' => $supervisor->id
                ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User Deleted'];
    }
}
