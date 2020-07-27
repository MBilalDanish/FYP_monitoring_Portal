<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->select('*')
            ->get();

        return response()->json([
            'data' => $users,
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
        $current_id=auth('api')->user()->id;
        $chatUser_id=$request->chatUser_id;
        $ids = [];
      
        $messages=DB::table('messages')->select('*')->where([
            ['from', '=', $current_id],
            ['to', '=', $chatUser_id],
        ])->orWhere([
            ['from', '=', $chatUser_id],
            ['to', '=', $current_id],
        ])->latest()->get();
        $deleteUs=DB::table('messages')->select('*')->where([
            ['from', '=', $current_id],
            ['to', '=', $chatUser_id],
        ])->orWhere([
            ['from', '=', $chatUser_id],
            ['to', '=', $current_id],
        ])->latest()->take($messages->count())->skip(10)->get();

        foreach ($deleteUs as $deleteMe) {
            $ids[] = $deleteMe->id;
        }
        Message::destroy($ids);
        Message::create([
            'from' => auth('api')->user()->id,
            'to' => $request->chatUser_id,
            'user_message' => $request->message,

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
    public function getMessages(Request $request, $chatUser_id)
    {

        $current_id = auth('api')->user()->id;

        $users = DB::table('messages')->select('*')->where([
            ['from', '=', $current_id],
            ['to', '=', $chatUser_id],
        ])->orWhere([
            ['from', '=', $chatUser_id],
            ['to', '=', $current_id],
        ])
            ->get();

        return response()->json([
            'data' => $users,
        ]);
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
